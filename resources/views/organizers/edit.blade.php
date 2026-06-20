<x-layout>
    <h3 class="mt-4">Sponsors</h3>

    @foreach($sponsors as $sponsor)
        @php
            $attachedSponsor = $organizer->sponsors->firstWhere('id', $sponsor->id);
            $isSelected = $attachedSponsor !== null;
            $contributionType = $attachedSponsor?->pivot->contribution_type;
            $contribution_amount = $attachedSponsor?->pivot->contribution_amount;
        @endphp

        <input type="checkbox"
               name="sponsors[{{ $sponsor->id }}][selected]"
               value="1"
            {{ $isSelected ? 'checked' : '' }}>

        <input type="text"
               name="sponsors[{{ $sponsor->id }}][contribution_type]"
               value="{{ $contributionType }}">

        <input type="number"
               step="0.01"
               name="sponsors[{{ $sponsor->id }}][contribution_amount]"
               value="{{ $contribution_amount }}">
    @endforeach
</x-layout>
