<?php

declare(strict_types=1);

/**
 * Irvandoda Full SEO Lightweight Theme Functions
 * IDA Design System Implementation
 * Built for Speed, Structured for Ranking
 * 
 * @package Irvandoda_SEO_Light
 * @author Irvando Demas Arifiandani
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Require PHP 8.5+
if (version_compare(PHP_VERSION, '8.5.0', '<')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>';
        echo esc_html__('Irvandoda SEO Light theme requires PHP 8.5 or higher. Please upgrade your PHP version.', 'irvandoda-seo-light');
        echo '</p></div>';
    });
    return;
}

// Theme constants
define('IDA_VERSION', '1.0.0');
define('IDA_THEME_DIR', get_template_directory());
define('IDA_THEME_URI', get_template_directory_uri());
define('IDA_MIN_PHP', '8.5.0');

// Load core files (comment out missing files temporarily)
// require_once IDA_THEME_DIR . '/inc/setup.php';
// require_once IDA_THEME_DIR . '/inc/enqueue.php';
// require_once IDA_THEME_DIR . '/inc/performance.php';
// require_once IDA_THEME_DIR . '/inc/seo.php';
// require_once IDA_THEME_DIR . '/inc/schema.php';
// require_once IDA_THEME_DIR . '/inc/toc.php';
// require_once IDA_THEME_DIR . '/inc/breadcrumb.php';
// require_once IDA_THEME_DIR . '/inc/helpers.php';
require_once IDA_THEME_DIR . '/inc/admin.php';
require_once IDA_THEME_DIR . '/inc/branding.php';
require_once IDA_THEME_DIR . '/inc/admin-style.php';

/**
 * ========================================
 * IDA DESIGN SYSTEM CORE FUNCTIONS
 * ========================================
 */

/**
 * Enqueue IDA Design System Styles
 */
function ida_enqueue_design_system(): void
{
    // Main IDA Design System CSS - FORCE LOAD
    wp_enqueue_style(
        'ida-design-system',
        get_template_directory_uri() . '/assets/css/ida-design-system.css',
        [],
        filemtime(get_template_directory() . '/assets/css/ida-design-system.css') // Cache busting
    );
}
add_action('wp_enqueue_scripts', 'ida_enqueue_design_system', 1);

/**
 * Generate Table of Contents from content
 */
function ida_generate_toc(string $content): string
{
    if (empty($content)) {
        return '';
    }
    
    // Extract headings (H2 and H3 only for clean TOC)
    preg_match_all('/<h([2-3])[^>]*>(.*?)<\/h[2-3]>/i', $content, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
        return '';
    }
    
    $toc = '';
    $current_level = 0;
    
    foreach ($matches as $match) {
        $level = (int) $match[1];
        $title = strip_tags($match[2]);
        $anchor = sanitize_title($title);
        
        // Add anchor to original content
        $content = str_replace(
            $match[0],
            '<h' . $level . ' id="' . $anchor . '">' . $match[2] . '</h' . $level . '>',
            $content
        );
        
        if ($level > $current_level) {
            $toc .= '<ol>';
        } elseif ($level < $current_level) {
            $toc .= '</ol>';
        }
        
        $toc .= '<li><a href="#' . $anchor . '">' . esc_html($title) . '</a></li>';
        $current_level = $level;
    }
    
    // Close remaining lists
    while ($current_level > 0) {
        $toc .= '</ol>';
        $current_level--;
    }
    
    return $toc;
}

/**
 * Get reading time estimate
 */
function ida_get_reading_time(?int $post_id = null): int
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    
    // Average reading speed: 200 words per minute
    $reading_time = ceil($word_count / 200);
    
    return max(1, $reading_time); // Minimum 1 minute
}

/**
 * Generate breadcrumb navigation
 */
