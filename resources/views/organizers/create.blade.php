<x-layout>
    <h3 class="mt-4">Sponsors</h3>

    @foreach($sponsors as $sponsor)
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-check mb-2">
                    <input type="checkbox"
                           class="form-check-input"
                           id="sponsor_{{ $sponsor->id }}"
                           name="sponsors[{{ $sponsor->id }}][selected]"
                           value="1">

                    <label for="sponsor_{{ $sponsor->id }}" class="form-check-label">
                        {{ $sponsor->name }}
                    </label>
                </div>

                <div class="mb-2">
                    <label class="form-label">Contribution type</label>
                    <input type="text"
                           name="sponsors[{{ $sponsor->id }}][contribution_type]"
                           class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label">Amount</label>
                    <input type="number"
                           step="0.01"
                           name="sponsors[{{ $sponsor->id }}][contribution_amount]"
                           class="form-control">
                </div>
            </div>
        </div>
    @endforeach
</x-layout>
