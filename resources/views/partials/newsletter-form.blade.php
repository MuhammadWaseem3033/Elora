<section class="elora-newsletter">
    <div class="container">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <span class="newsletter-subtitle">STAY INSPIRED</span>
                <h2>Join the ÉLORA Journal</h2>
                <p>
                    Subscribe to receive the latest fashion inspiration,
                    style stories and editorial updates.
                </p>
            </div>

            <form id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                @csrf

                <div class="newsletter-input-group">
                    <input type="email" name="email" placeholder="Enter your email address" required maxlength="255"
                        autocomplete="email">

                    <button type="submit" id="newsletterSubmit">
                        Subscribe
                    </button>
                </div>

                <p id="newsletterMessage" class="newsletter-message" role="status" aria-live="polite"></p>
            </form>
        </div>
    </div>
</section>
