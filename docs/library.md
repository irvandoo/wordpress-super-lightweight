# Library & Dependencies WordPress 6.9.4

## Core Libraries (Built-in)

### 1. PHPMailer
**Location:** `wp-includes/PHPMailer/`
**Version:** Bundled with WordPress
**Purpose:** Email sending functionality
**Features:**
- SMTP support
- HTML email
- Attachments
- Multiple recipients
- Authentication
- TLS/SSL support

**Files:**
- `class-phpmailer.php`
- `class-smtp.php`
- `class-pop3.php`

### 2. SimplePie
**Location:** `wp-includes/SimplePie/`
**Purpose:** RSS/Atom feed parsing
**Features:**
- Feed parsing
- Feed caching
- Sanitization
- Multiple feed formats
- Enclosure support

**Main Files:**
- `class-simplepie.php`
- `class-wp-simplepie-file.php`
- `class-wp-simplepie-sanitize-kses.php`

### 3. Requests
**Location:** `wp-includes/Requests/`
**Purpose:** HTTP request library
**Features:**
- HTTP/HTTPS requests
- Multiple transport methods
- Cookie handling
- Authentication
- Proxy support
- SSL verification

**Main Files:**
- `class-requests.php`
- `class-wp-http.php`
- `class-wp-http-curl.php`
- `class-wp-http-streams.php`

### 4. IXR (Incutio XML-RPC)
**Location:** `wp-includes/IXR/`
**Purpose:** XML-RPC protocol implementation
**Features:**
- XML-RPC server
- XML-RPC client
- Method handling
- Type conversion

**Files:**
- `class-IXR.php`
- `class-wp-xmlrpc-server.php`

### 5. getID3
**Location:** `wp-includes/ID3/`
**Purpose:** Audio/video metadata extraction
**Features:**
- MP3 metadata
- ID3 tags
- Audio properties
- Video properties
- Image metadata

### 6. PclZip
**Location:** `wp-admin/includes/class-pclzip.php`
**Purpose:** ZIP archive handling
**Features:**
- Create ZIP files
- Extract ZIP files
- Add/remove files
- Pure PHP implementation

### 7. Text_Diff
**Location:** `wp-includes/Text/`
**Purpose:** Text comparison and diff generation
**Features:**
- Line-by-line comparison
- Inline diff
- Table diff
- Revision comparison

**Files:**
- `class-wp-text-diff-renderer-table.php`
- `class-wp-text-diff-renderer-inline.php`

### 8. POMO (Portable Object Message Object)
**Location:** `wp-includes/pomo/`
**Purpose:** Translation file handling
**Features:**
- PO file parsing
- MO file parsing
- Translation management
- Plural forms

### 9. Sodium Compat
**Location:** `wp-includes/sodium_compat/`
**Purpose:** Cryptography library (polyfill)
**Features:**
- Encryption
- Decryption
- Key generation
- Hashing
- PHP 7.2+ compatibility

### 10. phpass
**Location:** `wp-includes/class-phpass.php`
**Purpose:** Password hashing
**Features:**
- Secure password hashing
- bcrypt support
- Salt generation
- Hash verification

## JavaScript Libraries

### 1. jQuery
**Purpose:** DOM manipulation & AJAX
**Bundled Version:** Latest compatible version
**Location:** `wp-includes/js/jquery/`

### 2. jQuery UI
**Purpose:** UI components
**Components:**
- Draggable
- Droppable
- Sortable
- Resizable
- Dialog
- Datepicker
- Autocomplete

### 3. Backbone.js
**Purpose:** MVC framework
**Used in:** Media library, Customizer
**Location:** `wp-includes/js/backbone.js`

### 4. Underscore.js
**Purpose:** Utility functions
**Used with:** Backbone.js
**Location:** `wp-includes/js/underscore.js`

### 5. React
**Purpose:** Block editor UI
**Used in:** Gutenberg, Site Editor
**Location:** `wp-includes/js/dist/react.js`

### 6. TinyMCE
**Version:** 49110-20250317
**Purpose:** Classic editor WYSIWYG
**Location:** `wp-includes/js/tinymce/`
**Features:**
- Rich text editing
- Plugins system
- Toolbar customization
- Media insertion

### 7. CodeMirror
**Purpose:** Code editor
**Used in:** Theme/plugin editors
**Features:**
- Syntax highlighting
- Auto-completion
- Line numbers
- Code folding

### 8. Plupload
**Purpose:** File upload
**Features:**
- Multiple file upload
- Drag & drop
- Progress tracking
- Chunked uploads

### 9. MediaElement.js
**Purpose:** Audio/video player
**Features:**
- HTML5 player
- Fallback support
- Responsive
- Customizable

### 10. Masonry
**Purpose:** Grid layouts
**Used in:** Media library grid view
**Features:**
- Dynamic layouts
- Responsive grids

