<?php
/**
 * Footer Template
 * IDA Design System - Minimal Footer
 * 
 * @package Irvandoda_SEO_Light
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="ida-footer site-footer">
        <div class="ida-container">
            
            <!-- Footer Navigation -->
            <nav class="ida-footer-nav" aria-label="<?php esc_attr_e('Footer menu', 'irvandoda-seo-light'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-menu',
                    'menu_id'        => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => 'ida_footer_fallback_menu',
                    'depth'          => 1,
                ]);
                ?>
            </nav>
            
            <!-- Footer Content -->
            <div class="ida-footer-content">
                <p>
                    &copy; <?php echo date('Y'); ?> 
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                    /* translators: %s: WordPress link */
                    printf(
                        esc_html__(' | Powered by %s', 'irvandoda-seo-light'),
                        '<a href="https://irvandoda.my.id" target="_blank" rel="noopener">Irvandoda SEO Light</a>'
                    );
                    ?>
                </p>
                
                <?php if (get_theme_mod('ida_footer_text')) : ?>
                    <p><?php echo wp_kses_post(get_theme_mod('ida_footer_text')); ?></p>
                <?php endif; ?>
            </div>
            
        </div>
    </footer>

</div><!-- #page -->

<!-- Back to Top Button -->
<button class="ida-back-to-top" onclick="scrollToTop()" title="Back to Top" style="display: none;">
    ↑
</button>

<style>
/* Footer Specific Styles */
.ida-footer {
    margin-top: auto; /* Push footer to bottom */
}

.ida-footer-content p {
    margin-bottom: var(--ida-space-sm);
}

.ida-footer-content p:last-child {
    margin-bottom: 0;
}

.ida-footer-content a {
    color: var(--ida-accent);
    text-decoration: none;
    transition: var(--ida-transition);
}

.ida-footer-content a:hover {
    text-decoration: underline;
}

/* Back to Top Button */
.ida-back-to-top {
    position: fixed;
    bottom: 20px;
    left: 20px;
    width: 50px;
    height: 50px;
    background: var(--ida-accent);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: var(--ida-font-size-lg);
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    transition: var(--ida-transition);
    z-index: 1000;
}

.ida-back-to-top:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}

.ida-back-to-top.show {
    display: block !important;
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile Footer */
@media (max-width: 767px) {
    .ida-back-to-top {
        bottom: 80px; /* Above sticky CTA if present */
        right: 20px;
        left: auto;
    }
}

/* Site Layout */
.site {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.site-content {
    flex: 1;
}

/* Print Styles */
@media print {
    .ida-footer,
    .ida-back-to-top,
    .ida-toc-float,
    .ida-sticky-cta {
        display: none !important;
    }
}
</style>

<script>
// Back to Top Button
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/Hide Back to Top Button
function handleBackToTop() {
    const backToTopBtn = document.querySelector('.ida-back-to-top');
    
    if (window.scrollY > 300) {
        backToTopBtn.style.display = 'block';
        backToTopBtn.classList.add('show');
    } else {
        backToTopBtn.classList.remove('show');
        setTimeout(() => {
            if (!backToTopBtn.classList.contains('show')) {
                backToTopBtn.style.display = 'none';
            }
        }, 300);
    }
}

// Event Listeners
window.addEventListener('scroll', handleBackToTop);

// Performance: Throttle scroll events
let ticking = false;

function requestTick() {
    if (!ticking) {
        requestAnimationFrame(function() {
            handleBackToTop();
            if (typeof handleHeaderScroll === 'function') {
                handleHeaderScroll();
            }
            if (typeof updateReadingProgress === 'function') {
                updateReadingProgress();
            }
            if (typeof handleStickyCTA === 'function') {
                handleStickyCTA();
            }
            ticking = false;
        });
        ticking = true;
    }
}

window.addEventListener('scroll', requestTick);

// Lazy Loading Enhancement
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Service Worker Registration (Optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('SW registered: ', registration);
            })
            .catch(function(registrationError) {
                console.log('SW registration failed: ', registrationError);
            });
    });
}
</script>

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Fallback footer menu if no menu is assigned
 */
function ida_footer_fallback_menu() {
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
    echo '<a href="' . esc_url(get_privacy_policy_url()) . '">Privacy Policy</a>';
    echo '<a href="' . esc_url(home_url('/contact/')) . '">Contact</a>';
}
?>