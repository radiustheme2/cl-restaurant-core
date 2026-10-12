<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CL_Restaurant_Core;

use \ReflectionClass;
use Elementor\Widget_Base;
use Rtcl\Helpers\Functions;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Custom_Widget_Base extends Widget_Base {
	public $rt_name;
	public $rt_base;
	public $rt_category;
	public $rt_icon;
	public $rt_translate;
	public $rt_dir;

	public function __construct( $data = [], $args = null ) {
		$this->rt_category = CL_RESTAURANT_CORE_THEME_PREFIX . '-widgets'; // Category /@dev
		$this->rt_icon     = 'rdtheme-el-custom';
		$this->rt_dir      = dirname( ( new ReflectionClass( $this ) )->getFileName() );
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return $this->rt_base;
	}

	public function get_title() {
		return $this->rt_name;
	}

	public function get_icon() {
		return $this->rt_icon;
	}

	public function get_categories() {
		return array( $this->rt_category );
	}

	// protected function register_controls() {
	// 	$fields = $this->rt_fields();
	// 	foreach ( $fields as $field ) {
	// 		if ( isset( $field['mode'] ) && $field['mode'] == 'section_start' ) {
	// 			$id = $field['id'];
	// 			unset( $field['id'] );
	// 			unset( $field['mode'] );
	// 			$this->start_controls_section( $id, $field );
	// 		}
	// 		elseif ( isset( $field['mode'] ) && $field['mode'] == 'section_end' ) {
	// 			$this->end_controls_section();
	// 		}
	// 		elseif ( isset( $field['mode'] ) && $field['mode'] == 'group' ) {
	// 			$type = $field['type'];
	// 			unset( $field['mode'] );
	// 			unset( $field['type'] );
	// 			$this->add_group_control( $type, $field );
	// 		}
	// 		elseif ( isset( $field['mode'] ) && $field['mode'] == 'responsive' ) {
	// 			$id = $field['id'];
	// 			unset( $field['id'] );
	// 			unset( $field['mode'] );
	// 			$this->add_responsive_control( $id, $field );
	// 		}
	// 		else {
	// 			$id = $field['id'];
	// 			unset( $field['id'] );
	// 			$this->add_control( $id, $field );
	// 		}
	// 	}
	// }

	public function rt_template( $template, $data ) {
		$template_name = '/elementor-custom/' . basename( $this->rt_dir ) . '/' . $template . '.php';
		if ( file_exists( get_stylesheet_directory() . $template_name ) ) {
			$file = get_stylesheet_directory() . $template_name;
		}
		elseif ( file_exists( get_template_directory() . $template_name ) ) {
			$file = get_template_directory() . $template_name;
		}
		else {
			$file = $this->rt_dir . '/' . $template . '.php';
		}

		ob_start();
		include $file;
		echo ob_get_clean();
	}

	public function rt_alignment_options(){
		return array(
			'left'    => array(
				'title' => __( 'Left', 'cl-restaurant-core' ),
				'icon' => 'eicon-text-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'cl-restaurant-core' ),
				'icon' => 'eicon-text-align-center',
			),
			'right' => array(
				'title' => __( 'Right', 'cl-restaurant-core' ),
				'icon' => 'eicon-text-align-right',
			),
			'justify' => array(
				'title' => __( 'Justified', 'cl-restaurant-core' ),
				'icon' => 'eicon-text-align-justify',
			),
		);
	}

	public function rt_grid_options(){
		return [
			'1'  => esc_html__( '1 Columns', 'cl-restaurant-core' ),
			'2'  => esc_html__( '2 Columns', 'cl-restaurant-core' ),
			'3'  => esc_html__( '3 Columns', 'cl-restaurant-core' ),
			'4'  => esc_html__( '4 Columns', 'cl-restaurant-core' ),
			'5'  => esc_html__( '5 Columns', 'cl-restaurant-core' ),
			'6'  => esc_html__( '6 Columns', 'cl-restaurant-core' ),
		];
	}

	public function rt_number_options(){
		return [
			'1'  => esc_html__( '1', 'cl-restaurant-core' ),
			'2'  => esc_html__( '2', 'cl-restaurant-core' ),
			'3'  => esc_html__( '3', 'cl-restaurant-core' ),
			'4'  => esc_html__( '4', 'cl-restaurant-core' ),				
			'5'  => esc_html__( '5', 'cl-restaurant-core' ),
			'6'  => esc_html__( '6', 'cl-restaurant-core' ),
			'7'  => esc_html__( '7', 'cl-restaurant-core' ),
			'8'  => esc_html__( '8', 'cl-restaurant-core' ),
		];
	}

	public function rt_autoplay_speed(){
		return [
			'500'  => esc_html__( '500', 'cl-restaurant-core' ),
			'1000' => esc_html__( '1000', 'cl-restaurant-core' ),
			'1500' => esc_html__( '1500', 'cl-restaurant-core' ),
			'2000' => esc_html__( '2000', 'cl-restaurant-core' ),
			'2500' => esc_html__( '2500', 'cl-restaurant-core' ),
			'3000' => esc_html__( '3000', 'cl-restaurant-core' ),
		];
	}

	public function rt_anim_delay(){
		return [
			'200' => esc_html__( '200', 'cl-restaurant-core' ),
			'300' => esc_html__( '300', 'cl-restaurant-core' ),
			'400' => esc_html__( '400', 'cl-restaurant-core' ),
			'500' => esc_html__( '500', 'cl-restaurant-core' ),
			'600' => esc_html__( '600', 'cl-restaurant-core' ),
			'700' => esc_html__( '700', 'cl-restaurant-core' ),
			'800' => esc_html__( '800', 'cl-restaurant-core' ),
			'900' => esc_html__( '900', 'cl-restaurant-core' ),
		];
	}

	public function rt_placeholder_image(){
		$placeholder_image = CL_RESTAURANT_CORE_BASE_URL.'assets/imgs/placeholder.png';

		/**
		 * Get placeholder image source.
		 *
		 * Filters the source of the default placeholder image used by Elementor.
		 *
		 * @since 1.0.0
		 *
		 * @param string $placeholder_image The source of the default placeholder image.
		 */
		$placeholder_image = apply_filters( 'elementor/utils/get_placeholder_image_src', $placeholder_image );

		return $placeholder_image;
	}

	public function rt_post_orderby(){
		return [
			'ID'  => esc_html__( 'Post Id', 'cl-restaurant-core' ),
			'author' => esc_html__( 'Post Author', 'cl-restaurant-core' ),
			'title' => esc_html__( 'Title', 'cl-restaurant-core' ),
			'date' => esc_html__( 'Date', 'cl-restaurant-core' ),
			'modified' => esc_html__( 'Modified', 'cl-restaurant-core' ),
			'parent' => esc_html__( 'Parent', 'cl-restaurant-core' ),
			'rand' => esc_html__( 'Random', 'cl-restaurant-core' ),
			'comment_count' => esc_html__( 'Comment Count', 'cl-restaurant-core' ),
			'menu_order' => esc_html__( 'Menu Order', 'cl-restaurant-core' ),
		];
	}
	public function rt_blog_categories() {
		$categories = get_categories( array(
			'orderby' => 'name',
			'parent'  => 0
		) );
		if(!empty( $categories )){
			$category_links = array();
			foreach ($categories as $key => $value) {
				$category_links[$value->term_id] = $value->name;  
			}
			return $category_links;
		}
	}

	// post tags lists
	public function rt_blog_tags() {
		$tags     = get_tags( [ 'hide_empty' => false ] );
		$tag_list = [];
		foreach ( $tags as $tag ) {
			$tag_list[ $tag->slug ] = $tag->name;
		}

		return $tag_list;
	}
	public function rt_blog_posts_title() {
		$args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'taxonomy'       => 'category'
		);
		$post_title = array();
		$grid_query = new \WP_Query( $args );
		if ( $grid_query->have_posts() ) : 
			while ( $grid_query->have_posts() ) : $grid_query->the_post();
			$post_title[get_the_ID()] = get_the_title();
			endwhile; wp_reset_postdata();
		endif;
		return $post_title;
	}
	//Get all thumbnail size
	public function rt_get_all_image_sizes() {
		global $_wp_additional_image_sizes;
		$image_sizes = [ '0' => __( 'Default Image Size', 'cl-restaurant-core' ) ];
		foreach ( $_wp_additional_image_sizes as $index => $item ) {
			$image_sizes[ $index ] = ucwords( $index . ' - ' . $item['width'] . 'x' . $item['height'] );
		}
		$image_sizes['full'] = __( "Full Size", 'cl-restaurant-core' );

		return $image_sizes;
	}
	public function rt_posts_title($post) {
		$prefix = CL_RESTAURANT_CORE_THEME_PREFIX;
		$args = array(
			'post_type'    => $post,
			'post_status'  => 'publish',
			// 'taxonomy'     => $prefix.'_portfolio_category',
			'posts_per_page' => -1,
		);
		$post_title = array();
		$grid_query = new \WP_Query( $args );
		if ( $grid_query->have_posts() ) : 
			while ( $grid_query->have_posts() ) : $grid_query->the_post();
			$post_title[get_the_ID()] = get_the_title();
			endwhile; wp_reset_postdata();
		endif;
		return $post_title;
	}

	//Get Custom post category:
	protected function rt_get_categories_by_id( $cat ) {
		$terms   = get_terms( [
			'taxonomy'   => $cat,
			'hide_empty' => true,
		] );
		$options = [ '0' => __( 'All Categories', 'cl-restaurant-core' ) ];
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
			return $options;
		}
	}

	//Get Custom post category:
	protected function rt_get_listing_types() {

		$listing_types = Functions::get_listing_types();
        $listing_types = empty( $listing_types ) ? [] : $listing_types;

		if ( ! empty( $listing_types ) ) {
			foreach ( $listing_types as $key => $listing_type ) {
				$options[ $key ] = $listing_type;
			}
			return $options;
		}
	}

}