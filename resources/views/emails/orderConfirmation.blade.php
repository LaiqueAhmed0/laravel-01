@extends('layouts.email')

@section('header')
    <!-- header-white -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_bg-white o_px o_py-md o_br-t o_sans o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-top: 24px;padding-bottom: 24px;">
                            <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-primary" href="{{config('app.url')}}" style="text-decoration: none;outline: none;color: #126de5;"><img src="https://portal.lovemobiledata.com/media/lmd.png" width="320" height="auto" alt="Love Mobile Data" style="max-width: 194px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>

    <!-- hero-white-icon-lines -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_bg-white o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #ffffff;color: #82899a;padding-left: 24px;padding-right: 24px;padding-top: 0;padding-bottom: 64px;">
                      
                            <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;">Thank you for your purchase!</h2>
                            <p style="margin-top: 0px;margin-bottom: 0px;">Your top-up has been scheduled in!<br>Go to your dashboard to keep track of your top-up.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
@endsection


@section('content')

    <!-- invoice_header -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_re o_bg-white o_px o_pt-xs o_hide-xs" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 8px;">
                            <!--[if mso]>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation">
                                <tbody>
                                <tr>
                                    <td width="400" align="left" valign="top" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                                <div class="o_px-xs o_sans o_text-xs o_left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: left;padding-left: 8px;padding-right: 8px;">
                                    <p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Item</p>
                                </div>
                            </div>
                            <!--[if mso]></td>
                            <td width="100" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">
                                <div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">
                                    <p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Qty</p>
                                </div>
                            </div>
                            <!--[if mso]></td>
                            <td width="100" align="right" valign="top" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">
                                <div class="o_px-xs o_sans o_text-xs o_right" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: right;padding-left: 8px;padding-right: 8px;">
                                    <p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Price</p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr>
                            <tr>
                                <td colspan="3" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tbody>
                                    <tr>
                                        <td class="o_re o_bb-light" style="font-size: 9px;line-height: 9px;height: 9px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>

    @foreach ($orderItems as $item)

        <!-- product-lg -->
        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
            <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                    <!--[if mso]>
                    <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                        <tbody>
                        <tr>
                            <td><![endif]-->
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                        <tbody>
                        <tr>
                            <td class="o_re o_bg-white o_px o_pt" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">
                                <!--[if mso]>
                                <table cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tbody>
                                    <tr>
                                        <td width="100" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
        
                                <!--[if mso]></td>
                                <td width="300" align="left" valign="top" style="padding: 0px 8px;"><![endif]-->
                                <div class="o_col o_col-4 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                                    <div style="font-size: 16px; line-height: 16px; height: 16px;">&nbsp;</div>
                                    <div class="o_px-xs o_sans o_text o_text-light o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
                                        <h4 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;">{{getPlanName($item->plan_id)}}</h4>
                                        <p class="o_text-secondary o_mb-xs" style="color: #424651;margin-top: 0px;margin-bottom: 8px;">{{$item->sim->iccid}}</p>
                                    </div>
                                </div>
                                <!--[if mso]></td>
                                <td width="100" align="right" valign="top" style="padding: 0px 8px;"><![endif]-->
                                <div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">
                                    <div class="o_hide-xs" style="font-size: 16px; line-height: 16px; height: 16px;">&nbsp;</div>
                                    <div class="o_px-xs o_sans o_text o_text-secondary o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: center;padding-left: 8px;padding-right: 8px;">
                                        <p class="o_mb-xxs" style="margin-top: 0px;margin-bottom: 4px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Quantity: </span>{{$item->quantity}} </p>
                                    </div>
                                </div>
                                <!--[if mso]></td>
                                <td width="100" align="right" valign="top" style="padding: 0px 8px;"><![endif]-->
                                <div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">
                                    <div class="o_hide-xs" style="font-size: 16px; line-height: 16px; height: 16px;">&nbsp;</div>
                                    <div class="o_px-xs o_sans o_text o_text-secondary o_right o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;">
                                        <p class="o_mb-xxs" style="margin-top: 0px;margin-bottom: 4px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Price:&nbsp; </span>£{{$item->price / 100}}</p>
                                    </div>
                                </div>
                                <!--[if mso]></td></tr>
                                <tr>
                                    <td colspan="4" style="padding: 0px 8px;"><![endif]-->
                                <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                        <tbody>
                                        <tr>
                                            <td class="o_re o_bb-light" style="font-size: 16px;line-height: 16px;height: 16px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--[if mso]></td></tr></table><![endif]-->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--[if mso]></td></tr></table><![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach

    <!-- invoice-total-light -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_re o_bg-white o_px-md o_py" align="right" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td width="252" class="o_px o_pb o_pt-xs o_bg-ultra_light o_br" align="left" style="background-color: #ebf5fa;border-radius: 4px;padding-left: 16px;padding-right: 16px;padding-top: 8px;padding-bottom: 16px;">
                                        <table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">
                                                    <p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">Subtotal</p>
                                                </td>
                                                <td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">
                                                    <p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">£ {{number_format($order->subtotal / 100, 2)}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">
                                                    <p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">Tax</p>
                                                </td>
                                                <td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">
                                                    <p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">£ {{number_format($order->tax / 100, 2)}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp;</td>
                                                <td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="50%" class="o_pt" align="left" style="padding-top: 16px;">
                                                    <p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;"><strong>Total Due</strong></p>
                                                </td>
                                                <td width="50%" class="o_pt" align="right" style="padding-top: 16px;">
                                                    <p class="o_sans o_text o_text-primary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #126de5;"><strong>£ {{number_format($order->total / 100, 2)}}</strong></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    <!-- customer-details-plain -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_re o_bg-white o_px o_pb-md" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">
                            <!--[if mso]>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation">
                                <tbody>
                                <tr>
                                    <td width="300" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">
                                <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp;</div>
                                <div class="o_px-xs o_sans o_text-xs o_text-secondary o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #424651;text-align: left;padding-left: 8px;padding-right: 8px;">
                                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Billing Information</strong></p>
                                    <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">{{$order->first_name}} {{$order->last_name}}<br>
                                        {{$order->address_1}}<br>
                                        {{$order->address_2 ? $order->address_2 . '<br>' : ''}}
                                        {{$order->city}}, {{$order->county}}<br>
                                        {{$order->postcode}}, {{$order->country_name}}</p>
                                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Payment Method</strong></p>
                                    <p style="margin-top: 0px;margin-bottom: 0px;">Card / Square Payments</p>
                                </div>
                            </div>
                            <!--[if mso]></td>
                            <td width="300" align="left" valign="top" style="padding: 0px 8px;"><![endif]-->
                            <div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">
                                <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp;</div>
                                <div class="o_px-xs o_sans o_text-xs o_text-secondary o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #424651;text-align: left;padding-left: 8px;padding-right: 8px;">
{{--                                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Shipping Information</strong></p>--}}
{{--                                    <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">{{$order->first_name}} {{$order->last_name}}<br>--}}
{{--                                        {{$order->address_1}}<br>--}}
{{--                                        {{$order->address_2 ? $order->address_2 . '<br>' : ''}}--}}
{{--                                        {{$order->city}}, {{$order->county}}<br>--}}
{{--                                        {{$order->postcode}}, {{$order->country}}--}}
{{--                                    </p>--}}
                                </div>
                            </div>
                            <!--[if mso]></td>
                            </tr></table><![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>


@endsection

@section('footer')
    <!-- spacer -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    <!-- footer-white-2cols -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
        <tr>
            <td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 32px;">
                <!--[if mso]>
                <table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation">
                    <tbody>
                    <tr>
                        <td><![endif]-->
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td class="o_re o_bg-white o_px o_pb-lg o_bt-light o_br-b" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;border-top: 1px solid #d3dce0;border-radius: 0px 0px 4px 4px;padding-left: 16px;padding-right: 16px;padding-bottom: 32px;">
                            <!--[if mso]>
                            <table cellspacing="0" cellpadding="0" border="0" role="presentation">
                                <tbody>
                                <tr>
                                    <td width="200" align="left" valign="top" style="padding:0px 8px;"><![endif]-->
                            <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                                <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp;</div>
                                <div class="o_px-xs o_sans o_text-xs o_text-light o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
                                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">©{{date('Y')}} Love Mobile Date. All rights reserved.</p>
                                    <p style="margin-top: 0px;margin-bottom: 0px;">
                                        <a class="o_text-light o_underline" href="https://lovemobiledata.com/contact/" style="text-decoration: underline;outline: none;color: #82899a;">Contact</a> <span class="o_hide-xs">&nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
                                        <a class="o_text-light o_underline" href="https://portal.lovemobiledata.com/login" style="text-decoration: underline;outline: none;color: #82899a;">My Account</a> <span class="o_hide-xs">
                                        {{--                                            &nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">--}}
                                        {{--                                        <a class="o_text-light o_underline" href="https://example.com/" style="text-decoration: underline;outline: none;color: #82899a;">Unsubscribe</a>--}}
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td>
                            <td width="400" align="right" valign="top" style="padding:0px 8px;"><![endif]-->
                            <div class="o_col o_col-2" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                                <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp;</div>
                                {{--                                <div class="o_px-xs o_sans o_text-xs o_text-light o_right o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: right;padding-left: 8px;padding-right: 8px;">--}}
                                {{--                                    <p style="margin-top: 0px;margin-bottom: 0px;">--}}
                                {{--                                        <a class="o_text-light" href="https://example.com/" style="text-decoration: none;outline: none;color: #82899a;"><img src="images/facebook-light.png" width="36" height="36" alt="fb" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>--}}
                                {{--                                        <a class="o_text-light" href="https://example.com/" style="text-decoration: none;outline: none;color: #82899a;"><img src="images/twitter-light.png" width="36" height="36" alt="tw" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>--}}
                                {{--                                        <a class="o_text-light" href="https://example.com/" style="text-decoration: none;outline: none;color: #82899a;"><img src="images/instagram-light.png" width="36" height="36" alt="ig" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>--}}
                                {{--                                        <a class="o_text-light" href="https://example.com/" style="text-decoration: none;outline: none;color: #82899a;"><img src="images/snapchat-light.png" width="36" height="36" alt="sc" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a>--}}
                                {{--                                    </p>--}}
                                {{--                                </div>--}}
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
                <div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp;</div>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
