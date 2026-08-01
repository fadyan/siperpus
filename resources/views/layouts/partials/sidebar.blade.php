<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/" class="brand-link">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="brand-image opacity-90 shadow" />
            <span class="brand-text fw-light">Siperpus DDI Cambalagi</span>
        </a>
    </div>
    
    <div class="sidebar-wrapper">
    <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="menu">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="/"
                   class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- ================= ADMIN ================= --}}
            @if(auth()->user()->level === "admin")
                <li class="nav-item {{ request()->routeIs('kelas*','kelas_group*','pegawai*','siswa*','buku*','rak_buku*','penerbit*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->routeIs('kelas*','kelas_group*','pegawai*','siswa*','buku*','rak_buku*','penerbit*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-database"></i>
                        <p>
                            Master Data
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('kelas') }}"
                               class="nav-link {{ request()->routeIs('kelas*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Kelas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('kelas_group') }}"
                               class="nav-link {{ request()->routeIs('kelas_group*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-diagram-3"></i>
                                <p>Kelas Group</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pegawai') }}"
                               class="nav-link {{ request()->routeIs('pegawai*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>Pegawai</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('siswa') }}"
                               class="nav-link {{ request()->routeIs('siswa*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Siswa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('buku') }}"
                               class="nav-link {{ request()->routeIs('buku*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-book"></i>
                                <p>Buku</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('rak_buku') }}"
                               class="nav-link {{ request()->routeIs('rak_buku*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bookshelf"></i>
                                <p>Rak Buku</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('penerbit') }}"
                               class="nav-link {{ request()->routeIs('penerbit*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building-check"></i>
                                <p>Penerbit</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            {{-- ================= PEGAWAI ================= --}}
            @if(auth()->user()->level === "pegawai")

                <li class="nav-item">
                    <a href="{{ route('kelas') }}"
                       class="nav-link {{ request()->routeIs('kelas*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-building"></i>
                        <p>Kelas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pegawai') }}"
                       class="nav-link {{ request()->routeIs('pegawai*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Pegawai</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('siswa') }}"
                       class="nav-link {{ request()->routeIs('siswa*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Siswa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('buku') }}"
                       class="nav-link {{ request()->routeIs('buku*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Buku</p>
                    </a>
                </li>

            @endif

            {{-- ================= TRANSAKSI ================= --}}
            @if(auth()->user()->level === "admin" || auth()->user()->level === "pegawai")
                <li class="nav-header">TRANSAKSI</li>
            @endif

            <li class="nav-item">
                <a href="{{ route('peminjaman') }}"
                   class="nav-link {{ request()->routeIs('peminjaman*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-book-half"></i>
                    <p>Pinjaman</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#"
                   id="openAI"
                   class="nav-link">
                    <i class="nav-icon bi bi-stars"></i>
                    <p>AI Assistant</p>
                </a>
            </li>

            {{-- ================= USER ================= --}}
            <li class="nav-header">USER</li>

            @if(auth()->user()->level === "admin")
                <li class="nav-item">
                    <a href="{{ route('user') }}"
                       class="nav-link {{ request()->routeIs('user*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>User</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST">
                    @csrf

                    <a href="#"
                       id="btnLogout"
                       class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>

                </form>

            </li>

        </ul>
    </nav>
</div>
</aside>