<?php
/**
 * Main Template File - Homepage
 * IDA Design System Implementation - Aesthetic Version
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="ida-container">
    <?php if (have_posts()) : ?>
        
        <!-- Hero Section (Homepage) -->
        <section class="ida-hero ida-hero-aesthetic">
            <div class="ida-hero-content">
                <h1 class="ida-hero-title ida-gradient-text">
                    <?php echo get_bloginfo('name'); ?>
                </h1>
                <div class="ida-hero-subtitle">
                    <?php echo get_bloginfo('description'); ?>
                </div>
                <div class="ida-hero-stats">
                    <div class="ida-stat">
                        <span class="ida-stat-number"><?php echo wp_count_posts()->publish; ?></span>
                        <span class="ida-stat-label">Articles</span>
                    </div>
                    <div class="ida-stat">
                        <span class="ida-stat-number"><?php echo get_user_count(); ?></span>
                        <span class="ida-stat-label">Authors</span>
                    </div>
                    <div class="ida-stat">
                        <span class="ida-stat-number"><?php echo wp_count_comments()->approved; ?></span>
                        <span class="ida-stat-label">Comments</span>
                    </div>
                </div>
            </div>
            <div class="ida-hero-decoration">
                <div class="ida-floating-element ida-float-1"></div>
                <div class="ida-floating-element ida-float-2"></div>
                <div class="ida-floating-element ida-float-3"></div>
            </div>
        </section>

        <!-- Featured Article Section -->
        <?php
        $featured_query = new WP_Query([
            'posts_per_page' => 1,
            'meta_key' => '_thumbnail_id',
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
        
        if ($featured_query->have_posts()) :
            while ($featured_query->have_posts()) : $featured_query->the_post();
        ?>
        <section class="ida-featured-section">
            <div class="ida-section-header">
                <h2 class="ida-section-title">Featured Article</h2>
                <div class="ida-section-line"></div>
            </div>
            
            <article class="ida-featured-card">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="ida-featured-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large', ['class' => 'ida-responsive-image']); ?>
                        </a>
                        <div class="ida-featured-overlay">
                            <div class="ida-featured-meta">
                                <span class="ida-featured-category">
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </span>
                                <span class="ida-featured-date"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="ida-featured-content">
                    <h3 class="ida-featured-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="ida-featured-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                    </div>
                    
                    <div class="ida-featured-footer">
                        <div class="ida-author-mini">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', ['class' => 'ida-author-avatar']); ?>
                            <span class="ida-author-name"><?php the_author(); ?></span>
                        </div>
                        <div class="ida-reading-time">
                            <span class="ida-time-icon">⏱</span>
                            <?php echo ida_get_reading_time(); ?> min read
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php 
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

        <!-- Latest Articles Grid -->
        <section class="ida-articles-section">
            <div class="ida-section-header">
                <h2 class="ida-section-title">Latest Articles</h2>
                <div class="ida-section-line"></div>
            </div>
            
            <div class="ida-grid ida-grid-aesthetic">
                <?php 
                // Skip the first post (featured)
                $post_count = 0;
                while (have_posts()) : the_post(); 
                    $post_count++;
                    if ($post_count == 1) continue; // Skip first post
                ?>
                    
                    <article class="ida-card ida-card-aesthetic ida-hover-lift">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="ida-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'ida-responsive-image']); ?>
                                </a>
                                <div class="ida-card-category">
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="ida-card-content">
                            <h3 class="ida-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="ida-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </div>
                            
                            <div class="ida-card-footer">
                                <div class="ida-card-meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>" class="ida-card-date">
                                        <?php echo get_the_date('M j'); ?>
                                    </time>
                                    <span class="ida-card-reading-time">
                                        <?php echo ida_get_reading_time(); ?>m
                                    </span>
                                </div>
                                <div class="ida-card-author">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', ['class' => 'ida-author-mini-avatar']); ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Newsletter CTA Section -->
        <section class="ida-newsletter-section">
            <div class="ida-newsletter-card">
                <div class="ida-newsletter-content">
                    <h3 class="ida-newsletter-title">Stay Updated</h3>
                    <p class="ida-newsletter-text">Get the latest articles and insights delivered to your inbox.</p>
                    <div class="ida-newsletter-form">
                        <input type="email" placeholder="Enter your email" class="ida-newsletter-input">
                        <button class="ida-btn ida-btn-primary ida-newsletter-btn">Subscribe</button>
                    </div>
                    <div class="ida-newsletter-note">
                        <span class="ida-check-icon">✓</span>
                        No spam, unsubscribe anytime
                    </div>
                </div>
                <div class="ida-newsletter-decoration">
                    <div class="ida-newsletter-circle ida-circle-1"></div>
                    <div class="ida-newsletter-circle ida-circle-2"></div>
                    <div class="ida-newsletter-circle ida-circle-3"></div>
                </div>
            </div>
        </section>

        <!-- Pagination -->
        <?php if (get_next_posts_link() || get_previous_posts_link()) : ?>
        <section class="ida-pagination-section">
            <div class="ida-pagination">
                <?php
                echo paginate_links([
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                    'type' => 'list',
                    'class' => 'ida-pagination-list'
                ]);
                ?>
            </div>
        </section>
        <?php endif; ?>

    <?php else : ?>
        
        <!-- No Posts Found -->
        <section class="ida-no-posts">
            <div class="ida-no-posts-content">
                <h2>No posts found</h2>
                <p>It looks like nothing was found at this location. Maybe try a search?</p>
                <?php get_search_form(); ?>
            </div>
        </section>
        
    <?php endif; ?>
</main>

<?php get_footer(); ?>