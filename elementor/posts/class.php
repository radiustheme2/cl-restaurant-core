<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.2
 */

namespace RadiusTheme\CL_Restaurant_Core;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rt_Post extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name      = esc_html__( 'Post', 'cl-restaurant-core' );
		$this->rt_base      = 'rt-post';
		$this->rt_translate = [
			'cols' => [
				'3'  => __( '4 Columns', 'cl-restaurant-core' ),
				'4'  => __( '3 Columns', 'cl-restaurant-core' ),
				'6'  => __( '2 Columns', 'cl-restaurant-core' ),
				'12' => __( '1 Columns', 'cl-restaurant-core' ),
			],
		];
		parent::__construct( $data, $args );
	}

	protected function register_controls() {
		// widget title
		$this->start_controls_section(
			'rt_post_grid',
			[
				'label' => esc_html__( 'Post Grid', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Style', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => __( 'Style 1', 'cl-restaurant-core' ),
					'style2' => __( 'Style 2', 'cl-restaurant-core' ),
				],

			]
		);
		$this->add_control(
			'gridcolumn-popover-toggle',
			[
				'label'        => __( 'Grid Column', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'cl-restaurant-core' ),
				'label_on'     => __( 'Custom', 'cl-restaurant-core' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'gird_column_desktop',
			[
				'label'   => esc_html__( 'Grid Column for Desktop', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '4',
				'options' => $this->rt_translate['cols'],

			]
		);

		$this->add_control(
			'gird_column_tab',
			[
				'label'   => esc_html__( 'Grid Column for Tab', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '6',
				'options' => $this->rt_translate['cols'],

			]
		);

		$this->add_control(
			'gird_column_mobile',
			[
				'label'   => esc_html__( 'Grid Column for Mobile', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '12',
				'options' => $this->rt_translate['cols'],

			]
		);

		$this->end_popover();

		$this->add_control(
			'post_limit',
			[
				'label'       => __( 'Post Limit', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Post Limit', 'cl-restaurant-core' ),
				'description' => __( 'Enter number of post to show.', 'cl-restaurant-core' ),
				'default'     => '12',
			]
		);

		$this->add_control(
			'post_source',
			[
				'label'       => __( 'Post Source', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'most_recent' => __( 'From all recent post', 'cl-restaurant-core' ),
					'by_title'       => __( 'By Post ID', 'cl-restaurant-core' ),
					'by_category' => __( 'By Category', 'cl-restaurant-core' ),
					'by_tags'     => __( 'By Tags', 'cl-restaurant-core' ),
				],
				'default'     => [ 'most_recent' ],
				'description' => __( 'Select posts source that you like to show.', 'cl-restaurant-core' ),
			]
		);
		$this->add_control(
			'titles',
			[
				'label'       => __( 'Choose Titles', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->rt_blog_posts_title(),
				'label_block' => true,
				'condition'   => [
					'post_source' => 'by_title',
				],
				'description' => __( 'Select post category\'s.', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => __( 'Choose Categories', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->rt_blog_categories(),
				'label_block' => true,
				'condition'   => [
					'post_source' => 'by_category',
				],
				'description' => __( 'Select post category\'s.', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'tags',
			[
				'label'       => __( 'Choose Tags', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->rt_blog_tags(),
				'label_block' => true,
				'condition'   => [
					'post_source' => 'by_tags',
				],
				'description' => __( 'Select post tag\'s.', 'cl-restaurant-core' ),
			]
		);

		// $this->add_control(
		// 	'post_id',
		// 	[
		// 		'label'       => __( 'Enter post IDs', 'cl-restaurant-core' ),
		// 		'type'        => Controls_Manager::TEXT,
		// 		'description' => __( 'Enter the post IDs separated by comma', 'cl-restaurant-core' ),
		// 		'label_block' => 'true',
		// 		'condition'   => [
		// 			'post_source' => 'by_id',
		// 		],
		// 	]
		// );

		$this->add_control(
			'offset',
			[
				'label'       => __( 'Post offset', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Post offset', 'cl-restaurant-core' ),
				'description' => __( 'Number of post to displace or pass over. The offset parameter is ignored when post limit => -1 (show all posts) is used.', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'       => __( 'Exclude posts', 'cl-restaurant-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => 'true',
				'description' => __( 'Enter the post IDs separated by comma for exclude', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order by', 'cl-restaurant-core' ),
				'type'    =>Controls_Manager::SELECT,
				'options' => [
					'date'           => __( 'Date', 'cl-restaurant-core' ),
					'ID'             => __( 'Order by post ID', 'cl-restaurant-core' ),
					'author'         => __( 'Author', 'cl-restaurant-core' ),
					'title'          => __( 'Title', 'cl-restaurant-core' ),
					'modified'       => __( 'Last modified date', 'cl-restaurant-core' ),
					'comment_count'  => __( 'Number of comments', 'cl-restaurant-core' ),
					'rand'           => __( 'Random order', 'cl-restaurant-core' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Sort order', 'cl-restaurant-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'ASC'  => __( 'ASC', 'cl-restaurant-core' ),
					'DESC' => __( 'DESC', 'cl-restaurant-core' ),
				],
			]
		);
		$this->end_controls_section();
		
		// Thumbnail style
		//========================================================
		$this->start_controls_section(
			'thumbnail_style',
			[
				'label' => __( 'Thumbnail Style', 'cl-restaurant-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'project_thumbnail_size',
			[
				'label'     => esc_html__( 'Image Size', 'cl-restaurant-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->rt_get_all_image_sizes(),
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => __( 'Image Height', 'cl-restaurant-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range'      => [
					'%' => [
						'min'  => 20,
						'max'  => 100,
					],
					'px' => [
						'min'  => 300,
						'max'  => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__figure img' => 'height: {{SIZE}}{{UNIT}};object-fit:cover',
				],
			]
		);

		$this->end_controls_section();


		// Title Settings
		//=====================================================================
		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title Style', 'cl-restaurant-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Title Color', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__heading a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__heading',
			]
		);
		$this->add_control(
			'title_limit',
			[
				'label'     => __( 'Ttitle Character Limit', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => '10',
			]
		);
		$this->add_control(
			'title_spacing',
			[
				'label'              => __( 'Title Spacing', 'cl-restaurant-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'allowed_dimensions' => 'vertical',
				'default'            => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'isLinked' => false,
				],
			]
		);
		$this->start_controls_tabs(
			'title_style_tabs'
		);
		$this->start_controls_tab(
			'title_normal_tab',
			[
				'label' => __( 'Normal', 'cl-restaurant-core' ),
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover_tab',
			[
				'label' => __( 'Hover', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Title Hover Color', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__heading a:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		// Content Settings
		//=====================================================================

		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Excerpt Style', 'cl-restaurant-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_visibility',
			[
				'label'   => __( 'Excerpt Visibility', 'cl-restaurant-core' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'visible' => [
						'title' => __( 'Visible', 'cl-restaurant-core' ),
						'icon'  => 'eicon-check',
					],
					'hidden'  => [
						'title' => __( 'Hidden', 'cl-restaurant-core' ),
						'icon'  => 'eicon-editor-close',
					],
				],
				'toggle'  => false,
				'default' => 'visible',
			]
		);
		$this->add_control(
			'content_limit',
			[
				'label'     => __( 'Excerpt Limit', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => '14',
				'condition' => [
					'content_visibility' => 'visible',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'content_typography',
				'selector'  => '{{WRAPPER}} .rt-el-post-wrapper .post-excerpt',
				'condition' => [
					'content_visibility' => 'visible',
				],
			]
		);

		$this->add_control(
			'content_spacing',
			[
				'label'              => __( 'Excerpt Spacing', 'cl-restaurant-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-el-post-wrapper .post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'allowed_dimensions' => 'vertical',
				'default'            => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'isLinked' => false,
				],
				'condition'          => [
					'content_visibility' => 'visible',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Content Color', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rt-el-post-wrapper .post-excerpt' => 'color: {{VALUE}}',
				],
				'condition' => [
					'content_visibility' => 'visible',
				],
			]
		);

		$this->end_controls_section();

		// Meta Information Settings
		//=====================================================================

		$this->start_controls_section(
			'meta_info_style',
			[
				'label' => __( 'Meta Info Style', 'cl-restaurant-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'post_meta_typography',
				'selector' => '{{WRAPPER}} .rt-el-post-wrapper .blog-block__meta ul li',
			]
		);

		$this->start_controls_tabs(
			'post_meta_style_tabs'
		);

		$this->start_controls_tab(
			'post_meta_normal_tab',
			[
				'label' => __( 'Normal', 'cl-restaurant-core' ),
			]
		);


		$this->add_control(
			'post_meta_color',
			[
				'label'     => __( 'Meta Color', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__meta .list-inline li' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__meta .list-inline li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'post_meta_hover_tab',
			[
				'label' => __( 'Box Hover', 'cl-restaurant-core' ),
			]
		);

		$this->add_control(
			'post_meta_color_hover',
			[
				'label'     => __( 'Meta Color Hover', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rt-el-post-wrapper .blog-block__content__meta .list-inline li a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'hr1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'author_visibility',
			[
				'label'        => __( 'Author Visibility', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'author_avatar',
			[
				'label'     => __( 'Author Avatar Style', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'icon',
				'options'   => [
					'icon'      => __( 'Author Icon', 'cl-restaurant-core' ),
					'image'     => __( 'Author Image', 'cl-restaurant-core' ),
					'no-avatar' => __( 'No Avatar', 'cl-restaurant-core' ),
				],
				'condition' => [
					'author_visibility' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_visibility',
			[
				'label'        => __( 'Date Visibility', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		
		$this->add_control(
			'cat_visibility',
			[
				'label'        => __( 'Category Visibility', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false
			]
		);

		$this->add_control(
			'p_date_format',
			[
				'label'     => __( 'Date Format', 'cl-restaurant-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'time_ago',
				'options'   => [
					'default'  => __( 'Default From Settings', 'cl-restaurant-core' ),
					'time_ago' => __( 'Time Ago Format', 'cl-restaurant-core' ),
				],
			]
		);


		$this->add_control(
			'reading_time_visibility',
			[
				'label'        => __( 'Reading Time Visibility', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false,
			]
		);

		$this->add_control(
			'comment_visibility',
			[
				'label'        => __( 'Comment Visibility', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => false,
			]
		);


		$this->end_controls_section();
		// Read More Settings
		//=====================================================================

		$this->start_controls_section(
			'read_more_btn',
			[
				'label' => __( 'Button Settings', 'cl-restaurant-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'read_more_btn_display',
			[
				'label'        => __( 'Button', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'cl-restaurant-core' ),
				'label_off'    => __( 'Hide', 'cl-restaurant-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'read_more_btn_text',
			[
				'label'        => __( 'Button Text', 'cl-restaurant-core' ),
				'type'         => \Elementor\Controls_Manager::TEXT,
				'default'	   =>__('More Details','cl-restaurant-core'),
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings();

		$template = 'view-1';
		if ( 'style2' == $data['layout'] ) {
			$template = 'view-2';
		}
		$this->rt_template( $template, $data );
	}

}