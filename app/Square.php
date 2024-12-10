<?php

namespace App;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;

class Square
{
    protected $appId;

    protected $accessToken;

    protected $locationId;

    protected $client;

    public function __construct()
    {
        $this->appId = env('SQUARE_APP_ID');
        $this->accessToken = env('SQUARE_ACCESS_TOKEN');
        $this->locationId = env('SQUARE_LOCATION_ID');
        $this->environment = env('SQUARE_ENVIRONMENT');
        $this->webhookSignatureKey = env('SQUARE_WEBHOOK_SIGNATURE_KEY');

        $this->client = new \Square\SquareClient([
            'accessToken' => $this->accessToken,
            'environment' => $this->environment,
        ]);
    }

    public function create(Order $order)
    {
        $currency = $this->client->getLocationsApi()
            ->retrieveLocation($this->locationId)
            ->getResult()
            ->getLocation()
            ->getCurrency();

        $money = new Money();
        $money->setCurrency($currency);
        $money->setAmount($order->total);

        $item = new \Square\Models\OrderLineItem(1);
        $item->setName('Order #'.str_pad($order->id, 5, '0', STR_PAD_LEFT));
        $item->setBasePriceMoney($money);

        $sOrder = new \Square\Models\Order($this->locationId);
        $sOrder->setLineItems([$item]);
        $sOrder->setMetadata(['order' => (string) $order->id]);

        $createOrderRequest = new \Square\Models\CreateOrderRequest();
        $createOrderRequest->setOrder($sOrder);

        $checkoutRequest = new \Square\Models\CreateCheckoutRequest($order->id, $createOrderRequest);
        $checkoutRequest->setRedirectUrl(config('app.url').'checkout/success/');
        $response = $this->client->getCheckoutApi()->createCheckout($this->locationId, $checkoutRequest);

        if ($response->isError()) {
            return null;
        }
        $checkout = $response->getResult()->getCheckout();
        $order->squareup_checkout = $checkout->getId();
        $order->save();

        return $checkout;
    }

    public function createPayment(Subscription $subscription, $price = null)
    {
        $response = $this->charge($price ?? $subscription->price, $subscription->card_id, $subscription->user, $subscription->plan['name']);

        $transaction = Transaction::create([
            'user_id' => $subscription->user->id,
            'subscription_id' => $subscription->id,
            'card_id' => $subscription->card_id,
            'price' => $price ?? $subscription->price,
        ]);

        if ($response['result']) {
            $subscription->status = 'active';
            $subscription->charge_at = Carbon::parse($subscription->charge_at)->addMonth();
            $transaction->squareup_id = $response['payment']->getId();
            $transaction->status = 'success';
        } else {
            $subscription->failed_transactions++;
            if ($subscription->failed_transactions == 3) {
                $subscription->status = 'failed';
                $subscription->expires_at = Carbon::now();
            }
            $transaction->status = 'failed';
        }
        $subscription->save();
        $transaction->save();
    }

    public function charge($charge, $card, User $customer, $note)
    {
        $amount = new Money();
        $amount->setAmount($charge);
        $amount->setCurrency('GBP');

        \Log::alert(print_r($charge, true));

        $body = new CreatePaymentRequest(
            $card,
            Str::uuid(),
            $amount
        );

        \Log::alert(print_r($body, true));

        $body->setAutocomplete(true);
        $body->setLocationId($this->locationId);
        $body->setNote($note);

        $apiResponse = $this->client->getPaymentsApi()->createPayment($body);

        if ($apiResponse->isSuccess()) {
            return ['result' => true, 'payment' => $apiResponse->getResult()->getPayment()];
        }
        \Log::alert(print_r($apiResponse, true));

        return ['result' => false, 'message' => $apiResponse->getResult()];
    }

    public function createCustomer($user)
    {
        if ($id = $this->customerExists($user)) {
            return $id;
        }
        $request = new \Square\Models\CreateCustomerRequest();
        $request->setEmailAddress($user->email);
        $response = $this->client->getCustomersApi()->createCustomer($request);
        $response = json_decode($response->getBody());
        if (! isset($response->customer)) {
            return null;
        }

        return $response->customer->id;
    }

    public function disableCard($card)
    {
        $api_response = $this->client->getCardsApi()->disableCard($card);
        if ($api_response->isSuccess()) {
            return true;
        }
        Log::alert(print_r($api_response->getErrors(), true));

        return false;
    }

