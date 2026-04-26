<?php
/**
 * Page Template
 * For static pages (About, Contact, etc.)
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<main class="container" style="padding: var(--sp-6) var(--sp-3);">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: var(--sp-4);">
            <?php ida_breadcrumb(); ?>
        </div>

        <!-- Page Content -->
        <article class="ida-single-content" style="max-width: 760px; margin: 0 auto;">
            
            <!-- Page Title -->
            <header style="margin-bottom: var(--sp-5); text-align: center;">
                <h1 style="font-size: 42px; font-weight: 800; line-height: 1.2; margin-bottom: var(--sp-3); letter-spacing: -0.02em;">
                    <?php the_title(); ?>
                </h1>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div style="margin-top: var(--sp-4); border-radius: 12px; overflow: hidden;">
                        <?php the_post_thumbnail('large', ['style' => 'width: 100%; height: auto;']); ?>
                    </div>
                <?php endif; ?>
            </header>

            <!-- Page Content -->
            <div class="ida-content-body" style="font-size: 18px; line-height: 1.8; color: var(--ida-text-light);">
                <?php the_content(); ?>
            </div>

            <!-- Page Links (for paginated content) -->
            <?php
            wp_link_pages([
                'before' => '<div style="margin-top: var(--sp-5); padding-top: var(--sp-4); border-top: 1px solid var(--ida-border);">',
                'after' => '</div>',
                'link_before' => '<span style="display: inline-block; padding: 8px 16px; margin: 4px; background: var(--ida-accent-soft); color: var(--ida-accent); border-radius: 6px; font-weight: 600;">',
                'link_after' => '</span>',
            ]);
            ?>

            <!-- Comments (if enabled) -->
            <?php
            if (comments_open() || get_comments_number()) :
                ?>
                <div style="margin-top: var(--sp-7); padding-top: var(--sp-5); border-top: 2px solid var(--ida-border);">
                    <?php comments_template(); ?>
                </div>
                <?php
            endif;
            ?>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
