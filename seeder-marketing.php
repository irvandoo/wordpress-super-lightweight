<?php
/**
 * Quick Seeder - Digital Marketing Content
 * 3 Categories x 3 Posts = 9 Posts Total
 */

require_once 'wp-load.php';

// Simple security check
if (!isset($_GET['run']) || $_GET['run'] !== 'yes') {
    echo '<!DOCTYPE html><html><head><title>Seeder</title><style>body{font-family:system-ui;max-width:600px;margin:100px auto;text-align:center;padding:20px}h1{color:#2563eb}a{display:inline-block;padding:16px 32px;background:#2563eb;color:white;text-decoration:none;border-radius:8px;font-weight:600;margin-top:20px}a:hover{background:#1d4ed8}</style></head><body><h1>🚀 Digital Marketing Seeder</h1><p>Klik tombol di bawah untuk generate 9 artikel (3 kategori x 3 posts)</p><a href="?run=yes">Generate Content</a></body></html>';
    exit;
}

echo '<!DOCTYPE html><html><head><title>Seeding...</title><style>body{font-family:system-ui;max-width:800px;margin:50px auto;padding:20px}h1{color:#2563eb}h2{color:#059669}p{padding:8px;background:#f8fafc;border-left:3px solid #2563eb;margin:8px 0}a{display:inline-block;padding:12px 24px;background:#2563eb;color:white;text-decoration:none;border-radius:6px;font-weight:600;margin-top:20px}a:hover{background:#1d4ed8}</style></head><body>';
echo "<h1>Seeding Digital Marketing Content...</h1>";

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
        wp_update_term($cat_id, 'category', ['description' => $desc]);
        $cat_ids[$name] = $cat_id;
        echo "<p>✓ Created category: $name</p>";
    } else {
        $cat_ids[$name] = $cat->term_id;
        echo "<p>✓ Category exists: $name</p>";
    }
}

