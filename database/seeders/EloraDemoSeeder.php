<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Design;
use App\Models\NewsletterSubscriber;
use App\Models\StaticPage;
use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class EloraDemoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Fashion Categories
        |--------------------------------------------------------------------------
        */

        $categoriesData = [
            ['name' => 'Women Fashion', 'slug' => 'women-fashion', 'description' => 'Explore elegant and modern women fashion collections.', 'sort_order' => 1],
            ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Discover beautiful footwear and shoe trends.', 'sort_order' => 2],
            ['name' => 'Watches', 'slug' => 'watches', 'description' => 'Explore timeless watches and luxury styles.', 'sort_order' => 3],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Discover fashion accessories and styling inspiration.', 'sort_order' => 4],
            ['name' => 'Bridal Fashion', 'slug' => 'bridal-fashion', 'description' => 'Elegant bridal fashion and wedding inspiration.', 'sort_order' => 5],
            ['name' => 'Evening Wear', 'slug' => 'evening-wear', 'description' => 'Beautiful evening dresses and formal looks.', 'sort_order' => 6],
        ];

        $categories = [];

        foreach ($categoriesData as $data) {
            $category = Category::firstOrNew(['slug' => $data['slug']]);

            $category->fill([
                'name' => $data['name'],
                'description' => $data['description'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);

            $category->save();

            $categories[$data['slug']] = $category;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Fashion Designs
        |--------------------------------------------------------------------------
        */

        $designsData = [
            [
                'category' => 'women-fashion',
                'title' => 'Royal Evening Gown',
                'slug' => 'royal-evening-gown',
                'designer' => 'ÉLORA Editorial',
                'collection_name' => 'Royal Elegance',
                'description' => 'A sophisticated evening gown featuring elegant details and timeless styling.',
                'featured' => true,
            ],
            [
                'category' => 'women-fashion',
                'title' => 'Floral Summer Dress',
                'slug' => 'floral-summer-dress',
                'designer' => 'ÉLORA Editorial',
                'collection_name' => 'Summer Bloom',
                'description' => 'A beautiful floral dress inspired by fresh summer fashion.',
                'featured' => true,
            ],
            [
                'category' => 'bridal-fashion',
                'title' => 'Ivory Bridal Dress',
                'slug' => 'ivory-bridal-dress',
                'designer' => 'ÉLORA Bridal',
                'collection_name' => 'Bridal Dreams',
                'description' => 'An elegant ivory bridal look with delicate details.',
                'featured' => true,
            ],
            [
                'category' => 'evening-wear',
                'title' => 'Emerald Party Outfit',
                'slug' => 'emerald-party-outfit',
                'designer' => 'ÉLORA Editorial',
                'collection_name' => 'Evening Glamour',
                'description' => 'A glamorous emerald outfit for special occasions.',
                'featured' => true,
            ],
            [
                'category' => 'women-fashion',
                'title' => 'Minimalist Formal Suit',
                'slug' => 'minimalist-formal-suit',
                'designer' => 'ÉLORA Studio',
                'collection_name' => 'Modern Classics',
                'description' => 'A clean and modern formal look for contemporary women.',
                'featured' => false,
            ],
            [
                'category' => 'shoes',
                'title' => 'Elegant Heels Collection',
                'slug' => 'elegant-heels-collection',
                'designer' => 'ÉLORA Accessories',
                'collection_name' => 'Modern Footwear',
                'description' => 'A curated collection of elegant heels and footwear.',
                'featured' => false,
            ],
            [
                'category' => 'watches',
                'title' => 'Classic Luxury Watch',
                'slug' => 'classic-luxury-watch',
                'designer' => 'ÉLORA Accessories',
                'collection_name' => 'Timeless Details',
                'description' => 'A timeless watch style with refined design.',
                'featured' => false,
            ],
            [
                'category' => 'accessories',
                'title' => 'Pearl Accessories',
                'slug' => 'pearl-accessories',
                'designer' => 'ÉLORA Accessories',
                'collection_name' => 'Elegant Touches',
                'description' => 'Classic pearl accessories for elegant styling.',
                'featured' => false,
            ],
        ];

        $designs = [];

        foreach ($designsData as $data) {
            $design = Design::firstOrNew(['slug' => $data['slug']]);

            $design->fill([
                'category_id' => $categories[$data['category']]->id,
                'title' => $data['title'],
                'short_description' => $data['description'],
                'description' => $data['description'],
                'designer' => $data['designer'],
                'collection_name' => $data['collection_name'],
                'status' => 'published',
                'is_featured' => $data['featured'],
                'published_at' => now(),
                'meta_title' => $data['title'] . ' | ÉLORA',
                'meta_description' => $data['description'],
            ]);

            $design->save();

            $designs[$data['slug']] = $design;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Multiple Design Images
        |--------------------------------------------------------------------------
        |
        | Images will be uploaded from Filament later.
        | Existing uploaded images are not overwritten.
        |
        */

        /*
        |--------------------------------------------------------------------------
        | 4. Blog Categories
        |--------------------------------------------------------------------------
        */

        $blogCategoriesData = [
            ['name' => 'Fashion Trends', 'slug' => 'fashion-trends'],
            ['name' => 'Bridal Fashion', 'slug' => 'bridal-fashion-journal'],
            ['name' => 'Style Guide', 'slug' => 'style-guide'],
            ['name' => 'Fashion Editorial', 'slug' => 'fashion-editorial'],
            ['name' => 'Seasonal Fashion', 'slug' => 'seasonal-fashion'],
        ];

        $blogCategories = [];

        foreach ($blogCategoriesData as $index => $data) {
            $blogCategory = BlogCategory::firstOrNew([
                'slug' => $data['slug'],
            ]);

            $blogCategory->fill([
                'name' => $data['name'],
                'description' => 'Explore ' . $data['name'] . ' inspiration and ideas.',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);

            $blogCategory->save();

            $blogCategories[$data['slug']] = $blogCategory;
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Journal Articles
        |--------------------------------------------------------------------------
        */

        $articlesData = [
            [
                'category' => 'fashion-trends',
                'title' => 'Top Fashion Trends to Watch in 2026',
                'slug' => 'top-fashion-trends-2026',
                'excerpt' => 'Discover the fashion trends shaping the style world in 2026.',
                'content' => '<h2>Fashion Trends in 2026</h2><p>Fashion continues to evolve with fresh silhouettes, refined colours and creative styling. This season brings together timeless elegance and modern expression.</p><p>From statement outfits to minimalist classics, discover new inspiration for your wardrobe and personal style.</p>',
                'featured' => true,
                'status' => 'published',
                'designs' => ['royal-evening-gown', 'floral-summer-dress'],
            ],
            [
                'category' => 'bridal-fashion-journal',
                'title' => 'The Beauty of Modern Bridal Fashion',
                'slug' => 'beauty-of-modern-bridal-fashion',
                'excerpt' => 'A closer look at modern bridal style and timeless wedding elegance.',
                'content' => '<h2>Modern Bridal Elegance</h2><p>Modern bridal fashion combines tradition with contemporary design. Beautiful fabrics, delicate details and elegant silhouettes create unforgettable wedding looks.</p>',
                'featured' => true,
                'status' => 'published',
                'designs' => ['ivory-bridal-dress'],
            ],
            [
                'category' => 'style-guide',
                'title' => 'How to Choose the Perfect Evening Dress',
                'slug' => 'choose-perfect-evening-dress',
                'excerpt' => 'Explore practical styling inspiration for choosing an elegant evening dress.',
                'content' => '<h2>Finding Your Perfect Evening Look</h2><p>Choosing an evening dress starts with understanding the occasion, silhouette and personal style. Explore colours, fabrics and details that make an outfit memorable.</p>',
                'featured' => false,
                'status' => 'published',
                'designs' => ['royal-evening-gown', 'emerald-party-outfit'],
            ],
            [
                'category' => 'fashion-editorial',
                'title' => 'Inside the World of Fashion Editorials',
                'slug' => 'inside-world-fashion-editorials',
                'excerpt' => 'Discover the creativity and storytelling behind fashion editorials.',
                'content' => '<h2>The Art of Fashion Editorials</h2><p>Fashion editorials bring together photography, styling, creative direction and storytelling. Each editorial creates a visual world that communicates a unique fashion perspective.</p>',
                'featured' => false,
                'status' => 'published',
                'designs' => ['minimalist-formal-suit'],
            ],
            [
                'category' => 'seasonal-fashion',
                'title' => 'Summer Fashion Inspiration for Women',
                'slug' => 'summer-fashion-inspiration-women',
                'excerpt' => 'Fresh outfit inspiration and seasonal styling ideas for summer.',
                'content' => '<h2>Summer Style Inspiration</h2><p>Summer fashion is all about light fabrics, fresh colours and effortless silhouettes. Explore versatile outfit ideas that bring comfort and elegance together.</p>',
                'featured' => false,
                'status' => 'draft',
                'designs' => ['floral-summer-dress'],
            ],
        ];

        foreach ($articlesData as $data) {
            $article = Article::firstOrNew([
                'slug' => $data['slug'],
            ]);

            $article->fill([
                'blog_category_id' => $blogCategories[$data['category']]->id,
                'title' => $data['title'],
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'author' => 'ÉLORA Editorial Team',
                'status' => $data['status'],
                'is_featured' => $data['featured'],
                'published_at' => $data['status'] === 'published' ? now() : null,
                'meta_title' => $data['title'] . ' | ÉLORA Journal',
                'meta_description' => $data['excerpt'],
            ]);

            $article->save();

            $relatedDesignIds = collect($data['designs'])
                ->map(fn($slug) => $designs[$slug]->id)
                ->all();

            $article->designs()->syncWithoutDetaching($relatedDesignIds);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Static Pages
        |--------------------------------------------------------------------------
        */

        $staticPages = [
            [
                'title' => 'About ÉLORA',
                'slug' => 'about',
                'content' => '<h2>About ÉLORA</h2><p>ÉLORA is an independent fashion and lifestyle magazine celebrating creativity, elegance and modern style.</p>',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h2>Contact ÉLORA</h2><p>We welcome your questions, suggestions and collaboration enquiries. Get in touch with our editorial team.</p>',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>ÉLORA respects visitor privacy. This page explains how website information may be collected and used.</p>',
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<h2>Disclaimer</h2><p>Content published on ÉLORA is provided for informational and editorial purposes.</p>',
            ],
            [
                'title' => 'Advertising',
                'slug' => 'advertising',
                'content' => '<h2>Advertising</h2><p>For advertising and editorial collaboration enquiries, please contact the ÉLORA team.</p>',
            ],
        ];

        foreach ($staticPages as $index => $data) {
            $page = StaticPage::firstOrNew([
                'slug' => $data['slug'],
            ]);

            $page->fill([
                'title' => $data['title'],
                'content' => $data['content'],
                'status' => 'published',
                'meta_title' => $data['title'] . ' | ÉLORA',
                'meta_description' => $data['title'] . ' - Official ÉLORA website.',
                'sort_order' => $index + 1,
            ]);

            $page->save();
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Contact Messages
        |--------------------------------------------------------------------------
        */

        $messages = [
            [
                'name' => 'Sophia Williams',
                'email' => 'sophia@example.com',
                'subject' => 'Fashion Collaboration',
                'message' => 'Hello ÉLORA team, I am interested in discussing a fashion editorial collaboration.',
            ],
            [
                'name' => 'Olivia Martin',
                'email' => 'olivia@example.com',
                'subject' => 'General Enquiry',
                'message' => 'I love your fashion magazine and would like to know more about your editorial content.',
            ],
            [
                'name' => 'Emma Johnson',
                'email' => 'emma@example.com',
                'subject' => 'Website Feedback',
                'message' => 'Your website has beautiful fashion inspiration. I would like to share some feedback.',
            ],
        ];

        foreach ($messages as $data) {
            ContactMessage::firstOrCreate(
                [
                    'email' => $data['email'],
                    'subject' => $data['subject'],
                ],
                [
                    'name' => $data['name'],
                    'message' => $data['message'],
                    'is_read' => false,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Newsletter Subscribers
        |--------------------------------------------------------------------------
        */

        $subscribers = [
            'sophia@example.com',
            'olivia@example.com',
            'emma@example.com',
            'isabella@example.com',
            'charlotte@example.com',
        ];

        foreach ($subscribers as $email) {
            NewsletterSubscriber::firstOrCreate(
                ['email' => $email],
                [
                    'is_active' => true,
                    'subscribed_at' => now(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 9. Advertisements
        |--------------------------------------------------------------------------
        */

        $advertisements = [
            ['title' => 'Header Demo Advertisement', 'placement' => 'header'],
            ['title' => 'Sidebar Demo Advertisement', 'placement' => 'sidebar'],
            ['title' => 'In Article Demo Advertisement', 'placement' => 'in_article'],
            ['title' => 'Between Designs Demo Advertisement', 'placement' => 'between_designs'],
            ['title' => 'Footer Demo Advertisement', 'placement' => 'footer'],
        ];

        foreach ($advertisements as $index => $data) {
            Advertisement::firstOrCreate(
                [
                    'title' => $data['title'],
                    'placement' => $data['placement'],
                ],
                [
                    'ad_code' => '<!-- Demo advertisement placeholder -->',
                    'is_active' => false,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
