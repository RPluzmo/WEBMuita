<x-layout>
    <x-slot:title>Lietotāju Pārvaldība</x-slot:title>

    <main class="dhl-container">
        <header class="dhl-header">
            <div>
                <h1>Lietotāji</h1>
            </div>
        </header>

        @if(session('status'))
            <div class="dhl-card">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="dhl-card">
                {{ session('error') }}
            </div>
        @endif

        <section class="dhl-card">
            <table class="dhl-table">
                <thead>
                    <tr>
                        <th>ID / Username</th>
                        <th>Vārds Uzvārds</th>
                        <th>E-pasts</th>
                        <th>Loma</th>
                        <th>Statuss</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <td>
                                <strong>{{ $user->id }}</strong><br>
                                <input type="text" name="username" value="{{ $user->username }}">
                            </td>
                            
                            <td>
                                <input type="text" name="full_name" value="{{ $user->full_name }}">
                            </td>
                            
                            <td>
                                <input type="email" name="email" value="{{ $user->email }}">
                            </td>
                            
                            <td>
                                <select name="role">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="analyst" {{ $user->role == 'analyst' ? 'selected' : '' }}>Analyst</option>
                                    <option value="inspector" {{ $user->role == 'inspector' ? 'selected' : '' }}>Inspector</option>
                                    <option value="broker" {{ $user->role == 'broker' ? 'selected' : '' }}>Broker</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </td>

                            <td>
                                <select name="active">
                                    <option value="1" {{ $user->active ? 'selected' : '' }}>Aktīvs</option>
                                    <option value="0" {{ !$user->active ? 'selected' : '' }}>NeaktīvsBloķēts</option>
                                </select>
                            </td>
                            
                            <td>
                                <div>
                                    <button type="submit" class="dhl-btn">
                                        Saglabāt
                                    </button>
                        </form>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Parliecināts?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit">Dzēst</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</x-layout>