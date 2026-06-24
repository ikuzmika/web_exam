<x-layout>
    <x-slot name="title">
        {{ __('photos.gallery_title') }}
    </x-slot>
    <section class="page-header">
        <div>
            <h1>{{ __('photos.gallery_title') }}</h1>
            <p>{{ __('photos.gallery_description') }}</p>
        </div>

        <div class="d-flex gap-2">
            @auth
                @can('create', App\Models\Photo::class)
                    <a href="{{ route('photo.create') }}" class="btn btn-primary">
                        {{ __('photos.upload_photo') }}
                    </a>
                @endcan

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('photo.pending') }}" class="btn btn-outline-primary">
                        {{ __('photos.pending_photos') }}
                    </a>

                    <a href="{{ route('photo.trashed') }}" class="btn btn-outline-danger">
                        {{ __('photos.deleted_photos') }}
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
                         alt="{{ translate_db($photo->title) ?: __('photos.photo') }}"
                         style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px;">

                    <h2 class="mt-3">
                        {{ translate_db($photo->title) ?: __('photos.untitled_photo') }}
                    </h2>

                    @if($photo->competition)
                        <p>
                            <strong>{{ __('photos.competition') }}:</strong>
                            {{ translate_db($photo->competition?->title) ?: __('common.not_specified') }}
                        </p>
                    @endif

                    @if ($photo->track)
                        <p>
                            <strong>{{ __('photos.track') }}:</strong>
                            {{ translate_db($photo->track->competition?->title) ?: __('competitions.no_competition') }}
                            —
                            {{ translate_db($photo->track->difficultyLevel?->name) ?: __('tracks.no_level') }}
                            —
                            {{ __('tracks.track_number', ['id' => $photo->track->id]) }}
                        </p>
                    @endif

                    @if ($photo->pair)
                        <p>
                            <strong>{{ __('photos.pair') }}:</strong>
                            {{ $photo->pair->dog?->handler?->name }}
                            {{ $photo->pair->dog?->handler?->surname }}
                            &
                            {{ $photo->pair->dog?->name }}
                        </p>
                    @endif

                    <p>
                        <strong>{{ __('photos.uploaded_by') }}:</strong>
                        {{ $photo->uploadedBy?->name ?? __('photos.unknown_user') }}
                    </p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('photo.show', $photo) }}" class="btn btn-outline-primary btn-sm">
                            {{ __('common.view_details') }}
                        </a>

                        @auth
                            @can('update', $photo)
                                <a href="{{ route('photo.edit', $photo) }}" class="btn btn-outline-primary btn-sm">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan

                            @can('delete', $photo)
                                <form method="POST" action="{{ route('photo.destroy', $photo) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('{{ __('photos.confirm_delete_photo') }}')">
                                        {{ __('common.delete') }}
                                    </button>
                                </form>
                            @endcan
                        @endauth
                    </div>

                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('photos.no_photos_found') }}</h2>
                <p>{{ __('photos.no_photos_description') }}</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
