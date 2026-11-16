<footer class="footer">
    <div class="container">

        <div class="footer-grid">

            <div>
                <a class="brand" href="{{ route('home') }}">ÉLORA</a>

                <p>
                    An independent style journal exploring fashion,
                    design, craftsmanship and personal style.
                </p>
            </div>

            <div>
                <h4>Explore</h4>

                <div class="footer-links">
                    @foreach ($headerCategories as $category)
                        <a href="{{ route('category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    <a href="{{ route('journal.index') }}">Journal</a>
                </div>
            </div>

            <div>
                <h4>ÉLORA</h4>

                <div class="footer-links">
                    @foreach ($footerBrandPages as $page)
                        <a href="{{ route('page.show', $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                    <a href="{{ route('contact.index') }}">Contact</a>
                </div>
            </div>

            <div>
                <h4>Information</h4>

                <div class="footer-links">
                    @foreach ($footerInfoPages as $page)
                        <a href="{{ route('page.show', $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    @endforeach

                    <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
                </div>
            </div>

        </div>

        <div class="copyright">
            © {{ date('Y') }} ÉLORA Style Journal.
            All rights reserved.
        </div>

    </div>
</footer>
