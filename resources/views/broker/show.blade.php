<x-layout>
    <div class="dhl-container">
        <header class="dhl-header">
            <div>
                <h1>Kravas deklarācija | {{ $case->external_ref ?? 'N/A' }}</h1>
            </div>
            <div >
                <span>
                    STATUSS: {{ strtoupper($case->status) }}
                </span>
            </div>
        </header>

        <div class="dhl-grid">
            <section class="dhl-card">
                <h3>Kravas apraksts</h3>
                <p><strong>No:</strong> {{ $case->origin_country }}</p>
                <p><strong>Uz:</strong> {{ $case->destination_country }}</p>
                <p><strong>Prioritāte:</strong> {{ strtoupper($case->priority) }}</p>
                <p><strong>Reģistrēta sistēmā:</strong> {{ $case->arrival_ts?->format('d.m.Y H:i') }}</p>
            </section>

            <section class="dhl-card">
                <h3>Deklarētājs / Saņēmējs</h3>
                <p><strong>Deklarētājs:</strong> {{ $case->declarant->full_name ?? $case->declarant->name ?? $case->client_info ?? 'Sistēmas lietotājs' }}</p>
                <p><strong>Reģ. nr:</strong> {{ $case->declarant->reg_code ?? '-' }}</p>
                <p><strong>Saņēmējs:</strong> {{ $case->consignee->name ?? 'Nav norādīts' }}</p>
                <p><strong>Kontakttālrunis:</strong> {{ $case->declarant->phone ?? '-' }}</p>
            </section>
        </div>

        <section class="dhl-card" style="margin-top: 20px;">
            <h3>Iesniegtā dokumentācija</h3>
            <table class="dhl-table">
                <thead>
                    <tr>
                        <th>Dokumenta tips</th>
                        <th>Faila nosaukums</th>
                        <th>Lapas</th>
                        <th>Augšupielādes laiks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($case->documents as $doc)
                    <tr>
                        <td><strong>{{ $doc->category ?? 'General' }}</strong></td>
                        <td>{{ $doc->filename }}</td>
                        <td>{{ $doc->pages ?? 1 }}</td>
                        <td>{{ $doc->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Nav pievienotu dokumentu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-layout>