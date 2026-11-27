@if (app()->environment('production') && config('services.google_analytics.measurement_id'))
    <div id="cookieConsent" class="cookie-consent" hidden>

        <h3>Your privacy matters</h3>

        <p>
            We use optional analytics cookies to understand how
            visitors explore ÉLORA and improve your browsing experience.

            Learn more in our
            <a href="{{ route('page.show', 'privacy-policy') }}" class="cookie-privacy-link">
                Privacy Policy
            </a>.
        </p>

        <div class="cookie-actions">
            <button type="button" id="acceptCookies">
                Accept Analytics
            </button>

            <button type="button" id="rejectCookies">
                Reject Analytics
            </button>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const banner = document.getElementById('cookieConsent');
            const settingsLink = document.getElementById('openCookieSettings');
            const measurementId = @json(config('services.google_analytics.measurement_id'));
            const storageKey = 'elora_cookie_consent';

            const consent = localStorage.getItem(storageKey);

            // Check existing consent
            if (consent === 'accepted') {
                initializeAnalytics();
            } else {
                window['ga-disable-' + measurementId] = true;

                if (consent !== 'rejected') {
                    banner.hidden = false;
                }
            }

            // Open cookie settings
            if (settingsLink) {
                settingsLink.addEventListener('click', function(event) {
                    event.preventDefault();

                    banner.hidden = false;
                    document.getElementById('acceptCookies').focus();
                });
            }

            // Accept analytics
            document.getElementById('acceptCookies')
                .addEventListener('click', function() {

                    localStorage.setItem(storageKey, 'accepted');

                    window['ga-disable-' + measurementId] = false;

                    initializeAnalytics();

                    banner.hidden = true;

                    if (settingsLink) {
                        settingsLink.focus();
                    }
                });

            // Reject or withdraw analytics consent
            document.getElementById('rejectCookies')
                .addEventListener('click', function() {

                    localStorage.setItem(storageKey, 'rejected');

                    window['ga-disable-' + measurementId] = true;

                    // Remove existing Google Analytics cookies
                    document.cookie.split(';').forEach(function(cookie) {

                        const name = cookie.split('=')[0].trim();

                        if (name === '_ga' || name.startsWith('_ga_') || name === '_gid') {

                            const expiry = '=; Max-Age=0; path=/';

                            document.cookie = name + expiry;

                            document.cookie = name + expiry +
                                '; domain=' + window.location.hostname;

                            document.cookie = name + expiry +
                                '; domain=.elorafashiontrends.com';
                        }
                    });

                    banner.hidden = true;

                    // Reload without loading Google Analytics
                    if (window.eloraAnalyticsInitialized) {
                        window.location.reload();
                    } else if (settingsLink) {
                        settingsLink.focus();
                    }
                });

        });
    </script>
@endif
