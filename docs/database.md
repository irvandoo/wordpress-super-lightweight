# Database Structure WordPress 6.9.4

## Database Information

**Database Version:** 60717
**Minimum MySQL:** 5.5.5
**Recommended MySQL:** 5.7+
**Charset:** utf8mb4
**Collation:** utf8mb4_unicode_ci

## Default Table Prefix
**Default:** `wp_`
**Configurable:** Yes (via wp-config.php)

## Core Database Tables

### 1. wp_posts
**Purpose:** Menyimpan semua content (posts, pages, attachments, revisions)

**Columns:**
- `ID` (bigint) - Primary key
- `post_author` (bigint) - User ID penulis
- `post_date` (datetime) - Tanggal publikasi
- `post_date_gmt` (datetime) - Tanggal publikasi GMT
- `post_content` (longtext) - Konten utama
- `post_title` (text) - Judul
- `post_excerpt` (text) - Excerpt/ringkasan
- `post_status` (varchar) - Status: publish, draft, pending, private, trash
- `comment_status` (varchar) - open, closed
- `ping_status` (varchar) - open, closed
- `post_password` (varchar) - Password protection
- `post_name` (varchar) - Slug/permalink
- `to_ping` (text) - URLs to ping
- `pinged` (text) - URLs already pinged
- `post_modified` (datetime) - Last modified date
- `post_modified_gmt` (datetime) - Last modified GMT
- `post_content_filtered` (longtext) - Filtered content
- `post_parent` (bigint) - Parent post ID
- `guid` (varchar) - Global unique identifier
- `menu_order` (int) - Sort order
- `post_type` (varchar) - post, page, attachment, revision, nav_menu_item, custom
- `post_mime_type` (varchar) - MIME type (for attachments)
- `comment_count` (bigint) - Number of comments

**Indexes:**
- PRIMARY KEY (ID)
- post_name
- type_status_date
- post_parent
- post_author

**Post Types:**
- `post` - Blog posts
- `page` - Static pages
- `attachment` - Media files
- `revision` - Post revisions
- `nav_menu_item` - Menu items
- `wp_block` - Reusable blocks
- `wp_template` - Block templates
- `wp_template_part` - Template parts
- `wp_navigation` - Navigation menus
- `wp_global_styles` - Global styles
- Custom post types

### 2. wp_postmeta
**Purpose:** Metadata untuk posts

**Columns:**
- `meta_id` (bigint) - Primary key
- `post_id` (bigint) - Foreign key to wp_posts
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

**Indexes:**
- PRIMARY KEY (meta_id)
- post_id
- meta_key

**Common Meta Keys:**
- `_edit_last` - Last editor user ID
- `_edit_lock` - Edit lock timestamp
- `_wp_page_template` - Page template
- `_thumbnail_id` - Featured image ID
- `_wp_attached_file` - Attachment file path
- `_wp_attachment_metadata` - Image metadata
- `_wp_trash_meta_status` - Original status before trash
- `_wp_trash_meta_time` - Trash timestamp

### 3. wp_comments
**Purpose:** Menyimpan komentar

**Columns:**
- `comment_ID` (bigint) - Primary key
- `comment_post_ID` (bigint) - Foreign key to wp_posts
- `comment_author` (tinytext) - Commenter name
- `comment_author_email` (varchar) - Email
- `comment_author_url` (varchar) - Website
- `comment_author_IP` (varchar) - IP address
- `comment_date` (datetime) - Comment date
- `comment_date_gmt` (datetime) - Comment date GMT
- `comment_content` (text) - Comment text
- `comment_karma` (int) - Comment karma
- `comment_approved` (varchar) - 0, 1, spam, trash
- `comment_agent` (varchar) - User agent
- `comment_type` (varchar) - comment, pingback, trackback
- `comment_parent` (bigint) - Parent comment ID
- `user_id` (bigint) - User ID (if logged in)

**Indexes:**
- PRIMARY KEY (comment_ID)
- comment_post_ID
- comment_approved_date_gmt
- comment_date_gmt
- comment_parent
- comment_author_email

### 4. wp_commentmeta
**Purpose:** Metadata untuk comments

**Columns:**
- `meta_id` (bigint) - Primary key
- `comment_id` (bigint) - Foreign key to wp_comments
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

**Indexes:**
- PRIMARY KEY (meta_id)
- comment_id
- meta_key

### 5. wp_users
**Purpose:** Menyimpan user accounts

**Columns:**
- `ID` (bigint) - Primary key
- `user_login` (varchar) - Username
- `user_pass` (varchar) - Hashed password
- `user_nicename` (varchar) - URL-friendly name
- `user_email` (varchar) - Email address
- `user_url` (varchar) - Website
- `user_registered` (datetime) - Registration date
- `user_activation_key` (varchar) - Activation key
- `user_status` (int) - User status
- `display_name` (varchar) - Display name

