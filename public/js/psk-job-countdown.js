(function () {
    'use strict';

    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function tick() {
        var els = document.querySelectorAll('.psk-job-countdown-banner[data-deadline]');

        els.forEach(function (el) {
            var deadline = Date.parse(el.getAttribute('data-deadline'));
            if (isNaN(deadline)) return;

            var diff = deadline - Date.now();

            if (diff <= 0) {
                if (el.getAttribute('data-expired') !== 'true') {
                    el.setAttribute('data-expired', 'true');
                    el.innerHTML = '<span class="psk-job-countdown-banner__expired-msg">'
                        + '<i class="fas fa-hourglass-end mr-1"></i> Deadline Passed</span>';
                }
                return;
            }

            var totalSeconds = Math.floor(diff / 1000);
            var days    = Math.floor(totalSeconds / 86400);
            var hours   = Math.floor((totalSeconds % 86400) / 3600);
            var minutes = Math.floor((totalSeconds % 3600) / 60);
            var seconds = totalSeconds % 60;

            var dEl = el.querySelector('.psk-cd-d');
            var hEl = el.querySelector('.psk-cd-h');
            var mEl = el.querySelector('.psk-cd-m');
            var sEl = el.querySelector('.psk-cd-s');

            if (dEl) dEl.textContent = days;
            if (hEl) hEl.textContent = pad(hours);
            if (mEl) mEl.textContent = pad(minutes);
            if (sEl) sEl.textContent = pad(seconds);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (!document.querySelector('.psk-job-countdown-banner[data-deadline]')) return;
        tick();
        setInterval(tick, 1000);
    });
})();
