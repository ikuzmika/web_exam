<x-layout>
    <x-slot name="title">
        {{ __('organizers.create_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('organizers.create_title') }}</h2>

            <p class="text-muted">
                {{ __('organizers.create_description') }}
            </p>

            <form method="POST" action="{{ route('organizer.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('organizers.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="venue" class="form-label">
                        {{ __('organizers.venue') }}
                    </label>

                    <input
                        type="text"
                        name="venue"
                        id="venue"
                        class="form-control"
                        value="{{ old('venue') }}"
                        required
                    >

                    @error('venue')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_person" class="form-label">
                        {{ __('organizers.contact_person') }}
                    </label>

                    <input
                        type="text"
                        name="contact_person"
                        id="contact_person"
                        class="form-control"
                        value="{{ old('contact_person') }}"
                    >

                    @error('contact_person')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        {{ __('organizers.email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="{{ old('email') }}"
                    >

                    @error('email')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">
                        {{ __('organizers.contact_number') }}
                    </label>

                    <input
                        type="text"
                        name="contact_number"
                        id="contact_number"
                        class="form-control"
                        value="{{ old('contact_number') }}"
                    >

                    @error('contact_number')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="profile-section-divider">

                <div class="mb-3">
                    <label class="form-label">
                        {{ __('organizers.sponsors') }}
                    </label>

                    <div class="checkbox-list">
                        @forelse($sponsors as $sponsor)
                            <div class="checkbox-list-item d-block">
                                <label class="d-flex align-items-center gap-2 mb-2">
                                    <input
                                        type="checkbox"
                                        name="sponsors[{{ $sponsor->id }}][selected]"
                                        value="1"
                                        @checked(old("sponsors.$sponsor->id.selected"))
                                    >

                                    <span>{{ $sponsor->name }}</span>
                                </label>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="sponsors[{{ $sponsor->id }}][contribution_type]"
                                            class="form-control"
                                            value="{{ old("sponsors.$sponsor->id.contribution_type") }}"
                                            placeholder="{{ __('organizers.contribution_type') }}"
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="sponsors[{{ $sponsor->id }}][contribution_amount]"
                                            class="form-control"
                                            value="{{ old("sponsors.$sponsor->id.contribution_amount") }}"
                                            placeholder="{{ __('organizers.contribution_amount') }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">
                                {{ __('organizers.no_sponsors_available') }}
                            </p>
                        @endforelse
                    </div>

                    @error('sponsors')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('organizers.create_button') }}
                    </button>

                    <a href="{{ route('organizer.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
