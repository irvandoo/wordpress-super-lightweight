<?php
declare(strict_types=1);

/**
 * Table of Contents Generator
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Generate TOC from content
 */
function ida_generate_toc(string $content): string {
    if (!is_singular('post') || !in_the_loop()) {
        return $content;
    }
    
    // Extract headings
    preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER);
    
    if (count($matches) < 3) {
        return $content; // Don't show TOC if less than 3 headings
    }
    
    $toc_items = [];
    $counter = 1;
    
    foreach ($matches as $heading) {
        $level = $heading[1];
        $text = strip_tags($heading[3]);
        $id = 'ida-toc-' . $counter;
        
        // Add ID to heading
        $content = str_replace($heading[0], '<h' . $level . ' id="' . $id . '">' . $heading[3] . '</h' . $level . '>', $content);
        
        $toc_items[] = [
            'level' => $level,
            'text' => $text,
            'id' => $id
        ];
        
        $counter++;
    }
    
    // Build TOC HTML
    $toc_html = '<nav class="ida-toc" aria-label="Table of Contents">';
    $toc_html .= '<h2 class="ida-toc-title">Table of Contents</h2>';
    $toc_html .= '<ol class="ida-toc-list">';
    
    foreach ($toc_items as $item) {
        $class = 'ida-toc-item ida-toc-level-' . $item['level'];
        $toc_html .= '<li class="' . esc_attr($class) . '">';
        $toc_html .= '<a href="#' . esc_attr($item['id']) . '">' . esc_html($item['text']) . '</a>';
        $toc_html .= '</li>';
    }
    
    $toc_html .= '</ol>';
    $toc_html .= '</nav>';
    
    // Insert TOC after first paragraph
    $content = preg_replace('/<\/p>/', '</p>' . $toc_html, $content, 1);
    
    return $content;
}
add_filter('the_content', 'ida_generate_toc', 10);
