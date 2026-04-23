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
<div class="top-header">
    <div class="container top-header-inner">
        <div><?php echo get_theme_mod('ida_top_header_text', 'Update Algoritma Terkini: ' . date('F Y')); ?></div>
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

<!-- SUB NAVIGATION / BREAKING NEWS TICKER -->
<div class="ticker-wrap">
    <div class="container ticker-inner">
        <span class="ticker-label">Terbaru</span>
        <div class="ticker-text">
            <?php
            $latest_post = new WP_Query([
                'posts_per_page' => 1,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ]);
            
            if ($latest_post->have_posts()) :
                while ($latest_post->have_posts()) : $latest_post->the_post();
                    echo '<a href="' . get_permalink() . '">🔥 ' . get_the_title() . '</a>';
                endwhile;
                wp_reset_postdata();
            else :
                echo '<a href="#">🔥 Selamat datang di ' . get_bloginfo('name') . '</a>';
            endif;
            ?>
        </div>
    </div>
</div>

<script>
// Sticky Nav Shadow on Scroll
document.addEventListener('DOMContentLoaded', () => {
    const navWrapper = document.querySelector('.main-nav-wrapper');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 150) {
            navWrapper.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
        } else {
            navWrapper.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.05)';
        }
    });
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
