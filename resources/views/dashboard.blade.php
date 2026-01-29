<x-layout>
    <x-slot:title>RHL</x-slot:title>
    <main class="dhl-container">
        
        <div class="tracking-hero">
            <h1>KRAVAS IZSEKOŠANA</h1>

            <form action="{{ route('track') }}" method="GET">
                <input type="text" name="case_id" placeholder="Piemēram: case-000001" required class="tracking-search-field">
                <button type="submit" class="dhl-btn">MEKLĒT</button>
            </form>
            <p>piezīmīte - Ja jūs esat ielādējis projektu un nekas netiek attēlots terminālī ir jāizpilda <b>php artisan api</b> kas ievietos datus no api mysql datubāzē.</p>
        </div>

        @if(isset($search_result))
            <div class="tracking-result-card">
                <div>
                    <div>
                        <h2>Rezultāti: <span>{{ $search_result->id }}</span></h2>
                    </div>
                </div>
                
                <div>
                    <p>Pašreizējais statuss:</p>
                    <h3>
                        @switch($search_result->status)
                            @case('new') Dokumenti saņemti un gaida apstrādi. @break
                            @case('in_inspection') Krava tiek apskatīta. @break
                            @case('released') Krava ir veiksmīgi apsatīta. @break
                            @case('on_hold') Krava ir aizturēta. @break
                            @default Statuss tiek precizēts @break
                        @endswitch
                    </h3>
                    <p>
                        Pēdējās izmaiņas reģistrētas: <strong>{{ $search_result->updated_at->format('d.m.Y') }}</strong>
                    </p>
                </div>

                <div>
                    <p>Maršruts: {{ $search_result->origin_country }} → {{ $search_result->destination_country }}</p>
                </div>
            </div>
        @elseif(request()->has('case_id'))
            <div>
                <h3>Krava nav atrasta</h3>
            </div>
        @endif

    </main>
</x-layout>