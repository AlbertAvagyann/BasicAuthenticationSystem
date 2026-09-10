(function () {
    function getStoredTheme() {
        return localStorage.getItem('theme');
    }

    function getPreferredTheme() {
        var stored = getStoredTheme();
        if (stored === 'dark' || stored === 'light') {
            return stored;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
    }

    function toggleTheme() {
        var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        var next = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', next);
        applyTheme(next);
    }

    function createToggleButton() {
        var btn = document.createElement('button');
        btn.id = 'theme-toggle';
        btn.className = 'theme-toggle';
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Toggle dark mode');

        var iconLight = document.createElement('span');
        iconLight.className = 'icon-light';
        iconLight.textContent = '\uD83C\uDF19';

        var iconDark = document.createElement('span');
        iconDark.className = 'icon-dark';
        iconDark.textContent = '\u2600\uFE0F';

        btn.appendChild(iconLight);
        btn.appendChild(iconDark);
        btn.addEventListener('click', toggleTheme);

        document.body.insertBefore(btn, document.body.firstChild);
    }

    applyTheme(getPreferredTheme());

    document.addEventListener('DOMContentLoaded', function () {
        if (!document.getElementById('theme-toggle')) {
            createToggleButton();
        }

        if (!getStoredTheme() && window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                applyTheme(e.matches ? 'dark' : 'light');
            });
        }
    });
})();