<?php
/**
 * Footer Template - IDA Design System v2.0
 * 
 * @package Irvandoda_SEO_Light
 */
?>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        
        <!-- Footer Grid -->
        <div class="footer-grid">
            
            <!-- Footer Brand -->
            <div class="footer-brand">
                <h4><?php bloginfo('name'); ?></h4>
                <p>
                    <?php 
                    $description = get_bloginfo('description');
                    echo $description ? esc_html($description) : 'Theme yang dibuat bukan hanya untuk dilihat, tapi untuk menguasai algoritma mesin pencari dengan pondasi UI/UX terbaik.';
                    ?>
                </p>
            </div>

            <!-- Footer Links: Navigasi -->
            <div class="footer-links">
                <h5>Navigasi</h5>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => 'ida_footer_nav_fallback',
                    'depth'          => 1,
                ]);
                ?>
            </div>

            <!-- Footer Links: Legal -->
            <div class="footer-links">
                <h5>Legal</h5>
                <ul>
                    <li><a href="<?php echo get_privacy_policy_url(); ?>">Kebijakan Privasi</a></li>
                    <li><a href="<?php echo home_url('/terms'); ?>">Syarat Ketentuan</a></li>
                    <li><a href="<?php echo home_url('/contact'); ?>">Kontak Bantuan</a></li>
                </ul>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
            <?php echo get_theme_mod('ida_footer_tagline', 'Zero Distraction, Full Conversion.'); ?>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Footer navigation fallback
 */
function ida_footer_nav_fallback() {
    echo '<ul>';
    echo '<li><a href="' . home_url('/') . '">Semua Artikel</a></li>';
    echo '<li><a href="' . home_url('/about') . '">Tentang Kami</a></li>';
    echo '<li><a href="' . home_url('/contact') . '">Kontak</a></li>';
    echo '</ul>';
}
?>