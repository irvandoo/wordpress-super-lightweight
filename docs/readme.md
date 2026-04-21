# WordPress 6.9.4 - Project Documentation

## Overview

Ini adalah instalasi WordPress versi 6.9.4 dengan locale Indonesia (id_ID). WordPress adalah Content Management System (CMS) open-source yang paling populer di dunia, digunakan oleh lebih dari 40% website di internet.

## Quick Info

- **Version:** 6.9.4
- **Database Version:** 60717
- **Locale:** Indonesian (id_ID)
- **PHP Required:** 7.2.24+
- **MySQL Required:** 5.5.5+
- **License:** GPL v2 or later

## Project Status

### ✅ Installed Components:
- WordPress Core 6.9.4
- Default themes (Twenty Twenty-Two through Twenty Twenty-Five)
- Akismet plugin (anti-spam)
- Hello Dolly plugin (example)

### ⚠️ Pending Setup:
- wp-config.php (needs to be created from wp-config-sample.php)
- Database connection
- Admin user creation
- Site configuration

## Documentation Structure

Dokumentasi project ini tersimpan di folder `/docs` dengan struktur sebagai berikut:

### 📁 Available Documentation:

1. **struktur.md** - Project structure & architecture
   - Directory organization
   - Core components
   - File hierarchy
   - System architecture

2. **fitur.md** - Features & capabilities
   - Block editor (110+ blocks)
   - REST API
   - Full Site Editing
   - All WordPress features

3. **library.md** - Libraries & dependencies
   - Built-in libraries
   - JavaScript frameworks
   - PHP extensions
   - Third-party integrations

4. **database.md** - Database structure
   - Table schemas
   - Relationships
   - Optimization tips
   - Backup strategies

5. **readme.md** - This file
   - Project overview
   - Quick start guide
   - Documentation index

6. **rulesdocs.md** - Change log & history
   - All project changes
   - Modification tracking
   - Update history

## Quick Start Guide

### 1. Database Setup

Create a MySQL database:
```sql
CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'wp_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON wordpress_db.* TO 'wp_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Configuration

Copy and configure wp-config.php:
```bash
cp wp-config-sample.php wp-config.php
```

Edit wp-config.php and set:
- Database name
- Database username
- Database password
- Database host
- Authentication keys (generate at https://api.wordpress.org/secret-key/1.1/salt/)
- Table prefix (optional, default: wp_)

### 3. Installation

Visit your site URL in browser:
```
http://your-domain.com/
```

Follow the 5-minute installation wizard:
1. Select language
2. Enter site information
3. Create admin account
4. Install WordPress

### 4. Post-Installation

After installation:
1. Login to admin dashboard (/wp-admin)
2. Configure permalinks (Settings → Permalinks)
3. Set timezone (Settings → General)
4. Configure reading settings
5. Install additional plugins/themes as needed

## Key Features

### Block Editor (Gutenberg)
- 110+ core blocks
- Drag & drop interface
- Real-time preview
- Reusable blocks
- Block patterns

### Full Site Editing
- Block-based themes
- Template editor
- Global styles
- Style variations
- Template parts

### REST API
- Full CRUD operations
- Custom endpoints
- Authentication support
- JSON responses
- Extensive documentation

### Performance
- Object caching
- Lazy loading
- Asset optimization
- CDN ready
- Speculative loading

### Security
- Regular updates
- Password hashing
- Nonce verification
- Data sanitization
- Application passwords
- Recovery mode

## Development

### Local Development Setup

1. **Requirements:**
   - PHP 7.2.24+
   - MySQL 5.5.5+ or MariaDB 10.0+
   - Apache/Nginx web server
   - mod_rewrite enabled

2. **Recommended Tools:**
   - Local development environment (XAMPP, MAMP, Laragon, Local)
   - Code editor (VS Code, PhpStorm)
   - WP-CLI (command-line interface)
   - Git for version control

3. **Debug Mode:**
   Add to wp-config.php:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   define('SCRIPT_DEBUG', true);
   ```

### Plugin Development

Create plugin in `wp-content/plugins/`:
```php
<?php
/**
 * Plugin Name: My Custom Plugin
 * Description: Plugin description
 * Version: 1.0.0
 * Author: Your Name
 */

// Your code here
```

### Theme Development

Create theme in `wp-content/themes/`:
```
my-theme/
├── style.css (required)
├── index.php (required)
├── functions.php
├── header.php
├── footer.php
├── sidebar.php
└── ...
```

Or use block theme structure:
```
my-block-theme/
├── style.css
├── theme.json
├── templates/
│   ├── index.html
│   └── ...
└── parts/
    ├── header.html
    └── footer.html
```

## File Structure

```
wpku/
├── wp-admin/          # Admin dashboard
├── wp-content/        # User content
│   ├── plugins/       # Plugins
│   ├── themes/        # Themes
│   ├── uploads/       # Media files
│   └── languages/     # Translations
├── wp-includes/       # Core files
├── docs/              # Documentation
├── index.php          # Entry point
├── wp-config.php      # Configuration (create this)
└── ...
```

## Important Files

- **wp-config.php** - Main configuration file
- **wp-settings.php** - Core initialization
- **.htaccess** - Rewrite rules (Apache)
- **index.php** - Entry point
- **wp-load.php** - Bootstrap file

