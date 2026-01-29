<nav class="dhl-navbar">
    <div class="dhl-nav-container">
        <a href="{{ url('/') }}" class="dhl-logo">RHL</a>

        <div class="dhl-nav-links">
            @auth
                

                <div class="dhl-user-info">
                    <div class="user-tag">
                        <a href="{{ route('dashboard') }}" class="nav-profile-link">Dashboard</a>
                    </div>
                    
                    <div class="user-tag">
                        <a href="{{ route('profile.edit') }}" class="nav-profile-link">
                            {{ Auth::user()->full_name }}
                        </a>
                        <span class="role-divider">|</span>
                        <span class="user-role-text">{{ strtoupper(auth()->user()->role) }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            Iziet
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="logout-btn nav-guest-link">Ienākt</a>
            @endguest
        </div>
    </div>
</nav>