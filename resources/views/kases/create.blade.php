<x-layout>
    <x-slot:title>Kravas Deklarācija</x-slot:title>

    <main class="dhl-container">
        <div class="dhl-banner"
             style="background-image: url('https://images.unsplash.com/photo-1580674684081-7617fbf3d745?q=80&w=1000');">
            <div class="dhl-banner-content">
                <h2>Jauna Krava</h2>
            </div>
        </div>

        <section class="dhl-card">
            <h3>KRAVAS DEKLARĀCIJAS FORMA</h3>
            
            <form action="{{ route('kases.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="dhl-grid">
                    <div>
                        <label>Klients</label>
                        <select name="client_type" class="dhl-form-control" id="client_type">
                            <option value="company">Uzņēmums</option>
                            <option value="individual">Privātpersona</option>
                        </select>
                    </div>

                    <div id="company_input_group">
                        <label>Uzņēmuma nosaukums</label>
                        <input type="text" name="company_name" class="dhl-form-control" placeholder="...">
                    </div>
                </div>
                <div class="dhl-grid">
                    <div>
                        <label class="profile-label">Auto reģistrācijas numurs</label>
                        <input type="text" name="plate_no" class="dhl-form-control" required placeholder="Piemēram, AB-1234">
                    </div>
                    <div>
                        <label class="profile-label">Uzņēmuma deklarācija</label>
                        <input type="text" name="checkpoint_id" class="dhl-form-control" placeholder="...">
                    </div>
                </div>

                <div class="dhl-grid">
                    <div>
                        <label class="profile-label">Izcelsmes valsts</label>
                        <input type="text" name="origin_country" class="dhl-form-control" placeholder="LV" required maxlength="2">
                    </div>
                    <div>
                        <label class="profile-label">Galamērķa valsts</label>
                        <input type="text" name="destination_country" class="dhl-form-control" placeholder="LT" required maxlength="2">
                    </div>
                </div>

                <div class="profile-field-group">
                    <label class="profile-label">Pievienot dokumentus</label>
                    <input type="file" name="documents[]">
                </div>

                <div>
                    <button type="submit" class="dhl-btn">IESNIEGT</button>
                    <a href="{{ route('dashboard') }}" class="dhl-btn">ATCELT</a>
                </div>
            </form>
        </section>
    </main>

<script>

    document.getElementById('client_type').addEventListener('change', function() {
        const group = document.getElementById('company_input_group');
        group.style.display = this.value === 'individual' ? 'none' : 'block';
    });
</script>

</x-layout>