## Common Tasks

### Update WordPress
1. Backup database and files
2. Update via dashboard (Dashboard → Updates)
3. Or manually download and replace files
4. Run database upgrade if needed

### Install Plugin
1. Dashboard → Plugins → Add New
2. Search or upload plugin
3. Click Install
4. Activate plugin

### Install Theme
1. Dashboard → Appearance → Themes → Add New
2. Search or upload theme
3. Click Install
4. Activate theme

### Backup Site
1. Export database (phpMyAdmin or WP-CLI)
2. Copy wp-content/ directory
3. Save wp-config.php
4. Store backups securely

### Migrate Site
1. Backup source site
2. Create database on destination
3. Import database
4. Copy files
5. Update wp-config.php
6. Search & replace URLs in database
7. Update permalinks

## Security Best Practices

1. **Keep Updated:**
   - WordPress core
   - Plugins
   - Themes
   - PHP version

2. **Strong Credentials:**
   - Complex passwords
   - Unique usernames
   - Two-factor authentication

3. **File Permissions:**
   - Directories: 755
   - Files: 644
   - wp-config.php: 600

4. **Security Plugins:**
   - Wordfence
   - Sucuri
   - iThemes Security

5. **Regular Backups:**
   - Daily database backups
   - Weekly file backups
   - Off-site storage

6. **SSL Certificate:**
   - Use HTTPS
   - Force SSL in wp-config.php
   - Update URLs to HTTPS

## Performance Optimization

1. **Caching:**
   - Object cache (Redis/Memcached)
   - Page cache (WP Super Cache, W3 Total Cache)
   - Browser caching

2. **CDN:**
   - CloudFlare
   - Amazon CloudFront
   - KeyCDN

3. **Image Optimization:**
   - Compress images
   - Use WebP format
   - Lazy loading
   - Responsive images

4. **Database:**
   - Optimize tables
   - Clean revisions
   - Remove spam comments
   - Delete transients

5. **Code:**
   - Minify CSS/JS
   - Combine files
   - Remove unused plugins
   - Optimize queries

## Troubleshooting

### White Screen of Death
1. Enable WP_DEBUG
2. Check error logs
3. Disable plugins
4. Switch to default theme
5. Increase memory limit

### Database Connection Error
1. Check wp-config.php credentials
2. Verify database server is running
3. Check database user privileges
4. Repair database

### 404 Errors
1. Reset permalinks (Settings → Permalinks → Save)
2. Check .htaccess file
3. Verify mod_rewrite is enabled

### Plugin Conflicts
1. Deactivate all plugins
2. Activate one by one
3. Identify conflicting plugin
4. Contact plugin author or find alternative

## Resources

### Official Resources:
- **WordPress.org:** https://wordpress.org/
- **Codex:** https://codex.wordpress.org/
- **Developer Docs:** https://developer.wordpress.org/
- **Support Forums:** https://wordpress.org/support/
- **Plugin Directory:** https://wordpress.org/plugins/
- **Theme Directory:** https://wordpress.org/themes/

### Learning Resources:
- **WordPress TV:** https://wordpress.tv/
- **Learn WordPress:** https://learn.wordpress.org/
- **WPBeginner:** https://www.wpbeginner.com/
- **WP Tavern:** https://wptavern.com/

### Development Tools:
- **WP-CLI:** https://wp-cli.org/
- **Query Monitor:** Plugin for debugging
- **Debug Bar:** Plugin for debugging
- **Theme Check:** Plugin for theme review

## Support

### Getting Help:
1. Check documentation (this folder)
2. Search WordPress.org forums
3. Check plugin/theme support forums
4. Stack Overflow (tag: wordpress)
5. WordPress Facebook groups
6. Local WordPress meetups

### Reporting Issues:
- Core issues: https://core.trac.wordpress.org/
- Plugin issues: Plugin support forum
- Theme issues: Theme support forum

## Contributing

WordPress is open-source. Contribute by:
1. Reporting bugs
2. Suggesting features
3. Writing documentation
4. Translating WordPress
5. Contributing code
6. Testing beta versions

## License

WordPress is released under GPL v2 or later.
- Free to use
- Free to modify
- Free to distribute
- Must remain GPL

## Version History

- **6.9.4** - Current version (Security & bug fixes)
- **6.9.0** - Major release (Accordion blocks, Abilities API)
- **6.8.0** - Previous major release
- See full changelog: https://wordpress.org/news/category/releases/

## Next Steps

1. ✅ Read this documentation
2. ⚠️ Create wp-config.php
3. ⚠️ Run installation wizard
4. ⚠️ Configure basic settings
5. ⚠️ Install essential plugins
6. ⚠️ Choose and customize theme
7. ⚠️ Create content
8. ⚠️ Launch site

## Contact & Maintenance

### Maintenance Schedule:
- **Daily:** Monitor site health
- **Weekly:** Check for updates
- **Monthly:** Full backup
- **Quarterly:** Security audit
- **Yearly:** Performance review

### Important Notes:
- Keep this documentation updated
- Document all customizations
- Track plugin/theme versions
- Maintain changelog in rulesdocs.md
- Regular security audits
- Performance monitoring

---

**Last Updated:** 2026-04-21
**WordPress Version:** 6.9.4
**Documentation Version:** 1.0.0
