<?php
function enqueue_page_specific_css()
{
    $page_css_file = "";
    if (is_front_page()) {
        $page_css_file = "front-page.css";
    } elseif (is_page()) {
        global $post;
        $page_template = get_page_template_slug($post->ID);
        if ($page_template) {
            $template_name = basename($page_template, ".php");
            $page_css_file = $template_name . ".css";
        } else {
            $page_css_file = "page.css";
        }
    } elseif (is_single()) {
        $page_css_file = "single.css";
    } elseif (is_archive() || is_home()) {
        $page_css_file = "archive.css";
    }

    if (!empty($page_css_file)) {
        $css_path = get_template_directory_uri() . "/assets/css/page/" . $page_css_file;
        wp_enqueue_style("page-specific", $css_path, [], null);
    }
}
add_action("wp_enqueue_scripts", "enqueue_page_specific_css", 20);
