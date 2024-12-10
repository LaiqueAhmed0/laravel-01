@extends('layouts.layout')

@push('head')

    <link href="/css/pages/wizard/wizard-2.css" rel="stylesheet" type="text/css">

    <style>
        .taxCodeGroup:after {
            font-family: 'Font Awesome 6 Pro';
            width: 24px;
            height: 28px;
            text-align: center;
            position: absolute;
            top: 30px;
            right: 15px;
            font-size: 20px;
        }

        .validCode:after {
            content: '\f058';
            color: #64cf37;
        }

        .invalidCode:after {
            content: '\f057';
            color: #fc6666;
        }

        #apple-pay-button {
            height: 48px;
            width: 100%;
            display: inline-block;
            -webkit-appearance: -apple-pay-button;
            -apple-pay-button-type: plain;
            -apple-pay-button-style: black;
        }

        .gpay-card-info-container.new_style {
            width: 100% !important;
            margin: 20px 0 !important;
        }

    </style>
@endpush

@push('content')
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="false">
                <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                    <!--begin::Wizard Step 1 Nav-->
                    <div class="wizard-steps">
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon ">
                                    <i class="la la-user icon-2x"></i>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Billing Details</h3>
                                    <div class="wizard-desc">Name, phone and email</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="la la-map-marked icon-2x"></i>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Billing Address</h3>
                                    <div class="wizard-desc">Address, postcode and country</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="la la-clipboard-check icon-2x"></i>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Review</h3>
                                    <div class="wizard-desc">Review order details</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->
                        <!--begin::Wizard Step 5 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="la la-credit-card icon-2x"></i>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Make Payment</h3>
                                    <div class="wizard-desc">Use Credit or Debit Cards</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 5 Nav-->
                        <!--begin::Wizard Step 6 Nav-->
                        <div class="wizard-step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="fab la-wpforms icon-2x"></i>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Completed!</h3>
                                    <div class="wizard-desc">Review and Submit</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 6 Nav-->
                    </div>
                </div>
                <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                    <div class="row">
                        <div class="offset-xxl-2 col-xxl-8">
                            <form class="form fv-plugins-bootstrap fv-plugins-framework" action="" method="post" id="kt_form">
                                @csrf
                                <input type="hidden" name="order">
                                <!--begin: Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h4 class="mb-10 font-weight-bold text-dark">Enter your Account Details</h4>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>First Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="fname" name="fname" placeholder="First Name" value="{{$user->first_name ?? ''}}">
                                                <span class="form-text text-muted">Please enter your first name.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Last Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="lname" name="lname" placeholder="Last Name" value="{{$user->last_name ?? ''}}">
                                                <span class="form-text text-muted">Please enter your last name.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Company Name (optional)</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="company_name" name="company_name" placeholder="Company Name" value="{{$user->company_name ?? ''}}">
                                                <span class="form-text text-muted">Please enter your company name.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Tax Number (optional)</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="tax_code" name="tax_code" placeholder="VAT Number" value="{{$user->tax_code ?? ''}}">
                                                <span class="form-text text-muted">Please enter your tax number.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="tel" class="form-control form-control-solid form-control-lg" v-model="phone" name="phone" placeholder="phone" value="{{$user->phone ?? ''}}">
                                                <span class="form-text text-muted">Please enter your phone number.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control form-control-solid form-control-lg" v-model="email" name="email" placeholder="Email" value="{{$user->email ?? ''}}">
                                                <span class="form-text text-muted">Please enter your email address.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Wizard Step 1-->
                                <!--begin: Wizard Step 2-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-4 font-weight-bold text-dark">Enter your Billing Address</h4>
                                    <p class="mb-6">Please note if your credit/debit card address is different to your billing address, you will be able to enter those when you are redirected to our payment provider.</p>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Address Line 1<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="address1" name="address1" placeholder="Address Line 1" value="{{$user->address ?? ''}}">
                                                <span class="form-text text-muted">Please enter your Address.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Address Line 2</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="address2" name="address2" placeholder="Address Line 2" value="{{$user->address_2 ?? ''}}">
                                                <span class="form-text text-muted">Please enter your Address.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Postcode<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="postcode" name="postcode" placeholder="Postcode" value="{{$user->postcode ?? ''}}">
                                                <span class="form-text text-muted">Please enter your Postcode.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>City<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="city" name="city" placeholder="City" value="{{$user->city ?? ''}}">
                                                <span class="form-text text-muted">Please enter your City.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>State/County</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="county" name="county" placeholder="State/County" value="{{$user->county ?? ''}}">
                                                <span class="form-text text-muted">Please enter your County.</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Country<span class="text-danger">*</span></label>
                                                <select name="country" class="form-control form-control-solid form-control-lg" v-model="country">
                                                    <option value="">Select</option>
                                                    @component('components.form.selectCounties')
                                                    @endcomponent
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Wizard Step 2-->
                                <!--begin: Wizard Step 4-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Section-->
                                    <h4 class="mb-10 font-weight-bold text-dark">Review your Order and Submit</h4>
                                    <h6 class="font-weight-bolder mb-3">Billing Address:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>@{{ fname }} @{{ lname }}</div>
                                        <div>@{{ address1 }}</div>
                                        <div>@{{ address2 }}</div>
                                        <div>@{{ postcode }}, @{{ city }}</div>
                                        <div id="country_name"></div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <!--end::Section-->
                                    <!--begin::Section-->
                                    <h6 class="font-weight-bolder mb-3">Order Details:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Ordered Plans</th>
                                                    <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                                    <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($cart as $item)
                                                    <tr class="font-weight-boldest">
                                                        <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                                                            <!--begin::Symbol-->
                                                            {{--                                                            <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">--}}
                                                            {{--                                                                <div class="symbol-label" style="background-image: url('{{$item['img']}}')"></div>--}}
                                                            {{--                                                            </div>--}}
                                                            <!--end::Symbol-->
                                                            <div class="d-flex flex-column">
                                                                <span>{{$item['plan']}} </span>
                                                                <span class="text-muted font-weight-normal">{{$item['piccid']}}</span></div>
                                                        </td>
                                                        <td class="text-right pt-7 align-middle">{{$item['quantity']}}</td>
                                                        <td class="text-right pt-7 align-middle">{{$item['rate']}}</td>
                                                        <td class="text-primary pr-0 pt-7 text-right align-middle">{{$item['total']}}</td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td class="font-weight-bolder text-right">Subtotal</td>
                                                    <td class="font-weight-bolder text-right pr-0">£ @{{subtotal}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="border-0 pt-0"></td>
                                                    <td class="border-0 pt-0 font-weight-bolder text-right">Tax</td>
                                                    <td class="border-0 pt-0 font-weight-bolder text-right pr-0">£ @{{tax}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="border-0 pt-0"></td>
                                                    <td class="border-0 pt-0 font-weight-bolder font-size-h5 text-right">Grand Total</td>
                                                    <td class="border-0 pt-0 font-weight-bolder font-size-h5 text-success text-right pr-0">£ @{{ (( parseInt(subtotal * 100) + parseInt(tax * 100) ) / 100).toFixed(2) }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <!--end::Section-->
                                    <!--begin::Section-->
                                    <h6 class="font-weight-bolder mb-3">IMPORTANT INFORMATION:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <ul>
                                            <li class="dark">Unless you have scheduled a date for your bundle to start, the data bundle being topped up will automatically start on first network connection depending on the country you are Roaming in.</li>
                                            <li><a style="color:#f78f45" href="https://lovemobiledata.com/faqs/" target="_blank">Ensure you have applied the APN settings on you device provided with the SIM pack or see FAQ</a> </li>
                                            <li><a style="color:#f78f45" href="https://lovemobiledata.com/terms-and-conditions/" target="_blank">You agree to our terms and condition of use</a></li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Terms and Conditions<span class="text-danger">*</span></label>
                                        <label class="checkbox">
                                            <input type="checkbox" name="terms">
                                            <span class="mr-5"></span> I agree to the website terms and conditions.
                                        </label>
                                    </div>

                                    <!--end::Section-->

                                </div>
                                <!--end: Wizard Step 4-->
                                <div class="pb-5" data-wizard-type="step-content">

                                    <h4 class="mb-10 font-weight-bold text-dark">Enter Card Details and Pay</h4>
                                    <div class="w-100 d-flex justify-content-end">
                                        <div class="d-inline-flex">
                                            <h6 class="pr-5">Total Due:</h6>
                                            <h6 class="font-weight-bolder">£ @{{ (( parseInt(subtotal * 100) + parseInt(tax * 100) ) / 100).toFixed(2) }}</h6>
                                        </div>
                                    </div>
                                    <div id="payment-form">
                                        <div id="apple-pay-button"></div>
                                        <div id="google-pay-button"></div>
                                        <div id="card-container"></div>
                                    </div>
                                    <h6 class="font-weight-bolder mt-6 mb-3">Accepted Cards:</h6>
                                    <div>
                                        <img class="d-inline-block h-50px" src="/media/200px-Mastercard-logo.svg.png">
                                        <img class="d-inline-block h-50px" src="/media/220px-Maestro_2016.svg.png">
                                        <img class="d-inline-block h-50px" src="/media/visa-ac7ab8356844bc9b5282bb09ea21d2e3.svg">
                                        <img class="d-inline-block h-50px mr-2" src="/media/amex.png">
                                        <img class="d-inline-block h-50px mr-2" src="/media/apple.png">
                                        <img class="d-inline-block h-50px" src="/media/google-pay.png">
                                    </div>
                                    <div class="top-0 left-0 w-100 h-100 position-absolute bg-white-o-90 align-items-center justify-content-center" style="display: none" id="checkout-loading">
                                        <div class="spinner spinner-lg spinner-info"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                        <div class="mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                Previous
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" id="card-button" data-wizard-type="action-submit">
                                Pay
                            </button>
                            <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <style>
            .sq-card-wrapper .sq-card-iframe-container {
                height: 48px !important;
            }


        </style>

@endpush

@push('scripts')

    <script src="/js/pages/custom/wizard/wizard-2.js" type="text/javascript"></script>

    <script src="/js/app.js" type="text/javascript"></script>

    <script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>

    <script>

        const appId = '{{env('SQUARE_APP_ID')}}';
        const locationId = '{{env('SQUARE_LOCATION_ID')}}';

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        async function initializeCard(payments) {
            const card = await payments.card();
            await card.attach('#card-container');

            return card;
        }

        async function createPayment(token) {
            let form = getFormData($('#kt_form'));
            const body = JSON.stringify({
                form,
                locationId,
                sourceId: token,
            });

            const paymentResponse = await fetch('/checkout/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body,
            });

            if (paymentResponse.ok) {
                return paymentResponse.json();
            }

            Swal.fire({
                icon: 'error',
                title: 'Checkout Error',
                text: 'Error with payment, please contact support.',
            });
        }

        async function tokenize(paymentMethod) {
            const tokenResult = await paymentMethod.tokenize();
            if (tokenResult.status === 'OK') {
                return tokenResult.token;
            } else {
                let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                if (tokenResult.errors) {
                    errorMessage += ` and errors: ${JSON.stringify(
                        tokenResult.errors
                    )}`;
                }
                
                console.log(tokenResult);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Checkout Error',
                    text: 'Error with payment, please contact support.',
                });
                throw new Error(errorMessage);
            }
        }
        function buildPaymentRequest(payments) {
            return payments.paymentRequest({
                countryCode: 'GB',
                currencyCode: 'GBP',
                total: {
                    amount: (( parseInt(app.subtotal * 100) + parseInt(app.tax * 100) ) / 100).toFixed(2),
                    label: 'Total',
                },
            });
        }

        async function initializeApplePay(payments) {
            const paymentRequest = buildPaymentRequest(payments)
            const applePay = await payments.applePay(paymentRequest);
            // Note: You do not need to `attach` applePay.
            return applePay;
        }

        async function initializeGooglePay(payments) {
            const paymentRequest = buildPaymentRequest(payments)

            const googlePay = await payments.googlePay(paymentRequest);
            await googlePay.attach('#google-pay-button');

            return googlePay;
        }




        document.addEventListener('DOMContentLoaded', async function () {
            if (!window.Square) {
                throw new Error('Square.js failed to load properly');
            }

            let payments;
            try {
                payments = window.Square.payments(appId, locationId);
            } catch {

                return;
            }

            let card;
            try {
                card = await initializeCard(payments);
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Checkout Error',
                    text: 'Error with checkout, please contact support.',
                });
                console.error('Initializing Card failed', e);
                return;
            }

            let applePay;
            try {
                applePay = await initializeApplePay(payments);
            } catch (e) {
                console.error('Initializing Apple Pay failed', e);
                // There are a number of reason why Apple Pay may not be supported
                // (e.g. Browser Support, Device Support, Account). Therefore you should
                // handle
                // initialization failures, while still loading other applicable payment
                // methods.
            }

            let googlePay;
            try {
                googlePay = await initializeGooglePay(payments);
            } catch (e) {
                console.error('Initializing Google Pay failed', e);
                // There are a number of reason why Google Pay may not be supported
                // (e.g. Browser Support, Device Support, Account). Therefore you
                // should handle initialization failures, while still loading other
                // applicable payment methods.
            }


            // Checkpoint 2.

            if (applePay !== undefined) {
                const applePayButton = document.getElementById('apple-pay-button');
                applePayButton.addEventListener('click', async function (event) {
                    await handlePaymentMethodSubmission(event, applePay);
                });
            }

            if (googlePay !== undefined) {
                const googlePayButton = document.getElementById('google-pay-button');
                googlePayButton.addEventListener('click', async function (event) {
                    await handlePaymentMethodSubmission(event, googlePay);
                });
            }


            async function handlePaymentMethodSubmission(event, paymentMethod) {
                event.preventDefault();

                try {
                    $('#checkout-loading').addClass('d-flex');
                    // disable the submit button as we await tokenization and make a payment request.
                    cardButton.disabled = true;
                    const token = await tokenize(paymentMethod);
                    const paymentResults = await createPayment(token);
                    window.location.href = '/checkout/success/';
                } catch (e) {
                    $('#checkout-loading').removeClass('d-flex');
                    cardButton.disabled = false;
                    console.error(e.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Checkout Error',
                        text: 'Error with payment, please contact support.',
                    });
                }
            }

            const cardButton = document.getElementById('card-button');
            cardButton.addEventListener('click', async function (event) {
                await handlePaymentMethodSubmission(event, card);
            });
        });
    </script>

    <script>
        window.addEventListener('message', function (event) {
            var msg = event.data || null;
            if (!msg) {
                return;
            }

            if (msg.type === 'close') {

                var container = document.querySelector('.secure-con');
                if (container) {
                    container.remove();
                }

                if (msg.data.status === 'success') {
                    window.location.href = '/checkout/complete?id=' + msg.data.orderId;
                } else if (msg.data.status === 'failed') {
                    var message = msg.data.message.join('<br>');

                    swal.fire({
                        title: msg.data.title,
                        html: message,
                        type: "error",
                    });
                }
            }
        });
    </script>



    <script>

        const countries = {!! \App\Models\Country::all()->toJson()!!};

        const app = new Vue({
            el: '#kt_form',
            data() {
                return {
                    fname: '{{$user->first_name ?? ''}}',
                    lname: '{{$user->last_name ?? ''}}',
                    phone: '{{$user->phone ?? ''}}',
                    email: '{{$user->email ?? ''}}',
                    tax_code: '{{$user->tax_code ?? ''}}',
                    company_name: '{{$user->company_name ?? ''}}',
                    address1: '{{$user->address ?? ''}}',
                    address2: '{{$user->address_2 ?? ''}}',
                    postcode: '{{$user->postcode ?? ''}}',
                    city: '{{$user->city ?? ''}}',
                    county: '{{$user->county ?? ''}}',
                    country: '{{$user->country ?? ''}}',
                    company: null,
                    taxCode: null,
                    subtotal: '{{str_replace(',', '', $subtotal) ?? 0}}',
                    tax: '{{str_replace(',', '', $tax) ?? 0}}',
                }
            }
        });

        function getCountryByID($id = null) {
            let country = countries.filter(function (item) {
                return item.id == $id;
            })
            return country[0].name ?? 'N/A';
        }

        $('[data-wizard-type="action-next"]').click(function () {
            $('#country_name').html(getCountryByID($('[name="country"]').val()));
        })


    </script>

    <script>
        $(document).ready(function () {
            var tax = app.tax;
            var taxGroup = $('.taxCodeGroup');

            $('#validate').click(vatCheck);

            $('[name="taxCode"]').change(function () {
                var vatCode = $('[name="taxCode"]').val();
                if (vatCode === '') {
                    taxGroup.removeClass('invalidCode');
                    taxGroup.removeClass('validCode');
                    app.tax = tax;
                }
            });

            $('[name="country"]').change(function () {
                var country = $('[name="country"]').val();
                if (country == 77) {
                    app.tax = tax;
                } else {
                    app.tax = 0.00;
                }
            });

            function vatCheck() {
                var vatCode = $('[name="taxCode"]').val();
                if (vatCode !== '') {
                    axios.get('/validate/tax', {
                        params: {
                            tax: vatCode,
                        }
                    }).then(function (response) {
                        if (response.data === true) {
                            vatSuccess();
                        } else {
                            vatFail();
                        }
                    });
                }
            }

            function vatSuccess() {
                swal.fire({
                    "title": "",
                    "text": "The tax code is valid!",
                    "type": "success",
                    "confirmButtonClass": "btn btn-secondary"
                });
                taxGroup.addClass('validCode');
                taxGroup.removeClass('invalidCode');
                $('[name="validTax"]').val('1');
                app.tax = 0;
            }

            function vatFail() {
                swal.fire({
                    "title": "",
                    "text": "The tax code is invalid!",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
                taxGroup.removeClass('validCode');
                taxGroup.addClass('invalidCode');
                $('[name="validTax"]').val('0');
                app.tax = tax;
            }
        });
    </script>
@endpush
