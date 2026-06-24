<x-layout>
    <x-slot name="title">
        {{ __('photos.photo_details') }}
    </x-slot>

    <section class="page-header">
        <div>
            <h1>{{ __('photos.photo_details') }}</h1>
            <p>{{ __('photos.show_description') }}</p>
        </div>

        <a href="{{ route('photo.index') }}" class="btn btn-outline-primary">
            {{ __('photos.back_to_gallery') }}
        </a>
    </section>

    <section class="content-list">
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

                <p>
                    <strong>{{ __('photos.uploaded_at') }}:</strong>
                    {{ $photo->created_at?->format('d.m.Y H:i') }}
                </p>

                <div class="d-flex gap-2 mt-3">
                    @auth
                        @can('update', $photo)
                            <a href="{{ route('photo.edit', $photo) }}" class="btn btn-primary">
                                {{ __('common.edit') }}
                            </a>
                        @endcan

                        @can('delete', $photo)
                            <form method="POST" action="{{ route('photo.destroy', $photo) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm(@js(__('photos.confirm_delete_photo')))">
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        @endcan
                    @endauth
                </div>
            </div>
        </article>
    </section>
</x-layout>
