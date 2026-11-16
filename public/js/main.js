
/*
|--------------------------------------------------------------------------
| ÉLORA - Main JavaScript
|--------------------------------------------------------------------------
| Vanilla JavaScript + Fetch API + History API
*/

// ==========================================
// 1. SPA PAGE NAVIGATION
// ==========================================

const pageContent = () => document.querySelector('#page-content');

let isNavigating = false;

async function navigateTo(url, addHistory = true) {

    if (isNavigating) return;

    isNavigating = true;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            window.location.href = url;
            return;
        }

        const html = await response.text();

        const parser = new DOMParser();
        const newDocument = parser.parseFromString(html, 'text/html');

        const newContent = newDocument.querySelector('#page-content');
        const currentContent = pageContent();

        if (!newContent || !currentContent) {
            window.location.href = url;
            return;
        }

        // Update page content
        currentContent.innerHTML = newContent.innerHTML;

        // Update browser title
        document.title = newDocument.title;

        // Update meta description
        const newDescription = newDocument.querySelector(
            'meta[name="description"]'
        );

        let currentDescription = document.querySelector(
            'meta[name="description"]'
        );

        if (newDescription) {
            if (!currentDescription) {
                currentDescription = document.createElement('meta');
                currentDescription.name = 'description';
                document.head.appendChild(currentDescription);
            }

            currentDescription.content = newDescription.content;
        }

        // Update browser URL
        if (addHistory) {
            history.pushState({}, '', url);
        }

        // Scroll to top
        window.scrollTo({
            top: 0,
            behavior: 'instant'
        });

        // Initialize new page functionality
        initializePage();

        // Notify other scripts
        document.dispatchEvent(new Event('elora:page-loaded'));

    } catch (error) {
        console.error('ÉLORA navigation error:', error);
        window.location.href = url;

    } finally {
        isNavigating = false;
    }
}


// ==========================================
// 2. INTERCEPT INTERNAL LINKS
// ==========================================

document.addEventListener('click', function (event) {

    const link = event.target.closest('a');

    if (!link) return;

    if (
        event.defaultPrevented ||
        event.button !== 0 ||
        event.metaKey ||
        event.ctrlKey ||
        event.shiftKey ||
        event.altKey ||
        link.target ||
        link.hasAttribute('download') ||
        link.hasAttribute('data-no-spa') ||
        link.getAttribute('rel') === 'external'
    ) {
        return;
    }

    const url = new URL(link.href, window.location.href);

    // Ignore external links
    if (url.origin !== window.location.origin) return;

    // Ignore mail, phone and JavaScript links
    if (!['http:', 'https:'].includes(url.protocol)) return;

    // Ignore same-page anchor links
    if (
        url.pathname === window.location.pathname &&
        url.search === window.location.search &&
        url.hash
    ) {
        return;
    }

    event.preventDefault();

    navigateTo(url.href);

});


// ==========================================
// 3. BROWSER BACK / FORWARD
// ==========================================

window.addEventListener('popstate', function () {
    navigateTo(window.location.href, false);
});


// ==========================================
// 4. PAGE FUNCTIONALITY
// ==========================================

function initializePage() {

    // Mobile Menu
    const menuButton = document.querySelector('.menu-btn');
    const navigation = document.querySelector('.nav');

    if (menuButton && navigation) {

        menuButton.addEventListener('click', function () {
            navigation.classList.toggle('open');
        });

    }

    // Search
    document.querySelectorAll('[data-search]').forEach(input => {

        input.addEventListener('input', function () {

            const query = input.value.toLowerCase();

            document.querySelectorAll('[data-searchable]').forEach(item => {

                item.style.display = item.textContent
                    .toLowerCase()
                    .includes(query) ? '' : 'none';
            });
        });
    });
    // Dynamic Copyright Year
    document.querySelectorAll('[data-year]').forEach(element => {
        element.textContent = new Date().getFullYear();
    });
    // Demo Forms
    document.querySelectorAll('[data-demo-form]').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const message = form.querySelector('[data-message]');
            if (message) {
                message.textContent =
                    'Thank you. Connect this demo form to Laravel before launch.';
            }
            form.reset();
        });
    });
}
// ==========================================
// 5. INITIAL PAGE LOAD
// ==========================================

