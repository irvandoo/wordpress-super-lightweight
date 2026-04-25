<?php
/**
 * 404 Error Page Template
 * IDA Design System - Professional 404 with Recovery Options
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); 

// Get theme settings
$general_settings = get_option('ida_general_settings', []);
?>

<!-- 404 CONTENT AREA -->
<main class="site-content-404">
    <div class="container">
        <div class="error-wrapper">
            
            <div class="error-code">404</div>
            
            <h1 class="error-title">Ups! Halaman Tidak Ditemukan</h1>
            
            <p class="error-desc">
                Sepertinya halaman yang Anda cari telah dipindahkan, dihapus, atau Anda salah mengetikkan URL. 
                Jangan khawatir, mari kita cari jalan kembalinya.
            </p>

            <!-- Search Form -->
            <form class="search-404" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" 
                       name="s" 
                       placeholder="Cari topik SEO, artikel, atau tutorial..." 
                       value="<?php echo get_search_query(); ?>" 
                       required>
                <button type="submit" class="btn">Cari Artikel</button>
            </form>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline">
                    ← Kembali ke Beranda
                </a>
                <a href="<?php echo esc_url(home_url('/sitemap.xml')); ?>" class="btn btn-outline">
                    Lihat Peta Situs
                </a>
            </div>

            <!-- Recovery Content: Pillar Articles -->
            <div class="recovery-content">
                <h3>Atau, Mulai Baca Artikel Terbaik Kami:</h3>
                
                <div class="card-grid">
                    <?php
                    // Get top 4 most viewed or recent posts
                    $popular_posts = new WP_Query([
                        'posts_per_page' => 4,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'meta_query' => [
                            [
                                'key' => '_thumbnail_id',
                                'compare' => 'EXISTS'
                            ]
                        ]
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
                    else :
                        // Fallback content if no posts
                    ?>
                        <article class="card-404">
                            <div class="card-body-404">
                                <span class="card-category-404">Pilar Content</span>
                                <h4><a href="<?php echo home_url('/'); ?>">Blueprint Arsitektur Silo 2026: Cara Mengalahkan Kompetitor Tanpa Backlink</a></h4>
                            </div>
                        </article>
                        <article class="card-404">
                            <div class="card-body-404">
                                <span class="card-category-404">On-Page SEO</span>
                                <h4><a href="<?php echo home_url('/'); ?>">Mengapa Dwell Time Adalah Metrik Ranking #1 Saat Ini?</a></h4>
                            </div>
                        </article>
                        <article class="card-404">
                            <div class="card-body-404">
                                <span class="card-category-404">Technical SEO</span>
                                <h4><a href="<?php echo home_url('/'); ?>">Cara Cepat Mengatasi Error 5xx di Google Search Console</a></h4>
                            </div>
                        </article>
                        <article class="card-404">
                            <div class="card-body-404">
                                <span class="card-category-404">Case Study</span>
                                <h4><a href="<?php echo home_url('/'); ?>">Trafik Naik 300% Hanya Dengan Mengganti Format Daftar Isi (TOC)</a></h4>
                            </div>
                        </article>
                    <?php endif; ?>
                </div>
            </div>

        </div> <!-- End Error Wrapper -->
    </div>
</main>

<?php get_footer(); ?>
