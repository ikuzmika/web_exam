<x-layout>
    <x-slot name="title">
        Login
    </x-slot>

    {{-- Login page --}}
    <section class="auth-page">
        <div class="auth-card">
            <span class="page-label">Login</span>

            <h1>Welcome back!</h1>

            <p class="auth-text">
                Log in to manage agility competitions, results, pairs and photos.
            </p>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                    >

                    @error('email')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
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
                    Login
                </button>
            </form>

            <p class="auth-bottom-text">
                Do not have an account?
                <a href="{{ route('auth.register') }}">Create account</a>
            </p>
        </div>
    </section>
</x-layout>