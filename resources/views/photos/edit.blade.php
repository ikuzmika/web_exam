<x-layout>
    <x-slot name="title">
        Edit photo
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Edit photo</h1>
            <p>Update photo information.</p>
        </div>
    </section>

    <section class="form-section">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('photo.update', $photo) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Current photo</label>

                <div>
                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         alt="{{ $photo->title ?? 'Photo' }}"
                         style="width: 300px; max-height: 250px; object-fit: cover; border-radius: 12px;">
                </div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Photo title</label>
                <input type="text"
                       name="title"
                       id="title"
                       class="form-control"
                       value="{{ old('title', $photo->title) }}">
            </div>

            <div class="mb-3">
                <label for="competition_id" class="form-label">Competition</label>
                <select name="competition_id" id="competition_id" class="form-control">
                    <option value="">No competition</option>

                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(old('competition_id', $photo->competition_id) == $competition->id)>
                            {{ $competition->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="track_id" class="form-label">Track</label>

                <select name="track_id" id="track_id" class="form-control">
                    <option value="">No track</option>

                    @foreach ($tracks as $track)
                        <option value="{{ $track->id }}" @selected(old('track_id', $photo->track_id) == $track->id)>
                            {{ $track->competition?->title ?? 'No competition' }}
                            —
                            {{ $track->difficultyLevel?->name ?? 'No level' }}
                            —
                            Track #{{ $track->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="pair_id" class="form-label">Pair</label>
                <select name="pair_id" id="pair_id" class="form-control" required>
                    <option value="">Choose pair</option>

                    @foreach ($pairs as $pair)
                        <option value="{{ $pair->id }}" @selected(old('pair_id', $photo->pair_id) == $pair->id)>
                            {{ $pair->dog?->handler?->name }}
                            {{ $pair->dog?->handler?->surname }}
                            &
                            {{ $pair->dog?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">New photo file</label>
                <input type="file"
                       name="photo"
                       id="photo"
                       class="form-control"
                       accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">
                Save changes
            </button>

            <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
                Back
            </a>
        </form>
    </section>
</x-layout>
