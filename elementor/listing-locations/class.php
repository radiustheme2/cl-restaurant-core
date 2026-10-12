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
use Elementor\Group_Control_Background;

class Listing_Locations extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'Listing Locations', 'cl-restaurant-core' );
		$this->rt_base = 'rt-listing-locations';
		parent::__construct( $data, $args );

	}
    public function get_script_depends() {
		return [
			'swiper',
		];
	}
	protected function register_controls() {
        $this->start_controls_section(
			'sec_general',
			[
				'label' => esc_html__( 'General', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'style',
			[
				'type'    => Controls_Manager::SELECT2,
				'label'   => esc_html__( 'Style', 'cl-restaurant-core' ),
				'options' => array(
					'1' => esc_html__( 'Style 1', 'cl-restaurant-core' ),
					'2' => esc_html__( 'Style 2', 'cl-restaurant-core' ),
					'3' => esc_html__( 'Style 3', 'cl-restaurant-core' ),
				),
				'default' => '1',
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'location_name', [
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'label'   => esc_html__( 'Select Location', 'cl-restaurant-core' ),
				'description' => esc_html__( 'Location background image', 'cl-restaurant-core' ),
				'options' => $this->rt_get_categories_by_id('rtcl_location'),
				'multiple' => false,
				'label_block' => true,
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'bgimg', [
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Background Image', 'cl-restaurant-core' ),
				'default' => [
					'url' => $this->rt_placeholder_image(),
				],
				'description' => esc_html__( 'Select location background image', 'cl-restaurant-core' ),
				'show_label' => false,
			]
		);
        $this->add_control(
			'locations',
			[
				'label'     => __( 'Add as many locations as you want', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);
		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Box Height', 'cl-restaurant-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'default' => array(
					'unit' => 'px',
					'size' => 500,
				),
				'selectors' => [
					'{{WRAPPER}} .el-location-box .rt-global-slider .location-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'display_count',
			[
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Show Listing Counts', 'cl-restaurant-core' ),
				'label_on'    => esc_html__( 'On', 'cl-restaurant-core' ),
				'label_off'   => esc_html__( 'Off', 'cl-restaurant-core' ),
				'default'     => 'yes',
			]
		);
		$this->add_control(
			'enable_link',
			[
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Enable Link', 'cl-restaurant-core' ),
				'label_on'    => esc_html__( 'On', 'cl-restaurant-core' ),
				'label_off'   => esc_html__( 'Off', 'cl-restaurant-core' ),
				'default'     => 'yes',
				'condition'   => array( 'style' => array( '2' ) ),
			]
		);
		$this->add_responsive_control(
			'border_radius',
			[
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'label'   => esc_html__( 'Image Border Radius', 'cl-restaurant-core' ),
				'selectors' => array(
					'{{WRAPPER}} .img-location .item-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .location-box-layout3.grid .item-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			]
		);
        $this->end_controls_section();


		/* - Carousel Settings
		======================================= */
		$this->start_controls_section(
			'sec_slider_options',
			[
				'label'     => esc_html__( 'Slider Options', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'slider_per_group',
			[
				'label'        => __( 'Slider Per Group', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
			]
		);
		$this->add_control(
			'arrows',
			[
				'label'        => __( 'Arrow', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_responsive_control(
			'icon_position',
			[
				'label'     => __( 'Navigation Position', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'                                                      => [
						'title' => __( 'Left', 'cl-restaurant-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'cl-restaurant-core' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Right', 'cl-restaurant-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .el-location-box.slider .section-heading' => 'justify-content:{{VALUE}}',
					
				],
				'condition' =>[
					'arrows'=>'yes'
				]
			]
		);
		$this->add_control(
			'slider_dots',
			[
				'label'        => __( 'Dots', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false
			]
		);
		$this->add_control(
			'slider_arrow',
			[
				'label'        => __( 'Arrow', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false
			]
		);

		$this->add_control(
			'slider_loop',
			[
				'label'        => __( 'Infinite', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cl-restaurant-core' ),
				'label_off'    => __( 'No', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label'        => __( 'Autoplay', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cl-restaurant-core' ),
				'label_off'    => __( 'No', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false,
			]
		);

		$this->add_control(
			'slider_autoplay_delay',
			[
				'label'     => __( 'Autoplay Speed', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 5000,
				'step'      => 500,
				'default'   => 3000,
				'condition' => [
					'slider_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'centeredSlides',
			[
				'label'        => __( 'Centered Slides', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'cl-restaurant-core' ),
				'label_off'    => __( 'No', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false,
				'description'  => __( 'If you use centered slider options then default column will not working.', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => __( 'Speed', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 5000,
				'step'    => 100,
				'default' => 2000,
			]
		);
		$this->add_control(
			'space',
			[
				'label'   => __( 'Space', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 10,
				],
			]
		);
		$this->add_control(
			'item',
			[
				'label'   => __( 'Desktop items', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 3,
				],
			]
		);
		$this->add_control(
			'medium_item',
			[
				'label'   => __( 'Medium Desktop items', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 2,
				],
			]
		);
		$this->add_control(
			'item_tablet',
			[
				'label'   => __( 'Tablet items', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 2,
				],
			]
		);
		$this->add_control(
			'item_mobile',
			[
				'label'   => __( 'Mobile items', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 1,
				],
			]
		);
		$this->add_control(
			'item_sm_mobile',
			[
				'label'   => __( 'Small Mobile items', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 3,
					],
				],
				'size_units' => [ 'px'],
				'default' => [
					'size' => 1,
				],
			]
		);
		$this->end_controls_section();

		// Styles
		$this->start_controls_section(
			'style_settings',
			[
				'label'     => esc_html__( 'Style Settings', 'cl-restaurant-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'shape_bg_color',
				'label'     => __( 'Background', 'cl-restaurant-core' ),
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Shape Background', 'cl-restaurant-core'),
						'default' => [ 'classic', 'gradient' ],
					]
				],
				'selector'  => '{{WRAPPER}} .location-box-layout-2 .img-location .shape',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'shape_hbg_color',
				'label'     => __( 'Background', 'cl-restaurant-core' ),
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Hover Shape Background', 'cl-restaurant-core'),
						'default' => [ 'classic', 'gradient' ],
					]
				],
				'selector'  => '{{WRAPPER}} .location-box-layout-2:hover .img-location .shape',
			]
		);

		$this->add_control(
			'nav_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Navigation Background', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:after, .swiper-rtl .swiper-button-next:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .swiper-button-next:after, .swiper-rtl .swiper-button-prev:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

    }
    protected function rt_term_post_count( $term_id ) {
		$args = [
			'nopaging'            => true,
			'fields'              => 'ids',
			'post_type'           => 'rtcl_listing',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'suppress_filters'    => false,
			'tax_query'           => [
				[
					'taxonomy' => 'rtcl_location',
					'field'    => 'term_id',
					'terms'    => $term_id,
				],
			],
		];

		$posts = get_posts( $args );
		return count( $posts );
	}
	protected function render() {
		$data = $this->get_settings();
		if($data['slider_autoplay']=='yes'){
			$data['slider_autoplay']=true;
		}
		else{
			$data['slider_autoplay']=false;
		}
		$slider_data = array(
			'slidesPerView' 	=>1,
			'loop'				=>$data['slider_loop']=='yes' ? true:false,
			'centeredSlides'	=>$data['centeredSlides']=='yes' ? true:false ,
			'slideToClickedSlide' =>true,
			'spaceBetween'		=>$data['space']['size'],
			'slidesPerGroup'		=>$data['slider_per_group']['size'],
			'autoplay'				=>array(
				'delay'  => $data['slider_autoplay_delay'],
			),
			'speed'      =>$data['speed'],
			'auto'		=>$data['slider_autoplay'], 
			'breakpoints' =>array(
				'0'    =>array('slidesPerView' =>1),
				'480'    =>array('slidesPerView'  =>$data['item_mobile']['size']),
				'768'    =>array('slidesPerView'  =>$data['item_tablet']['size']),
				'992'    =>array('slidesPerView'  =>$data['medium_item']['size']),		
				'1600'    =>array('slidesPerView' =>$data['item']['size'])
			),
		);
		$data['slider_data'] = json_encode( $slider_data );  
		
		$template = 'view-1';

		$this->rt_template( $template, $data );
	}

}