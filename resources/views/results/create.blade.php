<x-layout>
    <x-slot name="title">
        {{ __('results.create_title') }}
    </x-slot>

    <section class="profile-page-wrapper">
        <div class="profile-form-card">
            <h2>{{ __('results.create_title') }}</h2>

            <p class="text-muted">
                {{ __('results.create_description') }}
            </p>

            <form method="POST" action="{{ route('result.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="pair_id" class="form-label">
                        {{ __('results.pair') }}
                    </label>

                    <select name="pair_id" id="pair_id" class="form-control" required>
                        <option value="">
                            {{ __('results.choose_pair') }}
                        </option>

                        @foreach($pairs as $pair)
                            <option value="{{ $pair->id }}" @selected(old('pair_id') == $pair->id)>
                                {{ optional(optional($pair->dog)->handler)->name ?? __('common.unknown') }}
                                {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                                &
                                {{ optional($pair->dog)->name ?? __('results.unknown_dog') }}
                            </option>
                        @endforeach
                    </select>

                    @error('pair_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="track_id" class="form-label">
                        {{ __('results.track') }}
                    </label>

                    <select name="track_id" id="track_id" class="form-control" required>
                        <option value="">
                            {{ __('results.choose_track') }}
                        </option>

                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" @selected(old('track_id') == $track->id)>
                                {{ translate_db(optional($track->competition)->title) ?: __('common.not_specified') }}
                                —
                                {{ __('results.track_name', ['name' => $track->name]) }}
                                —
                                {{ optional($track->difficultyLevel)->name ?? __('common.not_specified') }}
                            </option>
                        @endforeach
                    </select>

                    @error('track_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="result_status_id" class="form-label">
                        {{ __('results.status') }}
                    </label>

                    <select name="result_status_id" id="result_status_id" class="form-control" required>
                        <option value="">
                            {{ __('results.choose_status') }}
                        </option>

                        @foreach($result_statuses as $status)
                            <option
                                value="{{ $status->id }}"
                                data-status-name="{{ $status->name }}"
                                @selected(old('result_status_id') == $status->id)
                            >
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('result_status_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="points" class="form-label">
                        {{ __('results.points') }}
                    </label>

                    <input
                        type="number"
                        name="points"
                        id="points"
                        class="form-control"
                        value="{{ old('points') }}"
                        min="0"
                        max="100"
                    >

                    @error('points')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('results.create_button') }}
                    </button>

                    <a href="{{ route('result.index') }}" class="btn btn-outline-primary">
                        {{ __('common.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
    <script>
        const statusSelect = document.getElementById('result_status_id');
        const pointsInput = document.getElementById('points');

        function updatePointsForStatus() {
            const selectedOption = statusSelect.options[statusSelect.selectedIndex];
            const statusName = selectedOption.dataset.statusName;

            if (statusName === 'NS') {
                pointsInput.value = 0;
                pointsInput.readOnly = true;
            } else {
                pointsInput.readOnly = false;
            }
        }

        statusSelect.addEventListener('change', updatePointsForStatus);

        updatePointsForStatus();
    </script>
</x-layout>
