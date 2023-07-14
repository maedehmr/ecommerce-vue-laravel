<x-guest-layout>
    <x-jet-authentication-card>
        <div class="allAuth">
            <div class="allVerifyEmail">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <a href="/" class="authLogo">
                        <img src="{{$siteLogo}}" alt="{{$siteLogo}}">
                    </a>
                    @if (session('status') == 'verification-link-sent')
                        <div class="forgotPassSubject">
                            {{ __('پیوند تأیید جدید به آدرس ایمیلی که هنگام ثبت نام ارائه کرده اید ارسال شده است.') }}
                        </div>
                    @endif
                    <div class="forgotPassSubject">
                        {{ __('از ثبت نام شما سپاسگزاریم! قبل از شروع ، آیا می توانید آدرس ایمیل خود را با کلیک بر روی پیوندی که برای شما ایمیل کردیم ، تأیید کنید؟ اگر ایمیل را دریافت نکردید ، ما با کمال میل ایمیل دیگری را برای شما ارسال خواهیم کرد.') }}
                    </div>

                    <x-jet-button type="submit" class="verifyBtn">
                        {{ __('ایمیل تایید را دوباره بفرست') }}
                    </x-jet-button>
                </form>
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
