<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CL_Restaurant_Core;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rt_Testimonial extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'Testimonial', 'cl-restaurant-core' );
		$this->rt_base = 'rt-testimonial-carousel';
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

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'name',
			[
				'label'       => __( 'Name', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Enter Name', 'cl-restaurant-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Enter Designation', 'cl-restaurant-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'content',
			[
				'label'   => __( 'Content', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Designation', 'cl-restaurant-core' ),
			]
		);
		$repeater->add_control(
            'rating',[
                'type' => Controls_Manager::SELECT2,
                'label'   => esc_html__( 'Rating', 'cl-restaurant-core' ),
				'options' => array(
					'1' => esc_html__( 'Rating 1', 'cl-restaurant-core' ),
					'2' => esc_html__( 'Rating 2', 'cl-restaurant-core' ),
					'3' => esc_html__( 'Rating 3', 'cl-restaurant-core' ),
					'4' => esc_html__( 'Rating 4', 'cl-restaurant-core' ),
					'5' => esc_html__( 'Rating 5', 'cl-restaurant-core' ),
				),
            ]
        );

		$this->add_control(
			'layout',
			[
				'type'    	  => Controls_Manager::SELECT,
				'label'   	  => esc_html__( 'Layout', 'cl-restaurant-core' ),
				'options' 	  => array(
					'slider'  => esc_html__( 'Slider', 'cl-restaurant-core' ),
					'grid' 	  => esc_html__( 'Grid', 'cl-restaurant-core' ),
				),
				'default' 	  => 'slider',
				'description' => esc_html__( 'Testimonial Layout. Default: 1', 'cl-restaurant-core' ),
			]
		);
		$this->add_control(
			'items',
			[
				'label'       => __( 'Testimonial List', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'name'        => __( 'Maria Zokatti', 'cl-restaurant-core' ),
						'designation' => __( 'CEO, PSDBOSS', 'cl-restaurant-core' ),
						'content'     => __( 'Engage with our professional real estate agents sell Following buy or rent your home.Get emails directly to your area reach inbox and manage the lead with.',
							'cl-restaurant-core' ),
					],
					[
						'name'        => __( 'John Doe', 'cl-restaurant-core' ),
						'designation' => __( 'WordPress Developer', 'cl-restaurant-core' ),
						'content'     => __( 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid expedita recusandae ipsam quas fugit aperiam nihil nemo delectus laudantium? Enim est quibusdam dicta a',
							'cl-restaurant-core' ),
					],
					[
						'name'        => __( 'Kent Odeldan', 'cl-restaurant-core' ),
						'designation' => __( 'Web Designer', 'cl-restaurant-core' ),
						'content'     => __( 'Aliquid expedita recusandae ipsam quas fugit aperiam nihil nemo delectus laudantium? Enim est quibusdam dicta a', 'cl-restaurant-core' ),
					],

				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->add_control(
			'rating',
			[
				'label'        => __( 'Rating', 'cl-restaurant-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->end_controls_section();

		/* = Grid Settings
		======================================= */
		$this->start_controls_section(
			'grid_settings',
			[
				'label'     => esc_html__( 'Grid Settings', 'cl-restaurant-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition'   => array( 'layout' => array( 'grid' ) ),
			]
		);
		$this->add_control(
			'grid_column',
			[
				'label'   => esc_html__( 'Grid Columns', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => $this->rt_grid_options(),
				'condition'   => array( 'layout' => array( 'grid' ) ),
			]
		);
		$this->end_controls_section();

		/* = Carousel Settings
		======================================= */
		$this->start_controls_section(
			'carousel_settings',
			[
				'label'     => esc_html__( 'Carousel Settings', 'cl-restaurant-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
					'layout' => 'slider',
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
					'size' => 24,
				],
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
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
				'condition'   => array( 'layout' => array( 'slider' ) ),
			]
		);
		$this->end_controls_section();

		//Settings
		//=======================================
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Content Style', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'thumb_style_heading',
			[
				'label' => __( 'Thumb Style', 'cl-restaurant-core' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'thum_display',
			[
				'label' => esc_html__( 'Thumb', 'cl-restaurant-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'cl-restaurant-core' ),
				'label_off' => esc_html__( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'thumb_size_width',
			[
				'label'      => __( 'Thumb Size Width', 'cl-restaurant-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 50,
						'max'  => 600,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-img img' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-el-testimonial .testimonial-img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'=>[
					'thum_display' =>'yes'
				]
			]
		);
		$this->add_control(
			'thumb_size_height',
			[
				'label'      => __( 'Thumb Size Height', 'cl-restaurant-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 50,
						'max'  => 600,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-img img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-el-testimonial .testimonial-img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'=>[
					'thum_display' =>'yes'
				]
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'cl-restaurant-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'=>[
					'thum_display' =>'yes'
				]
			]
		);
		$this->add_control(
			'name_style_heading',
			[
				'label'     => __( 'Name Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Name Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block__heading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => esc_html__( 'Name Typography', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .rt-el-testimonial .testimonial-block__heading',
			]
		);
		$this->add_control(
			'designation_style_heading',
			[
				'label'     => __( 'Designation Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'designation_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Designation', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block__designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typo',
				'label'    => esc_html__( 'Designation', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .rt-el-testimonial .testimonial-block__designation',
			]
		);

		$this->add_control(
			'content_style_heading',
			[
				'label'     => __( 'Content Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'content_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Content', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block .testimonial-block__text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typo',
				'label'    => esc_html__( 'Content', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .rt-el-testimonial .testimonial-block .testimonial-block__text',
			]
		);

		$this->add_control(
			'star_style_heading',
			[
				'label'     => __( 'Star Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'star_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Star Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block .rating li i' => 'color: {{VALUE}}',
				]
			]
		);
		$this->add_control(
			'star_active_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Star Active Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block .rating li i.active' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'quote_style_heading',
			[
				'label'     => __( 'Quote Icon Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'quote_sign_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Quote Icon', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block .qoute-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-el-testimonial.style2 .testimonial-block__quote i' => 'color: {{VALUE}}',
				]
			]
		);
		
		$this->add_control(
			'box_style_heading',
			[
				'label'     => __( 'Box Style', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'box_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Box Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-el-testimonial .testimonial-block' => 'background-color: {{VALUE}}',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'box_border',
				'label'    => esc_html__( 'Border', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .rt-el-testimonial .testimonial-block',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$data = $this->get_settings();

		if($data['slider_autoplay']=='yes'){
			$data['slider_autoplay']=true;
		}
		else{
			$data['slider_autoplay']=false;
		}
		$slider_data=array(
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

		if ( 'grid' == $data['layout'] ) {
			$template = 'view-2';
		}

		$this->rt_template( $template, $data );
	}

}