// Posts Data
$posts = [
    'SEO & Content Marketing' => [
        [
            'title' => 'Panduan Lengkap Keyword Research untuk SEO 2026',
            'content' => '<p>Keyword research adalah fondasi dari setiap strategi SEO yang sukses. Tanpa riset keyword yang tepat, konten Anda akan sulit ditemukan oleh target audience di mesin pencari.</p>

<h2>Mengapa Keyword Research Penting?</h2>
<p>Keyword research membantu Anda memahami bahasa yang digunakan oleh target audience saat mencari informasi. Dengan memahami intent pencarian mereka, Anda bisa membuat konten yang benar-benar menjawab kebutuhan mereka.</p>

<p>Google semakin pintar dalam memahami konteks dan intent di balik setiap pencarian. Algoritma seperti BERT dan MUM memungkinkan Google untuk memahami nuansa bahasa natural, bukan hanya keyword matching sederhana.</p>

<h2>Tools Keyword Research Terbaik 2026</h2>
<p>Ada banyak tools yang bisa membantu proses keyword research Anda:</p>

<h3>1. Google Keyword Planner</h3>
<p>Tool gratis dari Google Ads ini memberikan data search volume dan competition level langsung dari sumbernya. Meskipun datanya kadang terlalu broad, ini tetap menjadi starting point yang bagus.</p>

<h3>2. Ahrefs Keywords Explorer</h3>
<p>Ahrefs menawarkan database keyword terbesar dengan metrics yang sangat detail seperti keyword difficulty, click potential, dan parent topic. Tool ini sangat powerful untuk menemukan keyword opportunities.</p>

<h3>3. SEMrush Keyword Magic Tool</h3>
<p>SEMrush memiliki database lebih dari 20 miliar keywords. Fitur question-based keywords sangat berguna untuk menemukan long-tail keywords dengan intent yang jelas.</p>

<h2>Strategi Keyword Research yang Efektif</h2>
<p>Jangan hanya fokus pada high-volume keywords. Kombinasikan dengan long-tail keywords yang lebih spesifik dan memiliki conversion rate lebih tinggi.</p>

<p>Analisis juga search intent: apakah informational, navigational, commercial, atau transactional. Sesuaikan jenis konten dengan intent tersebut.</p>

<h2>Kesalahan Umum dalam Keyword Research</h2>
<p>Banyak marketer yang terjebak pada vanity metrics seperti search volume tinggi, padahal keyword tersebut terlalu kompetitif atau tidak relevan dengan bisnis mereka.</p>

<p>Fokus pada keyword yang memiliki balance antara volume, difficulty, dan relevance dengan produk/layanan Anda.</p>'
        ],
        [
            'title' => 'Strategi Link Building yang Aman dan Efektif di 2026',
            'content' => '<p>Backlink masih menjadi salah satu ranking factor terpenting di Google. Namun, tidak semua backlink diciptakan sama. Quality jauh lebih penting daripada quantity.</p>

<h2>Apa Itu Backlink Berkualitas?</h2>
<p>Backlink berkualitas adalah link yang berasal dari website authoritative, relevan dengan niche Anda, dan ditempatkan secara natural dalam konten yang berkualitas.</p>

<p>Google menggunakan algoritma PageRank yang telah dimodifikasi untuk menilai kualitas backlink. Faktor seperti domain authority, topical relevance, dan anchor text diversity semuanya diperhitungkan.</p>

<h2>Strategi White Hat Link Building</h2>
<p>Link building yang aman dan sustainable harus menggunakan metode white hat yang sesuai dengan guidelines Google.</p>

<h3>1. Guest Posting Berkualitas</h3>
<p>Tulis artikel guest post yang benar-benar memberikan value untuk audience website target. Jangan hanya fokus pada link, tapi bangun relationship dengan pemilik website.</p>

<h3>2. Digital PR dan Media Coverage</h3>
<p>Dapatkan coverage dari media online dengan membuat press release yang newsworthy atau melakukan stunt marketing yang menarik perhatian.</p>

<h3>3. Resource Page Link Building</h3>
<p>Cari resource pages yang relevan dengan niche Anda dan suggest konten Anda sebagai tambahan yang valuable untuk list mereka.</p>

<h2>Broken Link Building</h2>
<p>Teknik ini melibatkan menemukan broken links di website lain, lalu menawarkan konten Anda sebagai replacement. Ini win-win solution karena Anda membantu mereka fix broken links.</p>

<h2>Content Marketing untuk Natural Links</h2>
<p>Cara terbaik mendapatkan backlink adalah dengan membuat konten yang sangat berkualitas sehingga orang secara natural ingin link ke konten Anda.</p>

<p>Buat original research, infografis yang menarik, atau tools gratis yang useful. Konten seperti ini memiliki link magnet yang kuat.</p>

<h2>Monitoring dan Disavow Toxic Links</h2>
<p>Gunakan Google Search Console dan tools seperti Ahrefs untuk monitor backlink profile Anda. Jika menemukan toxic links, gunakan disavow tool untuk memberitahu Google agar mengabaikan links tersebut.</p>'
        ],
        [
            'title' => 'Content Marketing Strategy yang Menghasilkan ROI Tinggi',
            'content' => '<p>Content marketing bukan hanya tentang membuat konten sebanyak-banyaknya. Strategi yang tepat akan menghasilkan ROI yang jauh lebih tinggi dengan effort yang lebih efisien.</p>

<h2>Memahami Content Marketing Funnel</h2>
<p>Setiap stage dalam customer journey membutuhkan jenis konten yang berbeda. Pahami perbedaan antara TOFU (Top of Funnel), MOFU (Middle of Funnel), dan BOFU (Bottom of Funnel) content.</p>

<h3>TOFU Content: Awareness Stage</h3>
<p>Di stage ini, audience baru menyadari masalah mereka. Buat konten educational yang membantu mereka memahami masalah tersebut. Format yang cocok: blog posts, infografis, video tutorial.</p>

<h3>MOFU Content: Consideration Stage</h3>
<p>Audience sudah tahu masalahnya dan sedang mencari solusi. Buat konten yang membandingkan berbagai solusi. Format: comparison guides, case studies, webinars.</p>

<h3>BOFU Content: Decision Stage</h3>
<p>Audience siap membeli dan sedang memilih vendor. Buat konten yang menunjukkan keunggulan produk Anda. Format: product demos, free trials, customer testimonials.</p>

<h2>Content Distribution Strategy</h2>
<p>Konten terbaik sekalipun tidak akan efektif jika tidak didistribusikan dengan benar. Gunakan multi-channel approach untuk maksimalkan reach.</p>

<h3>Owned Media</h3>
<p>Website, blog, email list adalah aset yang Anda kontrol penuh. Ini harus menjadi hub utama untuk semua konten Anda.</p>

<h3>Earned Media</h3>
<p>PR coverage, guest posts, dan mentions dari influencer. Ini memberikan credibility dan exposure ke audience baru.</p>

<h3>Paid Media</h3>
<p>Facebook Ads, Google Ads, sponsored content. Gunakan untuk amplify konten terbaik Anda dan reach audience yang lebih targeted.</p>

<h2>Content Repurposing</h2>
<p>Satu piece of content bisa direpurpose menjadi berbagai format. Blog post bisa jadi video YouTube, infografis, carousel Instagram, atau thread Twitter.</p>

<p>Ini menghemat waktu dan memaksimalkan ROI dari setiap konten yang Anda buat.</p>

<h2>Measuring Content Marketing Success</h2>
<p>Track metrics yang benar-benar penting: organic traffic, engagement rate, conversion rate, dan customer acquisition cost. Jangan terjebak pada vanity metrics seperti page views saja.</p>

<p>Gunakan Google Analytics 4 untuk tracking yang lebih advanced dan insights yang lebih actionable.</p>'
        ]
    ],
    'Affiliate Marketing' => [
        [
            'title' => 'Cara Memulai Affiliate Marketing dari Nol untuk Pemula',
            'content' => '<p>Affiliate marketing adalah salah satu cara paling populer untuk menghasilkan passive income online. Dengan strategi yang tepat, Anda bisa mendapatkan komisi dari produk orang lain tanpa harus membuat produk sendiri.</p>

<h2>Apa Itu Affiliate Marketing?</h2>
<p>Affiliate marketing adalah model bisnis di mana Anda mempromosikan produk atau layanan orang lain dan mendapatkan komisi untuk setiap penjualan yang terjadi melalui referral link Anda.</p>

<p>Ini adalah win-win solution: merchant mendapatkan sales, customer mendapatkan produk yang mereka butuhkan, dan Anda mendapatkan komisi.</p>

<h2>Memilih Niche yang Profitable</h2>
<p>Pilih niche yang memiliki demand tinggi, competition yang manageable, dan produk affiliate dengan komisi yang bagus. Beberapa niche profitable: finance, health & fitness, technology, dan online education.</p>

<h3>Riset Kompetitor</h3>
<p>Analisis website affiliate yang sudah sukses di niche Anda. Pelajari strategi konten mereka, produk apa yang mereka promosikan, dan bagaimana mereka membangun audience.</p>

<h2>Platform Affiliate Terbaik</h2>
<p>Ada banyak affiliate network yang bisa Anda join:</p>

<h3>1. Amazon Associates</h3>
<p>Program affiliate terbesar dengan jutaan produk. Komisi memang kecil (1-10%), tapi conversion rate tinggi karena trust factor Amazon.</p>

<h3>2. ClickBank</h3>
<p>Fokus pada digital products dengan komisi hingga 75%. Cocok untuk niche info products dan online courses.</p>

<h3>3. ShareASale</h3>
<p>Network dengan ribuan merchants dari berbagai niche. Interface user-friendly dan payment reliable.</p>

<h2>Membangun Website Affiliate</h2>
<p>Website adalah aset utama Anda dalam affiliate marketing. Fokus pada konten berkualitas yang memberikan value, bukan hanya promosi produk.</p>

<p>Buat review mendalam, comparison articles, tutorial, dan buying guides yang membantu audience membuat keputusan pembelian yang informed.</p>

<h2>Traffic Generation Strategy</h2>
<p>Tanpa traffic, tidak ada sales. Kombinasikan SEO untuk organic traffic jangka panjang dengan paid ads untuk hasil cepat.</p>

<p>Bangun juga email list untuk relationship building dan repeat sales. Email marketing memiliki ROI tertinggi di affiliate marketing.</p>'
        ],
        [
            'title' => 'Strategi Meningkatkan Conversion Rate Affiliate Marketing',
            'content' => '<p>Mendapatkan traffic saja tidak cukup. Anda perlu mengoptimalkan conversion rate agar traffic tersebut menghasilkan komisi yang maksimal.</p>

<h2>Memahami Buyer Psychology</h2>
<p>Orang membeli berdasarkan emosi, lalu justify dengan logika. Pahami pain points audience Anda dan tunjukkan bagaimana produk yang Anda promosikan bisa solve masalah mereka.</p>

<h3>Social Proof</h3>
<p>Tampilkan testimonials, reviews, dan case studies. Social proof sangat powerful untuk meningkatkan trust dan conversion.</p>

<h2>Optimasi Landing Page</h2>
<p>Landing page yang baik harus memiliki headline yang compelling, benefit-focused copy, clear CTA, dan minimal distraction.</p>

<h3>A/B Testing</h3>
<p>Test berbagai elemen: headline, CTA button color, placement, copy length. Data-driven decisions akan meningkatkan conversion secara signifikan.</p>

<h2>Email Marketing Funnel</h2>
<p>Bangun automated email sequence yang nurture leads dan gradually introduce affiliate products. Jangan langsung hard sell di email pertama.</p>

<h3>Segmentasi Audience</h3>
<p>Segment email list berdasarkan interest dan behavior. Kirim offer yang relevan untuk setiap segment untuk meningkatkan conversion rate.</p>

<h2>Retargeting Strategy</h2>
<p>Gunakan Facebook Pixel dan Google Ads retargeting untuk reach kembali visitors yang belum convert. Retargeting memiliki conversion rate 2-3x lebih tinggi.</p>

<h2>Bonus dan Incentive</h2>
<p>Tawarkan bonus eksklusif untuk yang membeli melalui link Anda. Ini bisa berupa ebook, template, atau consultation call. Bonus yang valuable bisa jadi deciding factor.</p>

<h2>Transparency dan Disclosure</h2>
<p>Selalu disclose bahwa Anda menggunakan affiliate links. Transparency meningkatkan trust dan sebenarnya bisa meningkatkan conversion, bukan menurunkan.</p>'
        ],
        [
            'title' => 'Kesalahan Fatal dalam Affiliate Marketing yang Harus Dihindari',
            'content' => '<p>Banyak affiliate marketer pemula yang gagal karena melakukan kesalahan-kesalahan umum yang sebenarnya bisa dihindari. Pelajari kesalahan ini agar Anda tidak mengalami hal yang sama.</p>

<h2>1. Promosi Produk yang Tidak Pernah Digunakan</h2>
<p>Jangan promosikan produk yang tidak pernah Anda coba sendiri. Audience bisa merasakan ketidakautentikan Anda. Review yang genuine dan honest jauh lebih convincing.</p>

<h3>Solusi</h3>
<p>Invest untuk membeli produk yang akan Anda promosikan. Ini adalah business expense yang worth it karena Anda bisa membuat review yang lebih credible.</p>

<h2>2. Terlalu Fokus pada Komisi Tinggi</h2>
<p>Produk dengan komisi tinggi memang menarik, tapi jika tidak relevan dengan audience Anda atau kualitasnya buruk, conversion rate akan rendah.</p>

<h3>Solusi</h3>
<p>Pilih produk yang benar-benar solve masalah audience Anda, meskipun komisinya lebih kecil. Long-term trust lebih valuable daripada short-term profit.</p>

<h2>3. Tidak Membangun Email List</h2>
<p>Mengandalkan traffic dari search engine atau social media saja sangat risky. Algorithm bisa berubah kapan saja dan traffic Anda bisa drop drastis.</p>

<h3>Solusi</h3>
<p>Mulai build email list dari hari pertama. Email list adalah aset yang Anda kontrol penuh dan bisa generate recurring income.</p>

<h2>4. Konten yang Terlalu Sales-y</h2>
<p>Jika setiap artikel Anda hanya promosi produk, audience akan pergi. Berikan value dulu, baru promosi.</p>

<h3>Solusi</h3>
<p>Ikuti rule 80/20: 80% konten educational/entertaining, 20% promotional. Ini akan build trust dan authority.</p>

<h2>5. Tidak Tracking dan Analyzing Data</h2>
<p>Tanpa data, Anda tidak tahu apa yang working dan apa yang tidak. Ini seperti driving dengan mata tertutup.</p>

<h3>Solusi</h3>
<p>Setup Google Analytics, track conversion dengan UTM parameters, dan analyze data secara regular. Make data-driven decisions.</p>

<h2>6. Mengabaikan Mobile Optimization</h2>
<p>Lebih dari 60% traffic sekarang dari mobile. Jika website Anda tidak mobile-friendly, Anda kehilangan banyak potential sales.</p>

<h3>Solusi</h3>
<p>Pastikan website Anda responsive, loading speed cepat di mobile, dan CTA buttons mudah di-tap dengan jari.</p>'
        ]
    ],
    'Social Media Marketing' => [
        [
            'title' => 'Strategi Instagram Marketing untuk Meningkatkan Engagement 2026',
            'content' => '<p>Instagram tetap menjadi platform social media paling powerful untuk brand building dan engagement. Dengan strategi yang tepat, Anda bisa membangun community yang loyal dan engaged.</p>

<h2>Memahami Instagram Algorithm 2026</h2>
<p>Instagram algorithm memprioritaskan konten yang mendapatkan engagement tinggi dalam waktu singkat setelah posting. Faktor utama: likes, comments, shares, dan saves.</p>

<h3>Timing is Everything</h3>
<p>Post di waktu ketika audience Anda paling aktif. Gunakan Instagram Insights untuk melihat kapan followers Anda online.</p>

<h2>Content Strategy yang Efektif</h2>
<p>Variasikan jenis konten Anda: feed posts, Reels, Stories, dan Carousel. Setiap format memiliki kelebihan masing-masing.</p>

<h3>Reels: Reach Maksimal</h3>
<p>Reels mendapatkan reach paling tinggi di Instagram. Buat Reels yang entertaining, educational, atau inspiring. Hook di 3 detik pertama sangat crucial.</p>

<h3>Carousel: Engagement Tinggi</h3>
<p>Carousel posts mendapatkan engagement rate lebih tinggi karena orang swipe untuk melihat semua slides. Gunakan untuk tutorial, tips, atau storytelling.</p>

<h3>Stories: Daily Connection</h3>
<p>Stories untuk daily updates dan behind-the-scenes content. Gunakan interactive stickers (polls, questions, quizzes) untuk boost engagement.</p>

<h2>Hashtag Strategy</h2>
<p>Gunakan mix dari big hashtags (100K+ posts), medium hashtags (10K-100K), dan niche hashtags (<10K). Jangan hanya chase big hashtags karena competition terlalu tinggi.</p>

<h3>Branded Hashtag</h3>
<p>Buat branded hashtag untuk campaign Anda. Encourage followers untuk use hashtag tersebut untuk user-generated content.</p>

<h2>Engagement Tactics</h2>
<p>Engagement adalah two-way street. Jangan hanya post dan pergi. Reply semua comments, engage dengan content followers Anda, dan join conversations di niche Anda.</p>

<h3>DM Strategy</h3>
<p>Gunakan DM untuk build deeper relationships. Jangan spam, tapi initiate genuine conversations dengan potential customers atau collaborators.</p>

<h2>Instagram Ads</h2>
<p>Organic reach semakin menurun. Allocate budget untuk Instagram Ads untuk amplify best-performing content Anda.</p>

<p>Target audience dengan precision menggunakan Facebook Ads Manager. Test berbagai ad formats dan audiences untuk find winning combinations.</p>'
        ],
        [
            'title' => 'TikTok Marketing: Cara Viral dan Membangun Brand Awareness',
            'content' => '<p>TikTok bukan hanya untuk Gen Z. Platform ini menawarkan organic reach yang luar biasa dan opportunity untuk viral yang tidak ada di platform lain.</p>

<h2>Memahami TikTok Algorithm</h2>
<p>TikTok algorithm sangat demokratis. Even account baru dengan 0 followers bisa viral jika kontennya bagus. Algorithm melihat watch time, completion rate, dan engagement.</p>

<h3>For You Page (FYP)</h3>
<p>Goal utama adalah masuk FYP. Ini terjadi ketika video Anda mendapatkan engagement tinggi dari initial viewers. TikTok kemudian push video Anda ke audience yang lebih luas.</p>

<h2>Content yang Viral di TikTok</h2>
<p>TikTok adalah platform entertainment-first. Konten yang viral biasanya entertaining, relatable, atau educational dengan cara yang fun.</p>

<h3>Hook dalam 3 Detik</h3>
<p>Attention span di TikTok sangat pendek. Hook viewers dalam 3 detik pertama atau mereka akan scroll. Gunakan text overlay, visual yang menarik, atau statement yang controversial.</p>

<h3>Trending Sounds dan Challenges</h3>
<p>Participate dalam trending sounds dan challenges. Ini meningkatkan chance video Anda dilihat karena orang search trending sounds tersebut.</p>

<h2>TikTok for Business</h2>
<p>Jangan terlalu corporate di TikTok. Show personality, be authentic, dan jangan takut untuk be silly. Behind-the-scenes content dan employee spotlights perform well.</p>

<h3>Educational Content</h3>
<p>Quick tips, hacks, dan tutorials sangat popular di TikTok. Format "Things I wish I knew before..." atau "5 mistakes to avoid..." consistently perform well.</p>

<h2>Collaboration Strategy</h2>
<p>Collaborate dengan TikTok creators di niche Anda. Duet dan Stitch features memudahkan collaboration tanpa harus meet in person.</p>

<h3>Influencer Marketing</h3>
<p>Micro-influencers (10K-100K followers) di TikTok often have better engagement rate dan lebih affordable daripada macro-influencers.</p>

<h2>TikTok Ads</h2>
<p>TikTok Ads masih relatively cheaper daripada Facebook/Instagram Ads. In-Feed Ads yang native-looking perform best.</p>

<p>Test dengan budget kecil dulu, find winning creatives, lalu scale. TikTok Pixel tracking memungkinkan retargeting dan lookalike audiences.</p>'
        ],
        [
            'title' => 'LinkedIn Marketing untuk B2B: Strategi Lead Generation yang Efektif',
            'content' => '<p>LinkedIn adalah platform paling powerful untuk B2B marketing dan professional networking. Dengan 900+ juta users, ini adalah goldmine untuk lead generation.</p>

<h2>Optimasi LinkedIn Profile</h2>
<p>Profile Anda adalah landing page Anda di LinkedIn. Optimize setiap section: headline, about, experience, dan featured section.</p>

<h3>Headline yang Compelling</h3>
<p>Jangan hanya tulis job title. Gunakan headline untuk communicate value proposition Anda. Contoh: "Helping SaaS Companies 10x Their MRR Through Content Marketing".</p>

<h3>About Section</h3>
<p>Tell your story, showcase expertise, dan include clear CTA. Gunakan bullet points untuk readability dan include relevant keywords untuk SEO.</p>

<h2>Content Strategy di LinkedIn</h2>
<p>LinkedIn algorithm favor native content (text posts, documents, videos) daripada external links. Post consistently, ideally 3-5x per week.</p>

<h3>Jenis Konten yang Perform Well</h3>
<p>Personal stories, industry insights, controversial opinions (yang thoughtful), dan actionable tips. Vulnerability dan authenticity resonate di LinkedIn.</p>

<h3>Document Posts</h3>
<p>Upload PDF carousel yang visually appealing. Document posts get higher reach dan engagement daripada regular posts.</p>

<h2>LinkedIn Networking Strategy</h2>
<p>Networking di LinkedIn bukan tentang collecting connections, tapi building relationships.</p>

<h3>Personalized Connection Requests</h3>
<p>Jangan kirim generic connection request. Mention something specific tentang profile mereka atau mutual interest.</p>

<h3>Engage Before You Pitch</h3>
<p>Comment on their posts, share their content, dan build rapport dulu sebelum pitch produk/layanan Anda.</p>

<h2>LinkedIn Groups</h2>
<p>Join groups yang relevan dengan industry Anda. Participate actively, answer questions, dan establish yourself sebagai thought leader.</p>

<h2>LinkedIn Ads</h2>
<p>LinkedIn Ads memang mahal, tapi targeting options sangat precise. Anda bisa target by job title, company size, industry, dan seniority level.</p>

<h3>Lead Gen Forms</h3>
<p>LinkedIn Lead Gen Forms pre-filled dengan LinkedIn profile data, making it frictionless untuk users. Conversion rate significantly higher daripada landing page external.</p>

<h2>LinkedIn Sales Navigator</h2>
<p>Invest in Sales Navigator jika Anda serious tentang B2B lead generation. Advanced search filters dan lead recommendations sangat powerful.</p>

<p>Save leads, set alerts, dan use InMail credits strategically untuk reach decision makers yang otherwise sulit di-reach.</p>'
        ]
    ]
];

// Insert posts
$total = 0;
foreach ($posts as $cat_name => $cat_posts) {
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
        
        if ($post_id) {
            $total++;
            echo "<p>✓ Created post: {$post_data['title']}</p>";
        }
    }
}

echo "<h2>✓ Done! Created $total posts in 3 categories.</h2>";
echo "<p><a href='" . home_url() . "'>View Homepage</a></p>";
echo "</body></html>";
