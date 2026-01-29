<x-layout>
   
    
    <div class="dhl-container">
        <header class="dhl-header">
            <h1>Riski</h1>
            <span class="badge badge-red">Priority: {{ strtoupper($case->priority ?? 'NORMAL') }}</span>
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

            <div style="background: #fdebeb; padding: 15px; border: 1px solid var(--dhl-red);">
                    <strong>Atrastie Riski</strong>
                    <ul>
                        @foreach((array)($case->risk_flags ?? []) as $flag)
                            <li>{{ $flag }}</li>
                        @endforeach
                    </ul>
                </div>
            

            <form action="/kases/{{ $case->id }}/update" method="POST">
                    @csrf @method('PUT')
                    <label>Novērtēt Riskus:</label>
                    <select name="priority" class="dhl-form-control">
                        <option value="low" {{ ($case->priority ?? '') == 'low' ? 'selected' : '' }}>Zems</option>S
                        <option value="normal" {{ ($case->priority ?? '') == 'normal' ? 'selected' : '' }}>Vidējs</option>
                        <option value="high" {{ ($case->priority ?? '') == 'high' ? 'selected' : '' }}>Augsts</option>
                    </select>
                    <button type="submit" class="dhl-btn" style="margin-top: 10px;">SAGLABĀT</button>
                </form>

                
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

    </div>
</x-layout>
