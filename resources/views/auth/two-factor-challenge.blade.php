<x-guest-layout>
    <x-jet-authentication-card>
        <div x-data="{ recovery: false }">
            <div class="allAuth">
                <form method="POST" action="/two-factor-challenge">
                    @csrf
                    <a href="/" class="authLogo">
                        <img src="{{$siteLogo}}" alt="{{$siteLogo}}">
                    </a>
                    <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                        {{ __('لطفاً با وارد کردن کد احراز هویت ارائه شده توسط برنامه تأیید اعتبار ، دسترسی به حساب خود را تأیید کنید.') }}
                    </div>

                    <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                        {{ __('لطفاً با وارد کردن یکی از کدهای بازیابی اضطراری ، دسترسی به حساب خود را تأیید کنید.') }}
                    </div>

                    <x-jet-validation-errors class="error" />
                    <div class="loginItem" x-show="! recovery">
                        <x-jet-label for="code" value="{{ __('کد') }}" />
                        <x-jet-input id="code" class="block mt-1 w-full" placeholder="کد را وارد کنید ..." type="text" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    </div>

                    <div class="loginItem" x-show="recovery">
                        <x-jet-label for="recovery_code" value="{{ __('کد بازیابی') }}" />
                        <x-jet-input id="recovery_code" class="block mt-1 w-full" placeholder="کد را وارد کنید ..." type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    </div>

                    <div class="forgetPassLogin">
                        <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                x-show="! recovery"
                                x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                            {{ __('از کد بازیابی استفاده کنید') }}
                        </button>

                        <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                x-show="recovery"
                                x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                            {{ __('از کد احراز هویت استفاده کنید') }}
                        </button>

                        <x-jet-button class="ml-4">
                            {{ __('ورود') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
