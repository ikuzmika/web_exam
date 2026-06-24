<x-layout>
    <x-slot name="title">
        Photo details
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Photo details</h1>
            <p>View information about the selected photo.</p>
        </div>

        <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
            Back to gallery
        </a>
    </section>

    <section class="content-list">
        <article class="list-card">
            <div class="list-card-content">

                <div class="photo-show-image-wrapper">
                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         alt="{{ $photo->title ?? 'Photo' }}" class="photo-show-image">
                </div>
                <h2 class="mt-3">
                    {{ $photo->title ?? 'Untitled photo' }}
                </h2>

                <p>
                    <strong>Status:</strong>

                    @if ($photo->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning text-dark">Waiting for approval</span>
                    @endif
                </p>

                @if($photo->competition)
                    <p>
                        <strong>Competition:</strong>
                        {{ $photo->competition?->title}}
                    </p>
                @endif

                @if ($photo->track)
                    <p>
                        <strong>Track:</strong>
                        {{ $photo->track->competition?->title}}
                        —
                        {{ $photo->track->difficultyLevel?->name ?? 'No level' }}
                        —
                        Track #{{ $photo->track->id }}
                    </p>
                @endif

                @if ($photo->pair)
                    <p>
                        <strong>Pair:</strong>

                        {{ $photo->pair->dog?->handler?->name }}
                        {{ $photo->pair->dog?->handler?->surname }}

                        @if ($photo->pair->dog?->handler && $photo->pair->dog)
                            &
                        @endif

                        {{ $photo->pair->dog?->name }}
                    </p>
                @endif

                <p>
                    <strong>Uploaded by:</strong>
                    {{ $photo->uploadedBy?->name ?? 'Unknown user' }}
                </p>

                <p>
                    <strong>Uploaded at:</strong>
                    {{ $photo->created_at?->format('d.m.Y H:i') }}
                </p>

                <div class="d-flex gap-2 mt-3">
                    @auth
                        @can('update', $photo)
                            <a href="{{ route('photo.edit', $photo) }}" class="btn btn-primary">
                                Edit
                            </a>
                        @endcan

                        @can('delete', $photo)
                            <form method="POST" action="{{ route('photo.destroy', $photo) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this photo?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    @endauth

                    <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
                        Back
                    </a>
                </div>

            </div>
        </article>
    </section>
</x-layout>
