# Migration Guide - WordPress 6.9.4

## Overview
Panduan lengkap untuk migrasi WordPress site dari satu environment ke environment lain (local ke staging, staging ke production, atau antar server).

## Pre-Migration Checklist

### ✅ Before Starting:
- [ ] Backup source site (database + files)
- [ ] Verify backup integrity
- [ ] Check PHP version compatibility
- [ ] Check MySQL version compatibility
- [ ] Verify disk space on destination
- [ ] Note current WordPress version
- [ ] List all active plugins
- [ ] List active theme
- [ ] Document custom configurations
- [ ] Check file permissions
- [ ] Verify SSL certificate (if applicable)

## Migration Methods

### Method 1: Manual Migration (Recommended for Full Control)

#### Step 1: Backup Source Site

**Database Backup:**
```bash
# Via mysqldump
mysqldump -u username -p database_name > backup.sql

# Or via WP-CLI
wp db export backup.sql
```

**Files Backup:**
```bash
# Backup wp-content directory
tar -czf wp-content-backup.tar.gz wp-content/

# Backup entire WordPress installation
tar -czf wordpress-full-backup.tar.gz .
```

**What to Backup:**
- Database (complete)
- `wp-content/` directory (themes, plugins, uploads)
- `wp-config.php` file
- `.htaccess` file (if exists)
- Any custom files in root directory

#### Step 2: Prepare Destination

**Create Database:**
```sql
CREATE DATABASE new_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'new_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON new_database_name.* TO 'new_user'@'localhost';
FLUSH PRIVILEGES;
```

**Upload Files:**
```bash
# Via FTP/SFTP
# Upload all files to destination server

# Or via rsync
rsync -avz --progress /source/path/ user@destination:/path/
```

#### Step 3: Import Database

**Via MySQL Command:**
```bash
mysql -u username -p database_name < backup.sql
```

**Via phpMyAdmin:**
1. Login to phpMyAdmin
2. Select database
3. Click Import tab
4. Choose backup.sql file
5. Click Go

**Via WP-CLI:**
```bash
wp db import backup.sql
```

#### Step 4: Update wp-config.php

Edit `wp-config.php` with new database credentials:
```php
define('DB_NAME', 'new_database_name');
define('DB_USER', 'new_user');
define('DB_PASSWORD', 'new_password');
define('DB_HOST', 'localhost'); // or new host
```

Update authentication keys (generate new ones):
```php
define('AUTH_KEY',         'new-unique-key');
define('SECURE_AUTH_KEY',  'new-unique-key');
define('LOGGED_IN_KEY',    'new-unique-key');
define('NONCE_KEY',        'new-unique-key');
define('AUTH_SALT',        'new-unique-key');
define('SECURE_AUTH_SALT', 'new-unique-key');
define('LOGGED_IN_SALT',   'new-unique-key');
define('NONCE_SALT',       'new-unique-key');
```

#### Step 5: Search & Replace URLs

**Important Tables to Update:**
- `wp_options` (siteurl, home)
- `wp_posts` (post_content, guid)
- `wp_postmeta` (meta_value)
- `wp_usermeta` (meta_value)
- `wp_comments` (comment_content)
- `wp_commentmeta` (meta_value)

**Via WP-CLI (Recommended):**
```bash
wp search-replace 'http://old-domain.com' 'http://new-domain.com' --all-tables
```

**Via SQL (Manual):**
```sql
-- Update site URL
UPDATE wp_options SET option_value = 'http://new-domain.com' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'http://new-domain.com' WHERE option_name = 'home';

-- Update post content
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://old-domain.com', 'http://new-domain.com');

-- Update post meta
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://old-domain.com', 'http://new-domain.com');

-- Update GUIDs (optional, not recommended by WordPress)
-- UPDATE wp_posts SET guid = REPLACE(guid, 'http://old-domain.com', 'http://new-domain.com');
```

**Via Plugin:**
- Better Search Replace
- Velvet Blues Update URLs
- WP Migrate DB

**⚠️ Warning:** Be careful with serialized data! Use proper tools.

#### Step 6: Update File Paths

If upload directory path changed:
```sql
UPDATE wp_options SET option_value = '/new/path/to/uploads' WHERE option_name = 'upload_path';
```

#### Step 7: Fix Permissions

```bash
# Directories
find . -type d -exec chmod 755 {} \;

# Files
find . -type f -exec chmod 644 {} \;

# wp-config.php
chmod 600 wp-config.php

# .htaccess
chmod 644 .htaccess
```

#### Step 8: Regenerate .htaccess

1. Login to WordPress admin
2. Go to Settings → Permalinks
3. Click "Save Changes" (without changing anything)
4. This regenerates .htaccess with correct rules

#### Step 9: Clear Caches

