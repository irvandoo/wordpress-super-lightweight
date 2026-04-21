# Seeder & Sample Data - WordPress 6.9.4

## Overview
Panduan untuk mengisi WordPress dengan sample data untuk testing, development, atau demo purposes. WordPress tidak memiliki built-in seeder seperti Laravel, tetapi ada beberapa metode untuk generate sample content.

## Why Use Sample Data?

### Use Cases:
- **Development** - Test themes/plugins with realistic data
- **Demo Sites** - Show potential clients how site looks with content
- **Testing** - Performance testing with large datasets
- **Training** - Teaching WordPress to new users
- **Theme Development** - Test layouts with various content types
- **QA Testing** - Ensure features work with different data scenarios

## Built-in Sample Data

### WordPress Default Content

**Fresh Installation Includes:**
- 1 Sample post ("Hello World!")
- 1 Sample page ("Sample Page")
- 1 Sample comment (on Hello World post)
- Default categories (Uncategorized)
- Default user (admin)

**Location:**
- Post: wp-admin → Posts → All Posts
- Page: wp-admin → Pages → All Pages
- Comment: wp-admin → Comments

## Official WordPress Sample Data

### Theme Unit Test Data

**Source:** WordPress.org
**URL:** https://github.com/WPTT/theme-unit-test

**What's Included:**
- Various post formats
- Different content lengths
- Embedded media
- Galleries
- Special characters
- Edge cases
- Nested comments
- Multiple categories/tags

**Installation:**
1. Download XML file from GitHub
2. Go to Tools → Import
3. Install WordPress Importer
4. Upload XML file
5. Assign authors
6. Import attachments (optional)
7. Click Submit

**File:** `themeunittestdata.wordpress.xml`

### WP Test Data

**Source:** https://wptest.io/
**Features:**
- Comprehensive test data
- Various content types
- Media files
- Custom post types
- Taxonomies

## Plugin-Based Sample Data

### 1. FakerPress

**Best For:** Generating large amounts of random data
**Free:** Yes
**URL:** https://wordpress.org/plugins/fakerpress/

**Features:**
- Generate posts, pages, custom post types
- Generate users
- Generate terms (categories, tags)
- Generate comments
- Customizable quantity
- Random but realistic data
- Bulk generation

**Usage:**
```
1. Install FakerPress plugin
2. Activate plugin
3. Go to FakerPress menu
4. Choose content type (Posts, Users, Terms, Comments)
5. Set quantity and options
6. Click Generate
```

**Example Settings:**
- **Posts:** 100 posts with random titles, content, dates
- **Users:** 50 users with random names, emails
- **Comments:** 500 comments on random posts
- **Terms:** 20 categories, 50 tags

### 2. WP Sample Data Generator

**Best For:** Quick sample data generation
**Free:** Yes

**Features:**
- Generate posts
- Generate pages
- Generate custom post types
- Simple interface
- Fast generation

### 3. WordPress Beta Tester

**Best For:** Testing with WordPress.org sample content
**Free:** Yes
**URL:** https://wordpress.org/plugins/wordpress-beta-tester/

**Features:**
- Import official test data
- Test bleeding edge WordPress
- Development environment

## Manual Sample Data Creation

### Via WP-CLI

**Generate Posts:**
```bash
# Generate 100 posts
for i in {1..100}; do
  wp post create --post_type=post --post_title="Sample Post $i" --post_content="This is sample content for post $i" --post_status=publish
done
```

**Generate Pages:**
```bash
# Generate 20 pages
for i in {1..20}; do
  wp post create --post_type=page --post_title="Sample Page $i" --post_content="This is sample content for page $i" --post_status=publish
done
```

**Generate Users:**
```bash
# Generate 50 users
for i in {1..50}; do
  wp user create user$i user$i@example.com --role=subscriber --user_pass=password123
done
```

**Generate Comments:**
```bash
# Generate 10 comments on post ID 1
for i in {1..10}; do
  wp comment create --comment_post_ID=1 --comment_content="Sample comment $i" --comment_author="User $i" --comment_author_email="user$i@example.com"
done
```

**Generate Terms:**
```bash
# Generate categories
for i in {1..10}; do
  wp term create category "Category $i" --slug="category-$i"
done

# Generate tags
for i in {1..20}; do
  wp term create post_tag "Tag $i" --slug="tag-$i"
done
```

### Via PHP Script

**Create Custom Seeder Script:**

