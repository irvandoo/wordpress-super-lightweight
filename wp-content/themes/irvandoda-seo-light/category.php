<?php
/**
 * Category Archive Template
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="container">
    
    <!-- Category Header -->
    <section class="hero" style="padding: 48px 0 32px;">
        <?php $category = get_queried_object(); ?>
        <span class="hero-badge"><?php echo esc_html($category->name); ?></span>
        <h1 style="font-size: 36px; margin-bottom: 16px;">
            <?php single_cat_title(); ?>
        </h1>
        <?php if ($category->description) : ?>
            <p style="font-size: 18px; color: var(--ida-muted); max-width: 600px; margin: 0 auto;">
                <?php echo esc_html($category->description); ?>
            </p>
        <?php endif; ?>
    </section>

    <?php if (have_posts()) : ?>
        
        <!-- Posts Grid -->
        <section class="section">
            <div class="grid">
                <?php 
                $post_count = 0;
                while (have_posts()) : the_post(); 
                    $post_count++;
                    $is_featured = ($post_count === 1);
                    $reading_time = ida_get_reading_time();
                ?>
                    
                    <article class="card <?php echo $is_featured ? 'featured' : ''; ?>">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(null, $is_featured ? 'large' : 'medium'); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="card-img">
                        <?php else : ?>
                            <img src="https://placehold.co/<?php echo $is_featured ? '800x400' : '600x400'; ?>/eff6ff/2563eb?text=<?php echo urlencode(get_the_title()); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="card-img">
                        <?php endif; ?>

                        <div class="card-content-wrap">
                            
                            <div class="card-category">
                                <?php echo $is_featured ? 'Featured' : esc_html($category->name); ?>
                            </div>

                            <h3>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <p><?php echo wp_trim_words(get_the_excerpt(), $is_featured ? 30 : 20); ?></p>

                            <a href="<?php the_permalink(); ?>" class="card-cta">
                                Lihat selengkapnya →
                            </a>

                            <div class="card-meta">
                                <?php if ($is_featured) : ?>
                                    <span>⏱️ <?php echo $reading_time; ?> Min Read</span>
                                    <span>•</span>
                                    <span>Update: <?php echo get_the_date('j M Y'); ?></span>
                                <?php else : ?>
                                    <span>🗓️ <?php echo get_the_date('j M Y'); ?></span>
                                <?php endif; ?>
                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php
            the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
            ]);
            ?>
        </section>

    <?php else : ?>
        
        <!-- No Posts Found -->
        <section class="section">
            <div style="text-align: center; padding: 60px 20px;">
                <h2 style="margin-bottom: 16px;">No Posts Found</h2>
                <p style="color: var(--ida-muted); margin-bottom: 24px;">
                    There are no posts in this category yet.
                </p>
                <a href="<?php echo home_url('/'); ?>" class="btn">
                    Back to Homepage
                </a>
            </div>
        </section>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
