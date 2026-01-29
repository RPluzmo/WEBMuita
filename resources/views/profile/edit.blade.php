<x-layout>
    <x-slot:title>Profils</x-slot:title>

    <main class="dhl-container">
        <div class="dhl-banner"
            style="background-image: url('https://images.unsplash.com/photo-1434626881859-194d67b2b86f?q=80&w=1000');">
        </div>

        <section class="dhl-card profile-card">
            @if(session('success'))
                <div >
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-avatar-wrapper">
                <h3>{{ $user->full_name }}</h3>
                <span>{{ strtoupper($user->role) }}</span>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="dhl-grid">
                    <div>
                        <label>Sistēmas ID</label>
                        <h3>{{ $user->id }}</h3>
                    </div>
                    <div >
                        <label>Lietotājvārds</label>
                        <h3>{{ $user->username }}</h3>
                    </div>
                </div>

                <div>
                    <label>E-pasta adrese</label>
                    <h3>{{ $user->email }}</h3>
                </div>

                <div class="dhl-grid">
                    <div>
                        <label>Vārds</label>
                        <input type="text" name="first_name" 
                               value="{{ old('first_name', $firstName) }}" 
                               placeholder="Ievadiet vārdu">
                        @error('first_name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Uzvārds</label>
                        <input type="text" name="last_name" 
                               value="{{ old('last_name', $lastName) }}" 
                               placeholder="Ievadiet uzvārdu">
                        @error('last_name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="dhl-btn" style="width: 100%;">Saglabāt izmaiņas</button>
                </div>
            </form>
        </section>
    </main>
</x-layout>