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

use Elementor\Controls_Manager;

class Plugins_Hooks {

	protected static $instance = null;

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function __construct() {
		add_filter( 'rtcl_el_category_box_style', [ $this, 'cl_restaurant_listing_category_box_style' ], 10 );
        add_filter('rtcl_el_listing_category_widget_general_field', [ $this, 'category_settings_new_fields'], 10, 2 );
        add_filter('rtcl_el_listing_category_widget_general_field', [ $this, 'category_settings_cols_modity'], 10, 2 );
        add_filter('rtcl_el_listing_category_widget_style_field', [ $this, 'category_settings_style_modity'], 10, 2 );
        add_filter('rtcl_el_listing_category_widget_style_field', [ $this, 'category_settings_add_new_style'], 10, 2 );


        add_filter('el_listing_widget_content_visibility_fields', [ $this, 'listing_grid_settings_new_control'], 10, 2 );
        add_filter('rtcl_el_listing_slider_widget_general_field', [ $this, 'listing_slider_settings_field_modifications'], 11, 2 );
        // add_filter('el_listing_widget_content_visibility_fields', [ $this, 'listing_grid_settings_new_control'], 10, 2 );


        // add_filter('rtcl_el_widgets_fields/rtcl-listing-cat-box', [ $this, 'category_settings_cols_modity'], 10, 2 );

        // add_filter('rtcl_el_search_general_fields', [ $this, 'search_settings_modity'], 10, 2 );
		
    }

	
	/**
	 * Undocumented function
	 *
	 * @param [array] $data array for list style.
	 *
	 * @return array
	 */
	public static function cl_restaurant_listing_category_box_style( $data ) {
		$data['style-3'] = esc_html__( 'Style 3', 'cl-restaurant-core' );
		return $data;
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

	public function category_settings_new_fields( $fields, $obj ){

		if( 'rtcl-listing-cat-box' == $obj->rtcl_base ){

			$cat_label = array(
				array(
					'id'      => 'cat_label',
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( ' Category Label', 'cl-restaurant-core' ),
					'condition'   => [ 'rtcl_cats_style' => 'style-3'],		
					'description' => esc_html__( 'Keyword field position', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_cats', $cat_label, $fields );
		}

		return $fields;
	}

	public function category_settings_cols_modity( $fields, $obj ){
		$modify_array = array(
			array(
				'id'        => 'rtcl_sec_responsive',
				'condition'   => [ 'rtcl_cats_style' => ['style-1', 'style-2']],	
			),			
			array(
				'id'        => 'rtcl_col_xl',
				'condition'   => [ 'rtcl_cats_style' => ['style-1', 'style-2']],	
			),			
		);
		$fields = $obj->modify_controls( $modify_array, $fields );

		return $fields;
	}

	public function category_settings_style_modity( $fields, $obj ){
		$modify_array = array(
			array(
				'id'        => 'rtcl_background_body',
				'condition'   => [ 'rtcl_cats_style' => ['style-2', 'style-3']],	
			),			
		);
		$fields = $obj->modify_controls( $modify_array, $fields );

		return $fields;
	}

	public function category_settings_add_new_style( $fields, $obj ){
		if( 'rtcl-listing-cat-box' == $obj->rtcl_base ){
			$label_color = array(
				array(
					'id'      => 'label_color',
					'mode'    => 'responsive',
					'type'    => Controls_Manager::COLOR,
					'label'   => esc_html__( 'label Color', 'cl-restaurant-core' ),
					'selectors' => array( 
						'{{WRAPPER}} .cat-items-label' => 'color: {{VALUE}}'
					),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_title_color', $label_color, $fields );
		}

		return $fields;
	}

	public function listing_grid_settings_new_control( $fields, $obj ){

		if( 'rtcl-listing-slider' == $obj->rtcl_base ){

			$rtcl_show_onoff = array(
				array(
					'type'        => Controls_Manager::SWITCHER,
					'id'          => 'rtcl_show_onoff',
					'label'       => __( 'Show On/Off Status', 'cl-restaurant-core' ),
					'label_on'    => __( 'On', 'cl-restaurant-core' ),
					'label_off'   => __( 'Off', 'cl-restaurant-core' ),
					'default'     => 'yes',
					'description' => __( 'Show or Hide Listing On/Off. Default: On', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_show_image', $rtcl_show_onoff, $fields, true );
			$rtcl_show_discoumt = array(
				array(
					'type'        => Controls_Manager::SWITCHER,
					'id'          => 'rtcl_show_discoumt',
					'label'       => __( 'Show Discount', 'cl-restaurant-core' ),
					'label_on'    => __( 'On', 'cl-restaurant-core' ),
					'label_off'   => __( 'Off', 'cl-restaurant-core' ),
					'default'     => 'yes',
					'description' => __( 'Show or Hide Listing discount offer. Default: On', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_show_onoff', $rtcl_show_discoumt, $fields, true );

			$rtcl_show_more = array(
				array(
					'type'        => Controls_Manager::SWITCHER,
					'id'          => 'rtcl_show_more',
					'label'       => __( 'Show More Details', 'cl-restaurant-core' ),
					'label_on'    => __( 'On', 'cl-restaurant-core' ),
					'label_off'   => __( 'Off', 'cl-restaurant-core' ),
					'default'     => 'yes',
					'description' => __( 'Show or Hide Listing More Details Button. Default: On', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_show_favourites', $rtcl_show_more, $fields, true );

			$rtcl_show_website = array(
				array(
					'type'        => Controls_Manager::SWITCHER,
					'id'          => 'rtcl_show_website',
					'label'       => __( 'Website Details', 'cl-restaurant-core' ),
					'label_on'    => __( 'On', 'cl-restaurant-core' ),
					'label_off'   => __( 'Off', 'cl-restaurant-core' ),
					'default'     => 'yes',
					'description' => __( 'Show or Hide Listing Website. Default: On', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_show_phone', $rtcl_show_website, $fields, true );

			$rtcl_show_website = array(
				array(
					'type'        => Controls_Manager::SWITCHER,
					'id'          => 'rtcl_show_rating',
					'label'       => __( 'Show Rating', 'cl-restaurant-core' ),
					'label_on'    => __( 'On', 'cl-restaurant-core' ),
					'label_off'   => __( 'Off', 'cl-restaurant-core' ),
					'description' => __( 'Show or Hide Listing Rating. Default: Off', 'cl-restaurant-core' ),
				),
			);
			$fields = $obj->insert_new_controls( 'rtcl_show_website', $rtcl_show_website, $fields, true );
		}

		return $fields;
	}

	public function listing_slider_settings_field_modifications( $fields, $obj ){

		if( 'rtcl-listing-slider' == $obj->rtcl_base ){
			
			$modify_fields = array(
				array(
					'id'        => 'rtcl_show_phone',
					'unset'     => array(
						'conditions',
						'condition',
					),
					
				),
			);

			$fields = $obj->modify_controls( $modify_fields, $fields );
			// error_log( print_r( $fields , true ) . "\n\n" , 3, __DIR__ . '/log.txt' );
		}

		return $fields;
	}

}

Plugins_Hooks::instance();