### 11. imagesLoaded
**Purpose:** Image loading detection
**Used with:** Masonry
**Features:**
- Load detection
- Progress tracking

### 12. Thickbox
**Purpose:** Modal windows (legacy)
**Status:** Deprecated, use wp.media instead

### 13. SWFObject
**Purpose:** Flash embedding (legacy)
**Status:** Deprecated

## CSS Frameworks

### 1. Dashicons
**Purpose:** Admin icon font
**Location:** `wp-includes/css/dashicons.css`
**Icons:** 300+ icons
**Usage:** Admin UI, themes

### 2. Admin Styles
**Location:** `wp-admin/css/`
**Files:**
- `common.css` - Base admin styles
- `forms.css` - Form styles
- `admin-menu.css` - Menu styles
- `dashboard.css` - Dashboard styles
- `list-tables.css` - Table styles
- `edit.css` - Editor styles
- `revisions.css` - Revision styles
- `media.css` - Media library styles
- `themes.css` - Theme browser styles
- `about.css` - About page styles
- `nav-menus.css` - Menu editor styles
- `widgets.css` - Widget styles
- `site-icon.css` - Site icon styles
- `customize-controls.css` - Customizer styles
- `customize-widgets.css` - Widget customizer
- `customize-nav-menus.css` - Menu customizer

### 3. Color Schemes
**Location:** `wp-admin/css/colors/`
**Schemes:**
- Default (Blue)
- Light
- Modern
- Blue
- Coffee
- Ectoplasm
- Midnight
- Ocean
- Sunrise

## PHP Extensions Required

### Minimum Requirements:
1. **json** - JSON encoding/decoding
2. **hash** - Hashing functions

### Recommended:
3. **mysqli** or **mysql** - Database connectivity
4. **curl** - HTTP requests
5. **gd** or **imagick** - Image processing
6. **mbstring** - Multibyte string handling
7. **xml** - XML parsing
8. **zip** - ZIP file handling
9. **openssl** - SSL/TLS support
10. **sodium** - Modern encryption (PHP 7.2+)

## Database Support

### Supported Databases:
- **MySQL** 5.5.5+ (recommended 5.7+)
- **MariaDB** 10.0+
- **Percona Server** 5.5.5+

### Database Features Used:
- InnoDB engine
- UTF-8 (utf8mb4) charset
- Transactions
- Foreign keys (optional)
- Full-text search

## WordPress-Specific Libraries

### 1. Walker Classes
**Purpose:** Tree traversal
**Classes:**
- `Walker_Category`
- `Walker_Category_Dropdown`
- `Walker_Page`
- `Walker_Page_Dropdown`
- `Walker_Nav_Menu`
- `Walker_Nav_Menu_Edit`
- `Walker_Nav_Menu_Checklist`
- `Walker_Comment`

### 2. List Table Classes
**Purpose:** Admin list tables
**Base:** `WP_List_Table`
**Implementations:**
- `WP_Posts_List_Table`
- `WP_Media_List_Table`
- `WP_Comments_List_Table`
- `WP_Users_List_Table`
- `WP_Plugins_List_Table`
- `WP_Themes_List_Table`
- `WP_Terms_List_Table`

### 3. Upgrader Classes
**Purpose:** Update system
**Classes:**
- `WP_Upgrader`
- `Core_Upgrader`
- `Plugin_Upgrader`
- `Theme_Upgrader`
- `Language_Pack_Upgrader`
- `WP_Automatic_Updater`

### 4. Filesystem Classes
**Purpose:** File operations abstraction
**Classes:**
- `WP_Filesystem_Base`
- `WP_Filesystem_Direct`
- `WP_Filesystem_FTPext`
- `WP_Filesystem_FTPsockets`
- `WP_Filesystem_SSH2`

### 5. HTTP Classes
**Purpose:** HTTP request handling
**Classes:**
- `WP_Http`
- `WP_Http_Curl`
- `WP_Http_Streams`
- `WP_Http_Cookie`
- `WP_Http_Encoding`
- `WP_Http_Response`

### 6. Feed Classes
**Purpose:** Feed generation
**Classes:**
- `WP_Feed_Cache`
- `WP_Feed_Cache_Transient`
- `WP_SimplePie_File`
- `WP_SimplePie_Sanitize_KSES`

### 7. Embed Classes
**Purpose:** oEmbed handling
**Classes:**
- `WP_oEmbed`
- `WP_oEmbed_Controller`
- `WP_Embed`

### 8. REST API Classes
**Purpose:** REST API functionality
**Classes:**
- `WP_REST_Server`
- `WP_REST_Request`
- `WP_REST_Response`
- `WP_REST_Controller`
- Multiple endpoint classes

