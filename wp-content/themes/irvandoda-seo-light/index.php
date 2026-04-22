<?php
/**
 * Main Template - Homepage with Category Sections
 * IDA Design System v2.0 - SEO Engine Edition
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="ida-main-content">
    <div class="ida-container">

        <?php
        // Get all categories
        $categories = get_categories([
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 6, // Show top 6 categories
            'hide_empty' => true
        ]);

        if (!empty($categories)) :
            foreach ($categories as $category) :
                // Query posts for this category
                $category_posts = new WP_Query([
                    'cat' => $category->term_id,
                    'posts_per_page' => 6,
                    'post_status' => 'publish'
                ]);

                if ($category_posts->have_posts()) :
        ?>
                
                <!-- Category Section -->
                <section class="ida-category-section">
                    
                    <!-- Section Header -->
                    <div class="ida-section-header">
                        <h2 class="ida-section-title">
                            <a href="<?php echo get_category_link($category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </h2>
                        <a href="<?php echo get_category_link($category->term_id); ?>" class="ida-view-all">
                            View All →
                        </a>
                    </div>

                    <!-- Articles Grid -->
                    <div class="ida-articles-grid">
                        <?php 
                        $post_count = 0;
                        while ($category_posts->have_posts()) : $category_posts->the_post(); 
                            $post_count++;
                            $is_featured = ($post_count === 1); // First post is featured
                        ?>
                            
                            <article class="ida-article-card <?php echo $is_featured ? 'ida-featured' : ''; ?>">
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="ida-article-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php 
                                            if ($is_featured) {
                                                the_post_thumbnail('large');
                                            } else {
                                                the_post_thumbnail('medium');
                                            }
                                            ?>
                                        </a>
                                        <span class="ida-article-category">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="ida-article-content">
                                    
                                    <h3 class="ida-article-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <?php if ($is_featured) : ?>
                                        <div class="ida-article-excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="ida-article-meta">
                                        <span class="ida-meta-date">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor">
                                                <path d="M7 0a7 7 0 100 14A7 7 0 007 0zm0 13A6 6 0 117 1a6 6 0 010 12zm.5-10h-1v4.5l3.5 2.1.5-.8-3-1.8V3z"/>
                                            </svg>
                                            <?php echo get_the_date('M j, Y'); ?>
                                        </span>
                                        <span class="ida-meta-reading">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor">
                                                <path d="M7 0C3.1 0 0 3.1 0 7s3.1 7 7 7 7-3.1 7-7-3.1-7-7-7zm0 12.5c-3 0-5.5-2.5-5.5-5.5S4 1.5 7 1.5s5.5 2.5 5.5 5.5-2.5 5.5-5.5 5.5z"/>
                                            </svg>
                                            <?php echo ida_get_reading_time(); ?> min
                                        </span>
                                    </div>

                                </div>

                            </article>

                        <?php endwhile; ?>
                    </div>

                    <!-- Ad Slot (Between Sections) -->
                    <?php if ($category === reset($categories)) : // After first category ?>
                        <div class="ida-ad-slot ida-ad-inline">
                            <?php if (is_active_sidebar('content-ad-1')) : ?>
                                <?php dynamic_sidebar('content-ad-1'); ?>
                            <?php else : ?>
                                <div class="ida-ad-placeholder">
                                    <span>Ad Slot 728x90</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </section>

        <?php
                endif;
                wp_reset_postdata();
            endforeach;
        else :
        ?>
            
            <!-- No Categories Found -->
            <section class="ida-no-content">
                <h2>No content available</h2>
                <p>Please add some posts to get started.</p>
            </section>

        <?php endif; ?>

        <!-- Newsletter CTA -->
        <section class="ida-newsletter-cta">
            <div class="ida-newsletter-inner">
                <h3 class="ida-newsletter-title">Stay Updated</h3>
                <p class="ida-newsletter-text">Get the latest articles delivered to your inbox.</p>
                <form class="ida-newsletter-form" action="#" method="post">
                    <input type="email" placeholder="Enter your email" class="ida-newsletter-input" required>
                    <button type="submit" class="ida-btn ida-btn-primary">Subscribe</button>
                </form>
                <p class="ida-newsletter-note">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    No spam, unsubscribe anytime
                </p>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>