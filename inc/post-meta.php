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

if ( !class_exists( 'RT_Postmeta' ) ) {
	return;
}

$Postmeta = \RT_Postmeta::getInstance();

$prefix = CL_RESTAURANT_CORE_THEME_PREFIX;

$ctp_socials = array(
	'facebook' => array(
		'label' => esc_html__( 'Facebook', 'cl-restaurant-core' ),
		'type'  => 'text',
		'icon'  => 'flaticon-facebook',
		'color' => '#3b5998',
	),
	'twitter' => array(
		'label' => esc_html__( 'Twitter', 'cl-restaurant-core' ),
		'type'  => 'text',
		'icon'  => 'flaticon-twitter',
		'color' => '#1da1f2',
	),
	'instagram' => array(
		'label' => esc_html__( 'Instagram', 'cl-restaurant-core' ),
		'type'  => 'text',
		'icon'  => 'flaticon-instagram',
		'color' => '#AA3DB2',
	),
);

/*---------------------------------------------------------------------
#. = Layout Settings
-----------------------------------------------------------------------*/
$nav_menus = wp_get_nav_menus( array( 'fields' => 'id=>name' ) );
$nav_menus = array( 'default' => esc_html__( 'Default', 'cl-restaurant-core' ) ) + $nav_menus;

$Postmeta->add_meta_box( "{$prefix}_page_settings", esc_html__( 'Layout Settings', 'cl-restaurant-core' ), array( 'page', 'post', 'rtcl_builder' ), '', '', 'high', array(
	'fields' => array(
	
		"{$prefix}_layout_settings" => array(
			'label'   => esc_html__( 'Layouts', 'cl-restaurant-core' ),
			'type'    => 'group',
			'value'  => array(	
			
				"{$prefix}_layout" => array(
					'label'   => esc_html__( 'Layout', 'cl-restaurant-core' ),
					'type'    => 'select',
					'options' => array(
						'default'       => esc_html__( 'Default', 'cl-restaurant-core' ),
						'full-width'    => esc_html__( 'Full Width', 'cl-restaurant-core' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'cl-restaurant-core' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_header_top" => array(
					'label'    	  => esc_html__( 'Header top', 'cl-restaurant-core' ),
					'type'     	  => 'select',
					'options'  	  => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_header_top_layout" => array(
					'label'   => esc_html__( 'Header Top Layout', 'cl-restaurant-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'1'       => esc_html__( 'Layout 1', 'cl-restaurant-core' ),
						'2'       => esc_html__( 'Layout 2', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_tr_header" => array(
					'label'    	  => esc_html__( 'Transparent Header', 'cl-restaurant-core' ),
					'type'     	  => 'select',
					'options'  	  => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_header_area" => array(
					'label' 	  => esc_html__( 'Header Area On/Off', 'cl-restaurant-core' ),
					'type'  	  => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  	  => 'default',
				),
				"{$prefix}_header_menu" => array(
					'label'   => esc_html__( 'Menu Layout', 'cl-restaurant-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'container-fluid custom-padding' => esc_html__( 'Full width layout', 'cl-restaurant-core' ),
						'container'       => esc_html__( 'Box layout', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_footer_newsletter" => array(
					'label' 	  => esc_html__( 'Footer Newsletter', 'cl-restaurant-core' ),
					'type'  	  => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  	  => 'default',
				),
				"{$prefix}_footer_area" => array(
					'label' 	  => esc_html__( 'Footer Area', 'cl-restaurant-core' ),
					'type'  	  => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  	  => 'default',
				),
				"{$prefix}_footer" => array(
					'label'   => esc_html__( 'Footer Layout', 'cl-restaurant-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'1'       => esc_html__( 'Layout 1', 'cl-restaurant-core' ),
						'2'       => esc_html__( 'Layout 2', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_copyright_area" => array(
					'label' 	  => esc_html__( 'Copyright Area', 'cl-restaurant-core' ),
					'type'  	  => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'      => esc_html__( 'Enabled', 'cl-restaurant-core' ),
						'off'     => esc_html__( 'Disabled', 'cl-restaurant-core' ),
					),
					'default'  	  => 'default',
				),
				"{$prefix}_banner" => array(
					'label'   => esc_html__( 'Breadcrumb Area', 'cl-restaurant-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'cl-restaurant-core' ),
						'on'	  => esc_html__( 'Enable', 'cl-restaurant-core' ),
						'off'	  => esc_html__( 'Disable', 'cl-restaurant-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_banner_bgimg" => array(
					'label' => esc_html__( 'Breadcrumb Background Image', 'cl-restaurant-core' ),
					'type'  => 'image',
					'desc'  => esc_html__( 'If not selected, default will be used', 'cl-restaurant-core' ),
				),
				"{$prefix}_banner_bgcolor" => array(
					'label' => esc_html__( 'Breadcrumb Background Color', 'cl-restaurant-core' ),
					'type'  => 'color_picker',
					'desc'  => esc_html__( 'If not selected, default will be used', 'cl-restaurant-core' ),
				),
				"{$prefix}_banner_bgopacity" => array(
					'label' => esc_html__( 'Breadcrumb Background Opacity', 'cl-restaurant-core' ),
					'type'  => 'number',
					'desc'  => esc_html__( 'Max input number will be 100', 'cl-restaurant-core' ),
				),
				"{$prefix}_padding_top" => array(
					'label' => esc_html__( 'Padding Top', 'cl-restaurant-core' ),
					'type'  => 'text',
					'desc'  => esc_html__( 'default banner padding top will be used 100 "px"', 'cl-restaurant-core' ),
				),
				"{$prefix}_padding_bottom" => array(
					'label' => esc_html__( 'Padding Bottom', 'cl-restaurant-core' ),
					'type'  => 'text',
					'desc'  => esc_html__( 'default banner padding bottom will be used 100 "px"', 'cl-restaurant-core' ),
				),
				"{$prefix}_page_bgimg" => array(
					'label' => esc_html__( 'Page/Post Background Image', 'cl-restaurant-core' ),
					'type'  => 'image',
					'desc'  => esc_html__( 'If not selected, default will be used', 'cl-restaurant-core' ),
				),
				"{$prefix}_page_bgcolor" => array(
					'label' => esc_html__( 'Page/Post Background Color', 'cl-restaurant-core' ),
					'type'  => 'color_picker',
					'desc'  => esc_html__( 'If not selected, default will be used', 'cl-restaurant-core' ),
				),
			)
		)
	),
) );

if ( class_exists('Rtcl')) {
    $Postmeta->add_meta_box('listing_extra_fields', esc_html__('Listing Custom Information', 'cl-restaurant-core'), array("rtcl_listing"), '', '', 'high', array(
        'fields' => array(
			"listing_discount" => array(
				'label'   => esc_html__( 'Listing Discount', 'cl-restaurant-core' ),
				'type'    => 'text',
				'default' => '',
			),
        )
    ));
}