```bash
# Via WP-CLI
wp cache flush

# Or manually delete cache files
rm -rf wp-content/cache/*
```

**Clear Browser Cache:**
- Hard refresh (Ctrl+F5 / Cmd+Shift+R)
- Clear browser cache completely

**Clear CDN Cache:**
- Purge CloudFlare cache
- Purge other CDN caches

#### Step 10: Test Everything

**Checklist:**
- [ ] Homepage loads correctly
- [ ] Admin dashboard accessible
- [ ] Can login with existing credentials
- [ ] All pages load correctly
- [ ] All posts load correctly
- [ ] Images display correctly
- [ ] Internal links work
- [ ] External links work
- [ ] Forms work (contact, search, etc.)
- [ ] Comments work
- [ ] Media uploads work
- [ ] Plugins function correctly
- [ ] Theme displays correctly
- [ ] Mobile responsive works
- [ ] SSL certificate works (if HTTPS)
- [ ] Email notifications work
- [ ] Cron jobs work
- [ ] Search functionality works
- [ ] User registration works (if enabled)
- [ ] Payment gateway works (if e-commerce)

### Method 2: Plugin-Based Migration

#### Recommended Plugins:

**1. Duplicator**
- Free & Pro versions
- Creates package of site
- Handles search/replace automatically
- Good for beginners

**Steps:**
1. Install Duplicator on source site
2. Create package (database + files)
3. Download package + installer
4. Upload to destination server
5. Run installer.php
6. Follow wizard
7. Delete installer files

**2. All-in-One WP Migration**
- Free & Pro versions
- Simple interface
- Handles large sites (Pro)
- Good for quick migrations

**Steps:**
1. Install plugin on source site
2. Export site (creates .wpress file)
3. Install WordPress on destination
4. Install plugin on destination
5. Import .wpress file
6. Done!

**3. WP Migrate DB Pro**
- Pro only (paid)
- Best for developers
- Push/pull migrations
- Media files migration
- Find & replace

**4. UpdraftPlus**
- Backup & migration
- Cloud storage support
- Scheduled backups
- Easy restore

### Method 3: Host-Specific Migration

#### cPanel to cPanel:
1. Use cPanel backup feature
2. Download full backup
3. Upload to new cPanel
4. Restore via cPanel
5. Update DNS

#### Managed WordPress Hosts:
- **WP Engine:** Use automated migration tool
- **Kinsta:** Use MyKinsta migration tool
- **Flywheel:** Use migration plugin
- **SiteGround:** Use SG Migrator plugin

## Special Migration Scenarios

### Local to Production

**Additional Steps:**
1. Change WP_DEBUG to false
2. Remove development plugins
3. Optimize database
4. Enable caching
5. Setup CDN
6. Configure SSL
7. Setup backups
8. Configure security

**wp-config.php changes:**
```php
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
```

### HTTP to HTTPS

