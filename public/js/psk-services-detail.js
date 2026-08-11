/**
 * Punjab Seva Kendra — Service Detail Page JS
 * File: public/js/psk-services-detail.js
 * Load AFTER: jquery.min.js, bootstrap.bundle.min.js
 * Uses NO jQuery — plain ES5 for broad compatibility
 */

(function () {
    "use strict";

    /* ── 1. NAVBAR DROPDOWN ─────────────────────────────────── */
    var li = document.getElementById("psk-svc-li");
    var link = document.getElementById("psk-svc-link");
    var dropdown = document.getElementById("psk-dropdown");

    if (li && link && dropdown) {
        link.addEventListener("click", function (e) {
            var clickedCaret = e.target.closest
                ? e.target.closest("#psk-caret")
                : null;
            // Fallback for IE
            if (!clickedCaret) {
                var t = e.target;
                while (t && t !== li) {
                    if (t.id === "psk-caret") {
                        clickedCaret = t;
                        break;
                    }
                    t = t.parentNode;
                }
            }
            if (clickedCaret) {
                e.preventDefault();
                e.stopPropagation();
                li.classList.toggle("psk-open");
                dropdown.classList.toggle("psk-open");
                return;
            }
            // Text click — navigate, close dropdown
            dropdown.classList.remove("psk-open");
            li.classList.remove("psk-open");
        });

        document.addEventListener("click", function (e) {
            if (!li.contains(e.target)) {
                li.classList.remove("psk-open");
                dropdown.classList.remove("psk-open");
            }
        });
    }

    /* ── 2. SMOOTH SCROLL (all pages) ──────────────────────── */
    function smoothScrollTo(targetEl) {
        var navbar = document.getElementById("ftco-navbar");
        var offset = navbar ? navbar.offsetHeight + 16 : 86;
        var rect = targetEl.getBoundingClientRect();
        var top = rect.top + window.pageYOffset - offset;
        window.scrollTo({ top: top, behavior: "smooth" });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener("click", function (e) {
            var hash = this.getAttribute("href").slice(1);
            var target = document.getElementById(hash);
            if (!target) return;
            e.preventDefault();
            // Close nav dropdown if open
            if (li && dropdown) {
                li.classList.remove("psk-open");
                dropdown.classList.remove("psk-open");
            }
            smoothScrollTo(target);
        });
    });

    /* ── 3. SMOOTH SCROLL from another page via hash ────────── */
    // When landing on /services#cat-identity, wait for DOM then scroll
    if (window.location.hash) {
        var hash = window.location.hash.slice(1);
        var target = document.getElementById(hash);
        if (target) {
            setTimeout(function () {
                smoothScrollTo(target);
            }, 400);
        }
    }

    /* ── 4. FILE UPLOAD PREVIEW ─────────────────────────────── */
    var input = document.getElementById("app_documents");
    var preview = document.getElementById("uploadPreview");
    var zone = document.getElementById("uploadZone");

    if (input && preview && zone) {
        input.addEventListener("change", function () {
            renderFileChips(this.files);
        });

        zone.addEventListener("dragover", function (e) {
            e.preventDefault();
            this.classList.add("psk-dragover");
        });
        zone.addEventListener("dragleave", function () {
            this.classList.remove("psk-dragover");
        });
        zone.addEventListener("drop", function (e) {
            e.preventDefault();
            this.classList.remove("psk-dragover");
            if (e.dataTransfer && e.dataTransfer.files.length) {
                // Assign files to input
                try {
                    input.files = e.dataTransfer.files;
                } catch (err) {}
                renderFileChips(e.dataTransfer.files);
            }
        });
    }

    function renderFileChips(files) {
        if (!preview) return;
        preview.innerHTML = "";
        Array.prototype.forEach.call(files, function (file) {
            var ext = file.name.split(".").pop().toUpperCase();
            var name =
                file.name.length > 22
                    ? file.name.substring(0, 20) + "…"
                    : file.name;
            var chip = document.createElement("div");
            chip.className = "psk-file-chip";
            chip.innerHTML =
                '<span class="fa fa-file"></span>' + ext + " — " + name;
            preview.appendChild(chip);
        });
    }

    /* ── 5. PHONE — digits only ─────────────────────────────── */
    var phoneInput = document.getElementById("app_phone");
    if (phoneInput) {
        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "").substring(0, 10);
        });
    }

    /* ── 6. ACTIVE SIDEBAR NAV on scroll ────────────────────── */
    var navLinks = document.querySelectorAll('.psk-page-nav a[href^="#"]');
    var sections = [];

    navLinks.forEach(function (a) {
        var id = a.getAttribute("href").slice(1);
        var sec = document.getElementById(id);
        if (sec) sections.push({ el: sec, link: a });
    });

    if (sections.length) {
        window.addEventListener(
            "scroll",
            function () {
                var scrollY = window.pageYOffset + 120;
                var activeIdx = 0;
                sections.forEach(function (s, i) {
                    if (s.el.offsetTop <= scrollY) activeIdx = i;
                });
                navLinks.forEach(function (l) {
                    l.classList.remove("psk-active");
                });
                if (sections[activeIdx]) {
                    sections[activeIdx].link.classList.add("psk-active");
                }
            },
            { passive: true },
        );
    }

    /* ── 7. SERVICE CARD FILTER (services listing page) ─────── */
    var tabs = document.querySelectorAll(".psk-filter-tab");
    var items = document.querySelectorAll(".psk-service-item");
    var secs = document.querySelectorAll(".psk-services-section");

    if (tabs.length) {
        tabs.forEach(function (tab) {
            tab.addEventListener("click", function () {
                var filter = this.getAttribute("data-filter");
                tabs.forEach(function (t) {
                    t.classList.remove("active");
                });
                this.classList.add("active");

                if (filter === "all") {
                    items.forEach(function (item) {
                        item.classList.remove("psk-hidden");
                    });
                    secs.forEach(function (s) {
                        s.style.display = "";
                    });
                } else {
                    items.forEach(function (item) {
                        if (item.getAttribute("data-category") === filter) {
                            item.classList.remove("psk-hidden");
                        } else {
                            item.classList.add("psk-hidden");
                        }
                    });
                    secs.forEach(function (section) {
                        var visible = section.querySelectorAll(
                            ".psk-service-item:not(.psk-hidden)",
                        );
                        section.style.display =
                            visible.length > 0 ? "" : "none";
                    });
                    var firstVisible = document.querySelector(
                        '.psk-services-section:not([style*="none"])',
                    );
                    if (firstVisible) {
                        setTimeout(function () {
                            smoothScrollTo(firstVisible);
                        }, 80);
                    }
                }
            });
        });
    }
})();
// FAQ accordion
document.querySelectorAll(".psk-faq-new__q").forEach(function (q) {
    q.addEventListener("click", function () {
        var item = this.closest(".psk-faq-new__item");
        var isOpen = item.classList.contains("psk-faq-new__item--open");
        document
            .querySelectorAll(".psk-faq-new__item--open")
            .forEach(function (el) {
                el.classList.remove("psk-faq-new__item--open");
            });
        if (!isOpen) item.classList.add("psk-faq-new__item--open");
    });
});

(function () {
    var header = document.getElementById("pskHeaderWrap");
    if (!header) return;

    var scrollThreshold = 80; // px before compacting

    function onScroll() {
        if (window.scrollY > scrollThreshold) {
            header.classList.add("psk-scrolled");
        } else {
            header.classList.remove("psk-scrolled");
        }
    }

    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll(); // run on load in case page is already scrolled
})();
