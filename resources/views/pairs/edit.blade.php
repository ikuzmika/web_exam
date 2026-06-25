<x-layout>
    <x-slot name="title">
        {{ __('pairs.edit_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('pairs.edit_title') }}</h2>

            <p class="text-muted">
                {{ __('pairs.edit_description') }}
            </p>

            <form method="POST" action="{{ route('pair.update', $pair->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="handler_id" class="form-label">
                        {{ __('pairs.handler') }}
                    </label>

                    <select name="handler_id" id="handler_id" class="form-control" required>
                        <option value="">
                            {{ __('pairs.choose_handler') }}
                        </option>

                        @foreach($handlers as $handler)
                            <option
                                value="{{ $handler->id }}"
                                @selected(old('handler_id', optional($pair->dog)->handler_id) == $handler->id)
                            >
                                {{ $handler->name }} {{ $handler->surname }}
                            </option>
                        @endforeach
                    </select>

                    @error('handler_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="dog_id" class="form-label">
                        {{ __('pairs.dog') }}
                    </label>

                    <select name="dog_id" id="dog_id" class="form-control" required>
                        <option value="">
                            {{ __('pairs.choose_dog') }}
                        </option>

                        @foreach($dogs as $dog)
                            <option
                                value="{{ $dog->id }}"
                                @selected(old('dog_id', $pair->dog_id) == $dog->id)
                            >
                                {{ $dog->name }}
                                —
                                {{ optional($dog->sizeCategory)->name ?? __('common.not_specified') }}
                            </option>
                        @endforeach
                    </select>

                    @error('dog_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="active_from" class="form-label">
                        {{ __('pairs.active_from') }}
                    </label>

                    <input
                        type="date"
                        name="active_from"
                        id="active_from"
                        class="form-control"
                        value="{{ old('active_from', $pair->active_from) }}"
                        required
                    >

                    @error('active_from')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="active_until" class="form-label">
                        {{ __('pairs.active_until') }}
                    </label>

                    <input
                        type="date"
                        name="active_until"
                        id="active_until"
                        class="form-control"
                        value="{{ old('active_until', $pair->active_until) }}"
                    >

                    @error('active_until')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('pairs.update_button') }}
                    </button>

                    <a href="{{ route('pair.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
