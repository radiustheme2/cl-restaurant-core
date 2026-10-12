<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CL_Restaurant_Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \RT_Posts;

if ( !class_exists( 'RT_Posts' ) ) {
	return;
}

$prefix = CL_RESTAURANT_CORE_THEME_PREFIX;
$post_types = [];
$taxonomies = [];

$Posts = RT_Posts::getInstance();
$Posts->add_post_types( $post_types );
$Posts->add_taxonomies( $taxonomies );