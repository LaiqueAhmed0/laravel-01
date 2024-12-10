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
                            <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-primary" href="{{config('app.url')}}" style="text-decoration: none;outline: none;color: #126de5;"><img src="{{config('app.url')}}/media/lmd.svg" width="320" height="auto" alt="Love Mobile Data" style="max-width: 194px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
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
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp;</td>
                                    <td rowspan="2" class="o_sans o_text o_text-secondary o_px o_py" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                                        <img src="{{config('app.url')}}/media/mail/shopping_cart-48-primary.png" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;">
                                    </td>
                                    <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="40">&nbsp;</td>
                                    <td height="40">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 8px; line-height: 8px; height: 8px;">&nbsp;</td>
                                    <td style="font-size: 8px; line-height: 8px; height: 8px;">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                            <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;">A Sim has been assigned to you!</h2>
                            <p style="margin-top: 0px;margin-bottom: 0px;">Please login/register on <a href="https://mobile.eagle.brd.ltd/">Love Mobile Data</a> to claim the sim! </p>
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