<?php
declare(strict_types=1);

/**
 * Template part for displaying posts
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ida-post'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="ida-post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('ida-featured', ['loading' => 'lazy']); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="ida-post-content">
        <header class="ida-post-header">
            <h2 class="ida-post-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            
            <div class="ida-post-meta">
                <time class="ida-meta-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
                <span class="ida-meta-separator">•</span>
                <span class="ida-meta-reading-time">
                    <?php echo esc_html(ida_reading_time()); ?> min read
                </span>
            </div>
        </header>
        
        <div class="ida-post-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <footer class="ida-post-footer">
            <a href="<?php the_permalink(); ?>" class="ida-read-more">
                <?php esc_html_e('Read More', 'irvandoda-seo-light'); ?> &rarr;
            </a>
        </footer>
    </div>
    
</article>
