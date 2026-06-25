<x-layout>
    <x-slot name="title">
        {{ __('competitions.edit_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('competitions.edit_title') }}</h2>

            <form method="POST" action="{{ route('competition.update', $competition->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">
                        {{ __('competitions.title_field') }}
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title', $competition->title) }}"
                        required
                    >

                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">
                        {{ __('competitions.date') }}
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        class="form-control"
                        value="{{ old('date', \Carbon\Carbon::parse($competition->date)->format('Y-m-d')) }}"
                        required
                    >

                    @error('date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="organizer_id" class="form-label">
                        {{ __('competitions.organizer') }}
                    </label>

                    <select name="organizer_id" id="organizer_id" class="form-control" required>
                        <option value="">
                            {{ __('common.not_specified') }}
                        </option>

                        @foreach($organizers as $organizer)
                            <option
                                value="{{ $organizer->id }}"
                                @selected(old('organizer_id', $competition->organizer_id) == $organizer->id)
                            >
                                {{ translate_db($organizer->name) }}
                                —
                                {{ translate_db($organizer->venue) }}
                            </option>
                        @endforeach
                    </select>

                    @error('organizer_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="judge_id" class="form-label">
                        Judge
                    </label>

                    <select name="judge_id" id="judge_id" class="form-control" required>
                        <option value="">
                            {{ __('common.not_specified') }}
                        </option>

                        @foreach($judges as $judge)
                            <option
                                value="{{ $judge->id }}"
                                @selected(old('judge_id', $competition->judge_id) == $judge->id)
                            >
                                {{ $judge->name }} {{ $judge->surname }}
                            </option>
                        @endforeach
                    </select>

                    @error('judge_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                @php
                    $competitionPhoto = $competition->photo
                        ->where('title', 'Competition card photo')
                        ->first();

                    if (!$competitionPhoto) {
                        $competitionPhoto = $competition->photo->first();
                    }
                @endphp

                @if($competitionPhoto)
                    <div class="mb-3">
                        <label class="form-label">
                            Current competition image
                        </label>

                        <div class="photo-show-image-wrapper">
                            <img
                                src="{{ asset('storage/' . $competitionPhoto->file_path) }}"
                                alt="{{ __('competitions.competition_image') }}"
                                class="photo-show-image"
                            >
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="competition_photo" class="form-label">
                        {{ __('competitions.competition_image') }}
                    </label>

                    <input
                        type="file"
                        name="competition_photo"
                        id="competition_photo"
                        class="form-control"
                        accept="image/*"
                    >

                    @error('competition_photo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('competitions.update_button') }}
                    </button>

                    <a href="{{ route('competition.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>