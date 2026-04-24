<?php
/**
 * Header Template - IDA Design System v2.0
 * Structure: Top Nav → Header (Logo + Ad) → Main Nav → Breaking News
 * 
 * @package Irvandoda_SEO_Light
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- IDA Design System CSS - Force Load -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/ida-design-system.css?v=<?php echo time(); ?>" type="text/css" media="all">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP HEADER MENU -->
<?php $general_settings = get_option('ida_general_settings', []); ?>
<div class="top-header">
    <div class="container top-header-inner">
        <div><?php echo esc_html($general_settings['top_header_text'] ?? 'Update Algoritma Terkini: ' . date('F Y')); ?></div>
        <?php
        wp_nav_menu([
            'theme_location' => 'top-menu',
            'menu_class'     => 'top-menu',
            'container'      => false,
            'fallback_cb'    => 'ida_top_menu_fallback',
            'depth'          => 1,
        ]);
        ?>
    </div>
</div>

<!-- HEADER: Logo & Ad Space -->
<header class="site-header" id="header">
    <div class="container header-inner">
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <?php bloginfo('name'); ?>
            </a>
        <?php endif; ?>
        
        <div class="header-ad">
            <?php if (is_active_sidebar('header-ad')) : ?>
                <?php dynamic_sidebar('header-ad'); ?>
            <?php else : ?>
                [Tempat Iklan Banner 728x90]
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- MAIN NAVIGATION -->
<div class="main-nav-wrapper">
    <div class="container">
        <div class="main-nav-container">
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="Toggle Menu" id="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <?php
            wp_nav_menu([
                'theme_location' => 'menu-1',
                'menu_class'     => 'main-nav',
                'container'      => false,
                'fallback_cb'    => 'ida_main_menu_fallback',
                'depth'          => 1,
            ]);
            ?>
        </div>
    </div>
</div>

<!-- SUB NAVIGATION / BREAKING NEWS TICKER -->
<?php 
$ticker_settings = get_option('ida_ticker_settings', []);
$ticker_enable = isset($ticker_settings['enable']) ? $ticker_settings['enable'] : 1;
$ticker_label = $ticker_settings['label'] ?? 'Terbaru';
$ticker_count = $ticker_settings['count'] ?? 5;
$ticker_speed = $ticker_settings['speed'] ?? 50;

if ($ticker_enable) :
?>
<div class="ticker-wrap">
    <div class="container ticker-inner">
        <span class="ticker-label"><?php echo esc_html($ticker_label); ?></span>
        <div class="ticker-content">
            <div class="ticker-marquee">
                <?php
                $latest_posts = new WP_Query([
                    'posts_per_page' => $ticker_count,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
                
                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        echo '<a href="' . get_permalink() . '" class="ticker-item">';
                        echo '<span class="ticker-icon">🔥</span> ';
                        echo get_the_title();
                        echo '</a>';
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<a href="#" class="ticker-item">';
                    echo '<span class="ticker-icon">🔥</span> ';
                    echo 'Selamat datang di ' . get_bloginfo('name');
                    echo '</a>';
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mainNav.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !mainNav.contains(e.target)) {
                menuToggle.classList.remove('active');
                mainNav.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                menuToggle.classList.remove('active');
                mainNav.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    }
    
    // Breaking News Marquee Animation
    const marquee = document.querySelector('.ticker-marquee');
    if (marquee) {
        // Clone items for infinite scroll
        const items = marquee.innerHTML;
        marquee.innerHTML = items + items + items; // Triple for smooth loop
        
        let scrollAmount = 0;
        const speed = <?php echo $ticker_speed; ?>; // Pixels per second
        let isPaused = false;
        
        function animate() {
            if (!isPaused) {
                scrollAmount += speed / 60; // 60fps
                
                if (scrollAmount >= marquee.scrollWidth / 3) {
                    scrollAmount = 0;
                }
                
                marquee.style.transform = `translateX(-${scrollAmount}px)`;
            }
            requestAnimationFrame(animate);
        }
        
        // Pause on hover
        marquee.addEventListener('mouseenter', function() {
            isPaused = true;
        });
        
        marquee.addEventListener('mouseleave', function() {
            isPaused = false;
        });
        
        animate();
    }
    
    // Sticky Nav Shadow on Scroll
    const navWrapper = document.querySelector('.main-nav-wrapper');
    if (navWrapper) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 150) {
                navWrapper.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
            } else {
                navWrapper.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.05)';
            }
        });
    }
});
</script>

<?php
/**
 * Top menu fallback
 */
function ida_top_menu_fallback() {
    echo '<ul class="top-menu">';
    echo '<li><a href="' . home_url('/about') . '">Tentang Kami</a></li>';
    echo '<li><a href="' . home_url('/contact') . '">Kontak</a></li>';
    echo '</ul>';
}

/**
 * Main menu fallback
 */
function ida_main_menu_fallback() {
    echo '<ul class="main-nav">';
    echo '<li><a href="' . home_url('/') . '">Beranda</a></li>';
    
    $categories = get_categories(['number' => 4, 'hide_empty' => true]);
    foreach ($categories as $category) {
        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
    }
    
    echo '<li><a href="#" class="nav-cta">Download Blueprint</a></li>';
    echo '</ul>';
}
?>
