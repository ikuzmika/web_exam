<x-layout>
    <x-slot name="title">
        Agility Latvia
    </x-slot>

    {{-- Main welcome section --}}
    <section class="hero-section">
        <div class="hero-content">
            <span class="hero-label">Agility competition system</span>

            <h1 class="hero-title">
                Agility Latvia
            </h1>

            <p class="hero-text">
                A web system for viewing agility competitions, tracks, results,
                rankings, participating pairs and competition photos.
            </p>
        </div>
    </section>

    {{-- Main page preview section with search and planned competitions --}}
    <section class="home-dashboard">
        <div class="row g-4">

            {{-- Quick search block --}}
            <div class="col-lg-3">
                <div class="search-panel">
                    <h2>Quick search</h2>

                    <form>
                        <div class="mb-3">
                            <label for="handlerName" class="form-label">Handler name</label>
                            <input type="text" id="handlerName" class="form-control" placeholder="Enter handler name">
                        </div>

                        <div class="mb-3">
                            <label for="dogName" class="form-label">Dog name</label>
                            <input type="text" id="dogName" class="form-control" placeholder="Enter dog name">
                        </div>

                        <div class="mb-3">
                            <label for="competitionName" class="form-label">Competition name</label>
                            <input type="text" id="competitionName" class="form-control" placeholder="Enter competition">
                        </div>

                        <button type="button" class="btn btn-primary w-100">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            {{-- Planned competitions --}}
            <div class="col-lg-9">
                <div class="section-heading">
                    <h2>Planned competitions</h2>
                    <a href="{{ route('competition.index') }}" class="card-link">
                        View all
                    </a>
                </div>

                @forelse($upcomingCompetitions as $competition)
                    <div class="competition-preview-card">
                        <div class="competition-preview-content">
                            <h3>{{ $competition->title }}</h3>

                            <p>
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                            </p>

                            <p>
                                <strong>Venue:</strong>
                                {{ optional($competition->organizer)->venue ?? 'Not specified' }}
                            </p>

                            <a href="{{ route('competition.show', $competition->id) }}" class="btn btn-primary btn-sm">
                                Open
                            </a>
                        </div>

                        <div class="competition-image-placeholder">
                            Competition image
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <h2>No planned competitions</h2>
                        <p>There are no upcoming competitions added yet.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>
</x-layout>