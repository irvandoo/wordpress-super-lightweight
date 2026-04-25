<?php
/**
 * Test 404 Page
 * Quick test to preview 404 error page
 */

// Load WordPress
require_once('wp-load.php');

// Force 404 status
global $wp_query;
$wp_query->set_404();
status_header(404);
nocache_headers();

// Load 404 template
get_header();
include(get_template_directory() . '/404.php');

echo "\n\n<!-- 404 Page Test Successful -->\n";
echo "<!-- You can now test the actual 404 by visiting a non-existent URL -->\n";
echo "<!-- Example: " . home_url('/halaman-tidak-ada') . " -->\n";
