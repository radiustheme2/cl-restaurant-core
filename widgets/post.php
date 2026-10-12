<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CL_Restaurant_Core;

use \WP_Widget;
use \RT_Widget_Fields;
use radiustheme\Listygo\Helper;

class Post_Widget extends WP_Widget {
	public function __construct() {
		$id = CL_RESTAURANT_CORE_THEME_PREFIX . '_post';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A2: Posts', 'cl-restaurant-core' ), // Name
            array( 'description' => esc_html__( 'Listygo: Posts Widget', 'cl-restaurant-core' )
        ) );
	}

	public function widget( $args, $instance ){
		echo wp_kses_post( $args['before_widget'] );

		if ( !empty( $instance['title'] ) ) {
			$html = apply_filters( 'widget_title', $instance['title'] );
			$html = $args['before_title'] . $html .$args['after_title'];
		}
		else {
			$html = '';
		}

      	if (!empty($instance['layout'])) {
        	$layout = $instance['layout'];
      	} else {
        	$layout = '';
      	} 
		$q_args = array(
			'cat'                 => (int) $instance['cat'],
			'orderby'             => $instance['orderby'],
			'posts_per_page'      => $instance['number'],
			'ignore_sticky_posts' => true,
		);

		switch ( $instance['orderby'] ){
			case 'title':
			case 'menu_order':
			$q_args['order'] = 'ASC';
			break;
		}

		$query = new \WP_Query( $q_args );
		?>
		<?php if ( $query->have_posts() ) :?>
            <div class="widget-recent">
				<?php echo wp_kses_post( $html ); ?>
				<ul class="recent-post">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li class="media">
						<?php if ( $layout == 2 && has_post_thumbnail() ) { ?>
						<div class="item-img">
							<a href="<?php the_permalink(); ?>" class="item-figure">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</a>
						</div>
						<?php } ?>
						<div class="media-body">
							<h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<span>
								<i class="demo-icon clr-icon-calendar1-1"></i>
								<?php the_time( get_option( 'date_format' ) ); ?>
							</span>
						</div>
					</li>
					<?php endwhile;?>
				</ul>
            </div>
		<?php else: ?>
			<div><?php esc_html_e( 'Currently there are no posts to display', 'cl-restaurant-core' ); ?></div>
		<?php endif;?>
		<?php wp_reset_postdata();?>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['cat']      = ( ! empty( $new_instance['cat'] ) ) ? sanitize_text_field( $new_instance['cat'] ) : '';
		$instance['orderby']  = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';
		$instance['number']   = ( ! empty( $new_instance['number'] ) ) ? sanitize_text_field( $new_instance['number'] ) : '';
		$instance['layout']   = ( ! empty( $new_instance['layout'] ) ) ? sanitize_text_field( $new_instance['layout'] ) : '';
		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'   => '',
			'cat'     => '0',
			'orderby' => '',
			'number'  => '4',
			'layout'  => '1',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories = get_categories();
		$category_dropdown = array( '0' => esc_html__( 'All Categories', 'cl-restaurant-core' ) );

		foreach ( $categories as $category ) {
			$category_dropdown[$category->term_id] = $category->name;
		}

		$orderby = array(
			'date'        => esc_html__( 'Date (Recents comes first)', 'cl-restaurant-core' ),
			'title'       => esc_html__( 'Title', 'cl-restaurant-core' ),
			'menu_order'  => esc_html__( 'Custom Order (Available via Order field inside Page Attributes box)', 'cl-restaurant-core' ),
		);

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cl-restaurant-core' ),
				'type'    => 'text',
			),
			'cat'        => array(
				'label'   => esc_html__( 'Category', 'cl-restaurant-core' ),
				'type'    => 'select',
				'options' => $category_dropdown,
			),
			'orderby' => array(
				'label'   => esc_html__( 'Order by', 'cl-restaurant-core' ),
				'type'    => 'select',
				'options' => $orderby,
			),
			'number' => array(
				'label'   => esc_html__( 'Number of Post', 'cl-restaurant-core' ),
				'type'    => 'number',
			),
			'layout'      => array(
				'label'   => esc_html__( 'Thumbnail Image', 'cl-restaurant-core' ),
				'type'    => 'select',
				'options' => array(
					'1' => esc_html__( 'Without Thumbnail', 'cl-restaurant-core' ),
					'2' => esc_html__( 'With Thumbnail', 'cl-restaurant-core' ),
				),
			),
		);
		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}