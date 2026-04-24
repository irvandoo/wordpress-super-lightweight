<?php
/**
 * Quick Seeder - Digital Marketing Content
 * 3 Categories x 3 Posts = 9 Posts Total
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'wp-load.php';

// Simple security check
if (!isset($_GET['run']) || $_GET['run'] !== 'yes') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Seeder</title>
        <style>
            body{font-family:system-ui;max-width:600px;margin:100px auto;text-align:center;padding:20px}
            h1{color:#2563eb}
            a{display:inline-block;padding:16px 32px;background:#2563eb;color:white;text-decoration:none;border-radius:8px;font-weight:600;margin-top:20px}
            a:hover{background:#1d4ed8}
        </style>
    </head>
    <body>
        <h1>🚀 Digital Marketing Seeder</h1>
        <p>Klik tombol di bawah untuk generate 9 artikel (3 kategori x 3 posts)</p>
        <a href="?run=yes">Generate Content</a>
    </body>
    </html>
    <?php
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Seeding...</title>
    <style>
        body{font-family:system-ui;max-width:800px;margin:50px auto;padding:20px}
        h1{color:#2563eb}
        h2{color:#059669}
        p{padding:8px;background:#f8fafc;border-left:3px solid #2563eb;margin:8px 0}
        .error{background:#fee;border-left-color:#dc2626;color:#dc2626}
        a{display:inline-block;padding:12px 24px;background:#2563eb;color:white;text-decoration:none;border-radius:6px;font-weight:600;margin-top:20px}
        a:hover{background:#1d4ed8}
    </style>
</head>
<body>
<h1>Seeding Digital Marketing Content...</h1>

<?php
try {
    // Categories
    $categories = [
        'SEO & Content Marketing' => 'Strategi SEO dan Content Marketing untuk meningkatkan traffic organik',
        'Affiliate Marketing' => 'Panduan lengkap affiliate marketing dan monetisasi website',
        'Social Media Marketing' => 'Tips dan trik social media marketing untuk brand awareness'
    ];

    $cat_ids = [];
    foreach ($categories as $name => $desc) {
        $cat = get_term_by('name', $name, 'category');
        if (!$cat) {
            $cat_id = wp_create_category($name);
            if (is_wp_error($cat_id)) {
                throw new Exception("Failed to create category: $name");
            }
            wp_update_term($cat_id, 'category', ['description' => $desc]);
            $cat_ids[$name] = $cat_id;
            echo "<p>✓ Created category: $name</p>";
        } else {
            $cat_ids[$name] = $cat->term_id;
            echo "<p>✓ Category exists: $name</p>";
        }
    }

    // Simplified posts data
    $posts = [
        'SEO & Content Marketing' => [
            ['title' => 'Panduan Lengkap Keyword Research untuk SEO 2026', 'content' => '<p>Keyword research adalah fondasi dari setiap strategi SEO yang sukses.</p><h2>Tools Keyword Research Terbaik</h2><p>Ada banyak tools yang bisa membantu proses keyword research Anda.</p><h3>Google Keyword Planner</h3><p>Tool gratis dari Google Ads ini memberikan data search volume dan competition level.</p><h3>Ahrefs Keywords Explorer</h3><p>Ahrefs menawarkan database keyword terbesar dengan metrics yang sangat detail.</p><h2>Strategi Keyword Research</h2><p>Jangan hanya fokus pada high-volume keywords. Kombinasikan dengan long-tail keywords.</p>'],
            ['title' => 'Strategi Link Building yang Aman dan Efektif', 'content' => '<p>Backlink masih menjadi salah satu ranking factor terpenting di Google.</p><h2>Apa Itu Backlink Berkualitas?</h2><p>Backlink berkualitas adalah link yang berasal dari website authoritative.</p><h2>Strategi White Hat Link Building</h2><p>Link building yang aman harus menggunakan metode white hat.</p><h3>Guest Posting Berkualitas</h3><p>Tulis artikel guest post yang benar-benar memberikan value.</p>'],
            ['title' => 'Content Marketing Strategy yang Menghasilkan ROI', 'content' => '<p>Content marketing bukan hanya tentang membuat konten sebanyak-banyaknya.</p><h2>Content Marketing Funnel</h2><p>Setiap stage dalam customer journey membutuhkan jenis konten yang berbeda.</p><h2>Content Distribution Strategy</h2><p>Konten terbaik sekalipun tidak akan efektif jika tidak didistribusikan dengan benar.</p>']
        ],
        'Affiliate Marketing' => [
            ['title' => 'Cara Memulai Affiliate Marketing dari Nol', 'content' => '<p>Affiliate marketing adalah salah satu cara paling populer untuk menghasilkan passive income online.</p><h2>Apa Itu Affiliate Marketing?</h2><p>Affiliate marketing adalah model bisnis di mana Anda mempromosikan produk orang lain.</p><h2>Memilih Niche yang Profitable</h2><p>Pilih niche yang memiliki demand tinggi dan competition yang manageable.</p>'],
            ['title' => 'Strategi Meningkatkan Conversion Rate Affiliate', 'content' => '<p>Mendapatkan traffic saja tidak cukup. Anda perlu mengoptimalkan conversion rate.</p><h2>Memahami Buyer Psychology</h2><p>Orang membeli berdasarkan emosi, lalu justify dengan logika.</p><h2>Optimasi Landing Page</h2><p>Landing page yang baik harus memiliki headline yang compelling.</p>'],
            ['title' => 'Kesalahan Fatal dalam Affiliate Marketing', 'content' => '<p>Banyak affiliate marketer pemula yang gagal karena melakukan kesalahan umum.</p><h2>Promosi Produk yang Tidak Pernah Digunakan</h2><p>Jangan promosikan produk yang tidak pernah Anda coba sendiri.</p><h2>Tidak Membangun Email List</h2><p>Mengandalkan traffic dari search engine saja sangat risky.</p>']
        ],
        'Social Media Marketing' => [
            ['title' => 'Strategi Instagram Marketing untuk Engagement', 'content' => '<p>Instagram tetap menjadi platform social media paling powerful untuk brand building.</p><h2>Instagram Algorithm 2026</h2><p>Instagram algorithm memprioritaskan konten yang mendapatkan engagement tinggi.</p><h2>Content Strategy yang Efektif</h2><p>Variasikan jenis konten Anda: feed posts, Reels, Stories, dan Carousel.</p>'],
            ['title' => 'TikTok Marketing: Cara Viral dan Build Brand', 'content' => '<p>TikTok bukan hanya untuk Gen Z. Platform ini menawarkan organic reach yang luar biasa.</p><h2>Memahami TikTok Algorithm</h2><p>TikTok algorithm sangat demokratis. Even account baru bisa viral.</p><h2>Content yang Viral di TikTok</h2><p>TikTok adalah platform entertainment-first.</p>'],
            ['title' => 'LinkedIn Marketing untuk B2B Lead Generation', 'content' => '<p>LinkedIn adalah platform paling powerful untuk B2B marketing dan professional networking.</p><h2>Optimasi LinkedIn Profile</h2><p>Profile Anda adalah landing page Anda di LinkedIn.</p><h2>Content Strategy di LinkedIn</h2><p>LinkedIn algorithm favor native content daripada external links.</p>']
        ]
    ];

    // Insert posts
    $total = 0;
    foreach ($posts as $cat_name => $cat_posts) {
        if (!isset($cat_ids[$cat_name])) {
            echo "<p class='error'>✗ Category not found: $cat_name</p>";
            continue;
        }
        
        $cat_id = $cat_ids[$cat_name];
        
        foreach ($cat_posts as $post_data) {
            $post_id = wp_insert_post([
                'post_title' => $post_data['title'],
                'post_content' => $post_data['content'],
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'post',
                'post_category' => [$cat_id],
                'comment_status' => 'open',
                'ping_status' => 'open'
            ]);
            
            if (is_wp_error($post_id)) {
                echo "<p class='error'>✗ Failed: {$post_data['title']}</p>";
            } elseif ($post_id) {
                $total++;
                echo "<p>✓ Created: {$post_data['title']}</p>";
            }
        }
    }

    echo "<h2>✓ Done! Created $total posts in 3 categories.</h2>";
    echo "<p><a href='" . home_url() . "'>View Homepage</a></p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Error: " . esc_html($e->getMessage()) . "</p>";
}
?>

</body>
</html>
