<?php
declare(strict_types=1);

/**
 * Search Results Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="ida-main" class="ida-main" role="main">
    <div class="ida-container">
        
        <?php ida_breadcrumb(); ?>
        
        <header class="ida-search-header">
            <h1 class="ida-search-title">
                <?php printf(esc_html__('Search Results for: %s', 'irvandoda-seo-light'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>
        </header>
        
        <?php if (have_posts()) : ?>
            
            <div class="ida-posts">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php
            the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => __('&larr; Previous', 'irvandoda-seo-light'),
                'next_text' => __('Next &rarr;', 'irvandoda-seo-light')
            ]);
            ?>
            
        <?php else : ?>
            
            <div class="ida-no-posts">
                <h2><?php esc_html_e('Nothing Found', 'irvandoda-seo-light'); ?></h2>
                <p><?php esc_html_e('Sorry, no results found. Try different keywords.', 'irvandoda-seo-light'); ?></p>
                <?php get_search_form(); ?>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
