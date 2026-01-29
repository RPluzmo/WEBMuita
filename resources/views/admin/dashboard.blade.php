<x-layout>
    <x-slot:title>Admin</x-slot:title>

    <main class="dhl-container">
        
        <div class="dhl-banner" 
            style="background-image: url('');">
            <div class="dhl-banner-content">
                <h2>Administrators</h2>
            </div>
        </div>

        <div >
            <a href="{{ route('admin.users') }}" class="dhl-btn">PĀRVALDĪT LIETOTĀJUS</a>
        </div>
        
        <form action="{{ route('dashboard') }}" method="GET" class="dhl-filter-bar">
            <input type="text" name="search" placeholder="Meklē kravu kā - case-000001" value="{{ request('search') }}" class="dhl-form-control">
            
            <select name="status" class="dhl-form-control">
                <option value="">Visi statusi</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Jauns</option>
                <option value="in_inspection" {{ request('status') == 'in_inspection' ? 'selected' : '' }}>Gaida apskati</option>
                <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Notiek apskate</option>
                <option value="released" {{ request('status') == 'released' ? 'selected' : '' }}>Apskatīta</option>
                <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>Aizturēta</option>
            </select>

            <select name="priority" class="dhl-form-control">
                <option value="">Visas prioritātes</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Augsta</option>
                <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Vidēja</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Zema</option>
            </select>

            <select name="sort_by" class="dhl-form-control">
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Kārtot pēc: Datuma</option>
                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Kārtot pēc: Kravas ID</option>
                <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Kārtot pēc: Prioritātes</option>
            </select>

            <select name="order" class="dhl-form-control">
                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Jaunākāis pirmās</option>
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Vecākās pirmās</option>
            </select>

            <button type="submit" class="dhl-btn">Pielietot</button>
            <a href="{{ route('dashboard') }}" class="dhl-btn" style="background: #ffc400; ">Notīrīt</a>
        </form>

        <section class="dhl-card">
            <h3>VISU KRAVU REĢISTRS</h3>
            <div>
                <table class="dhl-table">
                    <thead>
                        <tr>
                            <th>KRAVAS ID / AUTO</th>
                            <th>KRAVA NO / UZ</th>
                            <th>PRIORITĀTE</th>
                            <th>STATUSS</th>
                            <th>APSKATĪT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($all_cases as $case)
                             <tr>
                                <td><strong>#{{ $case->id }}</strong><br><span>{{ $case->vehicle->plate_no ?? '---' }}</span></td>
                                <td><strong>{{ $case->origin_country }} → {{ $case->destination_country }}</strong></td>
                                <td><span>{{ strtoupper($case->priority) }}</span></td>
                                <td><strong>{{ strtoupper(str_replace('_', ' ', $case->status)) }}</strong></td>
                                <td><a href="/kases/{{ $case->id }}" class="dhl-btn" >SKATĪT</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; ">Krava nav atrasta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $all_cases->appends(request()->query())->links() }}
            </div>
        </section>
    </main>
</x-layout>