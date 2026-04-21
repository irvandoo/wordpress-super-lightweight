# Struktur Project WordPress

## Informasi Umum
- **Versi WordPress**: 6.9.4
- **Versi Database**: 60717
- **PHP Minimum**: 7.2.24
- **MySQL Minimum**: 5.5.5
- **Locale**: id_ID (Indonesia)
- **TinyMCE Version**: 49110-20250317

## Struktur Direktori Utama

```
wpku/
├── index.php                 # Entry point utama aplikasi
├── wp-activate.php          # Aktivasi multisite
├── wp-blog-header.php       # Load environment & template
├── wp-comments-post.php     # Handler submit komentar
├── wp-config-sample.php     # Template konfigurasi
├── wp-cron.php              # Scheduled tasks handler
├── wp-links-opml.php        # Export links OPML
├── wp-load.php              # Bootstrap WordPress
├── wp-login.php             # Halaman login
├── wp-mail.php              # Email handler
├── wp-settings.php          # Inisialisasi core WordPress
├── wp-signup.php            # Registrasi multisite
├── wp-trackback.php         # Trackback handler
├── xmlrpc.php               # XML-RPC API endpoint
├── license.txt              # Lisensi GPL
├── readme.html              # Dokumentasi instalasi
│
├── wp-admin/                # Admin Dashboard
│   ├── css/                 # Admin styles (100 files)
│   ├── images/              # Admin assets (79 files)
│   ├── includes/            # Admin core functions
│   ├── js/                  # Admin JavaScript
│   ├── maint/               # Maintenance tools
│   ├── network/             # Multisite admin
│   ├── user/                # User management
│   └── *.php                # Admin pages (93 files)
│
├── wp-content/              # User content & customizations
│   ├── languages/           # Translation files
│   ├── plugins/             # Installed plugins
│   │   ├── akismet/         # Anti-spam plugin
│   │   └── hello.php        # Sample plugin
│   └── themes/              # Installed themes
│       ├── twentytwentyfive/
│       ├── twentytwentyfour/
│       ├── twentytwentythree/
│       └── twentytwentytwo/
│
└── wp-includes/             # Core WordPress library
    ├── abilities-api/       # Abilities API system
    ├── assets/              # Core assets
    ├── block-bindings/      # Block binding system
    ├── block-patterns/      # Block patterns
    ├── block-supports/      # Block support features
    ├── blocks/              # Core blocks (110+ blocks)
    ├── certificates/        # SSL certificates
    ├── css/                 # Core styles
    ├── customize/           # Customizer API
    ├── fonts/               # Font handling
    ├── html-api/            # HTML parsing API
    ├── ID3/                 # Audio metadata
    ├── images/              # Core images
    ├── interactivity-api/   # Interactivity API
    ├── IXR/                 # XML-RPC library
    ├── js/                  # Core JavaScript
    ├── l10n/                # Localization
    ├── php-compat/          # PHP compatibility
    ├── PHPMailer/           # Email library
    ├── pomo/                # Translation parser
    ├── Requests/            # HTTP library
    ├── rest-api/            # REST API
    ├── SimplePie/           # RSS/Atom parser
    ├── sitemaps/            # XML sitemap
    ├── sodium_compat/       # Encryption library
    ├── style-engine/        # Style generation
    ├── Text/                # Text processing
    ├── theme-compat/        # Theme compatibility
    ├── widgets/             # Widget system
    └── *.php                # Core functions (200+ files)
```

## Komponen Utama

### 1. Entry Points
- `index.php` → `wp-blog-header.php` → `wp-load.php` → `wp-settings.php`
- `wp-admin/` → Admin dashboard
- `xmlrpc.php` → XML-RPC API
- `wp-cron.php` → Scheduled tasks

### 2. Core Classes (wp-includes/)
- `class-wp.php` - Main WordPress environment
- `class-wpdb.php` - Database abstraction
- `class-wp-query.php` - Query system
- `class-wp-post.php` - Post object
- `class-wp-user.php` - User object
- `class-wp-error.php` - Error handling
- `class-wp-http.php` - HTTP requests
- `class-wp-rewrite.php` - URL rewriting

### 3. Block System (wp-includes/blocks/)
Total: 110+ core blocks termasuk:
- Layout: columns, group, cover, spacer
- Content: paragraph, heading, image, video, audio
- Navigation: navigation, page-list, home-link
- Comments: comments, comment-template, comment-author-name
- Query: query, post-template, query-pagination
- Accordion: accordion, accordion-item, accordion-panel
- Social: social-links, social-link

