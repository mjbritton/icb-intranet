<?php

// PARENT THEME //

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{
    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme        = wp_get_theme();
    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css',
        array(), // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

// CHILD THEME //

function theme_files()
{

    if (strstr($_SERVER['SERVER_NAME'], 'localhost:3000')) {
        wp_enqueue_script('main-theme-js', 'http://192.168.1.3:3000/bundled.js', null, '1.1', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.225da0fb8ee436ef62fc.js'), null, '1.0', true);
        wp_enqueue_script('main-theme-js', get_theme_file_uri('/bundled-assets/scripts.920183adf1e07dfbd303.js'), null, '1.0', true);
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.9b8cc94badf8b0a523d5.css'));
    }

    wp_localize_script('main-theme-js', 'themeData', array(
        'root_url' => get_site_url(),
        'nonce'    => wp_create_nonce('wp_rest'),
    ));
}

add_action('wp_enqueue_scripts', 'theme_files');