```php
<?php
/**
 * WordPress Sample Data Seeder
 * Place in wp-content/plugins/ and activate
 */

/*
Plugin Name: Sample Data Seeder
Description: Generate sample data for testing
Version: 1.0.0
*/

// Add admin menu
add_action('admin_menu', 'seeder_menu');
function seeder_menu() {
    add_menu_page(
        'Sample Data Seeder',
        'Seeder',
        'manage_options',
        'sample-seeder',
        'seeder_page',
        'dashicons-database'
    );
}

// Admin page
function seeder_page() {
    if (isset($_POST['generate_posts'])) {
        generate_sample_posts($_POST['post_count']);
    }
    if (isset($_POST['generate_users'])) {
        generate_sample_users($_POST['user_count']);
    }
    ?>
    <div class="wrap">
        <h1>Sample Data Seeder</h1>
        
        <h2>Generate Posts</h2>
        <form method="post">
            <input type="number" name="post_count" value="10" min="1" max="1000">
            <input type="submit" name="generate_posts" value="Generate Posts" class="button button-primary">
        </form>
        
        <h2>Generate Users</h2>
        <form method="post">
            <input type="number" name="user_count" value="10" min="1" max="100">
            <input type="submit" name="generate_users" value="Generate Users" class="button button-primary">
        </form>
    </div>
    <?php
}

// Generate posts
function generate_sample_posts($count) {
    for ($i = 1; $i <= $count; $i++) {
        $post_data = array(
            'post_title'    => 'Sample Post ' . $i,
            'post_content'  => 'This is sample content for post ' . $i . '. ' . wp_generate_password(100, false),
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'post',
            'post_category' => array(1)
        );
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Add featured image (if exists)
            // Add meta data
            update_post_meta($post_id, '_sample_meta', 'Sample meta value');
            
            // Add tags
            wp_set_post_tags($post_id, 'sample, test, demo');
        }
    }
    
    echo '<div class="notice notice-success"><p>' . $count . ' posts generated successfully!</p></div>';
}

// Generate users
function generate_sample_users($count) {
    for ($i = 1; $i <= $count; $i++) {
        $user_data = array(
            'user_login'    => 'user' . $i,
            'user_pass'     => 'password123',
            'user_email'    => 'user' . $i . '@example.com',
            'first_name'    => 'User',
            'last_name'     => $i,
            'display_name'  => 'User ' . $i,
            'role'          => 'subscriber'
        );
        
        $user_id = wp_insert_user($user_data);
        
        if (!is_wp_error($user_id)) {
            // Add user meta
            update_user_meta($user_id, 'description', 'Sample user bio for user ' . $i);
        }
    }
    
    echo '<div class="notice notice-success"><p>' . $count . ' users generated successfully!</p></div>';
}
```

## Sample Data Types

### 1. Posts

**Variations to Test:**
- Short posts (< 100 words)
- Medium posts (100-500 words)
- Long posts (> 1000 words)
- Posts with images
- Posts with galleries
- Posts with videos
- Posts with embeds
- Posts with special characters
- Posts with different formats
- Scheduled posts
- Draft posts
- Private posts
- Password-protected posts

**Sample Post Content:**
```php
$sample_posts = array(
    array(
        'title' => 'Short Post Example',
        'content' => 'This is a short post with minimal content.',
        'format' => 'standard'
    ),
    array(
        'title' => 'Gallery Post Example',
        'content' => '[gallery ids="1,2,3,4,5,6"]',
        'format' => 'gallery'
    ),
    array(
        'title' => 'Video Post Example',
        'content' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'format' => 'video'
    ),
    array(
        'title' => 'Quote Post Example',
        'content' => '<blockquote>This is a sample quote.</blockquote>',
        'format' => 'quote'
    )
);
```

### 2. Pages

**Page Types:**
- Homepage
- About page
- Contact page
- Services page
- Portfolio page
- Blog page
- Privacy policy
- Terms of service
- FAQ page
- Parent pages with children

### 3. Users

**User Roles:**
- Administrator (1-2 users)
- Editor (2-5 users)
- Author (5-10 users)
- Contributor (10-20 users)
- Subscriber (50+ users)

**User Data:**
```php
$sample_users = array(
    array(
        'login' => 'john_editor',
        'email' => 'john@example.com',
        'first_name' => 'John',
        'last_name' => 'Editor',
        'role' => 'editor'
    ),
    array(
        'login' => 'jane_author',
        'email' => 'jane@example.com',
        'first_name' => 'Jane',
        'last_name' => 'Author',
        'role' => 'author'
    )
);
```

### 4. Comments

**Comment Types:**
- Approved comments
- Pending comments
- Spam comments
- Nested comments (replies)
- Comments from logged-in users
- Comments from guests

### 5. Media

**Media Types:**
- Images (JPEG, PNG, GIF, WebP)
- Videos (MP4)
- Audio (MP3)
- Documents (PDF)
- Various sizes

**Sample Images:**
- Use placeholder services:
  - https://picsum.photos/ (random images)
  - https://placeholder.com/ (placeholder images)
  - https://via.placeholder.com/ (simple placeholders)

### 6. Taxonomies

**Categories:**
- Technology
- Business
- Lifestyle
- Travel
- Food
- Health
- Education
- Entertainment

**Tags:**
- wordpress
- web-development
- design
- tutorial
- tips
- news
- review
- guide