**Indexes:**
- PRIMARY KEY (ID)
- user_login_key (UNIQUE)
- user_nicename
- user_email

### 6. wp_usermeta
**Purpose:** Metadata untuk users

**Columns:**
- `umeta_id` (bigint) - Primary key
- `user_id` (bigint) - Foreign key to wp_users
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

**Indexes:**
- PRIMARY KEY (umeta_id)
- user_id
- meta_key

**Common Meta Keys:**
- `nickname` - Nickname
- `first_name` - First name
- `last_name` - Last name
- `description` - Biography
- `rich_editing` - Visual editor enabled
- `syntax_highlighting` - Code editor highlighting
- `comment_shortcuts` - Keyboard shortcuts
- `admin_color` - Admin color scheme
- `use_ssl` - Force SSL
- `show_admin_bar_front` - Show admin bar
- `locale` - User locale
- `wp_capabilities` - User roles (serialized)
- `wp_user_level` - User level (deprecated)
- `dismissed_wp_pointers` - Dismissed pointers
- `session_tokens` - Login sessions

### 7. wp_terms
**Purpose:** Menyimpan taxonomy terms

**Columns:**
- `term_id` (bigint) - Primary key
- `name` (varchar) - Term name
- `slug` (varchar) - URL-friendly slug
- `term_group` (bigint) - Term group

**Indexes:**
- PRIMARY KEY (term_id)
- slug (UNIQUE)
- name

### 8. wp_term_taxonomy
**Purpose:** Menghubungkan terms dengan taxonomies

**Columns:**
- `term_taxonomy_id` (bigint) - Primary key
- `term_id` (bigint) - Foreign key to wp_terms
- `taxonomy` (varchar) - Taxonomy name
- `description` (longtext) - Term description
- `parent` (bigint) - Parent term ID
- `count` (bigint) - Number of objects

**Indexes:**
- PRIMARY KEY (term_taxonomy_id)
- term_id_taxonomy (UNIQUE)
- taxonomy

**Built-in Taxonomies:**
- `category` - Post categories
- `post_tag` - Post tags
- `nav_menu` - Navigation menus
- `link_category` - Link categories (deprecated)
- `post_format` - Post formats
- `wp_theme` - Theme taxonomies
- `wp_template_part_area` - Template part areas

### 9. wp_term_relationships
**Purpose:** Menghubungkan objects dengan terms

**Columns:**
- `object_id` (bigint) - Post/object ID
- `term_taxonomy_id` (bigint) - Foreign key to wp_term_taxonomy
- `term_order` (int) - Sort order

**Indexes:**
- PRIMARY KEY (object_id, term_taxonomy_id)
- term_taxonomy_id

### 10. wp_termmeta
**Purpose:** Metadata untuk terms

**Columns:**
- `meta_id` (bigint) - Primary key
- `term_id` (bigint) - Foreign key to wp_terms
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

**Indexes:**
- PRIMARY KEY (meta_id)
- term_id
- meta_key

### 11. wp_options
**Purpose:** Menyimpan site settings

**Columns:**
- `option_id` (bigint) - Primary key
- `option_name` (varchar) - Option name (UNIQUE)
- `option_value` (longtext) - Option value
- `autoload` (varchar) - yes, no (load on every page)

**Indexes:**
- PRIMARY KEY (option_id)
- option_name (UNIQUE)
- autoload

