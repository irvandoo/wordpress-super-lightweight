<?php
/**
 * IDA Design System Test Page
 * Test visual appearance and functionality
 */

// WordPress environment
require_once 'wp-config.php';
require_once ABSPATH . 'wp-settings.php';

// Set current theme
switch_theme('irvandoda-seo-light');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDA Design System Test</title>
    <link rel="stylesheet" href="wp-content/themes/irvandoda-seo-light/assets/css/ida-design-system.css">
    <style>
        body { margin: 0; padding: 20px; }
        .test-section { margin: 40px 0; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .test-title { color: #2563eb; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="ida-container">
        <h1>🎨 IDA Design System Test</h1>
        <p>Testing visual components and functionality...</p>

        <!-- Header Test -->
        <div class="test-section">
            <h2 class="test-title">Header Component</h2>
            <header class="ida-header">
                <div class="ida-header-inner ida-container">
                    <a href="#" class="ida-logo">Irvandoda</a>
                    <nav class="ida-nav">
                        <a href="#" class="ida-nav-link">Home</a>
                        <a href="#" class="ida-nav-link">About</a>
                        <a href="#" class="ida-nav-link">Contact</a>
                    </nav>
                </div>
            </header>
        </div>

        <!-- Hero Test -->
        <div class="test-section">
            <h2 class="test-title">Hero Section</h2>
            <section class="ida-hero">
                <h1 class="ida-hero-title">Welcome to IDA Design System</h1>
                <div class="ida-hero-meta">
                    <span>Built for Speed, Structured for Ranking</span>
                </div>
            </section>
        </div>

        <!-- Card Test -->
        <div class="test-section">
            <h2 class="test-title">Card Components</h2>
            <div class="ida-grid ida-grid-3">
                <article class="ida-card ida-hover-lift">
                    <div class="ida-card-content">
                        <h3 class="ida-card-title">
                            <a href="#">Sample Article Title</a>
                        </h3>
                        <div class="ida-card-meta">
                            <time>April 22, 2026</time>
                            <span class="ida-reading-time">5 min read</span>
                        </div>
                        <p class="ida-card-excerpt">This is a sample excerpt to test the card layout and typography system...</p>
                    </div>
                </article>
                
                <article class="ida-card ida-hover-lift">
                    <div class="ida-card-content">
                        <h3 class="ida-card-title">
                            <a href="#">Another Article</a>
                        </h3>
                        <div class="ida-card-meta">
                            <time>April 21, 2026</time>
                            <span class="ida-reading-time">3 min read</span>
                        </div>
                        <p class="ida-card-excerpt">Testing responsive grid layout and visual consistency...</p>
                    </div>
                </article>
            </div>
        </div>

        <!-- Typography Test -->
        <div class="test-section">
            <h2 class="test-title">Typography System</h2>
            <h1>H1 Heading (34px)</h1>
            <h2>H2 Heading (28px)</h2>
            <h3>H3 Heading (24px)</h3>
            <p>Body text (16px) with proper line height for optimal readability. This paragraph demonstrates the typography system in action.</p>
            <p class="ida-text-muted">Muted text for secondary information.</p>
        </div>

        <!-- Button Test -->
        <div class="test-section">
            <h2 class="test-title">Button Components</h2>
            <button class="ida-btn ida-btn-primary">Primary Button</button>
            <button class="ida-btn ida-btn-secondary">Secondary Button</button>
            <a href="#" class="ida-btn ida-btn-outline">Outline Button</a>
        </div>

        <!-- CTA Block Test -->
        <div class="test-section">
            <h2 class="test-title">CTA Block</h2>
            <div class="ida-cta-block">
                <h3 class="ida-cta-title">Ready to Get Started?</h3>
                <p class="ida-cta-text">Join thousands of users who trust our platform.</p>
                <a href="#" class="ida-btn ida-btn-primary">Get Started Now</a>
            </div>
        </div>

        <!-- Breadcrumb Test -->
        <div class="test-section">
            <h2 class="test-title">Breadcrumb Navigation</h2>
            <div class="ida-breadcrumb">
                <a href="#">Home</a>
                <span class="ida-breadcrumb-separator">›</span>
                <a href="#">Category</a>
                <span class="ida-breadcrumb-separator">›</span>
                <span>Current Page</span>
            </div>
        </div>

        <!-- TOC Test -->
        <div class="test-section">
            <h2 class="test-title">Table of Contents</h2>
            <div class="ida-toc">
                <h3 class="ida-toc-title">Table of Contents</h3>
                <ol class="ida-toc-list">
                    <li><a href="#section1">Introduction</a></li>
                    <li><a href="#section2">Getting Started</a></li>
                    <li><a href="#section3">Advanced Features</a></li>
                    <li><a href="#section4">Conclusion</a></li>
                </ol>
            </div>
        </div>

        <!-- Footer Test -->
        <div class="test-section">
            <h2 class="test-title">Footer Component</h2>
            <footer class="ida-footer">
                <div class="ida-footer-content ida-container">
                    <p>&copy; 2026 Irvandoda. Built with IDA Design System.</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        console.log('✅ IDA Design System Test Page Loaded');
        console.log('🎨 CSS Variables:', getComputedStyle(document.documentElement).getPropertyValue('--ida-accent'));
    </script>
</body>
</html>