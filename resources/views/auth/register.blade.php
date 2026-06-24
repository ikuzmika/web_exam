<x-layout>
    <x-slot name="title">
        {{ __('auth.register') }}
    </x-slot>

    <section class="auth-page">
        <div class="auth-card">

            <h1>{{ __('auth.create_account') }}</h1>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('auth.name') }}
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="{{ __('auth.enter_your_name') }}"
                        required
                    >

                    @error('name')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

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
                        placeholder="{{ __('auth.create_password') }}"
                        required
                    >

                    @error('password')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        {{ __('auth.confirm_password') }}
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="{{ __('auth.repeat_password') }}"
                        required
                    >

                    @error('password_confirmation')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    {{ __('auth.register') }}
                </button>
            </form>

            <p class="auth-bottom-text">
                {{ __('auth.already_registered') }}
                <a href="{{ route('auth.login') }}">
                    {{ __('auth.login') }}
                </a>
            </p>
        </div>
    </section>
</x-layout>
