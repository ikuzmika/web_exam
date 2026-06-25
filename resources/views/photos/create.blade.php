<x-layout>
    <x-slot name="title">
        {{ __('photos.upload_photo') }}
    </x-slot>

    <section class="profile-page-wrapperr">
        <div class="profile-form-card">
            <h1>{{ __('photos.upload_photo') }}</h1>
            <p>{{ __('photos.create_description') }}</p>


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
                                <option
                                    value="{{ $competition->id }}" @selected(old('competition_id') == $competition->id)>
                                    {{ translate_db($competition->title) }}
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
        </div>
    </section>
</x-layout>
