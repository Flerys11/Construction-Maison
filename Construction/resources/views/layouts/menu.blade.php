
<li class="nav-item">
    <a href="{{ route('postes.index') }}" class="nav-link {{ Request::is('postes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Postes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('sousTravauxes.index') }}" class="nav-link {{ Request::is('sousTravauxes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Sous Travauxes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('finitions.index') }}" class="nav-link {{ Request::is('finitions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Finitions</p>
    </a>
</li>
