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

            {{-- Planned competitions block --}}
            <div class="col-lg-9">
                <div class="section-heading">
                    <h2>Planned competitions</h2>
                    <a href="{{ route('competition.index') }}" class="card-link">
                        View all
                    </a>
                </div>

                <div class="competition-preview-card">
                    <div class="competition-preview-content">
                        <h3>Agility Competition in Zvejniekciems</h3>
                        <p><strong>Date:</strong> 05.06.2026</p>
                        <p><strong>Venue:</strong> Zvejniekciems</p>

                        <a href="{{ route('competition.index') }}" class="btn btn-primary btn-sm">
                            Open
                        </a>
                    </div>

                    <div class="competition-image-placeholder">
                        Competition image
                    </div>
                </div>

                <div class="competition-preview-card">
                    <div class="competition-preview-content">
                        <h3>Rēzekne Spring Cup 2026</h3>
                        <p><strong>Date:</strong> 11.05.2026</p>
                        <p><strong>Venue:</strong> Rēzekne</p>

                        <a href="{{ route('competition.index') }}" class="btn btn-primary btn-sm">
                            Open
                        </a>
                    </div>

                    <div class="competition-image-placeholder">
                        Competition image
                    </div>
                </div>

                <div class="competition-preview-card">
                    <div class="competition-preview-content">
                        <h3>National Agility Championship</h3>
                        <p><strong>Date:</strong> 31.05.2026</p>
                        <p><strong>Venue:</strong> Riga</p>

                        <a href="{{ route('competition.index') }}" class="btn btn-primary btn-sm">
                            Open
                        </a>
                    </div>

                    <div class="competition-image-placeholder">
                        Competition image
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-layout>