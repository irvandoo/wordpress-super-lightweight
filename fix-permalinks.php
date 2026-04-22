<?php
/**
 * Fix Permalinks and REST API
 * Run this file once to fix REST API 404 errors and permalink issues
 */

// Load WordPress
require_once('wp-load.php');

echo "=== WordPress Permalink & REST API Fix ===\n\n";

// Check current permalink structure
$current_permalink = get_option('permalink_structure');
echo "Current permalink structure: " . ($current_permalink ?: '(empty - using default)') . "\n";

// Check current site URL
$site_url = get_option('siteurl');
$home_url = get_option('home');
echo "Site URL: $site_url\n";
echo "Home URL: $home_url\n\n";

// Set permalink structure if empty
if (empty($current_permalink)) {
    echo "Setting permalink structure to: /%postname%/\n";
    update_option('permalink_structure', '/%postname%/');
    update_option('rewrite_rules', false);
}

// Update site URLs if needed
$correct_url = 'http://localhost/active/wordpress super lightweight';
if ($site_url !== $correct_url || $home_url !== $correct_url) {
    echo "Updating site URLs to: $correct_url\n";
    update_option('siteurl', $correct_url);
    update_option('home', $correct_url);
}

// Flush rewrite rules
echo "\nFlushing rewrite rules...\n";
flush_rewrite_rules(true);

// Verify REST API
echo "\nVerifying REST API...\n";
$rest_url = rest_url('wp/v2/users/me');
echo "REST API URL: $rest_url\n";

// Check if .htaccess is writable
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file)) {
    if (is_writable($htaccess_file)) {
        echo ".htaccess: Writable ✓\n";
        
        // Read current .htaccess
        $htaccess_content = file_get_contents($htaccess_file);
        echo "\nCurrent .htaccess RewriteBase:\n";
        if (preg_match('/RewriteBase\s+(.+)/', $htaccess_content, $matches)) {
            echo "  " . trim($matches[0]) . "\n";
        }
        
        // Check if it needs quotes
        if (strpos($htaccess_content, 'RewriteBase /active/wordpress%20super%20lightweight/') !== false) {
            echo "\n⚠️  .htaccess has URL-encoded path, fixing...\n";
            
            // Fix .htaccess
            $htaccess_content = str_replace(
                'RewriteBase /active/wordpress%20super%20lightweight/',
                'RewriteBase "/active/wordpress super lightweight/"',
                $htaccess_content
            );
            $htaccess_content = str_replace(
                'RewriteRule . /active/wordpress%20super%20lightweight/index.php [L]',
                'RewriteRule . "/active/wordpress super lightweight/index.php" [L]',
                $htaccess_content
            );
            
            file_put_contents($htaccess_file, $htaccess_content);
            echo ".htaccess fixed with quoted paths ✓\n";
        }
    } else {
        echo ".htaccess: Not writable ✗ (may need manual update)\n";
    }
} else {
    echo ".htaccess: Does not exist (will be created)\n";
}

// Test a sample post
echo "\nTesting sample post...\n";
$sample_post = get_posts(['numberposts' => 1, 'post_status' => 'publish']);
if (!empty($sample_post)) {
    $post_url = get_permalink($sample_post[0]->ID);
    echo "Sample post URL: $post_url\n";
    echo "Post title: " . $sample_post[0]->post_title . "\n";
}

echo "\n=== Fix Complete ===\n";
echo "Please refresh your WordPress admin page.\n";
echo "Try accessing a post URL to verify permalinks work.\n\n";
echo "You can delete this file (fix-permalinks.php) after running it.\n";