document.addEventListener('DOMContentLoaded', initializePage);
/* =====================================
   ÉLORA IMAGE LIGHTBOX
===================================== */

(function () {
    let galleryImages = [];
    let currentImageIndex = 0;

    const lightbox = document.getElementById('eloraLightbox');

    if (!lightbox) return;

    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxCounter = document.getElementById('lightboxCounter');

    const closeButton = lightbox.querySelector('.lightbox-close');
    const previousButton = lightbox.querySelector('.lightbox-prev');
    const nextButton = lightbox.querySelector('.lightbox-next');

    function collectGalleryImages() {
        galleryImages = Array.from(
            document.querySelectorAll('[data-gallery-image]')
        ).map(button => ({
            src: button.dataset.imageSrc,
            alt: button.dataset.imageAlt || ''
        }));
    }

    function showImage(index) {
        if (!galleryImages.length) return;

        currentImageIndex =
            (index + galleryImages.length) % galleryImages.length;

        const image = galleryImages[currentImageIndex];

        lightboxImage.src = image.src;
        lightboxImage.alt = image.alt;

        lightboxCounter.textContent =
            `${currentImageIndex + 1} / ${galleryImages.length}`;
    }

    function openLightbox(index) {
        collectGalleryImages();

        if (!galleryImages.length) return;

        showImage(index);

        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');

        document.body.classList.add('lightbox-active');
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');

        document.body.classList.remove('lightbox-active');

        lightboxImage.src = '';
    }

    function showNextImage() {
        showImage(currentImageIndex + 1);
    }

    function showPreviousImage() {
        showImage(currentImageIndex - 1);
    }

    document.addEventListener('click', function (event) {
        const galleryButton = event.target.closest('[data-gallery-image]');

        if (galleryButton) {
            collectGalleryImages();

            const index = Array.from(
                document.querySelectorAll('[data-gallery-image]')
            ).indexOf(galleryButton);

            openLightbox(index);
        }
    });

    closeButton.addEventListener('click', closeLightbox);
    nextButton.addEventListener('click', showNextImage);
    previousButton.addEventListener('click', showPreviousImage);

    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!lightbox.classList.contains('is-open')) return;

        if (event.key === 'Escape') {
            closeLightbox();
        }

        if (event.key === 'ArrowRight') {
            showNextImage();
        }

        if (event.key === 'ArrowLeft') {
            showPreviousImage();
        }
    });
})();


/* =====================================
   ÉLORA NEWSLETTER SUBSCRIPTION
===================================== */

document.addEventListener('submit', async function (event) {
    const form = event.target.closest('#newsletterForm');

    if (!form) return;

    event.preventDefault();

    const submitButton = form.querySelector('#newsletterSubmit');
    const messageElement = form.querySelector('#newsletterMessage');
    const emailInput = form.querySelector('input[name="email"]');

    const originalButtonText = submitButton.textContent;

    messageElement.textContent = '';
    messageElement.className = 'newsletter-message';

    submitButton.disabled = true;
    submitButton.textContent = 'Subscribing...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422 && data.errors) {
                const firstError = Object.values(data.errors)[0][0];
                throw new Error(firstError);
            }

            throw new Error(data.message || 'Something went wrong.');
        }

        messageElement.textContent = data.message;
        messageElement.classList.add('success');

        form.reset();

    } catch (error) {
        messageElement.textContent = error.message;
        messageElement.classList.add('error');

    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
    }
});

/* =====================================
   ÉLORA AD CLICK TRACKING
===================================== */

document.addEventListener('click', function (event) {
    const adLink = event.target.closest(
        '.elora-ad-item[data-ad-click-url] a'
    );

    if (!adLink) return;

    const adContainer = adLink.closest('.elora-ad-item');
    const clickUrl = adContainer?.dataset.adClickUrl;

    if (!clickUrl) return;

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    if (!csrfToken) return;

    fetch(clickUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        keepalive: true
    }).catch(error => {
        console.error('Ad click tracking failed:', error);
    });
});
