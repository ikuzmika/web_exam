<x-layout>
    <x-slot name="title">
        {{ __('sponsors.edit_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('sponsors.edit_title') }}</h2>

            <p class="text-muted">
                {{ __('sponsors.edit_description') }}
            </p>

            <form method="POST" action="{{ route('sponsor.update', $sponsor->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('sponsors.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name', $sponsor->name) }}"
                        required
                    >

                    @error('name')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        {{ __('sponsors.email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="{{ old('email', $sponsor->email) }}"
                    >

                    @error('email')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        {{ __('sponsors.description') }}
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description', $sponsor->description) }}</textarea>

                    @error('description')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3"><label class="form-label"> {{ __('sponsors.organizers') }} </label>
                    <div
                        class="checkbox-list"> @php $oldOrganizers = old('organizers'); @endphp @forelse($organizers as $organizer)
                            @php $pivot = $sponsor->organizers->firstWhere('id', $organizer->id)?->pivot; $isChecked = $oldOrganizers !== null ? isset($oldOrganizers[$organizer->id]['selected']) : $pivot !== null; @endphp
                            <div class="checkbox-list-item d-block"><label class="d-flex align-items-center gap-2 mb-2">
                                    <input type="checkbox" name="organizers[{{ $organizer->id }}][selected]"
                                           value="1" @checked($isChecked) > <span> {{ $organizer->name }} </span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text"
                                                                 name="organizers[{{ $organizer->id }}][contribution_type]"
                                                                 class="form-control"
                                                                 value="{{ old("organizers.{$organizer->id}.contribution_type", $pivot?->contribution_type) }}"
                                                                 placeholder="{{ __('sponsors.contribution_type') }}">
                                    </div>
                                    <div class="col-md-6"><input type="number" step="0.01" min="0"
                                                                 name="organizers[{{ $organizer->id }}][contribution_amount]"
                                                                 class="form-control"
                                                                 value="{{ old("organizers.{$organizer->id}.contribution_amount", $pivot?->contribution_amount) }}"
                                                                 placeholder="{{ __('sponsors.contribution_amount') }}">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0"> {{ __('sponsors.no_organizers_available') }} </p>
                        @endforelse
                    </div>
                    @error('organizers')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    @error('organizers.*.contribution_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    @error('organizers.*.contribution_amount')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>


                @error('organizer_ids')
                <div class="form-error">{{ $message }}</div>
                @enderror

                @error('organizer_ids.*')
                <div class="form-error">{{ $message }}</div>
                @enderror


                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('sponsors.update_button') }}
                    </button>

                    <a href="{{ route('sponsor.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
