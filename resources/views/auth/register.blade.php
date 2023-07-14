<x-guest-layout>
    <x-jet-authentication-card>

        <div class="allAuth">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <a href="/" class="authLogo">
                    <img src="{{$siteLogo}}" alt="{{$siteLogo}}">
                </a>
                <x-jet-validation-errors class="error" />
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="loginItem">
                    <x-jet-label for="name" value="{{ __('نام') }}" />
                    <x-jet-input id="name" type="text" placeholder="نام را وارد کنید ..." name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="loginItem">
                    <x-jet-label for="email" value="{{ __('ایمیل') }}" />
                    <x-jet-input id="email" type="email" placeholder="ایمیل را وارد کنید ..." name="email" :value="old('email')" required />
                </div>

                <div class="loginItem">
                    <x-jet-label for="password" value="{{ __('رمز') }}" />
                    <x-jet-input id="password" placeholder="رمز را وارد کنید ..." type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="loginItem">
                    <x-jet-label for="password_confirmation" value="{{ __('تکرار رمز') }}" />
                    <x-jet-input id="password_confirmation" placeholder="رمز را وارد کنید ..." type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="forgetPassLogin">
                    <a href="{{ route('login') }}">
                        {{ __('عضو هستید؟') }}
                    </a>

                    <x-jet-button class="ml-4">
                        {{ __('ثبت نام') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
