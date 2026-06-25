<x-layout>
    <x-slot name="title">
        {{ __('dogs.add_dog') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('dogs.add_dog') }}</h2>

            <form method="POST" action="{{ route('dog.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('dogs.dog') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        maxlength="100"
                        required
                    >

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="handler_id" class="form-label">
                        {{ __('dogs.handler') }}
                    </label>

                    <select name="handler_id" id="handler_id" class="form-control" required>
                        <option value="">
                            {{ __('common.not_specified') }}
                        </option>

                        @foreach($handler as $oneHandler)
                            <option value="{{ $oneHandler->id }}" @selected(old('handler_id') == $oneHandler->id)>
                                {{ $oneHandler->name }} {{ $oneHandler->surname }}
                            </option>
                        @endforeach
                    </select>

                    @error('handler_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="size_category_id" class="form-label">
                        {{ __('dogs.dog_size') }}
                    </label>

                    <select name="size_category_id" id="size_category_id" class="form-control" required>
                        <option value="">
                            {{ __('common.not_specified') }}
                        </option>

                        @foreach($size as $oneSize)
                            <option value="{{ $oneSize->id }}" @selected(old('size_category_id') == $oneSize->id)>
                                {{ $oneSize->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('size_category_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        {{ __('dogs.description') }}
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="3"
                        maxlength="255"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('common.create') }}
                    </button>

                    <a href="{{ route('dog.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>