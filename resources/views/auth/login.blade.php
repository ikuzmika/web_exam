<x-layout>
    <x-slot name="title">
        {{ __('auth.login') }}
    </x-slot>

    <section class="auth-page">
        <div class="auth-card">

            <h1>{{ __('auth.welcome_back') }}</h1>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">
                        {{ __('auth.email_address') }}
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="{{ __('auth.enter_your_email') }}"
                        required
                    >

                    @error('email')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        {{ __('auth.password') }}
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="{{ __('auth.enter_your_password') }}"
                        required
                    >

                    @error('password')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                @error('credentials')
                <div class="form-error mb-3">
                    {{ $message }}
                </div>
                @enderror

                <button type="submit" class="btn btn-primary w-100">
                    {{ __('auth.login') }}
                </button>
            </form>

            <p class="auth-bottom-text">
                {{ __('auth.do_not_have_account') }}
                <a href="{{ route('auth.register') }}">
                    {{ __('auth.create_account') }}
                </a>
            </p>
        </div>
    </section>
</x-layout>
