    <style>
    /* ── MEGA MENU ─────────────────────────────────────────── */
    .psk-mega-wrapper {
        position: static;
    }

    .psk-mega-toggle {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        color: #333;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 6px;
        height: 60px;
        position: relative;
    }
    .psk-mega-toggle:focus { outline: none; }
    .psk-mega-toggle .fa-chevron-down {
        font-size: 0.65rem;
        transition: transform 0.2s;
    }
    .psk-mega-wrapper.open .psk-mega-toggle .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Services text orange when open or on services page */
    .psk-mega-wrapper.open .psk-mega-toggle,
    .psk-mega-toggle.psk-nl-active {
        color: #fc5e28;
    }

    /* No underline on Services toggle ever */
    .psk-mega-toggle::after { display: none !important; }

    /* ── MEGA PANEL ── */
    .psk-mega-panel {
        display: none;
        position: fixed;
        left: 0 !important;
        right: 0 !important;
        top: 0;
        width: 100vw !important;
        background: #fff;
        border-top: 3px solid #fc5e28;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        z-index: 9999;
        padding: 28px 0;
    }
    .psk-mega-wrapper.open .psk-mega-panel {
        display: block;
    }

    .psk-mega-col {
        padding: 0 20px;
        border-right: 1px solid #f0f0f0;
    }
    .psk-mega-col:last-child {
        border-right: none;
        padding-right: 0;
    }

    .psk-mega-heading {
        font-size: 0.73rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fc5e28;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 2px solid #fff3ee;
        white-space: nowrap;
    }
    .psk-mega-col:last-child .psk-mega-heading {
        letter-spacing: 0.5px;
        font-size: 0.70rem;
    }
    .psk-mega-heading .fa { margin-right: 6px; }

    .psk-mega-link {
        display: block;
        font-size: 0.845rem;
        color: #444;
        padding: 5px 0;
        text-decoration: none;
        transition: color 0.15s, padding-left 0.15s;
        border-bottom: none;
    }
    .psk-mega-link:before {
        content: '›';
        color: #fc5e28;
        margin-right: 7px;
        font-size: 1rem;
        line-height: 1;
    }
    .psk-mega-link:hover {
        color: #fc5e28;
        padding-left: 5px;
        text-decoration: none;
    }

    /* ── Suppress active underline on other nav items when mega is open ── */
    .navbar-nav.mega-open .nav-item.active .psk-nl {
        color: #333 !important;
    }
    .navbar-nav.mega-open .nav-item.active .psk-nl::after {
        display: none !important;
    }

    /* ── Suppress active underline when hovering a different nav item ── */
    .navbar-nav:hover .nav-item.active .psk-nl {
        color: #333;
    }
    .navbar-nav:hover .nav-item.active .psk-nl::after {
        display: none;
    }
    .navbar-nav .nav-item.active:hover .psk-nl {
        color: #fc5e28;
    }
    .navbar-nav .nav-item.active:hover .psk-nl::after {
        display: block;
    }

    @media (max-width: 991px) {
        .psk-mega-panel {
            position: static !important;
            width: 100% !important;
            box-shadow: none !important;
            border-top: 2px solid #fc5e28;
            padding: 16px 0;
        }
        .psk-mega-col {
            border-right: none;
            border-bottom: 1px solid #f5f5f5;
            padding: 12px 16px;
            margin-bottom: 4px;
        }
        .psk-mega-heading {
            white-space: normal;
        }
        .navbar-nav:hover .nav-item.active .psk-nl {
            color: #fc5e28;
        }
        .navbar-nav:hover .nav-item.active .psk-nl::after {
            display: block;
        }
    }
    </style>

    <nav class="navbar navbar-expand-lg navbar-light" id="ftco-navbar"
        style="background:#fff; border-bottom:1px solid #eee; padding:0;">
        <div class="container d-flex align-items-center">

            <button class="navbar-toggler ml-auto" type="button"
                data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false">
                <span class="fa fa-bars" style="color:#333;"></span>
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav mx-auto align-items-lg-center" id="pskNavList">

                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}" class="nav-link psk-nl">Home</a>
                    </li>

                    <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                        <a href="{{ url('/about') }}" class="nav-link psk-nl">About</a>
                    </li>

                    {{-- Services mega menu --}}
                    <li class="nav-item psk-mega-wrapper" id="pskMegaWrapper">
                        <button class="nav-link psk-mega-toggle {{ request()->is('services*') ? 'psk-nl-active' : '' }}"
                                id="pskMegaToggle">
                            Services <span class="fa fa-chevron-down"></span>
                        </button>

                        @php
                        // category key => [label, icon]
                        $categoryMeta = [
                            'identity'      => ['Identity & ID Cards', 'fa-id-card'],
                            'registrations' => ['Registrations & Certificates', 'fa-file-text'],
                            'schemes'       => ['Govt. Schemes', 'fa-registered'],
                            'jobs'          => ['Jobs & Forms', 'fa-briefcase'],
                        ];
                    @endphp

                    <div class="psk-mega-panel" id="pskMegaPanel">
                        <div class="container">
                            <div class="row">
                                @foreach($megaServices as $categoryKey => $categoryServices)
                                    <div class="col-lg-3 psk-mega-col">
                                        <div class="psk-mega-heading">
                                            <span class="fa {{ $categoryMeta[$categoryKey][1] ?? 'fa-list' }}"></span>
                                            {{ $categoryMeta[$categoryKey][0] ?? ucfirst($categoryKey) }}
                                        </div>

                                        @foreach($categoryServices as $service)
                                            <a class="psk-mega-link" href="{{ url('/services/' . $service->slug) }}">
                                                {{ $service->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="col-lg-3 psk-mega-col">
                                    <a class="psk-mega-link" href="{{ url('/services') }}"
                                    style="color:#fc5e28; font-weight:700; margin-top:10px; display:inline-block;">
                                        View All Services →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </li>

                    <li class="nav-item {{ request()->is('jobs') ? 'active' : '' }}">
                        <a href="{{ url('/jobs') }}" class="nav-link psk-nl">Jobs Alerts</a>
                    </li>

                    <li class="nav-item {{ request()->is('blog*') ? 'active' : '' }}">
                        <a href="{{ url('/blog') }}" class="nav-link psk-nl">Blog</a>
                    </li>

                    <li class="nav-item {{ request()->is('forms*') ? 'active' : '' }}">
                        <a href="{{ url('/forms') }}" class="nav-link psk-nl">Download Forms</a>
                    </li>

                    <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                        <a href="{{ url('/contact') }}" class="nav-link psk-nl">Contact</a>
                    </li>

                </ul>

                <div class="d-flex align-items-center ml-lg-3">
                    <a href="{{ url('/track-application') }}" class="psk-track mr-3">
                        <span class="fa fa-map-marker mr-1"></span> Track Application
                    </a>
                    <!-- <a href="#" class="psk-cta" data-toggle="modal" data-target="#exampleModalCenter">
                        Book Appointment
                    </a> -->
                </div>
            </div>
        </div>
    </nav>

    <script>
    (function () {
        var wrapper  = document.getElementById('pskMegaWrapper');
        var toggle   = document.getElementById('pskMegaToggle');
        var panel    = document.getElementById('pskMegaPanel');
        var navList  = document.getElementById('pskNavList');
        var navbar   = document.getElementById('ftco-navbar');

        if (!wrapper || !toggle || !panel) return;

        var closeTimer = null;

        /* ── Position panel flush below navbar with NO gap ── */
        function positionPanel() {
            var rect = navbar.getBoundingClientRect();
            panel.style.top = Math.round(rect.bottom) + 'px';
        }

        /* ── Hide active state on sibling nav items ── */
        function suppressActive() {
            document.querySelectorAll('#pskNavList .nav-item.active').forEach(function (li) {
                if (li.id !== 'pskMegaWrapper') {
                    li.classList.remove('active');
                    li.setAttribute('data-was-active', '1');
                }
            });
            if (navList) navList.classList.add('mega-open');
        }

        /* ── Restore active state on sibling nav items ── */
        function restoreActive() {
            document.querySelectorAll('#pskNavList .nav-item[data-was-active="1"]').forEach(function (li) {
                li.classList.add('active');
                li.removeAttribute('data-was-active');
            });
            if (navList) navList.classList.remove('mega-open');
        }

        /* ── Open mega menu ── */
        function openMenu() {
            if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
            if (!wrapper.classList.contains('open')) {
                wrapper.classList.add('open');
                positionPanel();
                suppressActive();
            }
        }

        /* ── Close mega menu ── */
        function closeMenu() {
            closeTimer = setTimeout(function () {
                wrapper.classList.remove('open');
                restoreActive();
            }, 300);
        }

        /* ── Hover on wrapper li (the Services button) ── */
        wrapper.addEventListener('mouseenter', openMenu);
        wrapper.addEventListener('mouseleave', closeMenu);

        /* ── Hover on panel — cancel close when mouse is inside panel ── */
        panel.addEventListener('mouseenter', function () {
            if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
        });
        panel.addEventListener('mouseleave', closeMenu);

        /* ── Click toggle (mobile / keyboard) ── */
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            if (wrapper.classList.contains('open')) {
                clearTimeout(closeTimer);
                wrapper.classList.remove('open');
                restoreActive();
            } else {
                openMenu();
            }
        });

        /* ── Outside click closes menu ── */
        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target) && !panel.contains(e.target)) {
                clearTimeout(closeTimer);
                wrapper.classList.remove('open');
                restoreActive();
            }
        });

        /* ── Keep panel positioned on scroll / resize ── */
        window.addEventListener('scroll', function () {
            if (wrapper.classList.contains('open')) positionPanel();
        });
        window.addEventListener('resize', function () {
            if (wrapper.classList.contains('open')) positionPanel();
        });
    })();
    </script>