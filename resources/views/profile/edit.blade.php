<x-layout>
    <x-slot name="title">
        My profile
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <h2>Account information</h2>

                <div class="mb-3">
                    <label for="name" class="form-label">
                        Name
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control"
                           value="{{ old('email', $user->email) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">
                        Phone
                    </label>

                    <input type="text"
                           name="phone"
                           id="phone"
                           class="form-control"
                           value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Role
                    </label>

                    <input type="text"
                           class="form-control"
                           value="{{ ucfirst($user->role) }}"
                           disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Account status
                    </label>

                    @if ($user->is_blocked)
                        <div>
                        <span class="badge bg-danger">
                            Blocked
                        </span>
                        </div>
                    @else
                        <div>
                        <span class="badge bg-success">
                            Active
                        </span>
                        </div>
                    @endif
                </div>

                <hr class = "profile-section-divider">

                <h2>Change password</h2>

                <p class="text-muted">
                    Leave password fields empty if you do not want to change your password.
                </p>

                <div class="mb-3">
                    <label for="current_password" class="form-label">
                        Current password
                    </label>

                    <input type="password"
                           name="current_password"
                           id="current_password"
                           class="form-control"
                           autocomplete="current-password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        New password
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        Confirm new password
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control"
                           autocomplete="new-password">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>

                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
