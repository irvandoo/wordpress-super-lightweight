<?php
declare(strict_types=1);

/**
 * CTA Block Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

// Get CTA settings (can be customized via theme options or passed as args)
$cta_title = $args['title'] ?? __('Ready to Get Started?', 'irvandoda-seo-light');
$cta_text = $args['text'] ?? __('Join thousands of satisfied users today.', 'irvandoda-seo-light');
$cta_button_text = $args['button_text'] ?? __('Get Started', 'irvandoda-seo-light');
$cta_button_url = $args['button_url'] ?? home_url('/contact');
?>

<aside class="ida-cta">
    <div class="ida-cta-inner">
        <h2 class="ida-cta-title"><?php echo esc_html($cta_title); ?></h2>
        <p class="ida-cta-text"><?php echo esc_html($cta_text); ?></p>
        <a href="<?php echo esc_url($cta_button_url); ?>" class="ida-cta-button">
            <?php echo esc_html($cta_button_text); ?>
        </a>
    </div>
</aside>
