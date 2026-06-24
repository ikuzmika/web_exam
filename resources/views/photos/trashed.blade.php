<x-layout>
    <x-slot name="title">
        Deleted photos
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Deleted photos</h1>
            <p>Photos that were soft deleted. Admin can restore them or permanently delete them.</p>
        </div>

        <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
            Back to gallery
        </a>
    </section>

    <section class="content-list">
        @forelse ($photos as $photo)
            <article class="list-card">
                <div class="list-card-content">

                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         alt="{{ $photo->title ?? 'Photo' }}"
                         style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px; opacity: 0.75;">

                    <h2 class="mt-3">
                        {{ $photo->title ?? 'Untitled photo' }}
                    </h2>

                    <p>
                        <strong>Deleted at:</strong>
                        {{ $photo->deleted_at?->format('d.m.Y H:i') }}
                    </p>

                    <p>
                        <strong>Competition:</strong>
                        {{ $photo->competition?->title ?? 'Not specified' }}
                    </p>

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

                    <div class="d-flex gap-2 mt-3">

                        <form method="POST" action="{{ route('photo.restore', $photo->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success">
                                Restore
                            </button>
                        </form>

                        <form method="POST" action="{{ route('photo.forceDelete', $photo->id) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('This will permanently delete the photo. Are you sure?')">
                                Delete permanently
                            </button>
                        </form>

                    </div>

                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>No deleted photos found</h2>
                <p>There are no soft deleted photos.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
