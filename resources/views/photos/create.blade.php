<x-layout>
    <x-slot name="title">
        {{ __('photos.upload_photo') }}
    </x-slot>

    <section class="page-header">
        <div>
            <h1>{{ __('photos.upload_photo') }}</h1>
            <p>{{ __('photos.create_description') }}</p>
        </div>
    </section>

    <section class="form-section">

        <form method="POST" action="{{ route('photo.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">
                    {{ __('photos.photo_title') }}
                </label>

                <input type="text"
                       name="title"
                       id="title"
                       class="form-control"
                       value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="competition_id" class="form-label">
                    {{ __('photos.competition') }}
                </label>

                <select name="competition_id" id="competition_id" class="form-control">
                    <option value="">
                        {{ __('competitions.choose_competition') }}
                    </option>

                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(old('competition_id') == $competition->id)>
                            {{ translate_db($competition->title) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="track_id" class="form-label">
                    {{ __('photos.track') }}
                </label>

                <select name="track_id" id="track_id" class="form-control">
                    <option value="">
                        {{ __('tracks.choose_track') }}
                    </option>

                    @foreach ($tracks as $track)
                        <option value="{{ $track->id }}" @selected(old('track_id') == $track->id)>
                            {{ translate_db($track->competition?->title) ?: __('competitions.no_competition') }}
                            —
                            {{ translate_db($track->difficultyLevel?->name) ?: __('tracks.no_level') }}
                            —
                            {{ __('tracks.track_number', ['id' => $track->id]) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="pair_id" class="form-label">
                    {{ __('photos.pair') }}
                </label>

                <select name="pair_id" id="pair_id" class="form-control">
                    <option value="">
                        {{ __('pairs.choose_pair') }}
                    </option>

                    @foreach ($pairs as $pair)
                        <option value="{{ $pair->id }}" @selected(old('pair_id') == $pair->id)>
                            {{ $pair->dog?->handler?->name }}
                            {{ $pair->dog?->handler?->surname }}
                            &
                            {{ $pair->dog?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">
                    {{ __('photos.photo_file') }}
                </label>

                <input type="file"
                       name="photo"
                       id="photo"
                       class="form-control"
                       accept="image/*"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('photos.upload') }}
            </button>

            <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </form>
    </section>
</x-layout>