**Important Options:**
- `siteurl` - WordPress URL
- `home` - Site URL
- `blogname` - Site title
- `blogdescription` - Site tagline
- `users_can_register` - Registration enabled
- `admin_email` - Admin email
- `start_of_week` - Week start day
- `use_balanceTags` - Balance tags
- `use_smilies` - Convert emoticons
- `require_name_email` - Comment requirements
- `comments_notify` - Comment notifications
- `posts_per_page` - Posts per page
- `date_format` - Date format
- `time_format` - Time format
- `links_updated_date_format` - Link date format
- `comment_moderation` - Moderation enabled
- `moderation_notify` - Moderation notifications
- `permalink_structure` - Permalink structure
- `rewrite_rules` - Rewrite rules (serialized)
- `hack_file` - Deprecated
- `blog_charset` - Character set
- `moderation_keys` - Moderation keywords
- `active_plugins` - Active plugins (serialized)
- `category_base` - Category base
- `ping_sites` - Update services
- `comment_max_links` - Max links in comment
- `gmt_offset` - GMT offset
- `default_email_category` - Default category
- `recently_edited` - Recently edited files
- `template` - Active theme directory
- `stylesheet` - Active theme stylesheet
- `comment_registration` - Registration required
- `html_type` - HTML type
- `use_trackback` - Trackback enabled
- `default_role` - Default user role
- `db_version` - Database version
- `uploads_use_yearmonth_folders` - Organize uploads
- `upload_path` - Upload path
- `blog_public` - Search engine visibility
- `default_link_category` - Default link category
- `show_on_front` - Front page displays
- `tag_base` - Tag base
- `show_avatars` - Show avatars
- `avatar_rating` - Avatar rating
- `upload_url_path` - Upload URL path
- `thumbnail_size_w` - Thumbnail width
- `thumbnail_size_h` - Thumbnail height
- `thumbnail_crop` - Crop thumbnail
- `medium_size_w` - Medium width
- `medium_size_h` - Medium height
- `avatar_default` - Default avatar
- `large_size_w` - Large width
- `large_size_h` - Large height
- `image_default_link_type` - Image link type
- `image_default_size` - Default image size
- `image_default_align` - Default image alignment
- `close_comments_for_old_posts` - Close old comments
- `close_comments_days_old` - Days before closing
- `thread_comments` - Threaded comments
- `thread_comments_depth` - Thread depth
- `page_comments` - Paginate comments
- `comments_per_page` - Comments per page
- `default_comments_page` - Default comment page
- `comment_order` - Comment order
- `sticky_posts` - Sticky posts (serialized)
- `widget_categories` - Category widget
- `widget_text` - Text widget
- `widget_rss` - RSS widget
- `uninstall_plugins` - Uninstall callbacks
- `timezone_string` - Timezone
- `page_for_posts` - Posts page
- `page_on_front` - Front page
- `default_post_format` - Default post format
- `link_manager_enabled` - Link manager
- `finished_splitting_shared_terms` - Term splitting
- `site_icon` - Site icon ID
- `medium_large_size_w` - Medium large width
- `medium_large_size_h` - Medium large height
- `wp_page_for_privacy_policy` - Privacy page
- `show_comments_cookies_opt_in` - Cookie consent
- `admin_email_lifespan` - Email verification
- `disallowed_keys` - Disallowed comment keys
- `comment_previously_approved` - Previous approval
- `auto_plugin_theme_update_emails` - Update emails
- `auto_update_core_dev` - Core dev updates
- `auto_update_core_minor` - Core minor updates
- `auto_update_core_major` - Core major updates
- `wp_force_deactivated_plugins` - Force deactivated
- `initial_db_version` - Initial DB version
- `wp_user_roles` - User roles (serialized)
- `fresh_site` - Fresh installation
- `WPLANG` - Language
- `new_admin_email` - Pending admin email

### 12. wp_links (Optional/Deprecated)
**Purpose:** Blogroll/link management
**Status:** Deprecated, disabled by default

**Columns:**
- `link_id` (bigint) - Primary key
- `link_url` (varchar) - Link URL
- `link_name` (varchar) - Link name
- `link_image` (varchar) - Link image
- `link_target` (varchar) - Link target
- `link_description` (varchar) - Description
- `link_visible` (varchar) - Visibility
- `link_owner` (bigint) - Owner user ID
- `link_rating` (int) - Rating
- `link_updated` (datetime) - Last update
- `link_rel` (varchar) - Relationship
- `link_notes` (mediumtext) - Notes
- `link_rss` (varchar) - RSS URL

## Multisite Tables (if enabled)

### wp_blogs
**Purpose:** Sites in network

**Columns:**
- `blog_id` (bigint) - Primary key
- `site_id` (bigint) - Network ID
- `domain` (varchar) - Site domain
- `path` (varchar) - Site path
- `registered` (datetime) - Registration date
- `last_updated` (datetime) - Last update
- `public` (tinyint) - Public visibility
- `archived` (tinyint) - Archived status
- `mature` (tinyint) - Mature content
- `spam` (tinyint) - Spam status
- `deleted` (tinyint) - Deleted status
- `lang_id` (int) - Language ID

### wp_blogmeta
**Purpose:** Metadata untuk sites

**Columns:**
- `meta_id` (bigint) - Primary key
- `blog_id` (bigint) - Site ID
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

### wp_site
**Purpose:** Networks

**Columns:**
- `id` (bigint) - Primary key
- `domain` (varchar) - Network domain
- `path` (varchar) - Network path

### wp_sitemeta
**Purpose:** Network metadata

**Columns:**
- `meta_id` (bigint) - Primary key
- `site_id` (bigint) - Network ID
- `meta_key` (varchar) - Key name
- `meta_value` (longtext) - Value

### wp_registration_log
**Purpose:** Registration log

**Columns:**
- `ID` (bigint) - Primary key
- `email` (varchar) - Email
- `IP` (varchar) - IP address
- `blog_id` (bigint) - Site ID
- `date_registered` (datetime) - Registration date

