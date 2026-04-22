<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="ida-header" role="banner">
    <div class="ida-container">
        <div class="ida-header-inner">
            <div class="ida-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="ida-site-title" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if (has_nav_menu('primary')) : ?>
                <nav class="ida-nav" role="navigation" aria-label="Primary Navigation">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'ida-menu',
                        'fallback_cb' => false,
                        'depth' => 2
                    ]);
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</header>
