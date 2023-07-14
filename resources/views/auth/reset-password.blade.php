<x-guest-layout>
    <x-jet-authentication-card>
        <div class="allAuth">
            <form method="POST" action="{{ route('password.update') }}">
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
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="loginItem">
                    <x-jet-label for="email" value="{{ __('ایمیل') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" placeholder="ایمیل را وارد کنید ..." type="email" name="email" :value="old('email', $request->email)" required autofocus />
                </div>

                <div class="loginItem">
                    <x-jet-label for="password" value="{{ __('رمز') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" placeholder="رمز را وارد کنید ..." type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="loginItem">
                    <x-jet-label for="password_confirmation" value="{{ __('تکرار رمز') }}" />
                    <x-jet-input id="password_confirmation" placeholder="رمز را وارد کنید ..." class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="forgetPassLogin">
                    <x-jet-button>
                        {{ __('تغییر رمز') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