### wp_signups
**Purpose:** Pending signups

**Columns:**
- `signup_id` (bigint) - Primary key
- `domain` (varchar) - Domain
- `path` (varchar) - Path
- `title` (longtext) - Site title
- `user_login` (varchar) - Username
- `user_email` (varchar) - Email
- `registered` (datetime) - Registration date
- `activated` (datetime) - Activation date
- `active` (tinyint) - Active status
- `activation_key` (varchar) - Activation key
- `meta` (longtext) - Metadata

## Database Relationships

### Post Relationships:
```
wp_posts (ID) ← wp_postmeta (post_id)
wp_posts (ID) ← wp_comments (comment_post_ID)
wp_posts (ID) ← wp_term_relationships (object_id)
wp_posts (post_author) → wp_users (ID)
wp_posts (post_parent) → wp_posts (ID)
```

### Taxonomy Relationships:
```
wp_terms (term_id) → wp_term_taxonomy (term_id)
wp_term_taxonomy (term_taxonomy_id) → wp_term_relationships (term_taxonomy_id)
wp_term_taxonomy (parent) → wp_term_taxonomy (term_taxonomy_id)
wp_terms (term_id) ← wp_termmeta (term_id)
```

### User Relationships:
```
wp_users (ID) ← wp_usermeta (user_id)
wp_users (ID) ← wp_posts (post_author)
wp_users (ID) ← wp_comments (user_id)
```

### Comment Relationships:
```
wp_comments (comment_ID) ← wp_commentmeta (comment_id)
wp_comments (comment_post_ID) → wp_posts (ID)
wp_comments (user_id) → wp_users (ID)
wp_comments (comment_parent) → wp_comments (comment_ID)
```

## Database Operations

### WPDB Class Methods:
- `$wpdb->query()` - Execute query
- `$wpdb->get_results()` - Get multiple rows
- `$wpdb->get_row()` - Get single row
- `$wpdb->get_col()` - Get column
- `$wpdb->get_var()` - Get single value
- `$wpdb->insert()` - Insert row
- `$wpdb->update()` - Update row
- `$wpdb->delete()` - Delete row
- `$wpdb->prepare()` - Prepare statement
- `$wpdb->replace()` - Replace row

### Table Properties:
- `$wpdb->posts`
- `$wpdb->postmeta`
- `$wpdb->comments`
- `$wpdb->commentmeta`
- `$wpdb->users`
- `$wpdb->usermeta`
- `$wpdb->terms`
- `$wpdb->term_taxonomy`
- `$wpdb->term_relationships`
- `$wpdb->termmeta`
- `$wpdb->options`
- `$wpdb->links`

## Optimization

### Recommended Indexes:
- All foreign keys
- Frequently queried columns
- Sort columns
- Join columns

### Query Optimization:
- Use prepared statements
- Limit result sets
- Use appropriate indexes
- Avoid SELECT *
- Use caching

### Maintenance:
- Regular OPTIMIZE TABLE
- Monitor slow queries
- Update statistics
- Check table integrity

## Backup Recommendations

### What to Backup:
1. All wp_* tables
2. wp-config.php
3. wp-content/ directory
4. .htaccess file

### Backup Methods:
- mysqldump
- phpMyAdmin export
- WordPress backup plugins
- Server-level backups

## Security Considerations

### Database Security:
- Use strong passwords
- Limit database user privileges
- Change table prefix
- Regular updates
- Monitor for injections
- Use prepared statements
- Sanitize inputs
- Escape outputs

### Recommended Privileges:
- SELECT, INSERT, UPDATE, DELETE
- CREATE, ALTER, DROP (for updates)
- INDEX (for optimization)

## Migration Notes

### Export/Import:
- Use mysqldump for full backup
- Update URLs in database
- Update file paths
- Regenerate .htaccess
- Clear caches
- Update wp-config.php

### Search & Replace:
- Old URL → New URL
- Old path → New path
- Serialized data handling
- wp_options table
- wp_postmeta table
- wp_posts table (guid, post_content)

## Catatan Penting

1. **Charset utf8mb4** - Support emoji dan karakter khusus
2. **Serialized Data** - Banyak data disimpan dalam format serialized PHP
3. **Autoload Options** - Options dengan autoload=yes dimuat setiap page load
4. **Revisions** - Post revisions disimpan di wp_posts
5. **Transients** - Temporary data disimpan di wp_options
6. **Object Cache** - Dapat menggunakan external cache (Redis, Memcached)
7. **Table Prefix** - Dapat diubah untuk keamanan
8. **Foreign Keys** - Tidak menggunakan foreign key constraints
9. **InnoDB Engine** - Recommended untuk semua tables
10. **Regular Maintenance** - Optimize tables secara berkala
