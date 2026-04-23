<?php
/**
 * Main Template - Homepage with Category Sections
 * IDA Design System v2.0 - SEO Engine Edition
 * Based on Professional Mockup Design
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="container">
    
    <!-- HERO BLOCK: High Conversion & Fast Perception -->
    <section class="hero">
        <span class="hero-badge">IDA Design System v2.0</span>
        <h1><?php echo get_theme_mod('ida_hero_title', 'Theme WordPress Teringan yang Mendesain Ulang Algoritma SEO Anda.'); ?></h1>
        <p><?php echo get_theme_mod('ida_hero_description', 'Dibangun dengan filosofi Content-First dan Zero Distraction. Tingkatkan Dwell Time, CTR, dan dominasi SERP Google tanpa perlu plugin optimasi yang berat.'); ?></p>
        <a href="<?php echo get_theme_mod('ida_hero_cta_link', '#'); ?>" class="btn">
            <?php echo get_theme_mod('ida_hero_cta_text', 'Mulai Optimasi Sekarang'); ?>
        </a>
        <div class="trust-signal">
            <span class="stars">★★★★★</span>
            <span><?php echo get_theme_mod('ida_trust_text', 'Dipercaya oleh 5.000+ SEO Specialist'); ?></span>
        </div>
    </section>

    <?php
    // Get all categories
    $categories = get_categories([
        'orderby' => 'count',
        'order' => 'DESC',
        'number' => 6, // Show top 6 categories
        'hide_empty' => true
    ]);

    if (!empty($categories)) :
        $section_count = 0;
        foreach ($categories as $category) :
            $section_count++;
            
            // Query posts for this category
            $category_posts = new WP_Query([
                'cat' => $category->term_id,
                'posts_per_page' => 4, // 1 featured + 3 regular cards
                'post_status' => 'publish'
            ]);

            if ($category_posts->have_posts()) :
    ?>
            
            <!-- SECTION: Category -->
            <section id="<?php echo esc_attr($category->slug); ?>" class="section">
                
                <!-- Section Header -->
                <div class="section-header">
                    <h2><?php echo esc_html($category->name); ?></h2>
                    <a href="<?php echo get_category_link($category->term_id); ?>">
                        Lihat Semua <?php echo esc_html($category->name); ?> →
                    </a>
                </div>

                <!-- The Grid -->
                <div class="grid">
                    <?php 
                    $post_count = 0;
                    while ($category_posts->have_posts()) : $category_posts->the_post(); 
                        $post_count++;
                        $is_featured = ($post_count === 1); // First post is featured
                        $reading_time = ida_get_reading_time();
                    ?>
                        
                        <!-- Card -->
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
                                    <?php echo $is_featured ? 'Pilar Content' : esc_html($category->name); ?>
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

            </section>

            <?php
            // Add CTA Section after 2nd category
            if ($section_count === 2) :
            ?>
                <!-- CTA SECTION (VISUAL BREAK & CONVERSION) -->
                <section class="cta-section">
                    <h2><?php echo get_theme_mod('ida_cta_title', 'Siap Mendominasi Halaman Pertama?'); ?></h2>
                    <p><?php echo get_theme_mod('ida_cta_description', 'Dapatkan arsitektur theme ini secara utuh dan terapkan di website WordPress Anda dalam waktu kurang dari 5 menit.'); ?></p>
                    <a href="<?php echo get_theme_mod('ida_cta_link', '#'); ?>" class="btn" style="background: white; color: var(--ida-text) !important;">
                        <?php echo get_theme_mod('ida_cta_button_text', 'Download Versi PRO'); ?>
                    </a>
                </section>
            <?php endif; ?>

    <?php
            endif;
            wp_reset_postdata();
        endforeach;
    else :
    ?>
        
        <!-- No Categories Found -->
        <section class="section">
            <div style="text-align: center; padding: 60px 20px;">
                <h2 style="margin-bottom: 16px;">Belum Ada Konten</h2>
                <p style="color: var(--ida-muted); margin-bottom: 24px;">
                    Silakan jalankan seeder untuk generate demo content.
                </p>
                <a href="<?php echo home_url('/ida-seeder.php'); ?>" class="btn">
                    Generate Demo Content
                </a>
            </div>
        </section>

    <?php endif; ?>

</main>

<?php get_footer(); ?>