<?php
add_action('wp_enqueue_scripts', 'zoomy_child_enqueue_styles');
function zoomy_child_enqueue_styles()
{
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

include_once ('inc/_include.php');
