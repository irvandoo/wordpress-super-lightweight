# WordPress Super Lightweight Optimization Plan

## Target Optimization
- ✅ Admin panel: Keep (Classic Editor)
- ✅ Block Editor: Disable (Gutenberg removed)
- ✅ Themes: 1 only
- ✅ Multisite: Disabled
- ✅ Performance: Maximum (page load < 1s, minimal queries, N+1 solved)

## Current State
- **Size:** 83.1 MB
- **Files:** 3,575 files
- **Themes:** 4 themes (will reduce to 1)
- **Plugins:** 2 plugins (will remove)

## Target State
- **Size:** ~50-60 MB (40% reduction)
- **Files:** ~2,000 files (44% reduction)
- **Themes:** 1 lightweight theme
- **Plugins:** Only essential
- **Page Load:** < 1 second
- **Database Queries:** < 20 per page
- **N+1 Problem:** Solved

## Implementation Steps

### Phase 1: File Cleanup (Immediate)
1. Remove unused themes (keep 1)
2. Remove default plugins
3. Remove unused language files
4. Clean wp-content/uploads (if any)

### Phase 2: Core Optimization (wp-config.php)
1. Disable revisions
2. Disable auto-save
3. Disable trash
4. Disable file editing
5. Disable cron (use real cron)
6. Memory optimization

### Phase 3: Feature Disabling (functions.php)
1. Disable Gutenberg completely
2. Disable embeds
3. Disable emojis
4. Disable XML-RPC
5. Disable REST API (partial)
6. Disable heartbeat
7. Remove jQuery Migrate
8. Disable dashicons on frontend

### Phase 4: Database Optimization
1. Remove post revisions
2. Remove auto-drafts
3. Remove spam comments
4. Remove transients
5. Optimize tables
6. Add proper indexes

### Phase 5: Query Optimization (N+1 Solution)
1. Eager loading for posts
2. Eager loading for meta
3. Eager loading for terms
4. Object caching
5. Query monitoring

### Phase 6: Performance Tuning
1. Enable OPcache
2. Enable object caching (Redis/Memcached)
3. Enable page caching
4. Optimize autoload options
5. Lazy load images

## Expected Results

### Before:
- Size: 83.1 MB
- Files: 3,575
- Page Load: ~3-5s (default)
- Queries: 50-100+ per page
- Memory: 64-128 MB

### After:
- Size: ~50-60 MB (28% smaller)
- Files: ~2,000 (44% fewer)
- Page Load: < 1s (70% faster)
- Queries: < 20 per page (80% reduction)
- Memory: 32-64 MB (50% less)

## Risk Assessment
- **Low Risk:** File cleanup, wp-config optimization
- **Medium Risk:** Disabling features (reversible)
- **No Risk:** All changes are non-destructive to core files

## Rollback Plan
All changes are configuration-based, can be reverted by:
1. Restore wp-config.php
2. Remove custom functions.php code
3. Re-enable features as needed
