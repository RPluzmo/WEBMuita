<x-layout>
    <x-slot:title>Reģistrēties</x-slot:title>

    <div class="auth-wrapper">
        <div class="auth-card" style="max-width: 500px;">
            <h1>Reģistrēties</h1>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="stat-label">Vārds</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                               class="dhl-form-control" required>
                        @error('first_name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="stat-label">Uzvārds</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                               class="dhl-form-control" required>
                        @error('last_name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label class="stat-label">Izveidot paroli</label>
                    <input type="password" name="password" class="dhl-form-control" required>
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="dhl-btn" style="width: 100%;">REĢISTRĒT KONTU</button>

                <div class="auth-footer">
                    <a href="{{ route('login') }}" style="color: #9e9e9e; text-decoration: none;">Varbūt jums tomēr ir lietotājprofils? <strong style="color: var(--dhl-red);">Ienākt</strong></a>
                </div>
                <div>
                    <p><i>Piezīmīte par login</i> - jaunam izveidotam lietotājam piešķirsies epasts no user601(ieskaitot) tātad lai ielogotus jums būtu jāraksta:</p>
                    <p>pie epasta - <b>user601@RHL.lv</b></p>
                </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>