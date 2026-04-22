<?php
/**
 * WordPress Admin Access Guide
 * Instructions for accessing wp-admin
 */

echo "<h1>🔐 WordPress Admin Access Guide</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-left: 4px solid #2271b1; margin: 20px 0;'>";
echo "<h2>✅ Good News: wp-admin is Working!</h2>";
echo "<p>The 302 redirect to login page is <strong>normal behavior</strong>.</p>";
echo "</div>";

// Load WordPress to get admin info
require_once('wp-load.php');

echo "<h2>🚀 How to Access WordPress Admin:</h2>";

echo "<div style='background: #f0f6fc; padding: 15px; border: 1px solid #d1d9e0; border-radius: 6px; margin: 10px 0;'>";
echo "<h3>Method 1: Direct Login</h3>";
$login_url = wp_login_url();
echo "<p>1. Go to: <a href='$login_url' target='_blank'><strong>$login_url</strong></a></p>";
echo "<p>2. Enter your WordPress username and password</p>";
echo "<p>3. Click 'Log In'</p>";
echo "</div>";

echo "<div style='background: #fff8e1; padding: 15px; border: 1px solid #ffc107; border-radius: 6px; margin: 10px 0;'>";
echo "<h3>Method 2: Direct Admin URL</h3>";
$admin_url = admin_url();
echo "<p>1. Go to: <a href='$admin_url' target='_blank'><strong>$admin_url</strong></a></p>";
echo "<p>2. You'll be redirected to login page</p>";
echo "<p>3. Enter credentials and login</p>";
echo "</div>";

// Check if WordPress is installed
$users = get_users(['number' => 1]);
if (empty($users)) {
    echo "<div style='background: #ffebee; padding: 15px; border: 1px solid #f44336; border-radius: 6px; margin: 10px 0;'>";
    echo "<h3>⚠️ WordPress Not Installed Yet</h3>";
    echo "<p>It looks like WordPress installation is not complete.</p>";
    echo "<p><strong>Run WordPress Installation:</strong></p>";
    $install_url = site_url('wp-admin/install.php');
    echo "<p>1. Go to: <a href='$install_url' target='_blank'><strong>$install_url</strong></a></p>";
    echo "<p>2. Follow the 5-minute installation wizard</p>";
    echo "<p>3. Create admin username and password</p>";
    echo "<p>4. Then you can access wp-admin</p>";
    echo "</div>";
} else {
    $admin_user = $users[0];
    echo "<div style='background: #e8f5e8; padding: 15px; border: 1px solid #4caf50; border-radius: 6px; margin: 10px 0;'>";
    echo "<h3>✅ WordPress is Installed</h3>";
    echo "<p>Admin user exists: <strong>" . $admin_user->user_login . "</strong></p>";
    echo "<p>You can login with your credentials.</p>";
    echo "</div>";
}

echo "<h2>🔧 Quick Links:</h2>";
echo "<ul>";
echo "<li><a href='" . wp_login_url() . "' target='_blank'>WordPress Login</a></li>";
echo "<li><a href='" . admin_url() . "' target='_blank'>WordPress Admin Dashboard</a></li>";
echo "<li><a href='" . site_url() . "' target='_blank'>Website Homepage</a></li>";
echo "</ul>";

echo "<h2>🛠️ Troubleshooting:</h2>";
echo "<div style='background: #f8f9fa; padding: 15px; border: 1px solid #dee2e6; border-radius: 6px;'>";
echo "<h3>If you forgot your password:</h3>";
echo "<p>1. Go to login page</p>";
echo "<p>2. Click 'Lost your password?'</p>";
echo "<p>3. Enter your username or email</p>";
echo "<p>4. Check email for reset link</p>";

echo "<h3>If you forgot your username:</h3>";
echo "<p>Check your database table: <code>wp_users</code></p>";
echo "<p>Or create a new admin user via functions.php</p>";
echo "</div>";

echo "<hr>";
echo "<p><em>Created by: <a href='https://irvandoda.my.id' target='_blank'>Irvandoda</a></em></p>";