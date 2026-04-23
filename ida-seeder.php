<?php
/**
 * IDA Theme Seeder - Generate Demo Content
 * 
 * CARA PAKAI:
 * 1. Akses: http://localhost/active/wordpress%20super%20lightweight/ida-seeder.php
 * 2. Klik tombol "Generate Content"
 * 3. Tunggu sampai selesai
 * 4. Refresh homepage untuk lihat hasilnya
 * 
 * @package Irvandoda_SEO_Light
 */

// Load WordPress
require_once 'wp-load.php';

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

// Process seeding
$seeded = false;
$message = '';

if (isset($_POST['seed_content'])) {
    $seeded = ida_seed_content();
    $message = $seeded ? 'Content generated successfully!' : 'Error generating content.';
}

/**
 * Generate demo content
 */
function ida_seed_content() {
    global $wpdb;
    
    // Get admin user
    $admin_user = get_users(['role' => 'administrator', 'number' => 1]);
    $author_id = !empty($admin_user) ? $admin_user[0]->ID : 1;
    
    // Categories to create
    $categories = [
        'Technology' => 'Latest tech news, gadgets, and innovations',
        'Business' => 'Business insights, entrepreneurship, and finance',
        'Lifestyle' => 'Health, wellness, and lifestyle tips',
        'Travel' => 'Travel guides, destinations, and adventures',
        'Food' => 'Recipes, restaurants, and culinary experiences',
        'Sports' => 'Sports news, updates, and analysis'
    ];
    
    // Create categories
    $category_ids = [];
    foreach ($categories as $cat_name => $cat_desc) {
        $cat_id = wp_create_category($cat_name);
        if ($cat_id) {
            wp_update_term($cat_id, 'category', ['description' => $cat_desc]);
            $category_ids[$cat_name] = $cat_id;
        }
    }
    
    // Sample post titles and content
    $posts_data = [
        'Technology' => [
            [
                'title' => 'The Future of Artificial Intelligence in 2026',
                'content' => '<p>Artificial Intelligence continues to revolutionize every aspect of our lives. From healthcare to transportation, AI is making significant strides in improving efficiency and creating new possibilities.</p>

<h2>Machine Learning Advances</h2>
<p>Machine learning algorithms have become more sophisticated, enabling computers to learn from data and make predictions with unprecedented accuracy. This technology is being applied in various fields including medical diagnosis, financial forecasting, and autonomous vehicles.</p>

<h2>Natural Language Processing</h2>
<p>Natural Language Processing (NLP) has made tremendous progress, allowing machines to understand and generate human language more naturally. This has led to improved virtual assistants, translation services, and content generation tools.</p>

<h3>Key Developments</h3>
<p>Recent developments in AI include improved neural networks, better training methods, and more efficient algorithms. These advances are making AI more accessible and practical for everyday applications.</p>

<p>The future of AI looks promising, with potential applications in climate change mitigation, personalized education, and advanced robotics. As we move forward, ethical considerations and responsible AI development will be crucial.</p>'
            ],
            [
                'title' => '5G Technology: Transforming Mobile Connectivity',
                'content' => '<p>5G technology is revolutionizing how we connect and communicate. With faster speeds and lower latency, 5G is enabling new applications and services that were previously impossible.</p>

<h2>Speed and Performance</h2>
<p>5G networks offer speeds up to 100 times faster than 4G, enabling seamless streaming, instant downloads, and real-time communication. This performance boost is transforming mobile experiences.</p>

<h2>IoT and Smart Cities</h2>
<p>The Internet of Things (IoT) is being supercharged by 5G connectivity. Smart cities are becoming a reality with connected infrastructure, intelligent traffic management, and efficient resource utilization.</p>

<p>As 5G deployment continues globally, we can expect to see innovative applications in healthcare, education, and entertainment that leverage this powerful technology.</p>'
            ],
            [
                'title' => 'Cybersecurity Best Practices for 2026',
                'content' => '<p>In an increasingly digital world, cybersecurity has never been more important. Protecting your data and privacy requires awareness and proactive measures.</p>

<h2>Password Management</h2>
<p>Strong, unique passwords are your first line of defense. Use a password manager to generate and store complex passwords securely. Enable two-factor authentication wherever possible.</p>

<h2>Software Updates</h2>
<p>Keep all your software and devices updated with the latest security patches. Outdated software is a common entry point for cyber attacks.</p>

<h3>Common Threats</h3>
<p>Be aware of phishing attempts, ransomware, and social engineering attacks. Always verify the source before clicking links or downloading attachments.</p>

<p>Regular backups, secure networks, and employee training are essential components of a comprehensive cybersecurity strategy.</p>'
            ]
        ],
        'Business' => [
            [
                'title' => 'Entrepreneurship in the Digital Age',
                'content' => '<p>Starting a business in 2026 offers unprecedented opportunities thanks to digital tools and global connectivity. The barriers to entry have never been lower.</p>

<h2>Digital Marketing</h2>
<p>Social media, content marketing, and SEO are essential tools for modern entrepreneurs. Building an online presence is crucial for reaching customers and growing your business.</p>

<h2>E-commerce Platforms</h2>
<p>Platforms like Shopify, WooCommerce, and Amazon make it easy to start selling online. These tools handle payment processing, inventory management, and shipping logistics.</p>

<p>Success in digital entrepreneurship requires adaptability, continuous learning, and a customer-centric approach. Focus on solving real problems and delivering value.</p>'
            ],
            [
                'title' => 'Remote Work: The New Normal',
                'content' => '<p>Remote work has transformed from a perk to a standard practice. Companies worldwide are embracing flexible work arrangements and reaping the benefits.</p>

<h2>Productivity Tools</h2>
<p>Tools like Slack, Zoom, and Asana enable seamless collaboration across distributed teams. Cloud storage and project management software keep everyone connected and organized.</p>

<h2>Work-Life Balance</h2>
<p>Remote work offers better work-life balance, reduced commute time, and increased flexibility. However, it also requires discipline and clear boundaries.</p>

<p>The future of work is hybrid, combining the best of remote and office environments to maximize productivity and employee satisfaction.</p>'
            ]
        ],
        'Lifestyle' => [
            [
                'title' => '10 Habits for a Healthier Lifestyle',
                'content' => '<p>Building healthy habits is the foundation of long-term wellness. Small, consistent changes can lead to significant improvements in your quality of life.</p>

<h2>Regular Exercise</h2>
<p>Aim for at least 30 minutes of moderate exercise daily. This can include walking, jogging, swimming, or any activity you enjoy. Consistency is more important than intensity.</p>

<h2>Balanced Nutrition</h2>
<p>Focus on whole foods, plenty of vegetables, lean proteins, and healthy fats. Stay hydrated and limit processed foods and added sugars.</p>

<h3>Quality Sleep</h3>
<p>Prioritize 7-9 hours of quality sleep each night. Establish a consistent sleep schedule and create a relaxing bedtime routine.</p>

<p>Mental health is equally important. Practice stress management, maintain social connections, and seek help when needed.</p>'
            ],
            [
                'title' => 'Mindfulness and Meditation Guide',
                'content' => '<p>Mindfulness and meditation are powerful practices for reducing stress, improving focus, and enhancing overall well-being.</p>

<h2>Getting Started</h2>
<p>Begin with just 5 minutes a day. Find a quiet space, sit comfortably, and focus on your breath. When your mind wanders, gently bring your attention back.</p>

<h2>Benefits</h2>
<p>Regular meditation can reduce anxiety, improve emotional regulation, and enhance cognitive function. Many practitioners report better sleep and increased life satisfaction.</p>

<p>There are many meditation styles to explore, from guided meditations to body scans. Find what works best for you and make it a daily practice.</p>'
            ]
        ],
        'Travel' => [
            [
                'title' => 'Top 10 Travel Destinations for 2026',
                'content' => '<p>Discover the most exciting travel destinations for 2026. From pristine beaches to historic cities, these locations offer unforgettable experiences.</p>

<h2>Bali, Indonesia</h2>
<p>Known for its stunning beaches, rice terraces, and rich culture, Bali remains a top destination for travelers seeking both relaxation and adventure.</p>

<h2>Iceland</h2>
<p>Experience the Northern Lights, geothermal hot springs, and dramatic landscapes. Iceland offers unique natural wonders found nowhere else on Earth.</p>

<h3>Japan</h3>
<p>From ancient temples to modern cities, Japan offers a perfect blend of tradition and innovation. Experience world-class cuisine, beautiful gardens, and warm hospitality.</p>

<p>Each destination offers unique experiences and memories that will last a lifetime. Plan ahead and embrace the adventure!</p>'
            ]
        ],
        'Food' => [
            [
                'title' => 'Easy Healthy Recipes for Busy People',
                'content' => '<p>Eating healthy doesn\'t have to be complicated or time-consuming. These simple recipes are perfect for busy lifestyles.</p>

<h2>Meal Prep Basics</h2>
<p>Spend a few hours on Sunday preparing ingredients for the week. Cook grains, chop vegetables, and prepare proteins in advance.</p>

<h2>Quick Breakfast Ideas</h2>
<p>Overnight oats, smoothie bowls, and egg muffins can be prepared ahead and grabbed on busy mornings. These options are nutritious and satisfying.</p>

<p>With a little planning, you can enjoy delicious, healthy meals every day without spending hours in the kitchen.</p>'
            ]
        ],
        'Sports' => [
            [
                'title' => 'The Evolution of Sports Technology',
                'content' => '<p>Technology is transforming how we play, watch, and analyze sports. From wearable devices to AI-powered analytics, innovation is everywhere.</p>

<h2>Wearable Technology</h2>
<p>Smartwatches and fitness trackers help athletes monitor performance, track progress, and optimize training. These devices provide valuable insights into health and fitness.</p>

<h2>Video Analysis</h2>
<p>Advanced video analysis tools help coaches and athletes identify areas for improvement. Slow-motion replay and motion tracking provide detailed performance feedback.</p>

<p>As technology continues to advance, we can expect even more innovations that enhance athletic performance and fan engagement.</p>'
            ]
        ]
    ];
    
    // Generate posts
    $post_count = 0;
    foreach ($posts_data as $cat_name => $posts) {
        if (!isset($category_ids[$cat_name])) continue;
        
        foreach ($posts as $post_data) {
            $post_id = wp_insert_post([
                'post_title' => $post_data['title'],
                'post_content' => $post_data['content'],
                'post_status' => 'publish',
                'post_author' => $author_id,
                'post_type' => 'post',
                'post_category' => [$category_ids[$cat_name]],
                'comment_status' => 'open',
                'ping_status' => 'open'
            ]);
            
            if ($post_id) {
                // Set featured image (placeholder)
                $post_count++;
                
                // Add some comments
                for ($i = 1; $i <= rand(2, 5); $i++) {
                    wp_insert_comment([
                        'comment_post_ID' => $post_id,
                        'comment_author' => 'Reader ' . $i,
                        'comment_author_email' => 'reader' . $i . '@example.com',
                        'comment_content' => 'Great article! Very informative and well-written.',
                        'comment_approved' => 1,
                        'comment_date' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'))
                    ]);
                }
            }
        }
    }
    
    // Create pages
    $pages = [
        'About Us' => '<h2>About Our Website</h2>
<p>Welcome to our website! We are dedicated to providing high-quality content across various topics including technology, business, lifestyle, travel, food, and sports.</p>

<h3>Our Mission</h3>
<p>Our mission is to inform, educate, and inspire our readers with well-researched articles and engaging content.</p>

<h3>Our Team</h3>
<p>We have a team of experienced writers and editors who are passionate about delivering valuable content to our audience.</p>',
        
        'Contact' => '<h2>Get in Touch</h2>
<p>We\'d love to hear from you! Whether you have questions, feedback, or collaboration opportunities, feel free to reach out.</p>

<h3>Contact Information</h3>
<p><strong>Email:</strong> contact@example.com<br>
<strong>Phone:</strong> +1 (555) 123-4567<br>
<strong>Address:</strong> 123 Main Street, City, State 12345</p>',
        
        'Privacy Policy' => '<h2>Privacy Policy</h2>
<p>Last updated: ' . date('F j, Y') . '</p>

<h3>Information We Collect</h3>
<p>We collect information that you provide directly to us, including when you create an account, subscribe to our newsletter, or contact us.</p>

<h3>How We Use Your Information</h3>
<p>We use the information we collect to provide, maintain, and improve our services, and to communicate with you.</p>

<h3>Data Security</h3>
<p>We take reasonable measures to protect your personal information from unauthorized access, use, or disclosure.</p>',
        
        'Terms of Service' => '<h2>Terms of Service</h2>
<p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h3>Use License</h3>
<p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only.</p>

<h3>Disclaimer</h3>
<p>The materials on our website are provided on an \'as is\' basis. We make no warranties, expressed or implied, and hereby disclaim all other warranties.</p>'
    ];
    
    foreach ($pages as $page_title => $page_content) {
        wp_insert_post([
            'post_title' => $page_title,
            'post_content' => $page_content,
            'post_status' => 'publish',
            'post_author' => $author_id,
            'post_type' => 'page',
            'comment_status' => 'closed',
            'ping_status' => 'closed'
        ]);
    }
    
    return true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDA Theme Seeder</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        
        h1 {
            color: #2563eb;
            margin-bottom: 10px;
            font-size: 32px;
        }
        
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        
        .info-box h3 {
            color: #1e40af;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-box ul {
            margin-left: 20px;
            color: #374151;
            line-height: 1.8;
        }
        
        .info-box ul li {
            margin-bottom: 8px;
        }
        
        .warning-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        
        .warning-box strong {
            color: #92400e;
        }
        
        .success-box {
            background: #d1fae5;
            border-left: 4px solid #059669;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            color: #065f46;
        }
        
        .success-box strong {
            font-size: 18px;
        }
        
        form {
            text-align: center;
        }
        
        .btn {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 16px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-secondary {
            background: #6b7280;
            margin-left: 10px;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #2563eb;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎨 IDA Theme Seeder</h1>
        <p class="subtitle">Generate demo content for theme preview</p>
        
        <?php if ($seeded) : ?>
            <div class="success-box">
                <strong>✅ Success!</strong><br>
                Demo content has been generated successfully!
                <div class="stats">
                    <div class="stat-card">
                        <span class="stat-number">6</span>
                        <span class="stat-label">Categories</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Posts</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">4</span>
                        <span class="stat-label">Pages</span>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="<?php echo home_url('/'); ?>" class="btn">View Homepage</a>
                <a href="<?php echo admin_url(); ?>" class="btn btn-secondary">Go to Admin</a>
            </div>
        <?php else : ?>
            <div class="info-box">
                <h3>📦 What will be created:</h3>
                <ul>
                    <li><strong>6 Categories:</strong> Technology, Business, Lifestyle, Travel, Food, Sports</li>
                    <li><strong>15+ Posts:</strong> Well-written articles with proper formatting</li>
                    <li><strong>4 Pages:</strong> About, Contact, Privacy Policy, Terms of Service</li>
                    <li><strong>Comments:</strong> Sample comments on posts</li>
                </ul>
            </div>
            
            <div class="warning-box">
                <strong>⚠️ Warning:</strong> This will create new content in your WordPress installation. Make sure you're running this on a development/test site.
            </div>
            
            <form method="post">
                <button type="submit" name="seed_content" class="btn">
                    🚀 Generate Demo Content
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>