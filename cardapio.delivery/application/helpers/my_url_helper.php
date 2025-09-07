<?php
if (!function_exists('should_add_lang_parameter')) {
    function should_add_lang_parameter()
    {
        $CI = &get_instance();
        $language_type = $CI->config->item('language_type');
        $total_languages = $CI->config->item('total_languages');
        return (in_array($language_type, ['system', 'default']) && $total_languages > 1);
    }
}

if (!function_exists('get_current_language')) {
    function get_current_language()
    {
        $CI = &get_instance();
        return $CI->input->get('lang');
    }
}

if (!function_exists('add_lang_parameter')) {
    function add_lang_parameter($url)
    {
        if (!should_add_lang_parameter()) {
            return $url;
        }
        $current_lang = get_current_language();
        if (empty($current_lang)) {
            return $url;
        }

        // Check if there's additional path after the base_url 
        // (looking for formats like http://example.com/path?params/additional)
        $additional_path = '';
        $url_parts = explode('?', $url);

        if (count($url_parts) > 1 && strpos($url_parts[1], '/') !== false) {
            // Split at the first slash after the query string
            $query_and_path = explode('/', $url_parts[1], 2);
            $url_parts[1] = $query_and_path[0]; // Keep only the query part
            $additional_path = '/' . $query_and_path[1]; // Save the additional path
            $url = $url_parts[0] . '?' . $url_parts[1]; // Reconstruct the URL without additional path
        }

        // Parse the URL to handle query parameters correctly
        $parts = parse_url($url);
        $query = [];

        // If there are existing query parameters, parse them
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        // Add the language parameter
        $query['lang'] = $current_lang;

        // Rebuild the URL preserving the scheme if it exists
        $newUrl = '';
        if (isset($parts['scheme'])) {
            $newUrl .= $parts['scheme'] . '://';
        }
        if (isset($parts['host'])) {
            $newUrl .= $parts['host'];
        }
        if (isset($parts['path'])) {
            $newUrl .= $parts['path'];
        }
        if (!empty($query)) {
            $newUrl .= '?' . http_build_query($query);
        }

        // Append the additional path back
        $newUrl .= $additional_path;

        return $newUrl;
    }
}

if (!function_exists('base_url')) {
    function base_url($uri = '')
    {
        $CI = &get_instance();
        $base = $CI->config->base_url($uri);
        return add_lang_parameter($base);
    }
}

if (!function_exists('asset_url')) {
    function asset_url($uri = '')
    {
        $CI = &get_instance();
        return $CI->config->base_url($uri);
    }
}


if (!function_exists('site_url')) {
    function site_url($uri = '')
    {
        $CI = &get_instance();
        $url = $CI->config->site_url($uri);
        return add_lang_parameter($url);
    }
}


if (!function_exists('add_ref_parameter')) {
    function add_ref_parameter($url, $ref_id = null)
    {
        // If no ref_id provided, try to get it from GET parameters
        if ($ref_id === null) {
            $ref_id = isset($_GET['ref']) && !empty($_GET['ref']) ? $_GET['ref'] : '';
        }

        // If no ref_id, just return the original URL
        if (empty($ref_id)) {
            return $url;
        }

        // Check if URL already has parameters
        $separator = (strpos($url, '?') !== false) ? '&' : '?';

        // Add ref parameter
        return $url . $separator . 'ref=' . $ref_id;
    }
}

// Then modify your base_url function to use this
if (!function_exists('base_url_with_ref')) {
    function base_url_with_ref($uri = '')
    {
        $base = base_url($uri);
        return add_ref_parameter($base);
    }
}
