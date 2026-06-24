<x-layout>
    <x-slot name="title">
        Pending photos
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Pending photos</h1>
            <p>Photos waiting for admin approval.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
                Back to gallery
            </a>

            <a href="{{ route('photo.trashed') }}" class="btn btn-outline-danger">
                Deleted photos
            </a>
        </div>
    </section>

    <section class="content-list">
        @forelse ($photos as $photo)
            <article class="list-card">
                <div class="list-card-content">

                    <div class="photo-show-image-wrapper">
                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                             alt="{{ $photo->title ?? 'Photo' }}"
                             class="photo-show-image">
                    </div>

                    <h2 class="mt-3">
                        {{ $photo->title ?? 'Untitled photo' }}
                    </h2>

                    <p>
                        <strong>Status:</strong>
                        <span class="badge bg-warning text-dark">
                            Waiting for approval
                        </span>
                    </p>

                    <p>
                        <strong>Uploaded by:</strong>
                        {{ $photo->uploadedBy?->name ?? 'Unknown user' }}
                    </p>

                    <p>
                        <strong>Uploaded at:</strong>
                        {{ $photo->created_at?->format('d.m.Y H:i') }}
                    </p>

                    @if ($photo->competition)
                        <p>
                            <strong>Competition:</strong>
                            {{ $photo->competition->title }}
                        </p>
                    @endif

                    @if ($photo->track)
                        <p>
                            <strong>Type:</strong>
                            Track scheme
                        </p>

                        <p>
                            <strong>Track:</strong>
                            {{ $photo->track->competition?->title ?? 'No competition' }}
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

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('photo.show', $photo) }}" class="btn btn-outline-primary">
                            View details
                        </a>

                        <form method="POST" action="{{ route('photo.approve', $photo) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success">
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('photo.reject', $photo) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Reject this photo and move it to deleted photos?')">
                                Reject
                            </button>
                        </form>
                    </div>

                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>No pending photos</h2>
                <p>There are no photos waiting for approval.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
