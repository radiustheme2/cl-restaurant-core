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

class Custom_Widgets_Init {

	public $widgets;
	protected static $instance = null;
	public function __construct() {
		$widgets = array(
			'about' 	      => 'RT_about_Widget',
			'post'     	      => 'Post_Widget',
			'newsletter'      => 'Newsletter_Widget',
			'advanced-search' => 'Advanced_Search',
		);
		// $widgets2 = array();
		$this->widgets = $widgets;
		add_action( 'widgets_init', array( $this, 'custom_widgets' ) );
		add_filter( 'widget_form_callback', array( $this, 'rt_widget_form_extend' ), 10, 2);
		add_filter( 'widget_update_callback', array( $this, 'rt_widget_update' ), 10, 2 );
		add_filter( 'dynamic_sidebar_params', array( $this, 'rt_dynamic_sidebar_params' ), 0 );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/*====================================================================*/ 
	/* - Add a custom class in every widget
	/*====================================================================*/ 
	public function rt_widget_form_extend( $instance, $widget ) {
		$row = '';
		if ( !isset($instance['classes']) )
		$instance['classes'] = null;   
		$row .= "<p><label>Custom Class:</label>\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
		$row .= "</p>\n";
		echo $row; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- admin widget form HTML built internally
		return $instance;
	}

	public function rt_widget_update( $instance, $new_instance ) {
		$instance['classes'] = $new_instance['classes'];
		return $instance;
	}

	// Value add in widget
	public function rt_dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$widget_id    = $params[0]['widget_id'];
		$widget_obj   = $wp_registered_widgets[$widget_id];
		$widget_opt   = get_option($widget_obj['callback'][0]->option_name);
		$widget_num   = $widget_obj['params'][0]['number'];    
		if ( isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']) )
			$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );
		return $params;
	}

	public function custom_widgets() {
		if ( !class_exists( 'RT_Widget_Fields' ) ) return;
		foreach ( $this->widgets as $filename => $classname ) {
			$file  = dirname(__FILE__) . '/' . $filename . '.php';
			$class = __NAMESPACE__ . '\\' . $classname;
			require_once $file;
			register_widget( $class );
		}
	}
}

Custom_Widgets_Init::instance();