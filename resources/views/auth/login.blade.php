<x-guest-layout>
    <x-jet-authentication-card>

            <div class="allAuth">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <a href="/" class="authLogo">
                        <img src="{{$siteLogo}}" alt="{{$siteLogo}}">
                    </a>
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <x-jet-validation-errors class="error"/>
                    <div class="loginItem">
                        <x-jet-label for="email" value="{{ __('ایمیل') }}" />
                        <x-jet-input id="email" type="email" name="email" placeholder="ایمیل را وارد کنید ..." :value="old('email')" required autofocus />
                    </div>

                    <div class="loginItem">
                        <x-jet-label for="password" value="{{ __('رمز') }}" />
                        <x-jet-input id="password" type="password" placeholder="رمز را وارد کنید ..." name="password" required autocomplete="current-password" />
                    </div>


                    <div class="rememberLogin">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                            <span>{{ __('مرا بخاطر بسپار') }}</span>
                        </label>
                    </div>

                    @if ($captcha == '1')
                        <div class="loginCaptcha">
                            {!! NoCaptcha::renderJs('fa', true, '') !!}
                            {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                            <?php
                            $secret  = '';
                            $sitekey = '';
                            $captcha = new \Anhskohbo\NoCaptcha\NoCaptcha($secret, $sitekey);
                            ?>
                            <?php echo $captcha->renderJs(); ?>
                        </div>
                    @endif

                    @if ($google == '1')
                        <div align="center" class="fond">
                            <a href="{{ url('/google-login') }}" class="bouton_google" style="width:200px;">
                                ورود از طریق گوگل
                            </a>
                        </div>
                    @endif

                    <div class="forgetPassLogin">
                        <x-jet-button>
                            {{ __('ورود') }}
                        </x-jet-button>
                        <a href="/register">ثبت نام</a>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('رمز خود را فراموش کردید؟') }}
                            </a>
                        @endif

                    </div>
                </form>
            </div>
        </x-jet-authentication-card>
</x-guest-layout>
