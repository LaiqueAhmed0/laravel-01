@php $cart = Session::get('cart'); @endphp
<!--begin::My Cart-->
<div class="dropdown">
    <!--begin::Toggle-->
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-hover-transparent-white btn-dropdown btn-lg mr-1 position-relative">
            <span class="svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
                <i class="flaticon2-shopping-cart-1 text-light"></i>
                <!--end::Svg Icon-->
                <div class="badge badge-sm" id="cart-counter" style="color: #f69242;position: absolute; top: -4px; left: 14px;">0</div>
            </span>
            <span style="margin-left: -10px">Basket</span>
        </div>
    </div>
    <!--end::Toggle-->
    <!--begin::Dropdown-->
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-xl dropdown-menu-anim-up">

        <form>
            <!-- begin:: Mycart -->
            <!--begin::Header-->
            <div class="d-flex align-items-center py-10 px-8 bgi-size-cover bgi-no-repeat rounded-top"
                 style="background-image: url(/media/misc/bg-1.jpg)">
                <span class="btn btn-md btn-icon bg-white-o-15 mr-4">
                    <i class="flaticon2-shopping-cart-1 text-success"></i>
                </span>
                <h4 class="text-white m-0 flex-grow-1 mr-3">My Basket</h4>
                <button id="items" type="button" class="btn btn-success btn-sm">0 Items</button>
            </div>
            <!--end::Header-->
            <!--begin::Scroll-->
            <div id="cart" class="scroll scroll-push" data-scroll="true" data-height="250" data-mobile-height="200">
                <p style="text-align: center;padding-top: 30px;">No items in your basket</p>
            </div>

            <!--begin::Summary-->
            <div class="p-8">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <span class="font-weight-bold text-muted font-size-sm mr-2">Total</span>
                    <span id="cart_total" class="font-weight-bolder text-dark-50 text-right">£0.00</span>
                </div>
                <div class="text-right">
                    <a href="/cart" type="button" class="btn btn-primary text-weight-bold">View Basket</a>
                    <a href="/checkout" type="button" class="btn btn-success text-weight-bold" id="checkout-cart">Checkout</a>
                    <button type="button" onclick="emptyCart()" class="btn btn-danger text-weight-bold">Empty Basket
                    </button>
                </div>
            </div>
            <!--end::Summary-->
            <!-- end:: Mycart -->
        </form>
    </div>
</div>

<!--end: Cart-->
