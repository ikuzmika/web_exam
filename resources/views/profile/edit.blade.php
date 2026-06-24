<x-layout>
    <x-slot name="title">
        {{ __('profile.title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <h2>{{ __('profile.account_information') }}</h2>

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('profile.name') }}
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
                        {{ __('profile.email') }}
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
                        {{ __('profile.phone') }}
                    </label>

                    <input type="text"
                           name="phone"
                           id="phone"
                           class="form-control"
                           value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        {{ __('profile.role') }}
                    </label>

                    <input type="text"
                           class="form-control"
                           value="@if ($user->role === 'participant'){{ __('profile.participant') }}
                                  @elseif ($user->role === 'organizer'){{ __('profile.organizer') }}
                                  @elseif ($user->role === 'secretary'){{ __('profile.secretary') }}
                                  @elseif ($user->role === 'admin'){{ __('profile.admin') }}
                                  @else{{ ucfirst($user->role) }}@endif"
                           disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        {{ __('profile.account_status') }}
                    </label>

                    @if ($user->is_blocked)
                        <div>
                        <span class="badge bg-danger">
                            {{ __('profile.blocked') }}
                        </span>
                        </div>
                    @else
                        <div>
                        <span class="badge bg-success">
                            {{ __('profile.active') }}
                        </span>
                        </div>
                    @endif
                </div>

                <hr class="profile-section-divider">

                <h2>{{ __('profile.change_password') }}</h2>

                <p class="text-muted">
                    {{ __('profile.password_help') }}
                </p>

                <div class="mb-3">
                    <label for="current_password" class="form-label">
                        {{ __('profile.current_password') }}
                    </label>

                    <input type="password"
                           name="current_password"
                           id="current_password"
                           class="form-control"
                           autocomplete="current-password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        {{ __('profile.new_password') }}
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        {{ __('profile.confirm_new_password') }}
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control"
                           autocomplete="new-password">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('common.save_changes') }}
                    </button>

                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        {{ __('common.back') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
