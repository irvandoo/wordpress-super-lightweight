<?php
declare(strict_types=1);

/**
 * Related Posts Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

$related = ida_related_posts(get_the_ID(), 4);

if (!$related->have_posts()) {
    return;
}
?>

<section class="ida-related-posts">
    <h2 class="ida-related-title"><?php esc_html_e('Related Posts', 'irvandoda-seo-light'); ?></h2>
    
    <div class="ida-related-grid">
        <?php while ($related->have_posts()) : $related->the_post(); ?>
            
            <article class="ida-related-item">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="ida-related-thumbnail">
                        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('ida-related', ['loading' => 'lazy']); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="ida-related-content">
                    <h3 class="ida-related-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="ida-related-meta">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                    </div>
                </div>
            </article>
            
        <?php endwhile; ?>
    </div>
</section>

<?php wp_reset_postdata(); ?>