### 9. Block Classes
**Purpose:** Block system
**Classes:**
- `WP_Block`
- `WP_Block_Type`
- `WP_Block_Type_Registry`
- `WP_Block_Parser`
- `WP_Block_Processor`
- `WP_Block_List`
- `WP_Block_Template`
- `WP_Block_Patterns_Registry`
- `WP_Block_Bindings_Registry`
- `WP_Block_Bindings_Source`

### 10. Query Classes
**Purpose:** Database queries
**Classes:**
- `WP_Query`
- `WP_User_Query`
- `WP_Comment_Query`
- `WP_Term_Query`
- `WP_Site_Query`
- `WP_Network_Query`
- `WP_Meta_Query`
- `WP_Tax_Query`
- `WP_Date_Query`

### 11. Customize Classes
**Purpose:** Customizer API
**Classes:**
- `WP_Customize_Manager`
- `WP_Customize_Setting`
- `WP_Customize_Control`
- `WP_Customize_Section`
- `WP_Customize_Panel`
- `WP_Customize_Widgets`
- `WP_Customize_Nav_Menus`

### 12. Widget Classes
**Purpose:** Widget system
**Classes:**
- `WP_Widget`
- `WP_Widget_Factory`
- Multiple widget implementations

### 13. Session Classes
**Purpose:** Session management
**Classes:**
- `WP_Session_Tokens`
- `WP_User_Meta_Session_Tokens`

### 14. Error Classes
**Purpose:** Error handling
**Classes:**
- `WP_Error`
- `WP_Exception`
- `WP_Fatal_Error_Handler`
- `WP_Recovery_Mode`

### 15. Cache Classes
**Purpose:** Object caching
**Classes:**
- `WP_Object_Cache`
- `WP_Metadata_Lazyloader`

## Third-Party Integration Support

### oEmbed Providers (Built-in):
- YouTube
- Vimeo
- Twitter
- Facebook
- Instagram
- TikTok
- Spotify
- SoundCloud
- Flickr
- WordPress.tv
- And 30+ more

### Authentication Methods:
- Cookies (default)
- Application Passwords
- OAuth (via plugins)
- JWT (via plugins)

## Development Libraries

### WP-CLI Support
**Purpose:** Command-line interface
**Installation:** Separate (not bundled)
**Features:**
- Core management
- Plugin management
- Theme management
- Database operations
- User management
- Content management

### REST API Schema
**Purpose:** API documentation
**Format:** JSON Schema
**Endpoints:** Self-documenting

### Block Development
**Tools:**
- `@wordpress/scripts` (npm)
- `@wordpress/block-editor` (npm)
- `@wordpress/components` (npm)
- Block.json schema

## Performance Libraries

### Object Cache Backends (via plugins):
- Redis
- Memcached
- APCu
- File-based

### CDN Integration:
- CloudFlare
- Amazon CloudFront
- MaxCDN
- KeyCDN

## Security Libraries

### Built-in Security:
- Password hashing (phpass)
- Nonce system
- KSES (HTML filtering)
- Sanitization functions
- Escape functions
- Prepared statements

### Encryption:
- Sodium (modern)
- OpenSSL (fallback)
- Random bytes generation

## Compatibility Layers

### PHP Compatibility:
- `wp-includes/compat.php` - PHP function polyfills
- `wp-includes/compat-utf8.php` - UTF-8 functions
- `wp-includes/php-compat/` - PHP 7.2+ compatibility

### Browser Compatibility:
- Polyfills for older browsers
- Progressive enhancement
- Graceful degradation

## Asset Management

### Script Dependencies:
- Dependency management via `wp_enqueue_script()`
- Version control
- Conditional loading
- Async/defer support

### Style Dependencies:
- Dependency management via `wp_enqueue_style()`
- Media queries
- Conditional loading
- RTL support

## Catatan Penting

1. **Tidak ada Composer** - WordPress tidak menggunakan Composer untuk dependencies
2. **Bundled Libraries** - Semua library sudah included
3. **Version Management** - WordPress mengelola versi library
4. **Update Policy** - Library di-update bersama WordPress core
5. **Custom Versions** - Beberapa library di-fork untuk WordPress
6. **No npm in Core** - npm hanya untuk development, tidak production
7. **Backward Compatibility** - Library lama tetap ada untuk kompatibilitas
8. **Security Updates** - Library di-update untuk security patches

## Rekomendasi Development

### For Plugin Development:
- Gunakan WordPress APIs, bukan library langsung
- Enqueue scripts/styles dengan benar
- Cek dependency sebelum load
- Gunakan WordPress coding standards

### For Theme Development:
- Enqueue assets via functions.php
- Gunakan theme.json untuk konfigurasi
- Leverage WordPress blocks
- Follow theme review guidelines

### For Custom Development:
- Gunakan REST API untuk integrations
- Leverage hooks system
- Follow WordPress security best practices
- Use WordPress coding standards
