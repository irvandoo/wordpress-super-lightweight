<?php
/**
 * Social Media Meta Tags
 * Open Graph & Twitter Cards
 * 
 * @package Irvandoda_SEO_Light
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Open Graph and Twitter Card meta tags
 */
function ida_social_meta_tags(): void
{
    // Get current page info
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $site_url = home_url('/');
    
    // Default values
    $og_type = 'website';
    $og_title = $site_name;
    $og_description = $site_description;
    $og_url = $site_url;
    $og_image = get_site_icon_url(512);
    
    // Single post/page
    if (is_singular()) {
        global $post;
        
        $og_type = 'article';
        $og_title = get_the_title();
        $og_description = wp_trim_words(get_the_excerpt(), 30);
        $og_url = get_permalink();
        
        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url(null, 'large');
        }
        
        // Article specific tags
        $published_time = get_the_date('c');
        $modified_time = get_the_modified_date('c');
        $author = get_the_author();
        $categories = get_the_category();
        $tags = get_the_tags();
    }
    
    // Category/Archive
    if (is_category() || is_tag() || is_archive()) {
        $og_title = get_the_archive_title();
        $og_description = get_the_archive_description();
        $og_url = get_category_link(get_queried_object_id());
    }
    
    // Search
    if (is_search()) {
        $og_title = 'Hasil Pencarian: ' . get_search_query();
        $og_description = 'Hasil pencarian untuk "' . get_search_query() . '" di ' . $site_name;
        $og_url = get_search_link();
    }
    
    ?>
    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="<?php echo esc_attr($og_type); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($og_description); ?>">
    <meta property="og:url" content="<?php echo esc_url($og_url); ?>">
    <?php if ($og_image) : ?>
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>
    <meta property="og:locale" content="id_ID">
    
    <?php if (is_singular() && isset($published_time)) : ?>
    <!-- Article Specific Tags -->
    <meta property="article:published_time" content="<?php echo esc_attr($published_time); ?>">
    <meta property="article:modified_time" content="<?php echo esc_attr($modified_time); ?>">
    <meta property="article:author" content="<?php echo esc_attr($author); ?>">
    
    <?php if (!empty($categories)) : ?>
        <?php foreach ($categories as $category) : ?>
    <meta property="article:section" content="<?php echo esc_attr($category->name); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (!empty($tags)) : ?>
        <?php foreach ($tags as $tag) : ?>
    <meta property="article:tag" content="<?php echo esc_attr($tag->name); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <?php endif; ?>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($og_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($og_description); ?>">
    <?php if ($og_image) : ?>
    <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    <?php endif; ?>
    <meta name="twitter:site" content="@<?php echo esc_attr(get_bloginfo('name')); ?>">
    
    <!-- Additional Meta Tags -->
    <meta name="description" content="<?php echo esc_attr($og_description); ?>">
    <link rel="canonical" href="<?php echo esc_url($og_url); ?>">
    
    <?php
}
add_action('wp_head', 'ida_social_meta_tags', 5);

/**
 * Add social sharing buttons
 */
function ida_social_sharing_buttons(): string
{
    if (!is_singular()) {
        return '';
    }
    
    $post_title = urlencode(get_the_title());
    $post_url = urlencode(get_permalink());
    $post_excerpt = urlencode(wp_trim_words(get_the_excerpt(), 20));
    
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    $twitter_url = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url;
    $whatsapp_url = 'https://wa.me/?text=' . $post_title . '%20' . $post_url;
    $telegram_url = 'https://t.me/share/url?url=' . $post_url . '&text=' . $post_title;
    
    ob_start();
    ?>
    <div class="ida-social-share" style="display: flex; gap: 12px; align-items: center; margin: var(--sp-5) 0; padding: var(--sp-4); background: var(--ida-bg-soft); border-radius: 12px; border: 1px solid var(--ida-border);">
        <span style="font-weight: 600; color: var(--ida-text); font-size: 14px;">Bagikan:</span>
        <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener" class="ida-share-btn" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1877f2; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s;" title="Share on Facebook">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <a href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="noopener" class="ida-share-btn" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1da1f2; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s;" title="Share on Twitter">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
        </a>
        <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener" class="ida-share-btn" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #0077b5; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s;" title="Share on LinkedIn">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener" class="ida-share-btn" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #25d366; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s;" title="Share on WhatsApp">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        </a>
        <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener" class="ida-share-btn" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #0088cc; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s;" title="Share on Telegram">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
        </a>
    </div>
    
    <style>
    .ida-share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    </style>
    <?php
    return ob_get_clean();
}