function ida_breadcrumb(): void
{
    if (is_front_page()) {
        return;
    }
    
    $breadcrumb = '<a href="' . home_url('/') . '">Home</a>';
    $breadcrumb .= '<span class="ida-breadcrumb-separator">›</span>';
    
    if (is_category()) {
        $breadcrumb .= '<span>' . single_cat_title('', false) . '</span>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            $breadcrumb .= '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
            $breadcrumb .= '<span class="ida-breadcrumb-separator">›</span>';
        }
        $breadcrumb .= '<span>' . get_the_title() . '</span>';
    } elseif (is_page()) {
        $breadcrumb .= '<span>' . get_the_title() . '</span>';
    } elseif (is_search()) {
        $breadcrumb .= '<span>Search Results for "' . get_search_query() . '"</span>';
    } elseif (is_404()) {
        $breadcrumb .= '<span>Page Not Found</span>';
    }
    
    echo '<div class="ida-breadcrumb">' . $breadcrumb . '</div>';
}

/**
 * Add inline engagement blocks to content
 */
function ida_add_inline_engagement(string $content): string
{
    // Split content by paragraphs
    $paragraphs = explode('</p>', $content);
    $paragraph_count = count($paragraphs);
    
    // Add engagement blocks every 3-4 paragraphs
    $engagement_positions = [
        floor($paragraph_count * 0.25), // 25% through
        floor($paragraph_count * 0.5),  // 50% through
        floor($paragraph_count * 0.75), // 75% through
    ];
    
    foreach ($engagement_positions as $position) {
        if (isset($paragraphs[$position])) {
            $engagement_block = '
            <div class="ida-inline-block ida-tip">
                <div class="ida-inline-block-title">💡 Pro Tip</div>
                <p>This article contains actionable insights. Keep reading to discover more valuable strategies!</p>
            </div>';
            
            $paragraphs[$position] .= $engagement_block;
        }
    }
    
    return implode('</p>', $paragraphs);
}

/**
 * Add internal link suggestions
 */
function ida_add_internal_links(string $content): string
{
    // Get related posts based on categories/tags
    $related_posts = ida_get_related_posts(get_the_ID(), 3);
    
    if (empty($related_posts)) {
        return $content;
    }
    
    // Add internal links after first paragraph
    $first_p_pos = strpos($content, '</p>');
    if ($first_p_pos !== false) {
        $internal_links = '<div class="ida-internal-links">';
        foreach ($related_posts as $post) {
            $internal_links .= '<a href="' . get_permalink($post) . '" class="ida-internal-link">';
            $internal_links .= '📖 ' . get_the_title($post) . '</a>';
        }
        $internal_links .= '</div>';
        
        $content = substr_replace($content, '</p>' . $internal_links, $first_p_pos, 4);
    }
    
    return $content;
}

/**
 * Apply TOC anchors to content headings
 */
function ida_apply_toc_anchors(string $content): string
{
    // Add IDs to headings for TOC navigation
    $content = preg_replace_callback(
        '/<h([2-3])[^>]*>(.*?)<\/h[2-3]>/i',
        function($matches) {
            $level = $matches[1];
            $title = strip_tags($matches[2]);
            $anchor = sanitize_title($title);
            
            return '<h' . $level . ' id="' . $anchor . '">' . $matches[2] . '</h' . $level . '>';
        },
        $content
    );
    
    return $content;
}
function ida_get_related_posts(int $post_id, int $limit = 4): array
{
    $categories = wp_get_post_categories($post_id);
    $tags = wp_get_post_tags($post_id);
    
    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'post__not_in' => [$post_id],
        'meta_query' => [
            [
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ]
        ]
    ];
    
    // Prioritize posts with same categories
    if (!empty($categories)) {
        $args['category__in'] = $categories;
    } elseif (!empty($tags)) {
        $tag_ids = array_map(function($tag) { return $tag->term_id; }, $tags);
        $args['tag__in'] = $tag_ids;
    }
    
    $query = new WP_Query($args);
    return $query->posts;
}

/**
 * ========================================
 * THEME SETUP & SUPPORT
 * ========================================
 */

/**
 * Theme setup
 */