**Steps:**
1. Install SSL certificate
2. Update URLs in database
3. Update wp-config.php:
```php
define('FORCE_SSL_ADMIN', true);
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
    $_SERVER['HTTPS']='on';
```
4. Update .htaccess:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```
5. Test thoroughly

### Multisite Migration

**Additional Considerations:**
- Network tables (wp_blogs, wp_site, wp_sitemeta)
- Domain mapping
- Subdomain/subdirectory structure
- Network-activated plugins
- Network themes

**Steps:**
1. Backup all sites in network
2. Export all databases
3. Update wp-config.php:
```php
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false); // or true
define('DOMAIN_CURRENT_SITE', 'new-domain.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
```
4. Update all site URLs in database
5. Update domain mapping (if used)

### Large Site Migration

**For sites > 1GB:**

**Split Migration:**
1. Migrate database first
2. Migrate files in batches
3. Use rsync for incremental sync
4. Schedule during low traffic

**Optimization:**
```bash
# Compress before transfer
tar -czf uploads.tar.gz wp-content/uploads/

# Split large files
split -b 100M uploads.tar.gz uploads.tar.gz.part

# Transfer
scp uploads.tar.gz.part* user@destination:/path/

# Reassemble
cat uploads.tar.gz.part* > uploads.tar.gz
tar -xzf uploads.tar.gz
```

## Common Issues & Solutions

### Issue 1: White Screen After Migration
**Solution:**
- Enable WP_DEBUG
- Check error logs
- Verify file permissions
- Check PHP version compatibility
- Disable plugins temporarily

### Issue 2: Database Connection Error
**Solution:**
- Verify wp-config.php credentials
- Check database server is running
- Verify database user privileges
- Check database host (localhost vs IP)

### Issue 3: Missing Images
**Solution:**
- Verify uploads directory copied
- Check file permissions
- Update upload_path in wp_options
- Regenerate thumbnails
- Check .htaccess rules

### Issue 4: Broken Links
**Solution:**
- Run search/replace again
- Check for hardcoded URLs
- Verify permalink structure
- Regenerate .htaccess
- Check for protocol mismatch (http/https)

### Issue 5: Plugin Errors
**Solution:**
- Deactivate all plugins
- Activate one by one
- Check plugin compatibility
- Update plugins
- Check for path issues

### Issue 6: Theme Not Loading
**Solution:**
- Verify theme files copied
- Check theme directory name
- Update theme in database
- Check file permissions
- Clear cache

### Issue 7: Slow Performance
**Solution:**
- Optimize database
- Enable caching
- Optimize images
- Check server resources
- Review slow queries

### Issue 8: Email Not Working
**Solution:**
- Configure SMTP
- Check mail server settings
- Verify SPF/DKIM records
- Test with SMTP plugin
- Check firewall rules

## Post-Migration Optimization

### Database Optimization
```bash
# Via WP-CLI
wp db optimize

# Via SQL
OPTIMIZE TABLE wp_posts;
OPTIMIZE TABLE wp_postmeta;
OPTIMIZE TABLE wp_options;
```

### Clean Up
```bash
# Remove revisions
wp post delete $(wp post list --post_type='revision' --format=ids)

# Remove spam comments
wp comment delete $(wp comment list --status=spam --format=ids)

# Remove transients
wp transient delete --all
```

### Performance Tuning
1. Enable object caching
2. Setup page caching
3. Configure CDN
4. Optimize images
5. Minify CSS/JS
6. Enable GZIP compression
7. Leverage browser caching

## Migration Checklist

### Pre-Migration:
- [ ] Full backup created
- [ ] Backup verified
- [ ] Destination prepared
- [ ] DNS TTL lowered (if changing domains)
- [ ] Maintenance mode enabled
- [ ] Users notified (if applicable)

### During Migration:
- [ ] Files transferred
- [ ] Database imported
- [ ] wp-config.php updated
- [ ] URLs replaced
- [ ] Permissions fixed
- [ ] .htaccess regenerated

### Post-Migration:
- [ ] Site tested thoroughly
- [ ] SSL configured (if applicable)
- [ ] Caches cleared
- [ ] Performance optimized
- [ ] Backups configured
- [ ] Monitoring setup
- [ ] DNS updated (if applicable)
- [ ] Old site kept as backup (temporarily)
- [ ] Users notified of completion

## Rollback Plan

**If migration fails:**
1. Keep old site running
2. Don't update DNS until verified
3. Have backup ready to restore
4. Document what went wrong
5. Fix issues before retry

**Emergency Rollback:**
1. Restore old database
2. Restore old files
3. Revert DNS changes
4. Clear caches
5. Test old site

## Tools & Resources

### Command Line Tools:
- **WP-CLI** - WordPress command line
- **mysqldump** - Database backup
- **rsync** - File synchronization
- **ssh/scp** - Secure file transfer

### Plugins:
- Duplicator
- All-in-One WP Migration
- WP Migrate DB Pro
- UpdraftPlus
- BackupBuddy
- Better Search Replace

### Online Tools:
- Search Replace DB (interconnectit)
- WordPress Salts Generator
- SSL Checker
- DNS Propagation Checker

### Testing Tools:
- Broken Link Checker
- Query Monitor
- Debug Bar
- New Relic
- GTmetrix

## Best Practices

1. **Always Backup First** - Never migrate without backup
2. **Test in Staging** - Test migration process first
3. **Use Proper Tools** - Don't manually edit serialized data
4. **Document Everything** - Keep notes of all changes
5. **Schedule Wisely** - Migrate during low traffic
6. **Keep Old Site** - Don't delete until verified
7. **Monitor After** - Watch for issues post-migration
8. **Update Documentation** - Update docs with new info

## Security Considerations

### After Migration:
1. Change all passwords
2. Generate new auth keys
3. Update security plugins
4. Review user accounts
5. Check file permissions
6. Enable SSL
7. Configure firewall
8. Setup monitoring
9. Enable 2FA
10. Review access logs

## Maintenance After Migration

### First 24 Hours:
- Monitor error logs
- Check performance metrics
- Test all functionality
- Monitor uptime
- Check email delivery

### First Week:
- Daily backups
- Performance monitoring
- User feedback collection
- Bug fixing
- Optimization

### First Month:
- Weekly backups
- Security audit
- Performance review
- User satisfaction check
- Documentation update

## Support & Help

### If You Need Help:
1. Check error logs first
2. Search WordPress forums
3. Contact hosting support
4. Hire WordPress developer
5. Use migration service

### Professional Services:
- WordPress VIP
- WP Engine migrations
- Freelance developers
- WordPress agencies
- Migration specialists

---

**Last Updated:** 2026-04-21
**WordPress Version:** 6.9.4
**Status:** Complete Guide
