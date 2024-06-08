
                <!-- Dashboard -->
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                    <li class="menu-item active">
                        <a href="{{ route('tableau') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('liste.devis')}}" class="menu-link">
                            <div data-i18n="Analytics">Liste Devis En Cours</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('sous-travauxes.index')}}" class="menu-link">
                            <div data-i18n="Analytics">List Devis</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('finitions.index')}}" class="menu-link">
                            <div data-i18n="Analytics">Finition</div>
                        </a>
                    </li>

                    @endif

                @elseif(session()->has('id_client') != null)
                        <li class="menu-item ">
                            <a href="{{route('home.client')}}" class="menu-link menu-toggle">
                                <div data-i18n="Analytics">Liste Devis</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('liste.travaux')}}" class="menu-link">
                                <div data-i18n="Analytics">Liste Travaux En Cours</div>
                            </a>
                        </li>
                @endif


