<?php
/**
 * Header Template
 * IDA Design System - Minimal Elite Header
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
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Skip to content', 'irvandoda-seo-light'); ?>
    </a>

    <header id="masthead" class="ida-header site-header">
        <div class="ida-container">
            <div class="ida-header-inner">
                
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="ida-logo" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php endif; ?>
                </div>

                <!-- Navigation -->
                <nav id="site-navigation" class="ida-nav main-navigation" aria-label="<?php esc_attr_e('Primary menu', 'irvandoda-seo-light'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'ida_fallback_menu',
                        'depth'          => 1, // Single level only
                    ]);
                    ?>
                    
                    <!-- Search Icon (Optional) -->
                    <button class="ida-search-toggle" onclick="toggleSearch()" aria-label="Search">
                        🔍
                    </button>
                </nav>

            </div>
        </div>
        
        <!-- Search Form (Hidden by default) -->
        <div class="ida-search-form" id="search-form" style="display: none;">
            <div class="ida-container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'irvandoda-seo-light'); ?></span>
                        <input type="search" 
                               class="search-field" 
                               placeholder="<?php echo esc_attr_x('Search articles...', 'placeholder', 'irvandoda-seo-light'); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" />
                    </label>
                    <input type="submit" class="search-submit" value="<?php echo esc_attr_x('Search', 'submit button', 'irvandoda-seo-light'); ?>" />
                </form>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">

<style>
/* Header Specific Styles */
.ida-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transition: var(--ida-transition);
}

.ida-header.scrolled {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.site-logo img {
    max-height: 40px;
    width: auto;
}

.ida-search-toggle {
    background: none;
    border: none;
    font-size: var(--ida-font-size-lg);
    cursor: pointer;
    padding: var(--ida-space-sm);
    border-radius: var(--ida-border-radius);
    transition: var(--ida-transition);
}

.ida-search-toggle:hover {
    background: var(--ida-accent-soft);
}

.ida-search-form {
    background: var(--ida-accent-soft);
    border-top: 1px solid var(--ida-border);
    padding: var(--ida-space-lg) 0;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-form {
    display: flex;
    gap: var(--ida-space-sm);
    max-width: 400px;
    margin: 0 auto;
}

.search-field {
    flex: 1;
    padding: var(--ida-space-sm) var(--ida-space-md);
    border: 1px solid var(--ida-border);
    border-radius: var(--ida-border-radius);
    font-size: var(--ida-font-size-sm);
}

.search-submit {
    padding: var(--ida-space-sm) var(--ida-space-lg);
    background: var(--ida-accent);
    color: white;
    border: none;
    border-radius: var(--ida-border-radius);
    cursor: pointer;
    font-weight: 500;
    transition: var(--ida-transition);
}

.search-submit:hover {
    background: #1d4ed8;
}

/* Mobile Header */
@media (max-width: 767px) {
    .ida-header-inner {
        padding: var(--ida-space-sm) 0;
    }
    
    .ida-logo {
        font-size: var(--ida-font-size-lg);
    }
    
    .ida-nav {
        gap: var(--ida-space-sm);
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .search-field,
    .search-submit {
        width: 100%;
    }
}

/* Skip Link */
.skip-link {
    position: absolute;
    left: -9999px;
    top: 1.5em;
    z-index: 999999;
    text-decoration: underline;
}

.skip-link:focus {
    background: var(--ida-accent);
    color: white;
    left: 6px;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: var(--ida-border-radius);
}

/* Screen Reader Text */
.screen-reader-text {
    border: 0;
    clip: rect(1px, 1px, 1px, 1px);
    clip-path: inset(50%);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute !important;
    width: 1px;
    word-wrap: normal !important;
}

.screen-reader-text:focus {
    background-color: #f1f1f1;
    border-radius: 3px;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
    clip: auto !important;
    clip-path: none;
    color: #21759b;
    display: block;
    font-size: 0.875rem;
    font-weight: 700;
    height: auto;
    left: 5px;
    line-height: normal;
    padding: 15px 23px 14px;
    text-decoration: none;
    top: 5px;
    width: auto;
    z-index: 100000;
}
</style>

<script>
// Header Scroll Effect
function handleHeaderScroll() {
    const header = document.querySelector('.ida-header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}

// Search Toggle
function toggleSearch() {
    const searchForm = document.getElementById('search-form');
    const searchField = searchForm.querySelector('.search-field');
    
    if (searchForm.style.display === 'none' || !searchForm.style.display) {
        searchForm.style.display = 'block';
        setTimeout(() => searchField.focus(), 100);
    } else {
        searchForm.style.display = 'none';
    }
}

// Event Listeners
window.addEventListener('scroll', handleHeaderScroll);

// Close search on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const searchForm = document.getElementById('search-form');
        searchForm.style.display = 'none';
    }
});

// Close search when clicking outside
document.addEventListener('click', function(e) {
    const searchForm = document.getElementById('search-form');
    const searchToggle = document.querySelector('.ida-search-toggle');
    
    if (!searchForm.contains(e.target) && !searchToggle.contains(e.target)) {
        searchForm.style.display = 'none';
    }
});
</script>

<?php
/**
 * Fallback menu if no menu is assigned
 */
function ida_fallback_menu() {
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
    if (get_option('show_on_front') === 'page') {
        echo '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Blog</a>';
    }
}
?>