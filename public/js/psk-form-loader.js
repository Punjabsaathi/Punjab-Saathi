/**
 * Punjab Saathi — Form Submission Loader
 * File: public/js/psk-form-loader.js
 *
 * Shows a full-page "processing" overlay while a form is submitting.
 * Forms opt in with data-psk-loading="Custom message" (or just
 * data-psk-loading for the default message). Submission itself is left
 * completely untouched — this is a plain native form POST, not AJAX —
 * so validation, redirects, and session-flash messages behave exactly
 * as before. The overlay just gives the browser's normal navigation a
 * visible "processing" state instead of looking frozen.
 */
(function () {
    "use strict";

    var overlay = document.getElementById("psk-form-loader");
    var textEl = document.getElementById("psk-form-loader-text");
    var hintEl = document.getElementById("psk-form-loader-hint");
    if (!overlay) return;

    var DEFAULT_HINT = hintEl ? hintEl.textContent : "";
    var SLOW_HINT = "This is taking a bit longer than usual — please stay on this page.";
    var slowTimer = null;

    function showOverlay(message) {
        if (textEl) {
            textEl.textContent = message || "Submitting…";
        }
        if (hintEl) {
            hintEl.textContent = DEFAULT_HINT;
        }
        overlay.classList.add("psk-form-loader--visible");
        overlay.setAttribute("aria-hidden", "false");

        // Large uploads or a slow connection can leave the same message
        // on screen for a long time with no sign anything is still
        // happening — swap in a reassurance line rather than leave the
        // user guessing whether the page has frozen.
        clearTimeout(slowTimer);
        slowTimer = setTimeout(function () {
            if (hintEl) {
                hintEl.textContent = SLOW_HINT;
            }
        }, 9000);
    }

    function hideOverlay() {
        clearTimeout(slowTimer);
        overlay.classList.remove("psk-form-loader--visible");
        overlay.setAttribute("aria-hidden", "true");
    }

    document.querySelectorAll("form[data-psk-loading]").forEach(function (form) {
        form.addEventListener("submit", function () {
            showOverlay(form.getAttribute("data-psk-loading"));

            var submitControls = form.querySelectorAll(
                'button[type="submit"], input[type="submit"]'
            );
            submitControls.forEach(function (el) {
                el.disabled = true;
            });
        });
    });

    // If the user navigates back to a page that was mid-submit (bfcache
    // restore), the overlay must not stay stuck on screen forever.
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            hideOverlay();
            document
                .querySelectorAll(
                    'form[data-psk-loading] button[type="submit"], form[data-psk-loading] input[type="submit"]'
                )
                .forEach(function (el) {
                    el.disabled = false;
                });
        }
    });
})();
