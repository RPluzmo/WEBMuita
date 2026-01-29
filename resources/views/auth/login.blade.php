<x-layout>
    <x-slot:title>Ienākt</x-slot:title>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Ienākt</h1>
            
            <form method="POST" action="/login">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label for="email" class="stat-label">E-pasts</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="dhl-form-control" required autofocus>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label for="password" class="stat-label">Parole</label>
                    <input type="password" id="password" name="password" 
                           class="dhl-form-control" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="dhl-btn" style="width: 100%; padding: 15px;">IENĀKT SISTĒMĀ</button>
            </form>

            <div class="auth-footer">
                <p>Nav konta? <a href="{{ route('register') }}" style="color: var(--dhl-red); font-weight: bold; text-decoration: none;">Reģistrējies šeit</a></p>
            </div>
            <div>
                <h3>Piezīmīte</h3>
                <p>lai ielogotos kādā no 600 lietotājiem no api - epasta adrese būs <b>"user1@RHL.lv"</b> un parole ir <b>"qwe"</b> ikkatram</p>
                <p>var izmēģināt lietotājus kā:</p>
                <p><b>user1@RHL.lv</b> - analītiķis</p>
                <p><b>user2@RHL.lv</b> - adminstrātors</p>
                <p><b>user3@RHL.lv</b> - inspektors</p>
                <p><b>user5@RHL.lv</b> - broker(is)</p>
            </div>
        </div>
    </div>
</x-layout>