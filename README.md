# WordPress Super Lightweight

> **WordPress 6.9.4 Super Lightweight** - SEO-Optimized Theme with IDA Design System  
> *Zero Distraction, Full Conversion.*

[![WordPress](https://img.shields.io/badge/WordPress-6.9.4-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.5+-purple.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-9.1.0-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](LICENSE)

## 🚀 Overview

WordPress Super Lightweight adalah instalasi WordPress 6.9.4 yang telah dioptimasi dengan **IDA Design System** - sebuah framework desain yang fokus pada performa, SEO, dan konversi. Theme ini dibangun dengan filosofi **Content-First** dan **Zero Distraction** untuk meningkatkan Dwell Time, CTR, dan dominasi SERP Google.

## ✨ Key Features

### 🎨 IDA Design System
- **Professional Homepage** - Hero section, category sections, featured cards
- **Single Post Template** - Reading progress bar, Smart TOC, rating block
- **Category Archive** - Featured layout with responsive grid
- **404 Error Page** - User-friendly with search and article suggestions
- **Mobile Responsive** - Optimized for all devices

### ⚡ Performance Optimizations
- **Lightweight Core** - Minimal dependencies, no bloat
- **Optimized Assets** - Deferred JavaScript, minified CSS
- **Clean Console** - Suppressed unnecessary warnings
- **Fast Loading** - Optimized for Core Web Vitals

### 🔍 SEO Features
- **Structured Data** - JSON-LD schema markup
- **Smart TOC** - Collapsible table of contents
- **Breadcrumb Navigation** - Clear site hierarchy
- **Reading Time** - Estimated reading duration
- **Related Posts** - Internal linking suggestions

### 📱 User Experience
- **Breaking News Ticker** - Marquee-style with configurable speed
- **Mobile Hamburger Menu** - Slide-in navigation
- **Theme Options Panel** - Comprehensive admin settings
- **Custom Comment Template** - Professional comment layout

## 📋 Requirements

- **WordPress**: 6.9.4+
- **PHP**: 8.5.0+
- **MySQL**: 8.0+ (Recommended: 9.1.0)
- **Server**: Apache/Nginx with mod_rewrite

## 🛠️ Installation

### Quick Start

1. **Clone Repository**
   ```bash
   git clone https://github.com/irvandoo/wordpress-super-lightweight.git
   cd wordpress-super-lightweight
   ```

2. **Configure WordPress**
   ```bash
   cp wp-config-sample.php wp-config.php
   # Edit wp-config.php with your database credentials
   ```

3. **Set Permissions**
   ```bash
   chmod 755 wp-content
   chmod 644 wp-config.php
   ```

4. **Install WordPress**
   - Visit your site URL
   - Complete WordPress installation wizard
   - Activate "Irvandoda SEO Light" theme

### Theme Activation

1. Go to **Appearance → Themes**
2. Activate **Irvandoda SEO Light**
3. Configure settings at **Appearance → Theme Options**

## 🎯 Theme Structure

```
wp-content/themes/irvandoda-seo-light/
├── assets/
│   └── css/
│       └── ida-design-system.css    # Main design system CSS
├── inc/
│   ├── admin.php                    # Admin customizations
│   ├── admin-style.php              # Admin panel styling
│   ├── branding.php                 # WordPress branding
│   └── theme-options.php            # Theme settings panel
├── 404.php                          # Error page template
├── category.php                     # Category archive template
├── footer.php                       # Footer template
├── functions.php                    # Theme functions
├── header.php                       # Header template
├── index.php                        # Homepage template
├── single.php                       # Single post template
└── style.css                        # Theme stylesheet
```

## ⚙️ Configuration

### Theme Options

Access theme settings at **Appearance → Theme Options**:

#### General Settings
- Top header text
- Footer tagline

#### Ticker Settings
- Enable/disable ticker
- Ticker label text
- Scroll speed (10-200 px/s)
- Number of posts (1-20)

#### Hero Section
- Hero title
- Hero description
- CTA button text & link
- Trust signal text

#### CTA Section
- CTA title
- CTA description
- Button text & link

### Navigation Menus

Configure menus at **Appearance → Menus**:
- **Top Menu** - Header top bar
- **Primary Menu** - Main navigation
- **Footer Menu** - Footer links

### Widget Areas

Available widget areas:
- **Header Ad** - 728x90 leaderboard
- **Content Ad 1** - In-content advertising
- **Sidebar** - General sidebar widgets

## 🎨 Design System

### Color Palette

```css
--ida-bg: #ffffff;           /* Background */
--ida-bg-soft: #f8fafc;      /* Soft background */
--ida-text: #111111;         /* Primary text */
--ida-text-light: #374151;   /* Secondary text */
--ida-muted: #6b7280;        /* Muted text */
--ida-accent: #2563eb;       /* Accent color */
--ida-accent-soft: #eff6ff;  /* Soft accent */
--ida-border: #e5e7eb;       /* Border color */
```

### Typography

- **Font Family**: System UI stack for optimal performance
- **Base Size**: 16px
- **Line Height**: 1.7 for readability
- **Headings**: -0.02em letter spacing for modern look

### Spacing System

```css
--sp-1: 4px;    /* Extra small */
--sp-2: 8px;    /* Small */
--sp-3: 16px;   /* Medium */
--sp-4: 24px;   /* Large */
--sp-5: 32px;   /* Extra large */
--sp-6: 48px;   /* 2X large */
--sp-7: 64px;   /* 3X large */
--sp-8: 96px;   /* 4X large */
```

## 📊 Performance

### Optimization Features

- ✅ **Deferred JavaScript** - Non-blocking script loading
- ✅ **Minified Assets** - Reduced file sizes
- ✅ **No jQuery Migrate** - Removed unnecessary dependencies
- ✅ **Disabled Emojis** - Removed emoji scripts
- ✅ **Clean Headers** - Removed unnecessary meta tags
- ✅ **Optimized Images** - Responsive image sizes

### Core Web Vitals

Optimized for:
- **LCP** (Largest Contentful Paint) - Fast hero loading
- **FID** (First Input Delay) - Minimal JavaScript
- **CLS** (Cumulative Layout Shift) - Fixed layouts

## 🔒 Security

### Security Features

- ✅ **Security Headers** - X-Frame-Options, X-Content-Type-Options
- ✅ **Version Hiding** - Removed WordPress version from assets
- ✅ **Clean wp-config** - Proper file permissions
- ✅ **Input Sanitization** - All user inputs sanitized
- ✅ **Output Escaping** - All outputs escaped

### Best Practices

1. Keep WordPress core updated
2. Use strong passwords
3. Limit login attempts
4. Regular backups
5. SSL certificate (HTTPS)

## 🧪 Testing

### Test Files Included

- `test-404.php` - Preview 404 error page
- `test-category.php` - Test category queries
- `test-theme.php` - Theme functionality test

### Browser Compatibility

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers

## 📝 Changelog

### Version 1.0.0 (2026-04-24)

#### Added
- Professional 404 error page with search and suggestions
- Category archive template with featured layout
- Enhanced console error suppression
- Mobile hamburger menu with slide-in animation
- Breaking news ticker with marquee effect
- Theme options admin panel
- Single post template with reading progress
- Homepage with category sections

#### Fixed
- Console errors (SES lockdown, jQuery migrate)
- Category page 500 errors
- Mobile responsiveness issues

#### Optimized
- CSS delivery and minification
- JavaScript loading (deferred)
- Image sizes and formats
- Database queries

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details.

## 👤 Author

**Irvando Demas Arifiandani**
- GitHub: [@irvandoo](https://github.com/irvandoo)

## 🙏 Acknowledgments

- WordPress Core Team
- IDA Design System
- Open Source Community

## 📞 Support

For support, please open an issue in the GitHub repository.

---

**Made with ❤️ for SEO Specialists**  
*Zero Distraction, Full Conversion.*
