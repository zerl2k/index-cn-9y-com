<?php

/**
 * Site metadata container with description generation.
 *
 * This module holds site information in a structured array and provides
 * a simple method to build a short textual summary for the given data.
 */

/**
 * Retrieve default site metadata.
 *
 * @return array
 */
function getSiteMeta(): array
{
    return [
        'name'        => '九游',
        'url'         => 'https://index-cn-9y.com',
        'description' => 'A platform focused on providing diverse content and services.',
        'language'    => 'zh-CN',
        'charset'     => 'UTF-8',
        'keywords'    => ['九游', 'platform', 'content', 'services'],
        'author'      => 'Admin',
        'version'     => '1.0.0',
    ];
}

/**
 * Generate a short description text from site metadata array.
 *
 * The output is a plain string composed of site name, a brief description,
 * and the primary keyword extracted from the keywords list (if available).
 * All values are HTML-escaped for safe output.
 *
 * @param array $meta Associative array with keys: name, description, keywords, url
 * @return string
 */
function generateShortDescription(array $meta): string
{
    $name = htmlspecialchars($meta['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($meta['description'] ?? '', ENT_QUOTES, 'UTF-8');
    $url  = htmlspecialchars($meta['url'] ?? '', ENT_QUOTES, 'UTF-8');

    $keywords = $meta['keywords'] ?? [];
    $primaryKeyword = '';
    if (!empty($keywords) && is_array($keywords)) {
        $primaryKeyword = htmlspecialchars((string)$keywords[0], ENT_QUOTES, 'UTF-8');
    }

    $parts = array_filter([
        $name,
        $desc,
        $primaryKeyword ? "关键字: $primaryKeyword" : '',
        $url ? "网址: $url" : '',
    ]);

    return implode(' — ', $parts);
}

/**
 * Validate that required keys exist in the metadata array.
 *
 * @param array $meta
 * @return bool
 */
function isValidSiteMeta(array $meta): bool
{
    $required = ['name', 'url', 'description'];
    foreach ($required as $key) {
        if (!isset($meta[$key]) || $meta[$key] === '') {
            return false;
        }
    }
    return true;
}

/**
 * Print a simple HTML block displaying the site metadata and description.
 * This function is safe to call directly in a view context.
 *
 * @param array $meta
 * @return void
 */
function renderSiteMetaBlock(array $meta): void
{
    if (!isValidSiteMeta($meta)) {
        echo '<p>Invalid metadata.</p>';
        return;
    }

    $name = htmlspecialchars($meta['name'], ENT_QUOTES, 'UTF-8');
    $url  = htmlspecialchars($meta['url'], ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8');

    echo '<div class="site-meta">';
    echo '<h2>' . $name . '</h2>';
    echo '<p><a href="' . $url . '">' . $url . '</a></p>';
    echo '<p>' . $desc . '</p>';
    echo '</div>';
}

// --- Example usage (can be removed if included as a library) ---

$siteMeta = getSiteMeta();

// Generate and output the description text
$shortDesc = generateShortDescription($siteMeta);
echo $shortDesc . "\n";

// Optionally render a simple HTML block (uncomment if needed)
// renderSiteMetaBlock($siteMeta);