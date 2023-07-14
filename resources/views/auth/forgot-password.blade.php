<x-guest-layout>
    <x-jet-authentication-card>
        <div class="allAuth">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <a href="/" class="authLogo">
                    <img src="{{$siteLogo}}" alt="{{$siteLogo}}">
                </a>
                <x-jet-validation-errors class="error" />
                @if (session('status'))
                    <div class="error">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="forgotPassSubject">
                    {{ __('رمز عبور خود را فراموش کرده اید؟ مشکلی نیست فقط آدرس ایمیل خود را با ما در میان بگذارید و ما یک لینک تنظیم مجدد رمز عبور را برای شما ارسال خواهیم کرد که به شما امکان می دهد پیوند جدیدی را انتخاب کنید.') }}
                </div>

                <div class="loginItem">
                    <x-jet-label for="email" value="{{ __('ایمیل') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" placeholder="ایمیل را وارد کنید ..." type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="forgetPassLogin">
                    <x-jet-button>
                        {{ __('لینک تنظیم مجدد رمز عبور ایمیل') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
