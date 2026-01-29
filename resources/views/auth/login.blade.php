<x-layout>
    <x-slot:title>Ienākt | RHL Systems</x-slot:title>

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
        </div>
    </div>
</x-layout>