<x-layout>
    <x-slot name="title">
        {{ __('photos.pending_photos') }}
    </x-slot>
    <section class="page-header">
        <div>
            <h1>{{ __('photos.pending_photos') }}</h1>
            <p>{{ __('photos.pending_description') }}</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
                {{ __('photos.back_to_gallery') }}
            </a>

            <a href="{{ route('photo.trashed') }}" class="btn btn-outline-danger">
                {{ __('photos.deleted_photos') }}
            </a>
        </div>
    </section>

    <section class="content-list">
        @forelse ($photos as $photo)
            <article class="list-card">
                <div class="list-card-content">

                    <div class="photo-show-image-wrapper">
                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                             alt="{{ translate_db($photo->title) ?: __('photos.photo') }}"
                             class="photo-show-image">
                    </div>

                    <h2 class="mt-3">
                        {{ translate_db($photo->title) ?: __('photos.untitled_photo') }}
                    </h2>

                    <p>
                        <strong>{{ __('photos.status') }}:</strong>
                        <span class="badge bg-warning text-dark">
                        {{ __('photos.waiting_for_approval') }}
                    </span>
                    </p>

                    <p>
                        <strong>{{ __('photos.uploaded_by') }}:</strong>
                        {{ $photo->uploadedBy?->name ?? __('photos.unknown_user') }}
                    </p>

                    <p>
                        <strong>{{ __('photos.uploaded_at') }}:</strong>
                        {{ $photo->created_at?->format('d.m.Y H:i') }}
                    </p>

                    @if ($photo->competition)
                        <p>
                            <strong>{{ __('photos.competition') }}:</strong>
                            {{ translate_db($photo->competition->title) }}
                        </p>
                    @endif

                    @if ($photo->track)
                        <p>
                            <strong>{{ __('photos.type') }}:</strong>
                            {{ __('photos.track_scheme') }}
                        </p>

                        <p>
                            <strong>{{ __('photos.track') }}:</strong>
                            {{ translate_db($photo->track->competition?->title) ?: __('competitions.no_competition') }}
                            —
                            {{ translate_db($photo->track->difficultyLevel?->name) ?: __('tracks.no_level') }}
                            —
                            {{ __('tracks.track_number', ['id' => $photo->track->id]) }}
                        </p>
                    @else
                        <p>
                            <strong>{{ __('photos.type') }}:</strong>
                            {{ __('photos.gallery_photo') }}
                        </p>
                    @endif

                    @if ($photo->pair)
                        <p>
                            <strong>{{ __('photos.pair') }}:</strong>

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
                            {{ __('common.view_details') }}
                        </a>

                        <form method="POST" action="{{ route('photo.approve', $photo) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success">
                                {{ __('photos.approve') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('photo.reject', $photo) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('{{ __('photos.confirm_reject_photo') }}')">
                                {{ __('photos.reject') }}
                            </button>
                        </form>
                    </div>

                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('photos.no_pending_photos') }}</h2>
                <p>{{ __('photos.no_pending_photos_description') }}</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
