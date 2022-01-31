<main id="main" class="main-site">

    <style>
       .summary-item .row-in-form input[type="password"], .summary-item .row-in-form input[type="text"], .summary-item .row-in-form input[type="tel"] {
	font-size: 13px;
	line-height: 19px;
	display: inline-block;
	height: 43px;
	padding: 2px 20px;
	max-width: 300px;
	width: 100%;
	border: 1px solid #e6e6e6;
}
    </style>

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Checkout</span></li>
            </ul>
        </div>
        <div class=" main-content-area">
            <form wire:submit.prevent="placeOrder" onsubmit="$('#processing').show();">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wrap-address-billing">
                            <h3 class="box-title">Billing Address</h3>
                            <div class="billing-address">
                                <p class="row-in-form">
                                    <label for="fname">first name<span>*</span></label>
                                    <input  type="text" name="fname" value="" placeholder="Your name" wire:model="firstname">
                                    @error('firstname')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="lname">last name<span>*</span></label>
                                    <input  type="text" name="lname" value="" placeholder="Your last name" wire:model="lastname">
                                @error('lastname')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="email">Email Address:</label>
                                    <input  type="email" name="email" value="" placeholder="Type your email" wire:model="email">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="phone">Phone number<span>*</span></label>
                                    <input  type="number" name="phone" value="" placeholder="10 digits format" wire:model="mobile">
                                    @error('mobile')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="add">Tel line:</label>
                                    <input type="text" name="add" value="" placeholder="Telephone line (Optional)" wire:model="line1">

                                </p>
                                <p class="row-in-form">
                                    <label for="country">Country<span>*</span></label>
                                    <input type="text" name="country" value="" placeholder="United States" wire:model="country">
                                    @error('country')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="add">Province:</label>
                                    <input type="text" name="Provice" value="" placeholder="Province" wire:model="province">
                                    @error('province')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="city">Town / City<span>*</span></label>
                                    <input type="text" name="city" value="" placeholder="City name" wire:model="city">
                                    @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="Address">Address:</label>
                                    <input type="number" name="address" value="" placeholder="Your address" wire:model="address">
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </p>


                                    <label class="checkbox-field">
                                        <input name="different-add" id="different-add" value="1" type="checkbox" wire:model="deliver_to_different">
                                        <span>Deliver to a different address?</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>
                    @if($deliver_to_different)
                        <div class="col-md-12">
                            <div class="wrap-address-billing">
                                <h3 class="box-title">Delivery Address</h3>
                                <div class="billing-address">
                                    <p class="row-in-form">
                                        <label for="fname">first name<span>*</span></label>
                                        <input  type="text" name="fname" value="" placeholder="Your name" wire:model="d_firstname">
                                        @error('d_firstname')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="lname">last name<span>*</span></label>
                                        <input  type="text" name="lname" value="" placeholder="Your last name" wire:model="d_lastname">
                                        @error('d_lastname')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="email">Email Addreess:</label>
                                        <input  type="email" name="email" value="" placeholder="Type your email" wire:model="d_email">
                                        @error('d_email')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="phone">Phone number<span>*</span></label>
                                        <input  type="number" name="phone" value="" placeholder="10 digits format" wire:model="d_mobile">
                                        @error('d_mobile')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="add">Tel line:</label>
                                        <input type="text" name="add" value="" placeholder="Telephone line (Optional)" wire:model="d_line1">
                                    </p>
                                    <p class="row-in-form">
                                        <label for="country">Country<span>*</span></label>
                                        <input type="text" name="country" value="" placeholder="United States" wire:model="d_country">
                                        @error('d_country')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="add">Province:</label>
                                        <input type="text" name="Provice" value="" placeholder="Province" wire:model="d_province">
                                        @error('d_province')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="city">Town / City<span>*</span></label>
                                        <input type="text" name="city" value="" placeholder="City name" wire:model="d_city">
                                        @error('d_city')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="Address">Address:</label>
                                        <input type="number" name="address" value="" placeholder="Your address" wire:model="d_address">
                                        @error('d_address')<span class="text-danger">{{$message}}</span>@enderror
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="summary summary-checkout">

                    <div class="summary-item payment-method">

                        <h4 class="title-box">Payment Method</h4>
                        @if($paymentmode == 'card')
                            <div class="wrap-address-billing">
                                @if(Session::has('stripe_error'))
                                   <div class="alert alert-sucess" role="alert">{{Session::get('stripe_error')}}</div>
                                @endif
                                <p class="row-in-form">
                                    <label for="card-no">Card Number:</label>
                                    <input type="text" name="card-no" value="" placeholder="Card Number" wire:model="card_no">
                                    @error('card_no')<span class="text-danger">{{$message}}</span>@enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="exp-month">Expiry Month:</label>
                                    <input type="text" name="exp-month" value="" placeholder="MM" wire:model="exp_month">
                                    @error('exp_month')<span class="text-danger">{{$message}}</span>@enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="exp-year">Expiry Year:</label>
                                    <input type="text" name="exp-year" value="" placeholder="YYYY" wire:model="exp_year">
                                    @error('exp_year')<span class="text-danger">{{$message}}</span>@enderror
                                </p>
                                <p class="row-in-form">
                                    <label for="cvc">CVC:</label>
                                    <input type="password" name="cvc" value="" placeholder="CVC" wire:model="cvc">
                                    @error('cvc')<span class="text-danger">{{$message}}</span>@enderror
                                </p>
                            </div>

                     {{--   @elseif($paymentmode == 'paypal')
                        <div class="wrap-address-billing">
                            @if(Session::has('stripe_error'))
                               <div class="alert alert-sucess" role="alert">{{Session::get('stripe_error')}}</div>
                            @endif
                            <p class="row-in-form">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" placeholder="Name" >
                                @error('')<span class="text-danger">{{$message}}</span>@enderror
                            </p>
                            <p class="row-in-form">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" placeholder="Email" >
                                @error('')<span class="text-danger">{{$message}}</span>@enderror
                            </p>
                            <p class="row-in-form">
                                <label for="phone">Phone Number:</label>
                                <input type="tel" name="phone" id="phone_number" placeholder="Phone Number" >
                                @error('')<span class="text-danger">{{$message}}</span>@enderror
                            </p>
                        </div> --}}
                    @endif

                        <div class="choose-payment-methods">
                            <label class="payment-method">
                                <input name="payment-method" id="payment-method-bank" value="cod" type="radio" wire:model="paymentmode">
                                <span>Cash On Delivery</span>
                                <span class="payment-desc">Order Now Pay on Delivery </span>
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </label>
                            <label class="payment-method">
                                <input name="payment-method" id="payment-method-visa" value="card" type="radio" wire:model="paymentmode">
                                <span>Debit / Credit Card</span>
                                <span class="payment-desc">There are many variations of passages of Lorem Ipsum
                                    available</span>
                                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            </label>
                            <label class="payment-method">
                                <input name="payment-method" id="payment-method-bank" value="momo" type="radio" wire:model="paymentmode">
                                <span>Momo Pay</span>
                                <span class="payment-desc">Order Now Pay on Delivery </span>
                            </label>
                            <label class="payment-method">
                                <div id="paypal-button-container"></div>
                                <input name="payment-method" id="payment-method-paypal" value="paypal" type="radio" wire:model="paymentmode">
                                <span>Flutterwave</span>
                                <span class="payment-desc">You can pay with your credit</span>
                                <span class="payment-desc">card if you don't have a paypal account</span>
                            </label>
                            @error('paymentmode')<span class="text-danger">{{$message}}</span>@enderror
                        </div>

                        @if(Session::has('checkout'))

                        <p class="summary-info grand-total"><span>Grand Total</span> <span
                                class="grand-total-price">${{Session::get('checkout')['total']}}</span></p>

                        @endif

                        @if ($errors->isEmpty())
                            <div wire:ignore id="processing" style="font-size: 22px; margin-bottom:20px;padding-left:37px;color:green;display:none;">
                                <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                <span>Processing...</span>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-medium">Pay order</button>
                    </div>
                    <div class="summary-item shipping-method">
                        <h4 class="title-box f-title">Delivery method</h4>
                        <p class="summary-info"><span class="title">Flat Rate</span></p>
                        <p class="summary-info"><span class="title">Fixed $0</span></p>

                    </div>

                </div>
            </form>
        </div>
        <!--end main content area-->
    </div>
    <!--end container-->

</main>

