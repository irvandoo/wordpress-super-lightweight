<?php
/**
 * Footer Template - IDA Design System v2.0
 * 
 * @package Irvandoda_SEO_Light
 */
?>

    </div><!-- #content -->

    <!-- FOOTER -->
    <footer class="ida-footer">
        <div class="ida-container">
            
            <!-- Footer Widgets -->
            <div class="ida-footer-widgets">
                
                <!-- About Widget -->
                <div class="ida-footer-widget">
                    <h4 class="ida-widget-title">About <?php bloginfo('name'); ?></h4>
                    <p class="ida-widget-text">
                        <?php 
                        $description = get_bloginfo('description');
                        echo $description ? esc_html($description) : 'Your trusted source for quality content and insights.';
                        ?>
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="ida-footer-widget">
                    <h4 class="ida-widget-title">Quick Links</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'menu_class'     => 'ida-footer-menu',
                        'fallback_cb'    => 'ida_footer_menu_fallback',
                        'depth'          => 1,
                    ]);
                    ?>
                </div>

                <!-- Categories -->
                <div class="ida-footer-widget">
                    <h4 class="ida-widget-title">Categories</h4>
                    <ul class="ida-footer-menu">
                        <?php
                        $categories = get_categories(['number' => 6]);
                        foreach ($categories as $category) {
                            echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Social / Contact -->
                <div class="ida-footer-widget">
                    <h4 class="ida-widget-title">Follow Us</h4>
                    <div class="ida-social-links">
                        <a href="#" class="ida-social-link" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 0C4.477 0 0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.879V12.89h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.989C16.343 19.129 20 14.99 20 10c0-5.523-4.477-10-10-10z"/>
                            </svg>
                        </a>
                        <a href="#" class="ida-social-link" aria-label="Twitter">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="ida-social-link" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 0C7.284 0 6.944.012 5.877.06 4.813.11 4.086.278 3.45.525a4.902 4.902 0 00-1.772 1.153A4.902 4.902 0 00.525 3.45C.278 4.086.109 4.813.06 5.877.012 6.944 0 7.284 0 10s.012 3.056.06 4.123c.05 1.064.218 1.791.465 2.427a4.902 4.902 0 001.153 1.772 4.902 4.902 0 001.772 1.153c.636.247 1.363.416 2.427.465C6.944 19.988 7.284 20 10 20s3.056-.012 4.123-.06c1.064-.05 1.791-.218 2.427-.465a4.902 4.902 0 001.772-1.153 4.902 4.902 0 001.153-1.772c.247-.636.416-1.363.465-2.427.048-1.067.06-1.407.06-4.123s-.012-3.056-.06-4.123c-.05-1.064-.218-1.791-.465-2.427a4.902 4.902 0 00-1.153-1.772A4.902 4.902 0 0016.55.525C15.914.278 15.187.109 14.123.06 13.056.012 12.716 0 10 0zm0 1.802c2.67 0 2.987.01 4.041.059.976.045 1.505.207 1.858.344.466.182.8.399 1.15.748.35.35.566.684.748 1.15.137.353.3.882.344 1.857.048 1.055.058 1.37.058 4.041 0 2.67-.01 2.986-.058 4.04-.045.976-.207 1.505-.344 1.858a3.097 3.097 0 01-.748 1.15c-.35.35-.684.566-1.15.748-.353.137-.882.3-1.857.344-1.054.048-1.37.058-4.041.058-2.67 0-2.987-.01-4.04-.058-.976-.045-1.505-.207-1.858-.344a3.097 3.097 0 01-1.15-.748 3.098 3.098 0 01-.748-1.15c-.137-.353-.3-.882-.344-1.857-.048-1.055-.058-1.37-.058-4.041 0-2.67.01-2.986.058-4.04.045-.976.207-1.505.344-1.858.182-.466.399-.8.748-1.15.35-.35.684-.566 1.15-.748.353-.137.882-.3 1.857-.344 1.055-.048 1.37-.058 4.041-.058z"/>
                                <path d="M10 13.333a3.333 3.333 0 110-6.666 3.333 3.333 0 010 6.666zm0-8.468a5.135 5.135 0 100 10.27 5.135 5.135 0 000-10.27zm6.538-.203a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="ida-footer-bottom">
                <div class="ida-copyright">
                    <p>
                        &copy; <?php echo date('Y'); ?> 
                        <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>. 
                        All rights reserved.
                    </p>
                </div>
                <div class="ida-footer-links">
                    <a href="<?php echo get_privacy_policy_url(); ?>">Privacy Policy</a>
                    <span>•</span>
                    <a href="<?php echo home_url('/terms'); ?>">Terms of Service</a>
                    <span>•</span>
                    <a href="<?php echo home_url('/contact'); ?>">Contact</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="ida-back-to-top" onclick="scrollToTop()" aria-label="Back to top" style="display: none;">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 3l-7 7h4v7h6v-7h4l-7-7z"/>
        </svg>
    </button>

</div><!-- #page -->

<script>
// Back to Top
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Show/Hide Back to Top Button
window.addEventListener('scroll', function() {
    const backToTop = document.querySelector('.ida-back-to-top');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'flex';
    } else {
        backToTop.style.display = 'none';
    }
});
</script>

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Footer menu fallback
 */
function ida_footer_menu_fallback() {
    echo '<ul class="ida-footer-menu">';
    echo '<li><a href="' . home_url('/') . '">Home</a></li>';
    echo '<li><a href="' . home_url('/about') . '">About</a></li>';
    echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
    echo '<li><a href="' . get_privacy_policy_url() . '">Privacy</a></li>';
    echo '</ul>';
}
?>