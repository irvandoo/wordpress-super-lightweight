<?php
declare(strict_types=1);

/**
 * Author Box Template
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$author_url = get_author_posts_url($author_id);
$author_avatar = get_avatar($author_id, 80);
?>

<div class="ida-author-box" itemscope itemtype="https://schema.org/Person">
    <div class="ida-author-avatar">
        <a href="<?php echo esc_url($author_url); ?>" itemprop="url">
            <?php echo $author_avatar; ?>
        </a>
    </div>
    
    <div class="ida-author-info">
        <h3 class="ida-author-name">
            <a href="<?php echo esc_url($author_url); ?>" itemprop="url">
                <span itemprop="name"><?php echo esc_html($author_name); ?></span>
            </a>
        </h3>
        
        <?php if ($author_bio) : ?>
            <p class="ida-author-bio" itemprop="description"><?php echo esc_html($author_bio); ?></p>
        <?php endif; ?>
        
        <?php
        $social = ida_author_social_links($author_id);
        if (!empty($social)) :
        ?>
            <div class="ida-author-social">
                <?php foreach ($social as $network => $url) : ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($network); ?>">
                        <?php echo esc_html(ucfirst($network)); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
