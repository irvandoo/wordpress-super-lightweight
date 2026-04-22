<?php
declare(strict_types=1);

/**
 * 404 Error Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="ida-main" class="ida-main" role="main">
    <div class="ida-container">
        
        <?php ida_breadcrumb(); ?>
        
        <div class="ida-404">
            <h1 class="ida-404-title"><?php esc_html_e('404 - Page Not Found', 'irvandoda-seo-light'); ?></h1>
            <p class="ida-404-text"><?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'irvandoda-seo-light'); ?></p>
            
            <div class="ida-404-search">
                <h2><?php esc_html_e('Try searching:', 'irvandoda-seo-light'); ?></h2>
                <?php get_search_form(); ?>
            </div>
            
            <div class="ida-404-home">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="ida-button"><?php esc_html_e('Back to Home', 'irvandoda-seo-light'); ?></a>
            </div>
        </div>
        
    </div>
</main>

<?php get_footer(); ?>
