<?php
/**
 * Single Post Template - Article UX (CORE EXPERIENCE)
 * IDA Design System - SEO Engine Edition
 * 
 * @package Irvandoda_SEO_Light
 */

get_header(); ?>

<!-- Reading Progress Bar -->
<div class="ida-reading-progress" id="reading-progress"></div>

<main class="ida-container">
    <?php while (have_posts()) : the_post(); ?>
        
        <article class="ida-article">
            
            <!-- A. BREADCRUMB (Subtle & Clickable) -->
            <?php ida_breadcrumb(); ?>
            
            <!-- B. HERO BLOCK (Article Header) -->
            <header class="ida-hero">
                <h1 class="ida-hero-title"><?php the_title(); ?></h1>
                
                <div class="ida-hero-meta">
                    <div class="ida-hero-meta-item">
                        <span>📅</span>
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date('F j, Y'); ?>
                        </time>
                    </div>
                    <div class="ida-hero-meta-item">
                        <span>⏱</span>
                        <span><?php echo ida_get_reading_time(); ?> min read</span>
                    </div>
                    <div class="ida-hero-meta-item">
                        <span>👤</span>
                        <span>By <?php the_author(); ?></span>
                    </div>
                </div>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="ida-hero-image">
                        <?php the_post_thumbnail('large', ['class' => 'ida-responsive-image']); ?>
                    </div>
                <?php endif; ?>
            </header>
            
            <div class="ida-content-wrapper">
                
                <!-- C. TABLE OF CONTENTS (Smart & Auto-generated) -->
                <?php 
                $content = get_the_content();
                $toc = ida_generate_toc($content);
                if (!empty($toc)) : 
                ?>
                <div class="ida-toc" id="table-of-contents">
                    <h3 class="ida-toc-title">Table of Contents</h3>
                    <div class="ida-toc-list">
                        <?php echo $toc; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- D. CONTENT FLOW (Critical UX) -->
                <div class="ida-content">
                    <?php
                    // Process content with inline engagement
                    $processed_content = ida_add_inline_engagement($content);
                    $processed_content = ida_add_internal_links($processed_content);
                    
                    // Apply TOC anchors
                    if (!empty($toc)) {
                        $processed_content = ida_apply_toc_anchors($processed_content);
                    }
                    
                    echo apply_filters('the_content', $processed_content);
                    ?>
                </div>
                
                <!-- E. RATING BLOCK (Trust Signal) -->
                <div class="ida-rating-block">
                    <div class="ida-rating-stars">★★★★★</div>
                    <div class="ida-rating-text">4.8/5 Rating</div>
                    <div class="ida-rating-count">Based on 1,247 reader reviews</div>
                </div>
                
                <!-- F. CTA BLOCK (Conversion Focused) -->
                <div class="ida-cta-block">
                    <h3 class="ida-cta-title">Found This Helpful?</h3>
                    <p class="ida-cta-text">Share this article with others who might benefit from these insights.</p>
                    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                        <a href="#" class="ida-btn ida-btn-primary" onclick="ida_shareArticle('twitter')">
                            Share on Twitter
                        </a>
                        <a href="#" class="ida-btn ida-btn-secondary" onclick="ida_shareArticle('linkedin')">
                            Share on LinkedIn
                        </a>
                    </div>
                </div>
                
                <!-- G. AUTHOR BOX (E-E-A-T Signal) -->
                <div class="ida-author-box">
                    <div class="ida-author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                    </div>
                    <div class="ida-author-info">
                        <h4 class="ida-author-name"><?php the_author(); ?></h4>
                        <div class="ida-author-title">
                            <?php 
                            $author_title = get_the_author_meta('description') ? 'Content Specialist' : 'Author';
                            echo esc_html($author_title);
                            ?>
                        </div>
                        <div class="ida-author-bio">
                            <?php 
                            $author_bio = get_the_author_meta('description');
                            if ($author_bio) {
                                echo wp_kses_post($author_bio);
                            } else {
                                echo 'Passionate about creating valuable content that helps readers achieve their goals.';
                            }
                            ?>
                        </div>
                        <div class="ida-author-links">
                            <?php if (get_the_author_meta('user_url')) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('user_url')); ?>" class="ida-author-link" target="_blank" rel="noopener">
                                    Website
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="ida-author-link">
                                More Articles
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- H. RELATED CONTENT (Clean List) -->
                <?php 
                $related_posts = ida_get_related_posts(get_the_ID(), 4);
                if (!empty($related_posts)) : 
                ?>
                <section class="ida-related-section">
                    <h3 class="ida-related-title">Related Articles</h3>
                    <div class="ida-related-grid">
                        <?php foreach ($related_posts as $related_post) : ?>
                            <article class="ida-related-card">
                                <h4 class="ida-related-card-title">
                                    <a href="<?php echo get_permalink($related_post); ?>">
                                        <?php echo get_the_title($related_post); ?>
                                    </a>
                                </h4>
                                <div class="ida-related-card-meta">
                                    <?php echo get_the_date('M j, Y', $related_post); ?> • 
                                    <?php echo ida_get_reading_time($related_post->ID); ?> min read
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <!-- Final CTA (End Content) -->
                <div class="ida-cta-block">
                    <h3 class="ida-cta-title">Stay Updated</h3>
                    <p class="ida-cta-text">Get the latest insights delivered to your inbox.</p>
                    <a href="#newsletter" class="ida-btn ida-btn-primary">Subscribe Now</a>
                </div>
                
            </div>
            
        </article>
        
    <?php endwhile; ?>
</main>

<!-- JavaScript for Enhanced UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading Progress Bar
    const progressBar = document.getElementById('reading-progress');
    const article = document.querySelector('.ida-content');
    
    if (progressBar && article) {
        window.addEventListener('scroll', function() {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset;
            
            const articleBottom = articleTop + articleHeight - windowHeight;
            const progress = Math.min(Math.max((scrollTop - articleTop) / (articleBottom - articleTop), 0), 1);
            
            progressBar.style.width = (progress * 100) + '%';
        });
    }
    
    // Smooth Scroll for TOC Links
    const tocLinks = document.querySelectorAll('.ida-toc-list a');
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerOffset = 80; // Account for sticky header
                const elementPosition = targetElement.offsetTop;
                const offsetPosition = elementPosition - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Scroll-triggered CTA (Psychological UX)
    let ctaTriggered = false;
    window.addEventListener('scroll', function() {
        if (!ctaTriggered && window.pageYOffset > article.offsetHeight * 0.7) {
            // User has read 70% of content - good time for CTA
            ctaTriggered = true;
            console.log('CTA trigger point reached - user engaged with content');
        }
    });
});

// Share Functions
function ida_shareArticle(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    
    let shareUrl = '';
    
    switch(platform) {
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

// Focus Mode (Optional - Advanced UX)
function ida_toggleFocusMode() {
    document.body.classList.toggle('ida-focus-mode');
}

// CSS for Focus Mode
const focusModeCSS = `
.ida-focus-mode .ida-header,
.ida-focus-mode .ida-cta-block,
.ida-focus-mode .ida-related-section {
    opacity: 0.3;
    transition: opacity 0.3s ease;
}

.ida-focus-mode .ida-content {
    max-width: 600px;
    margin: 0 auto;
}
`;

// Inject Focus Mode CSS
const style = document.createElement('style');
style.textContent = focusModeCSS;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>