<?php
/**
 * Search Results Template
 * IDA Design System - Professional Search Layout
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="site-content-404">
    <div class="container">
        <div class="error-wrapper" style="max-width: 880px;">
            
            <!-- Search Header -->
            <div style="text-align: center; margin-bottom: var(--sp-6);">
                <h1 class="error-title" style="font-size: 28px;">
                    <?php
                    /* translators: %s: search query */
                    printf(esc_html__('Hasil Pencarian: "%s"', 'irvandoda-seo-light'), '<span style="color: var(--ida-accent);">' . get_search_query() . '</span>');
                    ?>
                </h1>
                <p class="error-desc" style="margin-bottom: var(--sp-4);">
                    <?php
                    global $wp_query;
                    if ($wp_query->found_posts > 0) {
                        printf(
                            esc_html(_n('Ditemukan %s artikel', 'Ditemukan %s artikel', $wp_query->found_posts, 'irvandoda-seo-light')),
                            '<strong>' . number_format_i18n($wp_query->found_posts) . '</strong>'
                        );
                    } else {
                        esc_html_e('Tidak ada hasil yang ditemukan', 'irvandoda-seo-light');
                    }
                    ?>
                </p>
                
                <!-- Search Form -->
                <form class="search-404" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" 
                           name="s" 
                           placeholder="Coba kata kunci lain..." 
                           value="<?php echo get_search_query(); ?>" 
                           required>
                    <button type="submit" class="btn">Cari Lagi</button>
                </form>
            </div>

            <?php if (have_posts()) : ?>
                
                <!-- Search Results -->
                <div class="recovery-content" style="border-top: none; padding-top: 0;">
                    <div class="card-grid">
                        <?php while (have_posts()) : the_post(); 
                            $categories = get_the_category();
                            $category_name = !empty($categories) ? $categories[0]->name : 'Artikel';
                        ?>
                            <article class="card-404">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                <?php endif; ?>
                                
                                <div class="card-body-404">
                                    <span class="card-category-404"><?php echo esc_html($category_name); ?></span>
                                    <h4>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                    <p style="font-size: 14px; color: var(--ida-muted); margin-top: 8px; line-height: 1.5;">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </p>
                                    <div style="margin-top: 12px; font-size: 13px; color: var(--ida-muted);">
                                        <span>📅 <?php echo get_the_date('j M Y'); ?></span>
                                        <span style="margin: 0 8px;">•</span>
                                        <span>⏱️ <?php echo ida_get_reading_time(); ?> min</span>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div style="margin-top: var(--sp-6); text-align: center;">
                        <?php
                        the_posts_pagination([
                            'mid_size' => 2,
                            'prev_text' => '← Sebelumnya',
                            'next_text' => 'Selanjutnya →',
                        ]);
                        ?>
                    </div>
                </div>

            <?php else : ?>
                
                <!-- No Results -->
                <div class="recovery-content" style="border-top: none; padding-top: 0;">
                    <div style="text-align: center; padding: var(--sp-6) var(--sp-4); background: var(--ida-bg-soft); border-radius: 12px;">
                        <div style="font-size: 64px; margin-bottom: var(--sp-3);">🔍</div>
                        <h3 style="font-size: 20px; margin-bottom: var(--sp-3); color: var(--ida-text);">
                            Tidak Ada Hasil
                        </h3>
                        <p style="color: var(--ida-muted); margin-bottom: var(--sp-4);">
                            Maaf, kami tidak menemukan artikel yang cocok dengan pencarian Anda.
                        </p>
                        
                        <div style="margin-bottom: var(--sp-5);">
                            <strong style="display: block; margin-bottom: 8px;">Tips Pencarian:</strong>
                            <ul style="list-style: none; padding: 0; color: var(--ida-muted); font-size: 14px;">
                                <li>✓ Gunakan kata kunci yang lebih umum</li>
                                <li>✓ Coba kata kunci yang berbeda</li>
                                <li>✓ Periksa ejaan kata kunci</li>
                                <li>✓ Gunakan sinonim atau kata terkait</li>
                            </ul>
                        </div>
                        
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
                            Kembali ke Beranda
                        </a>
                    </div>
                    
                    <!-- Popular Posts -->
                    <div style="margin-top: var(--sp-6);">
                        <h3 style="text-align: center; margin-bottom: var(--sp-4);">
                            Atau Baca Artikel Populer Kami:
                        </h3>
                        <div class="card-grid">
                            <?php
                            $popular_posts = new WP_Query([
                                'posts_per_page' => 4,
                                'post_status' => 'publish',
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ]);

                            if ($popular_posts->have_posts()) :
                                while ($popular_posts->have_posts()) : $popular_posts->the_post();
                                    $categories = get_the_category();
                                    $category_name = !empty($categories) ? $categories[0]->name : 'Artikel';
                            ?>
                                <article class="card-404">
                                    <div class="card-body-404">
                                        <span class="card-category-404"><?php echo esc_html($category_name); ?></span>
                                        <h4>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                    </div>
                                </article>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>
