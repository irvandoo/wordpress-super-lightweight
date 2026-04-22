<?php
/**
 * Test Theme Loading
 */

echo "<h1>Theme Loading Test</h1>";

// Test 1: Load WordPress
echo "<h2>Test 1: Load WordPress</h2>";
try {
    require_once('wp-load.php');
    echo "✓ WordPress loaded successfully<br>";
} catch (Exception $e) {
    echo "✗ WordPress load failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Check active theme
echo "<h2>Test 2: Active Theme</h2>";
$theme = wp_get_theme();
echo "Active theme: " . $theme->get('Name') . "<br>";
echo "Theme version: " . $theme->get('Version') . "<br>";
echo "Theme path: " . get_template_directory() . "<br>";

// Test 3: Check theme files
echo "<h2>Test 3: Theme Files</h2>";
$theme_files = [
    'style.css',
    'index.php',
    'functions.php',
    'header.php',
    'footer.php',
    'single.php'
];

foreach ($theme_files as $file) {
    $file_path = get_template_directory() . '/' . $file;
    if (file_exists($file_path)) {
        echo "✓ $file exists<br>";
    } else {
        echo "✗ $file missing<br>";
    }
}

// Test 4: Check functions
echo "<h2>Test 4: Theme Functions</h2>";
$functions = [
    'ida_get_reading_time',
    'ida_generate_toc',
    'ida_breadcrumb',
    'ida_theme_setup'
];

foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "✓ $func() exists<br>";
    } else {
        echo "✗ $func() missing<br>";
    }
}

// Test 5: Try to load index template
echo "<h2>Test 5: Template Loading</h2>";
try {
    ob_start();
    include get_template_directory() . '/index.php';
    $output = ob_get_clean();
    echo "✓ Index template loaded successfully<br>";
    echo "Output length: " . strlen($output) . " characters<br>";
} catch (Exception $e) {
    echo "✗ Index template failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>If all tests pass, try accessing the homepage.</strong></p>";