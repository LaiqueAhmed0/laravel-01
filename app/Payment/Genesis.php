<?php

namespace App\Payment;

use Genesis\API\Constants\Endpoints;
use Genesis\API\Constants\Environments;
use Genesis\Config;
use Genesis\Genesis as GenesisPaymentGateway;

class Genesis
{
    protected $endpoint = Endpoints::EMERCHANTPAY;

    protected $env = Environments::STAGING;

    protected $username = 'dbf024805009415e577c1dde5f045a83a4fa6405';

    protected $password = '1e3ee0ec0e1c39918cb405b0aff5a609b7bd281d';

    protected $token = '270b87d3c8587d948012adf0006c4b638c67e0f3';

    private $instance;

    public function __construct()
    {
        Config::setEndpoint($this->endpoint);
        Config::setEnvironment($this->env);
        Config::setUsername($this->username);
        Config::setPassword($this->password);
        Config::setToken($this->token);

        $this->instance = new GenesisPaymentGateway('WPF\Create');
    }

    public function getWebform(int $amount, string $description, string $email, string $firstName, string $lastName, string $address1, ?string $address2, string $zipcode, string $city, string $country)
    {
        $request = $this->instance->request();

        $request
            ->setTransactionId(time())
            ->setDescription($description)
            ->setNotificationUrl('https://mobile.eagle.brd.ltd/checkout/notification')
            ->setReturnSuccessUrl('https://mobile.eagle.brd.ltd/checkout/success')
            ->setReturnFailureUrl('https://mobile.eagle.brd.ltd/checkout/failure')
            ->setReturnCancelUrl('https://mobile.eagle.brd.ltd/checkout/cancel')
            ->setAmount($amount / 100)
            ->setCurrency('GBP')
            ->setLifetime('60')
            ->setCustomerEmail($email)
            ->setBillingFirstName($firstName)
            ->setBillingLastName($lastName)
            ->setBillingAddress1($address1)
            ->setBillingAddress2($address2)
            ->setBillingZipCode($zipcode)
            ->setBillingCity($city)
            ->setBillingCountry($country)
            ->addTransactionType('sale3d');
        try {
            $this->instance->execute();
            $response = $this->instance->response()->getResponseObject();

            return $response;
        } catch (\Genesis\Exceptions\ErrorAPI $e) {
            $response = $e->getMessage();
        } catch (\Genesis\Exceptions\InvalidArgument $e) {
            $response = $e->getMessage();
        } catch (\Genesis\Exceptions\ErrorParameter $e) {
            $response = $e->getMessage();
        } catch (\Genesis\Exceptions\Exception $e) {
            $response = $e->getMessage();
        }

        return dd($response);
    }
}
