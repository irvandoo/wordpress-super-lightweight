<?php
declare(strict_types=1);

/**
 * Archive Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="ida-main" class="ida-main" role="main">
    <div class="ida-container">
        
        <?php ida_breadcrumb(); ?>
        
        <header class="ida-archive-header">
            <?php the_archive_title('<h1 class="ida-archive-title">', '</h1>'); ?>
            <?php the_archive_description('<div class="ida-archive-description">', '</div>'); ?>
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
                <h1><?php esc_html_e('Nothing Found', 'irvandoda-seo-light'); ?></h1>
                <p><?php esc_html_e('No posts found in this archive.', 'irvandoda-seo-light'); ?></p>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
