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

    /* ── Services panel: categories as column headers side by side
       (not a vertical rail) — the original structure, with icons on
       each service link and a short line under each category heading
       as the visual polish. ── */
    .psk-mega-link .fa { width: 16px; text-align: center; flex-shrink: 0; font-size: 0.95rem; }

    /* ── Simple dropdown (Resources, and any future short link list) —
       a normal anchored dropdown, NOT the full-viewport mega panel
       above. The mega panel is sized for Services' wide multi-column
       grid; reusing it for a 3-link list leaves a huge empty white
       bar with sparse text in the corner. This is the right component
       for "just a handful of links" instead. ── */
    .psk-simple-dropdown { position: relative; }
    .psk-simple-dropdown__toggle {
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
    }
    .psk-simple-dropdown__toggle:focus { outline: none; }
    .psk-simple-dropdown__toggle .fa-chevron-down { font-size: 0.65rem; transition: transform 0.2s; }
    .psk-simple-dropdown.open .psk-simple-dropdown__toggle .fa-chevron-down { transform: rotate(180deg); }
    .psk-simple-dropdown.open .psk-simple-dropdown__toggle,
    .psk-simple-dropdown__toggle.psk-nl-active { color: #fc5e28; }

    .psk-simple-dropdown__menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 250px;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.14);
        padding: 8px 0;
        margin: 8px 0 0;
        list-style: none;
        z-index: 9999;
    }
    .psk-simple-dropdown.open .psk-simple-dropdown__menu { display: block; }
    .psk-simple-dropdown__menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }
    .psk-simple-dropdown__menu a:hover { background: #fff8f5; color: #fc5e28; text-decoration: none; }
    .psk-simple-dropdown__menu a .fa { color: #fc5e28; width: 16px; text-align: center; flex-shrink: 0; }

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
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.845rem;
        color: #444;
        padding: 8px 10px;
        margin: 0 -10px;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.15s, box-shadow 0.15s, color 0.15s;
    }
    .psk-mega-link:hover {
        background: #fff;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        color: #fc5e28;
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
        /* Match the plain nav-link rows (Home, About, Contact...) exactly
           — otherwise Services/Resources sit at a fixed 60px desktop-bar
           height with smaller text while everything else around them
           uses the site's normal mobile menu row styling, which looks
           inconsistent and cramped in the collapsed hamburger menu. */
        .psk-mega-toggle,
        .psk-simple-dropdown__toggle {
            display: flex !important;
            width: 100%;
            height: auto !important;
            padding: 16px 20px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            border-left: 4px solid transparent !important;
            justify-content: space-between;
        }
        .psk-mega-wrapper.open .psk-mega-toggle,
        .psk-simple-dropdown.open .psk-simple-dropdown__toggle {
            background: #fff8f5 !important;
            border-left-color: #fc5e28 !important;
        }

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
        /* The hover-only card/shadow treatment on service links doesn't
           apply on touch — give them a bit more tap padding instead so
           they're comfortably tappable in a stacked mobile list. */
        .psk-mega-link {
            padding: 10px;
            font-size: 0.9rem;
        }

        .psk-simple-dropdown__menu {
            position: static;
            box-shadow: none;
            border: none;
            border-radius: 0;
            margin: 0;
            padding: 0;
            background: #fafafa;
        }
        .psk-simple-dropdown__menu a {
            padding: 14px 20px 14px 32px;
            font-size: 14px;
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
                        <button type="button" class="nav-link psk-mega-toggle {{ request()->is('services*') ? 'psk-nl-active' : '' }}"
                                id="pskMegaToggle">
                            Services <span class="fa fa-chevron-down"></span>
                        </button>

                        @php
                        // category key => [label, icon, short description]
                        $categoryMeta = [
                            'identity'      => ['Identity & ID Cards', 'fa-id-card'],
                            'certificates'  => ['Certificates', 'fa-certificate'],
                            'registrations' => ['Registrations', 'fa-file-text'],
                            'schemes'       => ['Govt. Schemes', 'fa-registered'],
                            'jobs'          => ['Jobs & Forms', 'fa-briefcase'],
                        ];

                        // Display in a deliberate order (most-used first)
                        // instead of whatever order the DB grouping
                        // happens to return — then append any category
                        // not in the list above so nothing gets dropped.
                        $orderedCategories = collect(array_keys($categoryMeta))
                            ->filter(fn ($key) => $megaServices->has($key))
                            ->merge($megaServices->keys()->diff(array_keys($categoryMeta)));
                    @endphp
                    <div class="psk-mega-panel" id="pskMegaPanel">
                        <div class="container">
                            <div class="row">
                                @foreach($orderedCategories as $categoryKey)
                                @php $categoryServices = $megaServices->get($categoryKey); @endphp
                                    <div class="col psk-mega-col">
                                        <div class="psk-mega-heading">
                                            <span class="fa {{ $categoryMeta[$categoryKey][1] ?? 'fa-list' }}"></span>
                                            {{ $categoryMeta[$categoryKey][0] ?? ucfirst($categoryKey) }}
                                        </div>

                                        @foreach($categoryServices as $service)
                                            <a class="psk-mega-link" href="{{ url('/services/' . $service->slug) }}">
                                                <span class="fa {{ $service->icon ?: 'fa-file-text' }}" style="color:{{ $service->color ?: '#fc5e28' }};"></span>
                                                {{ $service->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="col psk-mega-col">
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
                        <a href="{{ url('/jobs') }}" class="nav-link psk-nl">Job Saathi</a>
                    </li>

                    {{-- Resources dropdown — groups content-type pages so
                         the top-level bar doesn't grow every time a new
                         informational page is added. Add future pages
                         (Schemes, Guides, FAQs, etc.) as another <li><a>
                         row here — the dropdown JS below already handles
                         any number of .psk-simple-dropdown instances, no
                         script changes needed. A compact anchored
                         dropdown, not the full-width Services mega
                         panel — that component is sized for a wide
                         multi-column grid and looks sparse/broken with
                         just a short link list. --}}
                    <li class="nav-item psk-simple-dropdown" id="pskResourcesWrapper">
                        <button type="button" class="psk-simple-dropdown__toggle {{ request()->is('news*', 'blog*', 'forms*') ? 'psk-nl-active' : '' }}">
                            Resources <span class="fa fa-chevron-down"></span>
                        </button>

                        <ul class="psk-simple-dropdown__menu">
                            <li><a href="{{ url('/news') }}"><span class="fa fa-bullhorn"></span>Government Updates &amp; News</a></li>
                            <li><a href="{{ url('/blog') }}"><span class="fa fa-file-text-o"></span>Blog</a></li>
                            <li><a href="{{ url('/forms') }}"><span class="fa fa-download"></span>Download Forms</a></li>
                        </ul>
                    </li>

                    <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                        <a href="{{ url('/contact') }}" class="nav-link psk-nl">Contact</a>
                    </li>

                </ul>

                <div class="d-flex align-items-center ml-lg-3">
                    <a href="{{ route('csc.directory') }}" class="psk-track mr-3">
                        <span class="fa fa-search mr-1"></span> Find CSC Center
                    </a>
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
        var navList = document.getElementById('pskNavList');
        var navbar  = document.getElementById('ftco-navbar');

        // Touch devices fire a synthetic mouseenter right before the real
        // click on first tap — with both a hover-to-open handler AND a
        // click-to-toggle handler attached, that means: tap opens it via
        // mouseenter, then the very same tap's click sees it already
        // "open" and immediately closes it again. Net effect: dropdowns
        // that won't stay open, or a tap landing on whatever's
        // underneath once things start shifting. Hover behavior should
        // only exist on devices that actually have real hover.
        var supportsHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;

        // Generic — wires up EVERY .psk-mega-wrapper found (Services,
        // Resources, and any future dropdown added the same way) so
        // adding another mega menu later never requires touching this
        // script again, just markup following the same structure.
        document.querySelectorAll('.psk-mega-wrapper').forEach(function (wrapper) {
            var toggle = wrapper.querySelector('.psk-mega-toggle');
            var panel  = wrapper.querySelector('.psk-mega-panel');
            if (!toggle || !panel) return;

            var closeTimer = null;

            function positionPanel() {
                var rect = navbar.getBoundingClientRect();
                panel.style.top = Math.round(rect.bottom) + 'px';
            }

            function suppressActive() {
                document.querySelectorAll('#pskNavList .nav-item.active').forEach(function (li) {
                    if (li !== wrapper) {
                        li.classList.remove('active');
                        li.setAttribute('data-was-active', '1');
                    }
                });
                if (navList) navList.classList.add('mega-open');
            }

            function restoreActive() {
                document.querySelectorAll('#pskNavList .nav-item[data-was-active="1"]').forEach(function (li) {
                    li.classList.add('active');
                    li.removeAttribute('data-was-active');
                });
                if (navList) navList.classList.remove('mega-open');
            }

            function openMenu() {
                if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                // Close any other open mega menu / simple dropdown first,
                // so two panels can never be stacked open at once.
                document.querySelectorAll('.psk-mega-wrapper.open').forEach(function (other) {
                    if (other !== wrapper) other.classList.remove('open');
                });
                document.querySelectorAll('.psk-simple-dropdown.open').forEach(function (other) {
                    other.classList.remove('open');
                });
                if (!wrapper.classList.contains('open')) {
                    wrapper.classList.add('open');
                    positionPanel();
                    suppressActive();
                }
            }

            function closeMenu() {
                closeTimer = setTimeout(function () {
                    wrapper.classList.remove('open');
                    restoreActive();
                }, 300);
            }

            if (supportsHover) {
                wrapper.addEventListener('mouseenter', openMenu);
                wrapper.addEventListener('mouseleave', closeMenu);

                panel.addEventListener('mouseenter', function () {
                    if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                });
                panel.addEventListener('mouseleave', closeMenu);
            }

            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (wrapper.classList.contains('open')) {
                    clearTimeout(closeTimer);
                    wrapper.classList.remove('open');
                    restoreActive();
                } else {
                    openMenu();
                }
            });

            document.addEventListener('click', function (e) {
                if (!wrapper.contains(e.target) && !panel.contains(e.target)) {
                    clearTimeout(closeTimer);
                    wrapper.classList.remove('open');
                    restoreActive();
                }
            });

            window.addEventListener('scroll', function () {
                if (wrapper.classList.contains('open')) positionPanel();
            });
            window.addEventListener('resize', function () {
                if (wrapper.classList.contains('open')) positionPanel();
            });
        });

        // Compact anchored dropdowns (Resources, and any future one built
        // the same way) — no fixed-position math needed since these sit
        // relative to their own toggle instead of spanning the viewport.
        document.querySelectorAll('.psk-simple-dropdown').forEach(function (wrapper) {
            var toggle = wrapper.querySelector('.psk-simple-dropdown__toggle');
            var menu   = wrapper.querySelector('.psk-simple-dropdown__menu');
            if (!toggle || !menu) return;

            var closeTimer = null;

            function closeAllMegaMenus() {
                document.querySelectorAll('.psk-mega-wrapper.open').forEach(function (w) {
                    w.classList.remove('open');
                });
            }

            function openMenu() {
                if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                closeAllMegaMenus();
                document.querySelectorAll('.psk-simple-dropdown.open').forEach(function (w) {
                    if (w !== wrapper) w.classList.remove('open');
                });
                wrapper.classList.add('open');
            }

            function closeMenu() {
                closeTimer = setTimeout(function () { wrapper.classList.remove('open'); }, 250);
            }

            if (supportsHover) {
                wrapper.addEventListener('mouseenter', openMenu);
                wrapper.addEventListener('mouseleave', closeMenu);
                menu.addEventListener('mouseenter', function () {
                    if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                });
                menu.addEventListener('mouseleave', closeMenu);
            }

            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (wrapper.classList.contains('open')) {
                    clearTimeout(closeTimer);
                    wrapper.classList.remove('open');
                } else {
                    openMenu();
                }
            });

            document.addEventListener('click', function (e) {
                if (!wrapper.contains(e.target)) {
                    clearTimeout(closeTimer);
                    wrapper.classList.remove('open');
                }
            });
        });
    })();
    </script>