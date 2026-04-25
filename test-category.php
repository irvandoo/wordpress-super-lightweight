<?php
/**
 * Test Category Page
 * Quick test to see if category.php template works
 */

// Load WordPress
require_once('wp-load.php');

// Get first category
$categories = get_categories(['number' => 1, 'hide_empty' => true]);

if (!empty($categories)) {
    $category = $categories[0];
    echo "Testing category: " . $category->name . "\n";
    echo "Category URL: " . get_category_link($category->term_id) . "\n\n";
    
    // Test query
    $args = [
        'cat' => $category->term_id,
        'posts_per_page' => 5,
        'post_status' => 'publish'
    ];
    
    $query = new WP_Query($args);
    
    echo "Found posts: " . $query->found_posts . "\n";
    
    if ($query->have_posts()) {
        echo "\nPosts in this category:\n";
        while ($query->have_posts()) {
            $query->the_post();
            echo "- " . get_the_title() . "\n";
        }
        wp_reset_postdata();
    }
    
    echo "\n✅ Category query works!\n";
    echo "\nNow test the actual URL: " . get_category_link($category->term_id) . "\n";
} else {
    echo "❌ No categories found. Run seeder first.\n";
}
