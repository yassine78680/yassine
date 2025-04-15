<aside class="col-lg-4 pt-4 pt-lg-2 px-max-md-0 order-summery-aside">
    <div class="__cart-total __cart-total_sticky">
        <div class="cart_total p-0">
            @php($shippingMethod=getWebConfig(name: 'shipping_method'))
            @php($subTotal=0)
            @php($totalTax=0)
            @php($totalShippingCost=0)
            @php($orderWiseShippingDiscount=\App\Utils\CartManager::order_wise_shipping_discount())
            @php($totalDiscountOnProduct=0)
            @php($cart=\App\Utils\CartManager::getCartListQuery(type: 'checked'))
            @php($cartGroupIds=\App\Utils\CartManager::get_cart_group_ids())
            @php($getShippingCost=\App\Utils\CartManager::get_shipping_cost(type: 'checked'))
            @php($getShippingCostSavedForFreeDelivery=\App\Utils\CartManager::getShippingCostSavedForFreeDelivery(type: 'checked'))
            @if($cart->count() > 0)
                @foreach($cart as $key => $cartItem)
                    @php($subTotal+=$cartItem['price']*$cartItem['quantity'])
                    @php($totalTax+=$cartItem['tax_model']=='exclude' ? ($cartItem['tax']*$cartItem['quantity']):0)
                    @php($totalDiscountOnProduct+=$cartItem['discount']*$cartItem['quantity'])
                @endforeach

                @if(session()->missing('coupon_type') || session('coupon_type') !='free_delivery')
                    @php($totalShippingCost=$getShippingCost - $getShippingCostSavedForFreeDelivery)
                @else
                    @php($totalShippingCost=$getShippingCost)
                @endif
            @endif

            @php($totalSavedAmount = $totalDiscountOnProduct)

            @if(session()->has('coupon_discount') && session('coupon_discount') > 0 && session('coupon_type') !='free_delivery')
                @php($totalSavedAmount += session('coupon_discount'))
            @endif

            @if($getShippingCostSavedForFreeDelivery > 0)
                @php($totalSavedAmount += $getShippingCostSavedForFreeDelivery)
            @endif

            @if($totalSavedAmount > 0)
                <h6 class="text-center text-primary mb-4 d-flex align-items-center justify-content-center gap-2">
                    <img src="{{theme_asset(path: 'public/assets/front-end/img/icons/offer.svg')}}" alt="">
                    {{translate('you_have_Saved')}}
                    <strong>{{ webCurrencyConverter(amount: $totalSavedAmount) }}!</strong>
                </h6>
            @endif

            {{-- Free Delivery by Admin design --}}
            {{-- <div class="__badge badge-soft-primary rounded font-semibold fs-12 p-2 status-badge w-100 d-flex justify-content-center align-items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                    <g clip-path="url(#clip0_11700_41088)">
                      <path d="M8.75416 15.0877C9.38886 14.4925 9.48661 13.5602 8.97249 13.0054C8.45838 12.4506 7.52708 12.4833 6.89239 13.0785C6.25769 13.6737 6.15994 14.606 6.67405 15.1609C7.18817 15.7157 8.11946 15.6829 8.75416 15.0877Z" fill="currentColor"/>
                      <path d="M17.1497 15.0875C17.7844 14.4923 17.8821 13.56 17.368 13.0052C16.8539 12.4503 15.9226 12.4831 15.2879 13.0783C14.6532 13.6735 14.5554 14.6058 15.0696 15.1606C15.5837 15.7154 16.515 15.6827 17.1497 15.0875Z" fill="currentColor"/>
                      <path d="M2.09629 7.80371C2.09629 7.43534 1.79928 7.13672 1.43291 7.13672C1.06654 7.13672 0.769531 7.43534 0.769531 7.80371C0.769531 8.17208 1.06654 8.4707 1.43291 8.4707C1.79928 8.4707 2.09629 8.17208 2.09629 7.80371Z" fill="currentColor"/>
                      <path d="M14.0131 13.9426C14.2488 12.7707 15.3492 11.8395 16.532 11.8395C17.6708 11.8395 18.4917 12.7031 18.4691 13.8137C19.7008 13.8461 20.0437 12.2145 20.0437 12.2145C20.1473 11.7582 20.3023 10.8687 20.432 9.9957C20.4745 9.72616 20.4418 9.45003 20.3376 9.19805C20.0156 8.44196 19.6265 7.71662 19.1751 7.03086C18.7479 6.38984 18.0315 6.01016 17.2138 5.99648C16.7261 5.98867 16.2473 5.98398 15.8858 5.98398L15.8827 5.98086C15.8361 5.19648 15.2677 4.5957 14.4697 4.52383C13.9506 4.47734 11.8942 4.44336 10.9072 4.44336C10.515 4.44336 9.95237 4.44883 9.38313 4.4582V4.45586H9.37847H2.53446C2.44735 4.45581 2.36109 4.47303 2.2806 4.50654C2.20012 4.54005 2.12699 4.5892 2.06539 4.65116C2.0038 4.71312 1.95495 4.78669 1.92164 4.86766C1.88833 4.94863 1.87121 5.03542 1.87126 5.12305V5.12617C1.87126 5.30229 1.9408 5.4712 2.0646 5.59573C2.18839 5.72027 2.35629 5.79023 2.53135 5.79023H3.91095C4.07707 5.80256 4.23242 5.8776 4.34584 6.00033C4.45926 6.12305 4.52237 6.28438 4.52251 6.45195V6.45547C4.52276 6.54318 4.50582 6.63009 4.47266 6.71121C4.43949 6.79233 4.39075 6.86608 4.32922 6.92823C4.2677 6.99038 4.19459 7.03971 4.11409 7.07341C4.03359 7.10711 3.94728 7.12451 3.86008 7.12461H3.15262C2.97683 7.12461 2.80824 7.19486 2.68394 7.31991C2.55964 7.44496 2.48981 7.61456 2.48981 7.79141C2.48975 7.879 2.50686 7.96575 2.54015 8.0467C2.57343 8.12764 2.62225 8.2012 2.6838 8.26316C2.74535 8.32511 2.81844 8.37426 2.89888 8.4078C2.97932 8.44133 3.06554 8.45859 3.15262 8.45859H3.86008C4.03598 8.45859 4.20466 8.52889 4.32904 8.65401C4.45341 8.77913 4.52329 8.94883 4.52329 9.12578C4.52329 9.30273 4.45341 9.47243 4.32904 9.59755C4.20466 9.72268 4.03598 9.79297 3.86008 9.79297H1.21349C1.03767 9.79297 0.86904 9.86321 0.744677 9.98824C0.620314 10.1133 0.550396 10.2829 0.550293 10.4598C0.550293 10.6367 0.620166 10.8064 0.74454 10.9315C0.868914 11.0567 1.0376 11.127 1.21349 11.127H3.86008C4.03598 11.127 4.20466 11.1972 4.32904 11.3224C4.45341 11.4475 4.52329 11.6172 4.52329 11.7941C4.52308 11.971 4.45312 12.1405 4.32876 12.2654C4.20441 12.3904 4.03584 12.4605 3.86008 12.4605H3.04157C2.86578 12.4605 2.69719 12.5308 2.57289 12.6558C2.44859 12.7809 2.37875 12.9505 2.37875 13.1273C2.37875 13.3042 2.44857 13.4739 2.57286 13.599C2.69715 13.7241 2.86574 13.7944 3.04157 13.7945L5.65321 13.7926L5.87027 13.2484C6.31486 12.4234 7.19939 11.8391 8.13594 11.8391C9.31907 11.8391 10.1593 12.7711 10.0669 13.9437H14.0127M7.43508 7.43516H6.54512C6.54427 7.43522 6.54348 7.43557 6.54285 7.43613C6.54222 7.43669 6.54179 7.43745 6.54162 7.43828L6.45969 8.02422C6.45957 8.02469 6.45956 8.02518 6.45966 8.02566C6.45976 8.02613 6.45997 8.02657 6.46027 8.02695C6.46058 8.02733 6.46096 8.02764 6.4614 8.02784C6.46184 8.02804 6.46232 8.02814 6.4628 8.02812H7.12522C7.15774 8.02719 7.19005 8.03358 7.2198 8.0468C7.24955 8.06003 7.27599 8.07977 7.2972 8.10459C7.31841 8.1294 7.33384 8.15866 7.34238 8.19024C7.35091 8.22181 7.35234 8.25491 7.34655 8.28711C7.3352 8.35789 7.29968 8.42247 7.2461 8.46974C7.19252 8.51701 7.12423 8.54401 7.053 8.54609H6.3898C6.38899 8.54607 6.3882 8.54633 6.38757 8.54683C6.38693 8.54733 6.38648 8.54804 6.3863 8.54883L6.26749 9.4C6.25614 9.47078 6.22062 9.53536 6.16704 9.58263C6.11346 9.6299 6.04517 9.6569 5.97394 9.65898C5.94144 9.65993 5.90914 9.65355 5.8794 9.64032C5.84966 9.62709 5.82323 9.60734 5.80206 9.58252C5.78088 9.55769 5.76548 9.52842 5.757 9.49684C5.74851 9.46526 5.74715 9.43218 5.753 9.4L6.06131 7.19219C6.07352 7.11744 6.11119 7.04929 6.16786 6.9994C6.22453 6.94952 6.29667 6.92101 6.37194 6.91875H7.50691C7.53942 6.91781 7.57172 6.92418 7.60146 6.93741C7.6312 6.95064 7.65762 6.97039 7.6788 6.99522C7.69997 7.02004 7.71537 7.04931 7.72386 7.08089C7.73234 7.11247 7.73371 7.14556 7.72785 7.17773C7.71634 7.24816 7.68083 7.31236 7.62741 7.35933C7.57399 7.4063 7.506 7.43311 7.43508 7.43516ZM9.81375 7.09453C9.90621 7.17705 9.97126 7.28613 10.0001 7.40703C10.0324 7.54399 10.0377 7.68599 10.0157 7.825C9.98866 8.0413 9.90068 8.24529 9.76211 8.41289C9.67749 8.51354 9.57 8.59219 9.44876 8.64219C9.44821 8.64277 9.4479 8.64354 9.4479 8.64434C9.4479 8.64513 9.44821 8.6459 9.44876 8.64648L9.6693 9.28672C9.72871 9.45859 9.57611 9.65898 9.38624 9.65898H9.37382C9.32775 9.66035 9.28245 9.64692 9.24447 9.62066C9.2065 9.59439 9.17782 9.55665 9.16259 9.51289L8.89583 8.73164C8.89545 8.73105 8.89493 8.73057 8.89432 8.73023C8.89371 8.72989 8.89303 8.7297 8.89233 8.72969H8.32543C8.32464 8.72973 8.32388 8.73002 8.32326 8.7305C8.32263 8.73099 8.32217 8.73166 8.32194 8.73242L8.22874 9.39961C8.21739 9.47039 8.18187 9.53497 8.12829 9.58224C8.07472 9.62951 8.00643 9.65651 7.9352 9.65859C7.90269 9.65954 7.87039 9.65316 7.84065 9.63993C7.81091 9.6267 7.78449 9.60695 7.76331 9.58213C7.74214 9.5573 7.72674 9.52803 7.71825 9.49645C7.70977 9.46487 7.7084 9.43179 7.71426 9.39961L8.02256 7.1918C8.03478 7.11705 8.07245 7.0489 8.12912 6.99901C8.18578 6.94913 8.25793 6.92062 8.3332 6.91836H9.21073C9.21073 6.91836 9.59592 6.90625 9.81375 7.09453ZM12.2289 7.15937C12.2184 7.22549 12.1852 7.28582 12.1352 7.32996C12.0851 7.3741 12.0213 7.39929 11.9548 7.40117H10.934C10.9332 7.40121 10.9324 7.4015 10.9318 7.40199C10.9312 7.40248 10.9307 7.40315 10.9305 7.40391L10.8493 7.98359C10.8492 7.98406 10.8492 7.98456 10.8493 7.98503C10.8494 7.9855 10.8496 7.98595 10.8499 7.98633C10.8502 7.98671 10.8506 7.98701 10.851 7.98721C10.8515 7.98742 10.8519 7.98752 10.8524 7.9875H11.6453C11.6757 7.9866 11.7059 7.99253 11.7337 8.00487C11.7614 8.01721 11.7861 8.03564 11.8059 8.05882C11.8257 8.08199 11.8401 8.10933 11.8481 8.13883C11.856 8.16832 11.8573 8.19923 11.8519 8.2293C11.8413 8.29541 11.8082 8.35574 11.7581 8.39988C11.7081 8.44403 11.6443 8.46921 11.5778 8.47109H10.7845C10.7837 8.47114 10.7829 8.47142 10.7823 8.47191C10.7817 8.4724 10.7812 8.47307 10.781 8.47383L10.6835 9.17148C10.6835 9.17246 10.6839 9.17339 10.6845 9.17412C10.6852 9.17484 10.6861 9.17529 10.687 9.17539H11.7071C11.7374 9.17449 11.7676 9.18042 11.7954 9.19276C11.8232 9.2051 11.8479 9.22353 11.8677 9.24671C11.8875 9.26989 11.9019 9.29722 11.9098 9.32672C11.9178 9.35621 11.9191 9.38712 11.9136 9.41719C11.9031 9.4833 11.8699 9.54363 11.8199 9.58777C11.7698 9.63192 11.706 9.6571 11.6395 9.65898H10.3737C10.3395 9.65946 10.3057 9.65238 10.2745 9.63824C10.2434 9.6241 10.2157 9.60325 10.1935 9.57716C10.1713 9.55107 10.155 9.52038 10.1459 9.48727C10.1368 9.45416 10.135 9.41943 10.1407 9.38555L10.4471 7.19336C10.4593 7.11861 10.4969 7.05046 10.5536 7.00058C10.6103 6.95069 10.6824 6.92218 10.7577 6.91992H12.0231C12.0532 6.9192 12.083 6.92519 12.1105 6.93744C12.138 6.9497 12.1625 6.96793 12.1822 6.99081C12.2018 7.0137 12.2162 7.04068 12.2243 7.06982C12.2324 7.09897 12.234 7.12955 12.2289 7.15937ZM14.3494 7.15937C14.3388 7.22549 14.3057 7.28582 14.2556 7.32996C14.2056 7.3741 14.1418 7.39929 14.0752 7.40117H13.0544C13.0536 7.40121 13.0529 7.4015 13.0523 7.40199C13.0516 7.40248 13.0512 7.40315 13.0509 7.40391L12.9702 7.98359C12.97 7.98406 12.97 7.98456 12.9701 7.98503C12.9702 7.9855 12.9704 7.98595 12.9707 7.98633C12.971 7.98671 12.9714 7.98701 12.9719 7.98721C12.9723 7.98742 12.9728 7.98752 12.9733 7.9875H13.7662C13.7965 7.9866 13.8267 7.99253 13.8545 8.00487C13.8823 8.01721 13.907 8.03564 13.9268 8.05882C13.9466 8.08199 13.961 8.10933 13.9689 8.13883C13.9769 8.16832 13.9782 8.19923 13.9727 8.2293C13.9622 8.29541 13.929 8.35574 13.879 8.39988C13.8289 8.44403 13.7651 8.46921 13.6986 8.47109H12.9049C12.9041 8.47114 12.9034 8.47142 12.9028 8.47191C12.9021 8.4724 12.9017 8.47307 12.9014 8.47383L12.804 9.17148C12.804 9.17246 12.8043 9.17339 12.805 9.17412C12.8056 9.17484 12.8065 9.17529 12.8075 9.17539H13.8275C13.8579 9.17449 13.8881 9.18042 13.9158 9.19276C13.9436 9.2051 13.9683 9.22353 13.9881 9.24671C14.0079 9.26989 14.0223 9.29722 14.0303 9.32672C14.0382 9.35621 14.0395 9.38712 14.0341 9.41719C14.0235 9.4833 13.9904 9.54363 13.9403 9.58777C13.8903 9.63192 13.8265 9.6571 13.7599 9.65898H12.4941C12.46 9.65946 12.4261 9.65238 12.395 9.63824C12.3639 9.6241 12.3362 9.60325 12.314 9.57716C12.2917 9.55107 12.2755 9.52038 12.2664 9.48727C12.2572 9.45416 12.2554 9.41943 12.2611 9.38555L12.5675 7.19336C12.5797 7.11861 12.6174 7.05046 12.6741 7.00058C12.7307 6.95069 12.8029 6.92218 12.8781 6.91992H14.1436C14.1736 6.9192 14.2035 6.92519 14.231 6.93744C14.2585 6.9497 14.283 6.96793 14.3026 6.99081C14.3223 7.0137 14.3367 7.04068 14.3448 7.06982C14.3528 7.09897 14.3544 7.12955 14.3494 7.15937ZM15.8249 6.90898C16.1716 6.90898 16.6205 6.91367 17.0709 6.92109C17.6168 6.93008 18.0944 7.18242 18.381 7.61289C18.6871 8.07711 18.9622 8.56124 19.2046 9.06211C19.3327 9.32461 19.097 9.66641 18.7883 9.66641H15.4781L15.8249 6.90898Z" fill="currentColor"/>
                      <path d="M9.00349 8.24609H8.38965L8.5062 7.40078H9.11966C9.11966 7.40078 9.56994 7.37148 9.49612 7.82343C9.49806 7.82343 9.44639 8.24609 9.00349 8.24609Z" fill="currentColor"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_11700_41088">
                        <rect width="19.8805" height="20" fill="white" transform="translate(0.55957)"/>
                      </clipPath>
                    </defs>
                  </svg>
                 <span>{{ translate('You have got free Shipping for this order') }}</span>     
            </div> --}}
            {{-- Free Delivery by Admin design ends --}}

            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('sub_total')}}</span>
                <span class="cart_value">
                    {{ webCurrencyConverter(amount: $subTotal) }}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('tax')}}</span>
                <span class="cart_value">
                    {{ webCurrencyConverter(amount: $totalTax) }}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('shipping')}}</span>
                <span class="cart_value">
                    {{ webCurrencyConverter(amount: $totalShippingCost) }}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('discount_on_product')}}</span>
                <span class="cart_value">
                    - {{ webCurrencyConverter(amount: $totalDiscountOnProduct) }}
                </span>
            </div>
            @php($coupon_dis=0)
            @if(auth('customer')->check())

                @if(session()->has('coupon_discount'))
                    @php($couponDiscount = session()->has('coupon_discount')?session('coupon_discount'):0)

                    <div class="d-flex justify-content-between">
                            <span class="cart_title">{{translate('coupon_discount')}}</span>
                            <span class="cart_value">
                                - {{ webCurrencyConverter(amount: $couponDiscount) }}
                            </span>
                    </div>

                    <div class="pt-2">
                        <div class="d-flex align-items-center form-control rounded-pill pl-3 p-1">
                            <img width="24" src="{{asset('public/assets/front-end/img/icons/coupon.svg')}}" alt="">
                            <div class="px-2 d-flex justify-content-between w-100">
                                <div>
                                    {{ session('coupon_code') }}
                                    <span class="text-primary small">( -{{ webCurrencyConverter(amount: $couponDiscount) }} )</span>
                                </div>
                                <div class="bg-transparent text-danger cursor-pointer px-2 get-view-by-onclick" data-link="{{ route('coupon.remove') }}">x</div>
                            </div>
                        </div>
                    </div>
                    @php($coupon_dis=session('coupon_discount'))
                @else
                    <div class="pt-2">
                        <form class="needs-validation coupon-code-form" action="javascript:" method="post" novalidate
                              id="coupon-code-ajax">
                            <div class="d-flex form-control rounded-pill ps-3 p-1">
                                <img width="24" src="{{theme_asset(path: 'public/assets/front-end/img/icons/coupon.svg')}}" alt="">
                                <input class="input_code border-0 px-2 text-dark bg-transparent outline-0 w-100"
                                       type="text" name="code" placeholder="{{translate('coupon_code')}}" required>
                                <button class="btn btn--primary rounded-pill text-uppercase py-1 fs-12" type="button" id="apply-coupon-code">
                                        {{translate('apply')}}
                                    </button>
                            </div>
                            <div class="invalid-feedback">{{translate('please_provide_coupon_code')}}</div>
                        </form>
                    </div>
                    @php($coupon_dis=0)
                @endif
            @endif
            <hr class="my-2">
            <div class="d-flex justify-content-between">
                <span class="cart_title text-primary font-weight-bold">{{translate('total')}}</span>
                <span class="cart_value">
                {{ webCurrencyConverter(amount: $subTotal+$totalTax+$totalShippingCost-$coupon_dis-$totalDiscountOnProduct-$orderWiseShippingDiscount) }}
                </span>
            </div>
        </div>
        @php($company_reliability = getWebConfig(name: 'company_reliability'))
        @if($company_reliability != null)
            <div class="pt-5">
                <div class="footer-slider owl-theme owl-carousel">
                    @foreach ($company_reliability as $key=>$value)
                        @if ($value['status'] == 1 && !empty($value['title']))
                            <div class="">
                                <img class="order-summery-footer-image" alt=""
                                     src="{{ getStorageImages(path: imagePathProcessing(imageData: $value['image'],path:'company-reliability'), type: 'source', source: theme_asset(path: 'public/assets/front-end/img').'/'.$value['item'].'.png') }}">
                                <div class="deal-title">{{translate($value['title'])}}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="pt-4">
            <a class="btn btn--primary btn-block proceed_to_next_button {{$cart->count() <= 0 ? 'custom-disabled' : ''}} action-checkout-function">{{translate('proceed_to_Checkout')}}</a>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a href="{{route('home')}}" class="d-flex align-items-center gap-2 text-primary font-weight-bold">
                <i class="tio-back-ui fs-12"></i> {{translate('continue_Shopping')}}
            </a>
        </div>

    </div>
</aside>

<div class="bottom-sticky3 bg-white p-3 shadow-sm w-100 d-lg-none">
    <div class="d-flex justify-content-center align-items-center fs-14 mb-2">
        <div class="product-description-label fw-semibold text-capitalize">{{translate('total_price')}} :</div>
        &nbsp; <strong
                class="text-base">{{ webCurrencyConverter(amount: $subTotal+$totalTax+$totalShippingCost-$coupon_dis-$totalDiscountOnProduct-$orderWiseShippingDiscount) }}</strong>
    </div>
    <a data-route="{{ Route::currentRouteName() }}"
       class="btn btn--primary btn-block proceed_to_next_button text-capitalize {{$cart->count() <= 0 ? 'custom-disabled' : ''}} action-checkout-function">{{translate('proceed_to_checkout')}}</a>
</div>

@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            orderSummaryStickyFunction()
        });
    </script>
@endpush
