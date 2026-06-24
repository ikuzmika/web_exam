<x-layout>
    <x-slot name="title">
        Register
    </x-slot>

    {{-- Register page --}}
    <section class="auth-page">
        <div class="auth-card">
            <span class="page-label">Register</span>
            <h1>Create account</h1>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Enter your name"
                        required
                    >

                    @error('name')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                        placeholder="Create a password"
                        required
                    >

                    @error('password')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm password</label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repeat your password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Register
                </button>
            </form>

            <p class="auth-bottom-text">
                Already have an account?
                <a href="{{ route('auth.login') }}">Login</a>
            </p>
        </div>
    </section>
</x-layout>