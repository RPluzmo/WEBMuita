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
                <p><strong>Riski:</strong> @json($case->risk_flags)</p>
            </section>

            <section class="dhl-card">
                <h3>Auto, kas atbildīgs</h3>
                <p><strong>Numur Zīme:</strong> {{ $case->vehicle->plate_no }}</p>
                <p><strong>Reģistrēts:</strong> {{ $case->vehicle->country }}</p>
                <p><strong>VIN:</strong> {{ $case->vehicle->vin }}</p>
                <p><strong>Ražotājs/Modelis:</strong> {{ $case->vehicle->make }} {{ $case->vehicle->model }}</p>
                <p><strong>ID:</strong> {{ $case->vehicle->id }}</p>
            </section>

            <section class="dhl-card">
                <h3>Saistītie Deklaranti</h3>
                <p><strong>Deklarants:</strong> {{ $case->declarant->name }} ({{ $case->declarant->reg_code }})</p>
                <p><strong>Uzņēmums:</strong> {{ $case->consignee->name ?? 'Nav norādīs' }}</p>
                <p><strong>Kontakt Informācija:</strong> {{ $case->declarant->email ?? 'Nav e-pasta' }} | {{ $case->declarant->phone ?? 'Nav telefona' }}</p>
                <p><strong>VAT:</strong> {{ $case->declarant->vat ?? 'Nav reģistrēts' }}</p>
            </section>
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
                        <th>Augšupielādēja:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($case->documents as $doc)
                    <tr>
                        <td>{{ $doc->category }}</td>
                        <td>{{ $doc->filename }}</td>
                        <td>{{ $doc->mime_type }}</td>
                        <td>{{ $doc->pages }}</td>
                        <td>{{ $doc->uploaded_by }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="dhl-card">
            <h3>Darbinieku darbības:</h3>
            @foreach($case->inspections as $insp)
            <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <p><strong>Tips:</strong> {{ $insp->type }} | <strong>Inspektors:</strong> {{ $insp->inspector->full_name ?? $insp->assigned_to }}</p>
                <p><strong>Rezultāt:</strong> @json($insp->result)</p>
                <p><strong>Pārbaude:</strong> @json($insp->checks)</p>
                <p><small>Laiks: {{ $insp->started_at?->format('H:i') }} - {{ $insp->completed_at?->format('d.m.Y H:i') }}</small></p>
            </div>
            @endforeach
        </section>
    </div>
</x-layout>