    public function getCards($id)
    {
        $response = $this->client->getCardsApi()->listCards(null, $id);

        if ($response->isSuccess()) {
            return $response->getResult()->getCards();
        }

        return $response->getErrors();
    }

    public function getCard($id)
    {
        $response = $this->client->getCardsApi()->retrieveCard($id);

        if ($response->isSuccess()) {
            return $response->getResult()->getCard();
        }

        return $response->getErrors();
    }

    public function addCard($user, $cardToken)
    {
        $card = new \Square\Models\Card();

        $card->setCardholderName($user->full_name);
        $card->setCustomerId($user->squareup_id);

        $body = new \Square\Models\CreateCardRequest(
            Str::uuid(),
            $cardToken,
            $card
        );

        $api_response = $this->client->getCardsApi()->createCard($body);

        if (! $api_response->isSuccess()) {
            return false;
        }

        return $api_response->getResult()->getCard()->getId();
    }

    public function getCustomer(User $user)
    {
        $api_response = $this->client->getCustomersApi()->retrieveCustomer($user->squareup_id);

        if ($api_response->isSuccess()) {
            return $api_response->getResult()->getCustomer();
        }
        $errors = $api_response->getErrors();
    }

    public function syncCustomerDetails(User $user)
    {
        $customer = $this->getCustomer($user);

        $address = new \Square\Models\Address();
        $address->setAddressLine1($user->address_line_1);
        $address->setAddressLine2($user->address_line_2);
        $address->setLocality($user->city);
        $address->setAdministrativeDistrictLevel1($user->region);
        $address->setPostalCode($user->postcode);
        $address->setCountry($user->country_symbol);

        $body = new \Square\Models\UpdateCustomerRequest();
        $body->setPhoneNumber($user->phone);
        $body->setGivenName($user->first_name);
        $body->setFamilyName($user->last_name);
        $body->setAddress($address);
        $body->setVersion($customer->getVersion());

        $api_response = $this->client->getCustomersApi()->updateCustomer($user->squareup_id, $body);

        if (! $api_response->isSuccess()) {
            dd($errors = $api_response->getErrors());
        }
    }

    public function generatePlans()
    {
        foreach (config('system.plans') as $plan) {
            if (isset($plan['squareup_id'])) {
                continue;
            }
            $recurring_price_money = new Money();
            $recurring_price_money->setAmount($plan['price']);
            $recurring_price_money->setCurrency('GBP');

            $subscription = new \Square\Models\SubscriptionPhase('MONTHLY', $recurring_price_money);

            $subscription_plan_data = new \Square\Models\CatalogSubscriptionPlan('Basic Plan', [$subscription]);

            $object = new \Square\Models\CatalogObject('SUBSCRIPTION_PLAN', "#plan-{$plan['id']}");
            $object->setSubscriptionPlanData($subscription_plan_data);

            $body = new \Square\Models\UpsertCatalogObjectRequest((string) Str::uuid(), $object);

            $api_response = $this->client->getCatalogApi()->upsertCatalogObject($body);

            if (! $api_response->isSuccess()) {
                $errors = $api_response->getErrors();
                dd($errors);
            }
        }
    }

    /**
     * @return array|false
     */
    public function getUserCurrentPlan(User $user)
    {
        $subscriptions = $this->getUserCurrentSubscription($user);
        if (! count($subscriptions)) {
            return false;
        }
        foreach ($subscriptions as $subscription) {
            if ($subscription->getStatus() !== 'PENDING' && $subscription->getCanceledDate()) {
                $data['current'] = [
                    'subscriptions' => $subscription,
                    'plan' => collect(config('system.plans'))->where('squareup_id', $subscription->getPlanId())->first(),
                ];
            } elseif (! $subscription->getCanceledDate()) {
                $data['next'] = [
                    'subscriptions' => $subscription,
                    'plan' => collect(config('system.plans'))->where('squareup_id', $subscription->getPlanId())->first(),
                ];
            }
        }

        return $data;
    }

    public function getUserCurrentSubscription(User $user)
    {
        $customer_ids = [$user->squareup_id];
        $filter = new \Square\Models\SearchSubscriptionsFilter();
        $filter->setCustomerIds($customer_ids);

        $query = new \Square\Models\SearchSubscriptionsQuery();
        $query->setFilter($filter);

        $body = new \Square\Models\SearchSubscriptionsRequest();
        $body->setQuery($query);

        $api_response = $this->client->getSubscriptionsApi()->searchSubscriptions($body);

        if (! $api_response->isSuccess()) {
            abort(404);
        }

        return $api_response->getResult()->getSubscriptions();
    }

