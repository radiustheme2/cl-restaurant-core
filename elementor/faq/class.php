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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rt_Faq extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'Faq', 'cl-restaurant-core' );
		$this->rt_base = 'rt-faq';
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
			'title', [
				'label' => __( 'Title', 'cl-restaurant-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'List Title' , 'cl-restaurant-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content', [
				'label' => __( 'Content', 'cl-restaurant-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'cl-restaurant-core' ),
				'show_label' => false,
			]
		);
		$this->add_control(
			'faq_items',
			[
				'label'       => __( 'Faq List', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'        => __( 'Why do I need a Directory Listing for my Business?', 'cl-restaurant-core' ),
						'content'     => __( 'Mauris sit dignissim tempor eget tellus pretium a pulvinar ut. In sed diam egestas vulputate at there euismod. In odio sed id velit integer diam sed cras. Ut volutpat, in rhoncus massa. Morbi leo lobortis nullam non ornare mauris, pulvinar. Id pellentesque a neque at egestas. Lorem ipsum dolor sit amet, gravida.',
							'cl-restaurant-core' ),
					],
					[
						'title'        => __( 'Does my Business need a Listing on all Directories?', 'cl-restaurant-core' ),
						'content'     => __( 'Activities sit dignissim tempor eget tellus pretium a pulvinar ut. In sed diam egestas vulputate at there euismod. In odio sed id velit integer diam sed cras. Ut volutpat, in rhoncus massa. Morbi leo lobortis nullam non ornare mauris, pulvinar. Id pellentesque a neque at egestas. Lorem ipsum dolor sit amet, gravida.',
							'cl-restaurant-core' ),
					],
					[
						'title'        => __( 'What are the Benefits of Paid Listings?', 'cl-restaurant-core' ),
						'content'     => __( 'Odeldan sit dignissim tempor eget tellus pretium a pulvinar ut. In sed diam egestas vulputate at there euismod. In odio sed id velit integer diam sed cras. Ut volutpat, in rhoncus massa. Morbi leo lobortis nullam non ornare mauris, pulvinar. Id pellentesque a neque at egestas. Lorem ipsum dolor sit amet, gravida.',
							'cl-restaurant-core' ),
					],

				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->add_control(
			'icon_display',
			[
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Icon', 'cl-restaurant-core' ),
				'label_on'    => esc_html__( 'On', 'cl-restaurant-core' ),
				'label_off'   => esc_html__( 'Off', 'cl-restaurant-core' ),
				'description' => esc_html__( 'Enable or disable icon. Default: Off', 'cl-restaurant-core' ),
				'default' => 'on',
			]
		);
		$this->add_control(
			'icon',
			[
				'type'        => Controls_Manager::ICONS,
				'label'   => esc_html__( 'Icon', 'cl-restaurant-core' ),
				'default' => array(
					'value' => 'fas fa-smile-wink',
					'library' => 'fa-solid',
				),
				'condition'   => [ 'icon_display!' => ''],
			]
		);
		$this->add_control(
			'active_icon',
			[
				'type'        => Controls_Manager::ICONS,
				'label'   => esc_html__( 'Active Icon', 'cl-restaurant-core' ),
				'default' => array(
					'value' => 'far fa-smile',
					'library' => 'fa-solid',
				),
				'condition'   => [ 'icon_display!' => ''],
			]
		);
		$this->add_control(
			'icon_position',
			[
				'type'    => Controls_Manager::CHOOSE,
				'label'   => esc_html__( 'Icon Position', 'cl-restaurant-core' ),
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'cl-restaurant-core' ),
						'icon' => 'far fa-hand-point-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'cl-restaurant-core' ),
						'icon' => 'far fa-hand-point-right',
					],		     
				],
				'default' => 'right',
				'label_block' => false,
				'toggle' => false,
				'condition'   => [ 'icon_display!' => ''],
			]
		);
		$this->add_responsive_control(
			'space_bottom',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Space Bottom', 'cl-restaurant-core' ),
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->end_controls_section();

		/* = Title Style
		========================================= */
		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Title Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => esc_html__( 'Title Typography', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .faq-box .panel-heading .accordion-button',
			]
		);
		$this->add_control(
			'title_active_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Title Active Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button:not(.collapsed)' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		/* = Content Style
		========================================= */
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Content', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'cl-restaurant-core' ),
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-body' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typo',
				'label'    => esc_html__( 'Designation', 'cl-restaurant-core' ),
				'selector' => '{{WRAPPER}} .faq-box .panel-body',
			]
		);
		$this->end_controls_section();

		/* = Icon Style
		========================================= */
		$this->start_controls_section(
			'icon_style',
			[
				'label' => __( 'Icon', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'cl-restaurant-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button span.rtin-accordion-icon .rtin-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button span.rtin-accordion-icon .rtin-icon svg path' => 'stroke: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Active Color', 'cl-restaurant-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button:not(.collapsed) span.rtin-accordion-icon .rtin-icon.rt-icon-opened i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button:not(.collapsed) span.rtin-accordion-icon .rtin-icon.rt-icon-opened svg path' => 'stroke: {{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' =>'',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button span.rtin-accordion-icon .rtin-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .faq-box .panel-heading .accordion-button span.rtin-accordion-icon .rtin-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'cl-restaurant-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rt-el-testimonial-carousel.style2 .testimonial-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$data = $this->get_settings();

		$template = 'view';

		$this->rt_template( $template, $data );
	}

}