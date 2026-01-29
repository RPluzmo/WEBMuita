<x-layout>
    
    <div class="dhl-container">
        <header class="dhl-header">
            <div>
                <h1>#{{ $case->id }}</h1>
            </div>
            <span>STATUSS: {{ strtoupper($case->status) }}</span>
        </header>

        <div class="dhl-grid">
            <section class="dhl-card">
                <h3>Kravas apraksts</h3>
                <p><strong>Prioritāte:</strong> {{ strtoupper($case->priority) }}</p>
                <p><strong>Reģistrēta sistēmā:</strong> {{ $case->arrival_ts?->format('d.m.Y H:i') }}</p>
                <p><strong>Pašlaik atrodas:</strong> {{ $case->checkpoint_id }}</p>
                <p><strong>No:</strong> {{ $case->origin_country }}</p>
                <p><strong>Uz:</strong> {{ $case->destination_country }}</p>
            </section>

            <section class="dhl-card">
                <h3>Auto, kas atbildīgs</h3>
                <p><strong>Numur Zīme:</strong> {{ $case->vehicle->plate_no }}</p>
                <p><strong>Reģistrēts:</strong> {{ $case->vehicle->country }}</p>
                <p><strong>Ražotājs/Modelis:</strong> {{ $case->vehicle->make }} {{ $case->vehicle->model }}</p>
            </section>

            <div class="dhl-card">
                <h3>Apskate</h3>
                <form action="/kases/{{ $case->id }}/update" method="POST">
                    @csrf @method('PUT')
                    <select name="status" class="dhl-form-control">
                        <option value="in_inspection">Gaida Apskati</option>
                        <option value="screening">Notiek Apskate</option>
                        <option value="released">Apkatīta</option>
                        <option value="on_hold">Aizturēta</option>
                    </select>
                    <button type="submit" class="dhl-btn">Saglabāt</button>
                </form>
            </div>
        </div>

        <section class="dhl-card">
            <h3>Dokumenti</h3>
            <table class="dhl-table">
                <thead>
                    <tr>
                        <th>Kategorija:</th>
                        <th>Faila Nosaukums:</th>
                        <th>Tips:</th>
                        <th>Lappuses:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($case->documents as $doc)
                    <tr>
                        <td>{{ $doc->category }}</td>
                        <td>{{ $doc->filename }}</td>
                        <td>{{ $doc->mime_type }}</td>
                        <td>{{ $doc->pages }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

    </div>
</x-layout>