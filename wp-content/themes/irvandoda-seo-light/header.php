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

<div id="page" class="site">
    
    <!-- 1. TOP NAVIGATION BAR -->
    <div class="ida-top-bar">
        <div class="ida-container">
            <div class="ida-top-bar-inner">
                <div class="ida-top-bar-left">
                    <span class="ida-top-date">
                        <?php echo date_i18n('l, F j, Y'); ?>
                    </span>
                </div>
                <div class="ida-top-bar-right">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'top-menu',
                        'menu_id'        => 'top-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. HEADER (Logo + Ad Slot) -->
    <header class="ida-header-main">
        <div class="ida-container">
            <div class="ida-header-content">
                
                <!-- Logo -->
                <div class="ida-logo-wrapper">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="ida-logo-text">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (get_bloginfo('description')) : ?>
                        <p class="ida-tagline"><?php bloginfo('description'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Ad Slot (728x90 Leaderboard) -->
                <div class="ida-ad-slot ida-ad-header">
                    <?php if (is_active_sidebar('header-ad')) : ?>
                        <?php dynamic_sidebar('header-ad'); ?>
                    <?php else : ?>
                        <div class="ida-ad-placeholder">
                            <span>Header Ad 728x90</span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </header>

    <!-- 3. MAIN NAVIGATION MENU -->
    <nav class="ida-main-nav" id="main-navigation">
        <div class="ida-container">
            <div class="ida-main-nav-inner">
                
                <!-- Mobile Menu Toggle -->
                <button class="ida-menu-toggle" aria-label="Toggle Menu" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Main Menu -->
                <div class="ida-menu-wrapper">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'ida-menu',
                        'fallback_cb'    => 'ida_default_menu',
                        'depth'          => 2,
                    ]);
                    ?>
                </div>

                <!-- Search Icon -->
                <button class="ida-search-toggle" onclick="toggleSearch()" aria-label="Search">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

            </div>
        </div>

        <!-- Search Form (Hidden) -->
        <div class="ida-search-dropdown" id="search-dropdown" style="display: none;">
            <div class="ida-container">
                <?php get_search_form(); ?>
            </div>
        </div>
    </nav>

    <!-- 4. BREAKING NEWS / LATEST ARTICLES TICKER -->
    <div class="ida-breaking-news">
        <div class="ida-container">
            <div class="ida-breaking-inner">
                <span class="ida-breaking-label">Latest Articles</span>
                <div class="ida-breaking-content">
                    <?php
                    $latest_posts = new WP_Query([
                        'posts_per_page' => 5,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);
                    
                    if ($latest_posts->have_posts()) :
                        echo '<div class="ida-ticker">';
                        while ($latest_posts->have_posts()) : $latest_posts->the_post();
                            echo '<a href="' . get_permalink() . '" class="ida-ticker-item">';
                            echo '<span class="ida-ticker-icon">•</span>';
                            echo get_the_title();
                            echo '</a>';
                        endwhile;
                        echo '</div>';
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div id="content" class="site-content">

<script>
// Mobile Menu Toggle
function toggleMobileMenu() {
    const menuWrapper = document.querySelector('.ida-menu-wrapper');
    const menuToggle = document.querySelector('.ida-menu-toggle');
    
    menuWrapper.classList.toggle('active');
    menuToggle.classList.toggle('active');
    document.body.classList.toggle('menu-open');
}

// Search Toggle
function toggleSearch() {
    const searchDropdown = document.getElementById('search-dropdown');
    const searchField = searchDropdown.querySelector('input[type="search"]');
    
    if (searchDropdown.style.display === 'none') {
        searchDropdown.style.display = 'block';
        setTimeout(() => searchField.focus(), 100);
    } else {
        searchDropdown.style.display = 'none';
    }
}

// Close search on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('search-dropdown').style.display = 'none';
    }
});

// Sticky Navigation
let lastScroll = 0;
const mainNav = document.getElementById('main-navigation');

window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 100) {
        mainNav.classList.add('sticky');
        
        if (currentScroll > lastScroll) {
            mainNav.classList.add('hide');
        } else {
            mainNav.classList.remove('hide');
        }
    } else {
        mainNav.classList.remove('sticky');
        mainNav.classList.remove('hide');
    }
    
    lastScroll = currentScroll;
});

// Breaking News Ticker Animation
const ticker = document.querySelector('.ida-ticker');
if (ticker) {
    let scrollAmount = 0;
    const scrollSpeed = 1;
    
    function autoScroll() {
        scrollAmount += scrollSpeed;
        if (scrollAmount >= ticker.scrollWidth / 2) {
            scrollAmount = 0;
        }
        ticker.style.transform = `translateX(-${scrollAmount}px)`;
        requestAnimationFrame(autoScroll);
    }
    
    // Clone items for infinite scroll
    const tickerItems = ticker.innerHTML;
    ticker.innerHTML = tickerItems + tickerItems;
    
    autoScroll();
}
</script>

<?php
/**
 * Default menu fallback
 */
function ida_default_menu() {
    echo '<ul class="ida-menu">';
    echo '<li><a href="' . home_url('/') . '">Home</a></li>';
    
    $categories = get_categories(['number' => 5]);
    foreach ($categories as $category) {
        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
    }
    
    echo '</ul>';
}
?>
