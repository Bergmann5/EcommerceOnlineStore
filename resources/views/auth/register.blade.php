<x-base-layout>
<main id="main" class="main-site left-sidebar">

<div class="container">

    <div class="wrap-breadcrumb">
        <ul>
            <li class="item-link"><a href="/" class="link">home</a></li>
            <li class="item-link"><span>Register</span></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
            <div class=" main-content-area">
                <div class="wrap-login-item ">
                    <div class="register-form form-item ">
                    <x-jet-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('register') }}">
            @csrf

            <fieldset class="wrap-title">
                    <h3 class="form-title">Create an account</h3>
                    <h4 class="form-subtitle">Personal infomation</h4>
            </fieldset>
            <fieldset class="wrap-input">
                <x-jet-label for="name" value="{{ __('Name*') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" placeholder="Your name*" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </fieldset>

            <fieldset class="wrap-input">
                <x-jet-label for="email" value="{{ __('Email Address*') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" placeholder="Email address" name="email" :value="old('email')" required />
            </fieldset>

            <fieldset class="wrap-title">
                                <h3 class="form-title">Login Information</h3>
            </fieldset>

            <fieldset class="wrap-input item-width-in-half left-item ">
                <x-jet-label for="password" value="{{ __('Password*') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" placeholder="Password" name="password" required autocomplete="new-password" />
            </fieldset>

            <fieldset class="wrap-input item-width-in-half ">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password*') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password" />
            </fieldset>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <fieldset>
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
            </fieldset>
            @endif

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="btn btn-sign">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>


                    </div>
                </div>
            </div><!--end main products area-->
        </div>
    </div><!--end row-->

</div><!--end container-->

</main>

</x-base-layout>