function ida_theme_setup(): void
{
    // Add theme support
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Register navigation menus
    register_nav_menus([
        'top-menu' => esc_html__('Top Menu', 'irvandoda-seo-light'),
        'menu-1' => esc_html__('Primary Menu', 'irvandoda-seo-light'),
        'footer-menu' => esc_html__('Footer Menu', 'irvandoda-seo-light'),
    ]);
    
    // Add image sizes
    add_image_size('ida-featured', 780, 400, true);
    add_image_size('ida-thumbnail', 300, 200, true);
    add_image_size('ida-medium', 600, 400, true);
}
add_action('after_setup_theme', 'ida_theme_setup');

/**
 * Register widget areas
 */
function ida_widgets_init(): void
{
    // Header Ad Widget
    register_sidebar([
        'name'          => esc_html__('Header Ad', 'irvandoda-seo-light'),
        'id'            => 'header-ad',
        'description'   => esc_html__('728x90 Leaderboard ad in header', 'irvandoda-seo-light'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    // Content Ad 1
    register_sidebar([
        'name'          => esc_html__('Content Ad 1', 'irvandoda-seo-light'),
        'id'            => 'content-ad-1',
        'description'   => esc_html__('728x90 ad between content sections', 'irvandoda-seo-light'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    // Sidebar Widget
    register_sidebar([
        'name'          => esc_html__('Sidebar', 'irvandoda-seo-light'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'irvandoda-seo-light'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'ida_widgets_init');

/**
 * ========================================
 * PERFORMANCE OPTIMIZATIONS
 * ========================================
 */

/**
 * Optimize WordPress for performance
 */
function ida_performance_optimizations(): void
{
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove jQuery migrate
    add_action('wp_default_scripts', function($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, ['jquery-migrate']);
            }
        }
    });
}
add_action('init', 'ida_performance_optimizations');

/**
 * Defer JavaScript loading
 */
function ida_defer_scripts(string $tag, string $handle, string $src): string
{
    // Don't defer admin scripts or jQuery
    if (is_admin() || in_array($handle, ['jquery', 'jquery-core'])) {
        return $tag;
    }
    
    // Add defer attribute
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'ida_defer_scripts', 10, 3);

/**
 * ========================================
 * SEO OPTIMIZATIONS
 * ========================================
 */

/**
 * Add structured data (JSON-LD)
 */
function ida_add_structured_data(): void
{
    if (is_single()) {
        global $post;
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => wp_trim_words(get_the_excerpt(), 20),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author(),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url(),
                ],
            ],
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'mainEntityOfPage' => get_permalink(),
        ];
        
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'ida_add_structured_data');

/**
 * ========================================
 * CUSTOMIZER SETTINGS
 * ========================================
 */

/**
 * Add customizer settings
 */
function ida_customize_register(WP_Customize_Manager $wp_customize): void
{
    // IDA Design System Section
    $wp_customize->add_section('ida_design_system', [
        'title' => __('IDA Design System', 'irvandoda-seo-light'),
        'priority' => 30,
    ]);
    
    // Accent Color
    $wp_customize->add_setting('ida_accent_color', [
        'default' => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ida_accent_color', [
        'label' => __('Accent Color', 'irvandoda-seo-light'),
        'section' => 'ida_design_system',
    ]));
    
    // Hero Section
    $wp_customize->add_section('ida_hero_section', [
        'title' => __('Hero Section', 'irvandoda-seo-light'),
        'priority' => 31,
    ]);
    
    // Hero Title
    $wp_customize->add_setting('ida_hero_title', [
        'default' => 'Theme WordPress Teringan yang Mendesain Ulang Algoritma SEO Anda.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_hero_title', [
        'label' => __('Hero Title', 'irvandoda-seo-light'),
        'section' => 'ida_hero_section',
        'type' => 'text',
    ]);
    
    // Hero Description
    $wp_customize->add_setting('ida_hero_description', [
        'default' => 'Dibangun dengan filosofi Content-First dan Zero Distraction. Tingkatkan Dwell Time, CTR, dan dominasi SERP Google tanpa perlu plugin optimasi yang berat.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('ida_hero_description', [
        'label' => __('Hero Description', 'irvandoda-seo-light'),
        'section' => 'ida_hero_section',
        'type' => 'textarea',
    ]);
    
    // Hero CTA Text
    $wp_customize->add_setting('ida_hero_cta_text', [
        'default' => 'Mulai Optimasi Sekarang',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_hero_cta_text', [
        'label' => __('Hero CTA Button Text', 'irvandoda-seo-light'),
        'section' => 'ida_hero_section',
        'type' => 'text',
    ]);
    
    // Hero CTA Link
    $wp_customize->add_setting('ida_hero_cta_link', [
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('ida_hero_cta_link', [
        'label' => __('Hero CTA Button Link', 'irvandoda-seo-light'),
        'section' => 'ida_hero_section',
        'type' => 'url',
    ]);
    
    // Trust Signal Text
    $wp_customize->add_setting('ida_trust_text', [
        'default' => 'Dipercaya oleh 5.000+ SEO Specialist',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_trust_text', [
        'label' => __('Trust Signal Text', 'irvandoda-seo-light'),
        'section' => 'ida_hero_section',
        'type' => 'text',
    ]);
    
    // CTA Section
    $wp_customize->add_section('ida_cta_section', [
        'title' => __('CTA Section', 'irvandoda-seo-light'),
        'priority' => 32,
    ]);
    
    // CTA Title
    $wp_customize->add_setting('ida_cta_title', [
        'default' => 'Siap Mendominasi Halaman Pertama?',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_cta_title', [
        'label' => __('CTA Title', 'irvandoda-seo-light'),
        'section' => 'ida_cta_section',
        'type' => 'text',
    ]);
    
    // CTA Description
    $wp_customize->add_setting('ida_cta_description', [
        'default' => 'Dapatkan arsitektur theme ini secara utuh dan terapkan di website WordPress Anda dalam waktu kurang dari 5 menit.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('ida_cta_description', [
        'label' => __('CTA Description', 'irvandoda-seo-light'),
        'section' => 'ida_cta_section',
        'type' => 'textarea',
    ]);
    
    // CTA Button Text
    $wp_customize->add_setting('ida_cta_button_text', [
        'default' => 'Download Versi PRO',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_cta_button_text', [
        'label' => __('CTA Button Text', 'irvandoda-seo-light'),
        'section' => 'ida_cta_section',
        'type' => 'text',
    ]);
    
    // CTA Link
    $wp_customize->add_setting('ida_cta_link', [
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('ida_cta_link', [
        'label' => __('CTA Button Link', 'irvandoda-seo-light'),
        'section' => 'ida_cta_section',
        'type' => 'url',
    ]);
    
    // Top Header Text
    $wp_customize->add_setting('ida_top_header_text', [
        'default' => 'Update Algoritma Terkini: ' . date('F Y'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_top_header_text', [
        'label' => __('Top Header Text', 'irvandoda-seo-light'),
        'section' => 'ida_design_system',
        'type' => 'text',
    ]);
    
    // Footer Tagline
    $wp_customize->add_setting('ida_footer_tagline', [
        'default' => 'Zero Distraction, Full Conversion.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_footer_tagline', [
        'label' => __('Footer Tagline', 'irvandoda-seo-light'),
        'section' => 'ida_design_system',
        'type' => 'text',
    ]);
}
add_action('customize_register', 'ida_customize_register');

/**
 * Output custom CSS for customizer settings
 */
function ida_customizer_css(): void
{
    $accent_color = get_theme_mod('ida_accent_color', '#2563eb');
    
    if ($accent_color !== '#2563eb') {
        echo '<style type="text/css">';
        echo ':root { --ida-accent: ' . esc_attr($accent_color) . '; }';
        echo '</style>';
    }
}
add_action('wp_head', 'ida_customizer_css');

/**
 * ========================================
 * SECURITY ENHANCEMENTS
 * ========================================
 */

/**
 * Security headers
 */
function ida_security_headers(): void
{
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'ida_security_headers');

/**
 * Remove WordPress version from scripts and styles
 */
function ida_remove_version_strings(string $src): string
{
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY) ?? '', $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'ida_remove_version_strings');
add_filter('style_loader_src', 'ida_remove_version_strings');

/**
 * ========================================
 * FINAL THEME INITIALIZATION
 * ========================================
 */

/**
 * Theme activation hook
 */
function ida_theme_activation(): void
{
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default permalink structure
    if (!get_option('permalink_structure')) {
        update_option('permalink_structure', '/%postname%/');
    }
}
add_action('after_switch_theme', 'ida_theme_activation');

/**
 * Theme deactivation hook
 */
function ida_theme_deactivation(): void
{
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('switch_theme', 'ida_theme_deactivation');


/**
 * ========================================
 * CUSTOM COMMENT TEMPLATE
 * ========================================
 */

/**
 * Custom comment callback
 */
function ida_custom_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <div <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <?php echo get_avatar($comment, 48, '', '', ['class' => 'comment-avatar']); ?>
        <div class="comment-content">
            <div class="comment-meta">
                <strong><?php comment_author(); ?></strong>
                <span>• <?php comment_date('j F Y'); ?></span>
            </div>
            <?php comment_text(); ?>
            <?php
            comment_reply_link(array_merge($args, [
                'depth' => $depth,
                'max_depth' => $args['max_depth'],
                'reply_text' => 'Balas',
                'before' => '',
                'after' => '',
            ]));
            ?>
        </div>
    </div>
    <?php
}

/**
 * ========================================
 * SINGLE POST CUSTOMIZER SETTINGS
 * ========================================
 */

/**
 * Add single post customizer settings
 */
function ida_single_post_customizer(WP_Customize_Manager $wp_customize): void
{
    // Single Post Section
    $wp_customize->add_section('ida_single_post', [
        'title' => __('Single Post Settings', 'irvandoda-seo-light'),
        'priority' => 33,
    ]);
    
    // Rating Text
    $wp_customize->add_setting('ida_rating_text', [
        'default' => 'Artikel ini telah divalidasi berdasarkan Core Update ' . date('F Y'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_rating_text', [
        'label' => __('Rating Block Text', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'text',
    ]);
    
    // Highlight Text
    $wp_customize->add_setting('ida_highlight_text', [
        'default' => 'Implementasi strategi ini membutuhkan konsistensi. Hasil optimal biasanya terlihat dalam 2-3 bulan.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('ida_highlight_text', [
        'label' => __('Highlight Box Text', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'textarea',
    ]);
    
    // Post CTA Title
    $wp_customize->add_setting('ida_post_cta_title', [
        'default' => 'Implementasikan Sistem Ini Tanpa Coding',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_post_cta_title', [
        'label' => __('Post CTA Title', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'text',
    ]);
    
    // Post CTA Description
    $wp_customize->add_setting('ida_post_cta_description', [
        'default' => 'Tema Irvandoda didesain khusus secara otomatis menerapkan semua prinsip Dwell Time, Whitespace, dan Smart TOC.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('ida_post_cta_description', [
        'label' => __('Post CTA Description', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'textarea',
    ]);
    
    // Post CTA Button
    $wp_customize->add_setting('ida_post_cta_button', [
        'default' => 'Download Theme Irvandoda Sekarang',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('ida_post_cta_button', [
        'label' => __('Post CTA Button Text', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'text',
    ]);
    
    // Post CTA Link
    $wp_customize->add_setting('ida_post_cta_link', [
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('ida_post_cta_link', [
        'label' => __('Post CTA Button Link', 'irvandoda-seo-light'),
        'section' => 'ida_single_post',
        'type' => 'url',
    ]);
}
add_action('customize_register', 'ida_single_post_customizer');
