<x-layout>
    <x-slot name="title">
        {{ __('tracks.edit_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('tracks.edit_title') }}</h2>

            <p class="text-muted">
                {{ __('tracks.edit_description') }}
            </p>

            <form method="POST" action="{{ route('track.update', $track->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('tracks.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name', $track->name) }}"
                        required
                    >

                    @error('name')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="competition_id" class="form-label">
                        {{ __('tracks.competition') }}
                    </label>

                    <select name="competition_id" id="competition_id" class="form-control" required>
                        <option value="">
                            {{ __('tracks.choose_competition') }}
                        </option>

                        @foreach($competitions as $competition)
                            <option value="{{ $competition->id }}" @selected(old('competition_id', $track->competition_id) == $competition->id)>
                                {{ translate_db($competition->title) }}
                            </option>
                        @endforeach
                    </select>

                    @error('competition_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="difficulty_level_id" class="form-label">
                        {{ __('tracks.difficulty_level') }}
                    </label>

                    <select name="difficulty_level_id" id="difficulty_level_id" class="form-control" required>
                        <option value="">
                            {{ __('tracks.choose_difficulty_level') }}
                        </option>

                        @foreach($difficultyLevels as $difficultyLevel)
                            <option value="{{ $difficultyLevel->id }}" @selected(old('difficulty_level_id', $track->difficulty_level_id) == $difficultyLevel->id)>
                                {{ translate_db($difficultyLevel->name) }}
                            </option>
                        @endforeach
                    </select>

                    @error('difficulty_level_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                @php
                    $currentPhoto = $track->schemePhotos->first();
                @endphp

                @if($currentPhoto)
                    <div class="mb-3">
                        <label class="form-label">
                            {{ __('tracks.current_photo') }}
                        </label>

                        <div class="photo-show-image-wrapper">
                            <img
                                src="{{ asset('storage/' . $currentPhoto->file_path) }}"
                                alt="{{ $currentPhoto->title ?? __('tracks.track_photo') }}"
                                class="photo-show-image"
                            >
                        </div>

                        <label class="d-flex align-items-center gap-2 mt-3">
                            <input
                                type="checkbox"
                                name="delete_scheme_photo"
                                value="1"
                            >

                            <span>{{ __('tracks.delete_current_photo') }}</span>
                        </label>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="scheme_photo" class="form-label">
                        {{ $currentPhoto ? __('tracks.replace_photo') : __('tracks.track_photo') }}
                    </label>

                    <input
                        type="file"
                        name="scheme_photo"
                        id="scheme_photo"
                        class="form-control"
                        accept="image/*"
                    >

                    @error('scheme_photo')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('tracks.update_button') }}
                    </button>

                    <a href="{{ route('track.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
