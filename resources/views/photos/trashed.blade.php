<x-layout>
    <x-slot name="title">
        {{ __('photos.deleted_photos') }}
    </x-slot>

    <section class="page-header">
        <div>
            <h1>{{ __('photos.deleted_photos') }}</h1>
            <p>{{ __('photos.deleted_description') }}</p>
        </div>

        <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
            {{ __('photos.back_to_gallery') }}
        </a>
    </section>

    <section class="content-list">
        @forelse ($photos as $photo)
            <article class="list-card">
                <div class="list-card-content">

                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         alt="{{ translate_db($photo->title) ?: __('photos.photo') }}"
                         style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px; opacity: 0.75;">

                    <h2 class="mt-3">
                        {{ translate_db($photo->title) ?: __('photos.untitled_photo') }}
                    </h2>

                    <p>
                        <strong>{{ __('common.deleted_at') }}:</strong>
                        {{ $photo->deleted_at?->format('d.m.Y H:i') }}
                    </p>

                    <p>
                        <strong>{{ __('photos.competition') }}:</strong>
                        {{ translate_db($photo->competition?->title) ?: __('common.not_specified') }}
                    </p>

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

                    <p>
                        <strong>{{ __('photos.uploaded_by') }}:</strong>
                        {{ $photo->uploadedBy?->name ?? __('photos.unknown_user') }}
                    </p>

                    @can('force-delete', \App\Models\Photo::class)
                        <div class="d-flex gap-2 mt-3">
                            <form method="POST" action="{{ route('photo.restore', $photo->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-success">
                                    {{ __('common.restore') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('photo.forceDelete', $photo->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm(@js(__('photos.confirm_permanent_delete_photo')))">
                                    {{ __('photos.delete_permanently') }}
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('photos.no_deleted_photos') }}</h2>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
