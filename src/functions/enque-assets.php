<?php
function base_enqueue_styles()
{
    $common_css_dir = get_template_directory() . "/assets/css/common/";
    $common_css_files = glob($common_css_dir . "*.css");

    sort($common_css_files);

    foreach ($common_css_files as $css_path) {
        $handle = "common-" . basename($css_path, ".css");
        $css_uri = str_replace(get_template_directory(), get_template_directory_uri(), $css_path);
        $ver = file_exists($css_path) ? filemtime($css_path) : null;
        wp_enqueue_style($handle, $css_uri, [], $ver, "all");
    }
}
add_action("wp_enqueue_scripts", "base_enqueue_styles");

function page_specific_enqueue_styles()
{
    if (is_front_page()) {
        wp_enqueue_style("front-page-styles", get_template_directory_uri() . "/assets/css/page/front-page.css", [], filemtime(get_template_directory() . "/assets/css/page/front-page.css"), "all");
        wp_enqueue_style("swiper-styles", "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css", [], null, "all");
    } elseif (is_404()) {
        wp_enqueue_style("subpage-styles", get_template_directory_uri() . "/assets/css/common/subpage.css", [], filemtime(get_template_directory() . "/assets/css/common/subpage.css"), "all");
        wp_enqueue_style("404-styles", get_template_directory_uri() . "/assets/css/page/404.css", [], filemtime(get_template_directory() . "/assets/css/page/404.css"), "all");
    } else {
        wp_enqueue_style("subpage-styles", get_template_directory_uri() . "/assets/css/common/subpage.css", [], filemtime(get_template_directory() . "/assets/css/common/subpage.css"), "all");
    }
}
add_action("wp_enqueue_scripts", "page_specific_enqueue_styles");

function auto_enqueue_page_css()
{
    if (is_page()) {
        global $post;
        $slug = $post->post_name;

        $parent_slug = "";
        if ($post->post_parent) {
            $parent = get_post($post->post_parent);
            if ($parent) {
                $parent_slug = $parent->post_name;
            }
        }

        $base_dir = get_template_directory() . "/assets/css/page/";
        $pattern = $base_dir . "**/*.css";
        $files = glob($pattern, GLOB_BRACE | GLOB_NOSORT);

        $targets = [$slug];
        if ($parent_slug) {
            $targets[] = $parent_slug . "-" . $slug;
        }

        $index_css = $base_dir . $slug . "/index.css";
        if (file_exists($index_css)) {
            $css_uri = str_replace(get_template_directory(), get_template_directory_uri(), $index_css);
            wp_enqueue_style("page-" . $slug . "-index", $css_uri, [], filemtime($index_css), "all");
        }

        foreach ($files as $css_path) {
            $filename = pathinfo($css_path, PATHINFO_FILENAME);
            if (in_array($filename, $targets, true)) {
                $css_uri = str_replace(get_template_directory(), get_template_directory_uri(), $css_path);
                wp_enqueue_style("page-" . $filename, $css_uri, [], filemtime($css_path), "all");
            }
        }
    }
}
add_action("wp_enqueue_scripts", "auto_enqueue_page_css");

function page_specific_enqueue_scripts()
{
    wp_enqueue_script("main-scripts", get_template_directory_uri() . "/assets/js/main.js", ["jquery"], null, true);

    if (is_front_page()) {
        wp_enqueue_script("front-page-scripts", "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js", ["jquery"], null, true);
        wp_enqueue_script("front-page-custom-scripts", get_template_directory_uri() . "/assets/js/front-page.js", ["jquery", "front-page-scripts"], filemtime(get_template_directory() . "/assets/js/front-page.js"), true);
    } elseif (is_page("about")) {
        wp_enqueue_script("about-scripts", get_template_directory_uri() . "/assets/js/about.js", ["jquery"], filemtime(get_template_directory() . "/assets/js/about.js"), true);
    }
}
add_action("wp_enqueue_scripts", "page_specific_enqueue_scripts");
