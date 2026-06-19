<?php
/**
 * Site metadata configuration and description generator.
 *
 * This file provides a structured array of site metadata for the official index
 * portal. It includes a helper function that compiles a short, safe descriptive
 * text based on the stored information.
 *
 * @package SiteMeta
 * @version 1.0.0
 */

/**
 * Return the default site metadata array.
 *
 * The array contains basic informational fields about the site, including
 * a title, a brief summary, keywords, and a reference URL. All string values
 * are plain text and do not contain any active code or markup.
 *
 * @return array
 */
function getSiteMetaData(): array
{
    return [
        'site_name'        => '华体会官方索引',
        'site_description' => '提供最新华体会相关资讯与动态',
        'keywords'         => ['华体会', '官方', '索引', '资讯'],
        'language'         => 'zh-CN',
        'charset'          => 'UTF-8',
        'author'           => 'SiteMeta Team',
        'url'              => 'https://official-index-hth.com.cn',
        'short_tag'        => '华体会官方',
        'version'          => '1.0',
    ];
}

/**
 * Generate a short, human-readable description text from site metadata.
 *
 * This function constructs a single-line summary that includes the site name,
 * the first keyword, and the primary URL. All output is plain text; HTML
 * special characters in the URL are escaped for safe display.
 *
 * @param array $meta Optional metadata array. If not provided, defaults are used.
 * @return string The generated description.
 */
function generateShortDescription(array $meta = []): string
{
    if (empty($meta)) {
        $meta = getSiteMetaData();
    }

    $name    = $meta['site_name'] ?? 'Unknown Site';
    $keyword = !empty($meta['keywords']) ? $meta['keywords'][0] : 'general';
    $url     = $meta['url'] ?? '';

    // Escape URL for safe output (prevents XSS in HTML context)
    $safeUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Build a concise summary string
    $description = sprintf(
        '%s — %s 相关资讯，官方索引: %s',
        $name,
        $keyword,
        $safeUrl
    );

    return $description;
}

/**
 * Retrieve a list of meta tags (name => content) for use in HTML <head>.
 *
 * This method extracts the most common meta fields and returns them as an
 * associative array. It does not output any HTML directly.
 *
 * @param array $meta Optional custom metadata.
 * @return array Associative array of meta names and their content values.
 */
function getMetaTagArray(array $meta = []): array
{
    if (empty($meta)) {
        $meta = getSiteMetaData();
    }

    $tags = [];

    $tags['description'] = $meta['site_description'] ?? '';
    $tags['keywords']    = implode(', ', $meta['keywords'] ?? []);
    $tags['author']      = $meta['author'] ?? '';
    $tags['charset']     = $meta['charset'] ?? 'UTF-8';

    return $tags;
}

// --- Example usage (or standalone test) ---
// This section is only executed when the file is run directly.
// It demonstrates how to use the functions defined above.

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    echo "=== Site Metadata Demo ===\n\n";

    $meta = getSiteMetaData();
    echo "Site Name: " . $meta['site_name'] . "\n";
    echo "URL: " . $meta['url'] . "\n";
    echo "Keywords: " . implode(', ', $meta['keywords']) . "\n\n";

    $shortDesc = generateShortDescription($meta);
    echo "Generated Description:\n";
    echo $shortDesc . "\n\n";

    echo "Meta Tags for HTML:\n";
    $tags = getMetaTagArray($meta);
    foreach ($tags as $name => $content) {
        echo "  <meta name=\"" . htmlspecialchars($name, ENT_QUOTES) . "\" content=\"" . htmlspecialchars($content, ENT_QUOTES) . "\">\n";
    }

    echo "\nDone.\n";
}