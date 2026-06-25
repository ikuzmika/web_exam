<x-layout>
    <x-slot name="title">
        {{ __('common.edit') }} {{ __('handlers.title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('common.edit') }} {{ __('handlers.title') }}</h2>

            <form method="POST" action="{{ route('handler.update', $handler->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('handlers.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name', $handler->name) }}"
                        maxlength="60"
                        required
                    >

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="surname" class="form-label">
                        {{ __('handlers.surname') }}
                    </label>

                    <input
                        type="text"
                        name="surname"
                        id="surname"
                        class="form-control"
                        value="{{ old('surname', $handler->surname) }}"
                        maxlength="60"
                        required
                    >

                    @error('surname')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        {{ __('handlers.email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="{{ old('email', $handler->email) }}"
                        maxlength="20"
                    >

                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">
                        {{ __('handlers.contact_number') }}
                    </label>

                    <input
                        type="text"
                        name="contact_number"
                        id="contact_number"
                        class="form-control"
                        value="{{ old('contact_number', $handler->contact_number) }}"
                        maxlength="20"
                    >

                    @error('contact_number')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('common.save_changes') }}
                    </button>

                    <a href="{{ route('handler.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>