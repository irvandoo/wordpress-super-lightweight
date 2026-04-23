<?php
/**
 * Single Post Template - IDA Design System v2.0
 * Optimized for Dwell Time & Reading Experience
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<!-- Micro UX: Reading Progress -->
<div id="progress-bar"></div>

<!-- MAIN ARTICLE SECTION -->
<main class="site-content">
    <div class="container-single">

        <?php while (have_posts()) : the_post(); ?>

            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="<?php echo home_url('/'); ?>">Beranda</a> › 
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    $category = $categories[0];
                    echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a> › ';
                }
                ?>
                <span><?php the_title(); ?></span>
            </nav>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <!-- Hero Block / Post Header -->
                <header class="post-header">
                    <?php if (!empty($categories)) : ?>
                        <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                    <?php endif; ?>
                    
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <div class="meta-author">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                            <span><?php the_author(); ?></span>
                        </div>
                        <span class="meta-divider">•</span>
                        <span>Diperbarui <?php echo get_the_modified_date('j F Y'); ?></span>
                        <span class="meta-divider">•</span>
                        <span>⏱️ <?php echo ida_get_reading_time(); ?> Menit Baca</span>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="post-thumbnail">
                <?php endif; ?>

                <!-- The Content Core -->
                <div class="post-content">
                    
                    <?php
                    // Get content
                    $content = get_the_content();
                    
                    // Generate TOC
                    $toc = ida_generate_toc($content);
                    
                    // Apply TOC anchors to content
                    $content = ida_apply_toc_anchors($content);
                    
                    // Get first paragraph for intro
                    $paragraphs = explode('</p>', $content);
                    $intro = '';
                    if (!empty($paragraphs[0])) {
                        $intro = $paragraphs[0] . '</p>';
                        // Remove first paragraph from content
                        array_shift($paragraphs);
                        $content = implode('</p>', $paragraphs);
                    }
                    
                    // Output intro
                    echo $intro;
                    ?>

                    <!-- Trust Signal / SERP Hook (After Intro) -->
                    <div class="rating-block">
                        <span class="stars">★★★★★</span>
                        <span><?php echo get_theme_mod('ida_rating_text', 'Artikel ini telah divalidasi berdasarkan Core Update ' . date('F Y')); ?></span>
                    </div>

                    <?php if (!empty($toc)) : ?>
                        <!-- Smart TOC (Table of Contents) -->
                        <details class="toc-box" open>
                            <summary>Daftar Isi Pembahasan</summary>
                            <div class="toc-list">
                                <?php echo $toc; ?>
                            </div>
                        </details>
                    <?php endif; ?>

                    <?php
                    // Output rest of content
                    echo $content;
                    
                    // Add related posts inline
                    $related_posts = ida_get_related_posts(get_the_ID(), 2);
                    if (!empty($related_posts)) {
                        $related_count = 0;
                        $content_parts = explode('</h2>', $content);
                        
                        foreach ($related_posts as $related_post) {
                            if ($related_count < count($content_parts) - 1) {
                                echo '<div class="inline-related">';
                                echo '<span class="inline-related-label">Baca Juga</span>';
                                echo '<a href="' . get_permalink($related_post) . '">' . get_the_title($related_post) . '</a>';
                                echo '</div>';
                                $related_count++;
                            }
                        }
                    }
                    ?>

                    <!-- Highlight Block / Visual Break -->
                    <div class="highlight-box">
                        <strong>💡 Insight Penting</strong>
                        <?php echo get_theme_mod('ida_highlight_text', 'Implementasi strategi ini membutuhkan konsistensi. Hasil optimal biasanya terlihat dalam 2-3 bulan.'); ?>
                    </div>

                </div> <!-- End Post Content -->

                <!-- CTA Block (End of Content) -->
                <div class="cta-block">
                    <h3><?php echo get_theme_mod('ida_post_cta_title', 'Implementasikan Sistem Ini Tanpa Coding'); ?></h3>
                    <p><?php echo get_theme_mod('ida_post_cta_description', 'Tema Irvandoda didesain khusus secara otomatis menerapkan semua prinsip Dwell Time, Whitespace, dan Smart TOC.'); ?></p>
                    <a href="<?php echo get_theme_mod('ida_post_cta_link', '#'); ?>" class="btn">
                        <?php echo get_theme_mod('ida_post_cta_button', 'Download Theme Irvandoda Sekarang'); ?>
                    </a>
                </div>

                <!-- Author Box -->
                <div class="author-box">
                    <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', ['class' => 'author-avatar']); ?>
                    <div class="author-info">
                        <h4><?php the_author(); ?></h4>
                        <p><?php echo get_the_author_meta('description') ?: 'Penulis di ' . get_bloginfo('name') . '. Fokus pada SEO, UI/UX, dan optimasi performa website.'; ?></p>
                    </div>
                </div>

                <!-- Related Content -->
                <?php
                $related_posts = ida_get_related_posts(get_the_ID(), 2);
                if (!empty($related_posts)) :
                ?>
                    <section class="related-content">
                        <h3>Baca Juga (Topik Terkait)</h3>
                        <div class="card-grid">
                            <?php foreach ($related_posts as $related_post) : ?>
                                <article class="card">
                                    <?php if (has_post_thumbnail($related_post->ID)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($related_post->ID, 'medium'); ?>" 
                                             alt="<?php echo get_the_title($related_post); ?>">
                                    <?php else : ?>
                                        <img src="https://placehold.co/600x337/f8fafc/64748b?text=<?php echo urlencode(get_the_title($related_post)); ?>" 
                                             alt="<?php echo get_the_title($related_post); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h4>
                                            <a href="<?php echo get_permalink($related_post); ?>">
                                                <?php echo get_the_title($related_post); ?>
                                            </a>
                                        </h4>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Comments Section -->
                <?php if (comments_open() || get_comments_number()) : ?>
                    <section class="comments-section">
                        <h3>Komentar (<?php echo get_comments_number(); ?>)</h3>
                        
                        <!-- Form Komentar -->
                        <div class="comment-form">
                            <h4>Tinggalkan Balasan</h4>
                            <p>Alamat email Anda tidak akan dipublikasikan. Ruas yang wajib ditandai *</p>
                            
                            <?php
                            comment_form([
                                'title_reply' => '',
                                'comment_field' => '<div class="form-group"><textarea id="comment" name="comment" placeholder="Tulis pendapat atau pertanyaan Anda di sini..." rows="4" required></textarea></div>',
                                'fields' => [
                                    'author' => '<div class="form-grid"><div class="form-group"><input id="author" name="author" type="text" placeholder="Nama Lengkap *" required /></div>',
                                    'email' => '<div class="form-group"><input id="email" name="email" type="email" placeholder="Alamat Email *" required /></div></div>',
                                ],
                                'class_submit' => 'btn',
                                'label_submit' => 'Kirim Komentar',
                                'submit_button' => '<button type="submit" class="btn">%4$s</button>',
                            ]);
                            ?>
                        </div>

                        <!-- Daftar Komentar -->
                        <?php if (have_comments()) : ?>
                            <div class="comments-list">
                                <?php
                                wp_list_comments([
                                    'style' => 'div',
                                    'callback' => 'ida_custom_comment',
                                    'avatar_size' => 48,
                                ]);
                                ?>
                            </div>

                            <?php
                            // Comment pagination
                            if (get_comment_pages_count() > 1 && get_option('page_comments')) :
                                ?>
                                <nav class="comment-navigation">
                                    <?php
                                    paginate_comments_links([
                                        'prev_text' => '← Sebelumnya',
                                        'next_text' => 'Selanjutnya →',
                                    ]);
                                    ?>
                                </nav>
                            <?php endif; ?>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Reading Progress Bar
    const progressBar = document.getElementById('progress-bar');
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    });

    // 2. Sticky Nav Box Shadow
    const navWrapper = document.querySelector('.main-nav-wrapper');
    if (navWrapper) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navWrapper.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
            } else {
                navWrapper.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.05)';
            }
        });
    }

    // 3. Smooth Scroll untuk TOC
    document.querySelectorAll('.toc-list a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        });
    });
});
</script>

<?php get_footer(); ?>
