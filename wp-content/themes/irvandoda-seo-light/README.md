# Irvandoda Full SEO Lightweight Theme

**Built for Speed, Structured for Ranking**

Ultra-lightweight WordPress theme optimized for Google PageSpeed 95-100, Core Web Vitals, and SEO.

## 🚀 Features

### Performance
- ✅ Google PageSpeed Score: 95-100 (mobile & desktop)
- ✅ Core Web Vitals Optimized (LCP < 1.8s, CLS = 0, INP < 100ms)
- ✅ No jQuery, no frameworks
- ✅ Total CSS < 40KB
- ✅ Total JS < 25KB
- ✅ Inline critical CSS
- ✅ Async CSS loading
- ✅ Deferred JavaScript
- ✅ Native lazy loading

### SEO
- ✅ Semantic HTML5
- ✅ Schema.org structured data (Article, Breadcrumb, Organization)
- ✅ Open Graph & Twitter Cards
- ✅ Auto-generated Table of Contents
- ✅ SEO-friendly breadcrumb navigation
- ✅ Reading time calculator
- ✅ Optimized meta tags

### Design
- ✅ Minimalist blog layout
- ✅ Mobile-first responsive design
- ✅ Max width: 720px (optimal readability)
- ✅ System fonts only
- ✅ Clean whitespace
- ✅ No layout shifts (CLS = 0)

### Developer-Friendly
- ✅ Hook system for plugin extensibility
- ✅ Namespace prefix: `ida_`
- ✅ Modular file structure
- ✅ Well-documented code
- ✅ WordPress coding standards

## 📦 Installation

1. Upload theme to `/wp-content/themes/`
2. Activate from WordPress admin
3. Done! Theme is production-ready

## 🎨 Customization

### Hooks Available

```php
// Content hooks
do_action('ida_before_content');
do_action('ida_after_content');

// Meta hooks
do_action('ida_meta');
do_action('ida_og');
do_action('ida_schema');
```

### Helper Functions

```php
// Reading time
ida_reading_time();

// Related posts
ida_related_posts($post_id, $limit);

// Breadcrumb
ida_breadcrumb();
```

## 📊 Performance Metrics

Expected results:
- **Page Load**: < 1 second
- **Database Queries**: < 20 per page
- **Memory Usage**: 32-64 MB
- **HTTP Requests**: 5-15 requests
- **TTFB**: < 200ms
- **FCP**: < 1.0s
- **LCP**: < 2.5s

## 🛠️ Technical Stack

- **PHP**: 8.5+ (optimized with strict types, return type declarations, match expressions)
- **WordPress**: 6.0+
- **CSS**: Pure CSS (no preprocessors)
- **JavaScript**: Vanilla JS (no libraries)
- **Fonts**: System fonts

## 🔥 PHP 8.5 Optimizations

This theme is fully optimized for PHP 8.5 with modern features:
- ✅ Strict type declarations (`declare(strict_types=1)`)
- ✅ Return type declarations for all functions
- ✅ Match expressions instead of if/switch
- ✅ Null coalescing assignment operator (`??=`)
- ✅ Union types and nullable types
- ✅ Short array syntax `[]`
- ✅ Named arguments for better readability
- ✅ All PHP 8.5 performance improvements

## 📝 File Structure

```
/irvandoda-seo-light/
├── style.css
├── functions.php
├── index.php
├── single.php
├── archive.php
├── search.php
├── 404.php
├── header.php
├── footer.php
├── /assets
│   ├── /css
│   │   ├── critical.css
│   │   └── main.min.css
│   └── /js
│       └── main.min.js
├── /inc
│   ├── setup.php
│   ├── enqueue.php
│   ├── performance.php
│   ├── seo.php
│   ├── schema.php
│   ├── toc.php
│   ├── breadcrumb.php
│   └── helpers.php
└── /template-parts
    ├── content.php
    ├── author-box.php
    ├── related-post.php
    └── cta.php
```

## 👨‍💻 Author

**Irvando Demas Arifiandani**
- Website: [irvandoda.my.id](https://irvandoda.my.id)
- Email: irvando.d.a@gmail.com
- WhatsApp: +62 857-4747-6308

## 📄 License

GNU General Public License v2 or later

## 🙏 Credits

Built with ❤️ for the WordPress community.

---

**Version**: 1.0.0  
**Last Updated**: 2026-04-21