### 7. Custom Post Types

**Examples:**
- Portfolio items
- Testimonials
- Products
- Events
- Team members
- Services
- Projects

## E-Commerce Sample Data (WooCommerce)

### WooCommerce Sample Products

**Built-in Importer:**
1. Install WooCommerce
2. Go to WooCommerce → Status → Tools
3. Click "Import sample products"
4. Wait for import to complete

**What's Included:**
- Simple products
- Variable products
- Grouped products
- External products
- Product categories
- Product tags
- Product attributes
- Sample orders
- Sample customers

### Custom WooCommerce Data

**Via WP-CLI:**
```bash
# Generate products
wp wc product create --name="Sample Product" --type=simple --regular_price=19.99 --user=1
```

## Performance Testing Data

### Large Dataset Generation

**For Performance Testing:**
- 10,000+ posts
- 1,000+ users
- 50,000+ comments
- 100+ categories
- 500+ tags

**WP-CLI Bulk Generation:**
```bash
# Generate 10,000 posts
wp post generate --count=10000 --post_type=post --post_status=publish

# Generate 1,000 users
wp user generate --count=1000 --role=subscriber

# Generate 50,000 comments
wp comment generate --count=50000 --post_id=1
```

## Cleanup & Reset

### Remove Sample Data

**Via Plugin:**
- WP Reset
- Advanced Database Cleaner
- WP-Sweep

**Via WP-CLI:**
```bash
# Delete all posts
wp post delete $(wp post list --post_type=post --format=ids) --force

# Delete all pages
wp post delete $(wp post list --post_type=page --format=ids) --force

# Delete all users except admin
wp user delete $(wp user list --role=subscriber --format=ids) --yes

# Delete all comments
wp comment delete $(wp comment list --format=ids) --force

# Delete all terms
wp term delete category $(wp term list category --field=term_id) --force
```

**Via SQL:**
```sql
-- Delete all posts (except default)
DELETE FROM wp_posts WHERE ID > 1;
DELETE FROM wp_postmeta WHERE post_id > 1;

-- Delete all comments (except default)
DELETE FROM wp_comments WHERE comment_ID > 1;
DELETE FROM wp_commentmeta WHERE comment_id > 1;

-- Delete all users (except admin)
DELETE FROM wp_users WHERE ID > 1;
DELETE FROM wp_usermeta WHERE user_id > 1;

-- Reset auto-increment
ALTER TABLE wp_posts AUTO_INCREMENT = 2;
ALTER TABLE wp_comments AUTO_INCREMENT = 2;
ALTER TABLE wp_users AUTO_INCREMENT = 2;
```

## Best Practices

### 1. Development Environment Only
- Never use sample data on production
- Use separate database for testing
- Clear sample data before launch

### 2. Realistic Data
- Use realistic content lengths
- Include various content types
- Test edge cases
- Include special characters

### 3. Performance Considerations
- Generate data in batches
- Monitor server resources
- Use WP-CLI for large datasets
- Clear caches after generation

### 4. Data Variety
- Mix of old and new content
- Various authors
- Different categories/tags
- Multiple content formats

### 5. Media Files
- Use placeholder images
- Don't use copyrighted content
- Optimize image sizes
- Test various file types

## Sample Data Checklist

### Basic Content:
- [ ] 20-50 posts
- [ ] 5-10 pages
- [ ] 10-20 users
- [ ] 50-100 comments
- [ ] 10-15 categories
- [ ] 30-50 tags
- [ ] 20-30 images

### Advanced Content:
- [ ] Custom post types
- [ ] Custom taxonomies
- [ ] Custom fields
- [ ] Menu items
- [ ] Widgets
- [ ] Sidebars
- [ ] Navigation menus

### E-Commerce (if applicable):
- [ ] Products
- [ ] Product categories
- [ ] Product tags
- [ ] Product attributes
- [ ] Sample orders
- [ ] Sample customers
- [ ] Reviews

## Troubleshooting

### Issue: Timeout During Generation
**Solution:**
- Increase PHP max_execution_time
- Generate in smaller batches
- Use WP-CLI instead of browser
- Increase memory_limit

### Issue: Duplicate Content
**Solution:**
- Use unique titles/slugs
- Check for existing content
- Use random generators
- Clear before regenerating

### Issue: Missing Images
**Solution:**
- Check upload directory permissions
- Verify image URLs
- Use local placeholder images
- Check file size limits

## Resources

### Sample Data Sources:
- WordPress Theme Unit Test Data
- WPTest.io
- Lorem Ipsum generators
- Placeholder image services
- Sample JSON data

### Tools:
- FakerPress plugin
- WP-CLI
- Custom PHP scripts
- Database management tools

### Documentation:
- WordPress Codex
- WP-CLI documentation
- Plugin documentation
- Developer resources

---

**Last Updated:** 2026-04-21
**WordPress Version:** 6.9.4
**Status:** Complete Guide