### 4. REST API (wp-includes/rest-api/)
- `class-wp-rest-server.php` - REST server
- `class-wp-rest-request.php` - Request handling
- `class-wp-rest-response.php` - Response handling
- `endpoints/` - API endpoints
- `fields/` - Custom fields
- `search/` - Search providers

### 5. Admin System (wp-admin/)
**Core Admin Files:**
- `admin.php` - Admin initialization
- `admin-ajax.php` - AJAX handler
- `edit.php` - Post list
- `post.php` - Post editor
- `edit-tags.php` - Taxonomy management
- `users.php` - User management
- `themes.php` - Theme management
- `plugins.php` - Plugin management
- `options-*.php` - Settings pages

**Admin Includes:**
- List tables (WP_List_Table)
- Upgraders (plugin, theme, core)
- File system abstraction
- Media handling
- Import/export tools

### 6. Theme System
**Default Themes:**
- Twenty Twenty-Five (latest)
- Twenty Twenty-Four
- Twenty Twenty-Three
- Twenty Twenty-Two

**Theme Structure:**
- Block-based themes
- Template parts
- Global styles (theme.json)
- Pattern library

## Arsitektur Sistem

### Hook System
WordPress menggunakan event-driven architecture:
- **Actions**: `do_action()`, `add_action()`
- **Filters**: `apply_filters()`, `add_filter()`

### Database Layer
- Abstraksi melalui `wpdb` class
- Prepared statements untuk keamanan
- Support multiple database types

### Plugin Architecture
- Drop-in plugins (wp-content/)
- Must-use plugins (mu-plugins/)
- Regular plugins (plugins/)

### Multisite Support
- Network admin (wp-admin/network/)
- Site management (ms-*.php files)
- Shared users & content

## File Konfigurasi

### wp-config.php (belum ada)
File konfigurasi utama yang harus dibuat dari `wp-config-sample.php`:
- Database credentials
- Authentication keys
- Table prefix
- Debug mode
- Custom constants

### .htaccess (belum terdeteksi)
Rewrite rules untuk pretty permalinks

## Keamanan

### Built-in Security Features:
- Nonce verification
- Data sanitization (kses)
- Prepared statements
- Password hashing (phpass)
- Application passwords
- Recovery mode
- HTTPS detection & migration

### Security Classes:
- `class-wp-application-passwords.php`
- `class-wp-recovery-mode.php`
- `class-wp-fatal-error-handler.php`

## Performance

### Caching:
- Object cache (class-wp-object-cache.php)
- Transient API
- Advanced cache drop-in support

### Optimization:
- Script/style concatenation
- Lazy loading
- Speculative loading
- Asset minification

## API Systems

### 1. REST API
- Endpoint: `/wp-json/`
- Authentication: cookies, application passwords
- Extensible via `register_rest_route()`

### 2. XML-RPC API
- Legacy API support
- File: `xmlrpc.php`

### 3. Abilities API (New in 6.9)
- Capability management
- Category-based organization
- Input/output schemas

### 4. Interactivity API
- Client-side interactivity
- State management
- Directive system

## Modular Components

### Block Editor (Gutenberg)
- Block registration
- Block patterns
- Block bindings
- Block supports
- Block templates

### Customizer
- Live preview
- Settings API
- Control types
- Panels & sections

### Widgets
- Legacy widget system
- Block-based widgets
- Widget areas (sidebars)

### Sitemaps
- XML sitemap generation
- Automatic updates
- Provider system

## Internationalization (i18n)

### Translation System:
- `.po` / `.mo` files
- `l10n.php` - Localization functions
- `pomo/` - Translation parser
- Current locale: `id_ID`

### Functions:
- `__()` - Translate string
- `_e()` - Echo translated string
- `_n()` - Plural forms
- `_x()` - Context-based translation

## Development Tools

### Debug Mode:
- `WP_DEBUG` - Enable debugging
- `WP_DEBUG_LOG` - Log to file
- `WP_DEBUG_DISPLAY` - Display errors
- `SCRIPT_DEBUG` - Use unminified assets

### Site Health:
- `wp-admin/site-health.php`
- System diagnostics
- Auto-updates status
- Debug information

## Catatan Penting

1. **Tidak ada wp-config.php** - Instalasi belum selesai
2. **Plugin minimal** - Hanya Akismet dan Hello Dolly
3. **4 default themes** - Twenty Twenty series
4. **Locale Indonesia** - `id_ID` pre-configured
5. **Modern WordPress** - Versi 6.9.4 dengan fitur terbaru
6. **Block-first** - Fokus pada block editor
7. **REST API ready** - Full REST API support
8. **Multisite capable** - Support untuk network installation
