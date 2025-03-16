<div class="dropdown">
    @auth
        <button class="btn btn-link nav-link dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="badge bg-danger">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
            @forelse(auth()->user()->notifications as $notification)
                <li>
                    <a class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}" href="#">
                        {{ $notification->data['message'] ?? 'Notification' }}
                        <small class="text-muted d-block">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </a>
                </li>
            @empty
                <li><span class="dropdown-item">Aucune notification</span></li>
            @endforelse
        </ul>
    @else
        <a href="{{ route('login') }}" class="nav-link">
            <i class="fas fa-bell"></i>
        </a>
    @endauth
</div> 