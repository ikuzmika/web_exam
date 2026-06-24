<x-layout>
    <x-slot name="title">
        Photo gallery
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Photo gallery</h1>
            <p>Photos from agility competitions.</p>
        </div>

        <div class="d-flex gap-2">
            @auth
                @can('create', App\Models\Photo::class)
                    <a href="{{ route('photo.create') }}" class="btn btn-primary">
                        Upload photo
                    </a>
                @endcan

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('photo.pending') }}" class="btn btn-outline-primary">
                        Pending photos
                    </a>

                    <a href="{{ route('photo.trashed') }}" class="btn btn-outline-danger">
                        Deleted photos
                    </a>
                @endif
            @endauth
        </div>
    </section>

    <section class="content-list">
        @forelse ($photos as $photo)
            <article class="list-card">
                <div class="list-card-content">
                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         alt="{{ $photo->title ?? 'Photo' }}"
                         style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px;">

                    <h2 class="mt-3">
                        {{ $photo->title ?? 'Untitled photo' }}
                    </h2>

                    @if($photo->competition)
                        <p>
                            <strong>Competition:</strong>
                            {{ $photo->competition?->title ?? 'Not specified' }}
                        </p>

                    @endif

                    @if ($photo->track)
                        <p>
                            <strong>Track:</strong>
                            {{ $photo->track->competition?->title}}
                            —
                            {{ $photo->track->difficultyLevel?->name}}
                            —
                            Track #{{ $photo->track->id }}
                        </p>
                    @endif

                    @if ($photo->pair)
                        <p>
                            <strong>Pair:</strong>
                            {{ $photo->pair->dog?->handler?->name }}
                            {{ $photo->pair->dog?->handler?->surname }}
                            &
                            {{ $photo->pair->dog?->name }}
                        </p>
                    @endif

                    <p>
                        <strong>Uploaded by:</strong>
                        {{ $photo->uploadedBy?->name ?? 'Unknown user' }}
                    </p>

                    <div class="d-flex gap-2">

                        <a href="{{ route('photo.show', $photo) }}" class="btn btn-outline-primary btn-sm">
                            View details
                        </a>

                        @auth
                            @can('update', $photo)
                                <a href="{{ route('photo.edit', $photo) }}" class="btn btn-outline-primary btn-sm">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $photo)
                                <form method="POST" action="{{ route('photo.destroy', $photo) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        @endauth
                    </div>

                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>No photos found</h2>
                <p>There are no photos in the gallery yet.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