    public function customerExists($user)
    {
        $email = new \Square\Models\CustomerTextFilter();
        $email->setFuzzy($user->email);

        $filter = new \Square\Models\CustomerFilter();
        $filter->setEmailAddress($email);

        $query = new \Square\Models\CustomerQuery();
        $query->setFilter($filter);

        $body = new \Square\Models\SearchCustomersRequest();
        $body->setLimit(10);
        $body->setQuery($query);

        $response = $this->client->getCustomersApi()->searchCustomers($body);
        $response = json_decode($response->getBody());

        if (! isset($response->customers)) {
            return false;
        }

        return collect($response->customers)->sortBy('created_at')->first()->id;
    }

    public function cancelUserPlan(User $user)
    {
        $plans = $this->getUserCurrentPlan($user);
        foreach ($plans as $plan) {
            $response = $this->client->getSubscriptionsApi()->cancelSubscription($plan['subscriptions']->getId());
            if ($response->isSuccess()) {
                dd($response->getResult()->getSubscription());
            } else {
                dd($response->getErrors());
            }
        }
    }

    public function resumeUserPlan(User $user)
    {
        $plans = $this->getUserCurrentPlan($user);
        if (isset($plans['current'])) {
            $this->applyPlanToUser($user, $plans['current']['plan']['id']);
        }

        return false;
    }

    public function cancelUserUpgrade(User $user)
    {
        $plans = $this->getUserCurrentPlan($user);
        if (! isset($plans['next'])) {
            return;
        }
        dd($plans['next']);
        $response = $this->client->getSubscriptionsApi()->cancelSubscription($plans['next']['subscriptions']->getId());
        if ($response->isSuccess()) {
            dd($response->getResult()->getSubscription());
        } else {
            dd($response->getErrors());
        }
    }

    public function applyPlanToUser(User $user, int $planId)
    {
        $this->syncCustomerDetails($user);

        $cards = $this->getCards($user->squareup_id);
        $plans = collect(config('system.plans'));
        $current = $this->getUserCurrentPlan($user);

        if ($current) {
            $response = $this->client->getSubscriptionsApi()->cancelSubscription($current['current']['subscriptions']->getId());
            if ($response->isSuccess()) {
                $canceledDate = $response->getResult()->getSubscription()->getCanceledDate();
            } else {
                dd($response->getErrors());
            }
        }

        $body = new \Square\Models\CreateSubscriptionRequest(
            $this->locationId,
            $plans->where('id', $planId)->first()['squareup_id'],
            $user->squareup_id
        );

        $body->setIdempotencyKey((string) Str::uuid());
        $body->setStartDate($canceledDate ?? date('Y-m-d'));
        $body->setTaxPercentage('20');
        $body->setCardId($cards[0]->getId());

        $api_response = $this->client->getSubscriptionsApi()->createSubscription($body);

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
            dd($result);
        } else {
            $errors = $api_response->getErrors();
            dd($errors);
        }
    }

    public function isValidWebhook($notificationSignature, $notificationBody)
    {
        if (! isset($notificationBody, $notificationSignature)) {
            return false;
        }

        $signatureUrl = 'https://portal.lovemobiledata.com/checkout/notification';
        $stringToSign = $signatureUrl.$notificationBody;
        $hash = hash_hmac('sha1', $stringToSign, $this->webhookSignatureKey, true);
        $generatedSignature = base64_encode($hash);

        return hash_equals($generatedSignature, $notificationSignature);
    }

    public function onWebhook()
    {
        Log::debug('Webhook triggered');

        $notificationSignature = $_SERVER['HTTP_X_SQUARE_SIGNATURE'] ?? null;
        $notificationBody = file_get_contents('php://input');

        if (! $this->isValidWebhook($notificationSignature, $notificationBody)) {
            Log::debug('Failed');

            return abort(400, 'Failed to validate webhook!');
        }
        $json = json_decode($notificationBody);
        if ($json->type !== 'payment.updated') {
            return false;
        }
        $payment = $json->data->object->payment;
        if (isset($payment) && $payment->status === 'COMPLETED' && isset($payment->order_id)) {
            $order = Order::where('squareup_checkout', $payment->order_id)->first();
            if ($order && $order->status == 'pending') {
                $order->status = 'processing';
                $order->save();

                return $order;
            }
        }

        return false;
    }
}
