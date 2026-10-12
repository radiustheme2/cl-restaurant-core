<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CL_Restaurant_Core;

use \WP_Widget;
use \RT_Widget_Fields;
use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Options;

class RT_about_Widget extends WP_Widget {
	public function __construct() {
		$id = CL_RESTAURANT_CORE_THEME_PREFIX . '_about';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A1: About', 'cl-restaurant-core' ), // Name
            array( 'description' => esc_html__( 'Listygo: About Widget', 'cl-restaurant-core' )
        ) );
	}

	public function widget( $args, $instance ){
		echo wp_kses_post( $args['before_widget'] );

		$socials = Helper::socials();
		$title = $instance['title'];
		$desc = $instance['desc'] ? $instance['desc'] : '';
		$social = $instance['social'] ? $instance['social'] : ''; 
		?>

		<div class="widget-about">
			<div class="footer-logo">
				<?php
				if ( ! empty( $instance['logo_img'] ) ) {
					$html = wp_get_attachment_image_src( $instance['logo_img'], 'full' );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( $html[0] ) . '" alt=""></a>';
				} elseif ( ! empty( $instance['title'] ) ) {
					$html = apply_filters( 'widget_title', $instance['title'] );
					echo $args['before_title'] . $html . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted WordPress widget args
				} else {
					if ( 1 == Options::$footer_style ) {
						get_template_part( 'template-parts/header/logo', 2 );
					} elseif ( 2 == Options::$footer_style ) {
						get_template_part( 'template-parts/header/logo', 1 );
					}
				}
				?>
			</div>
			<?php if (!empty($desc)) { ?>
				<p class="footer-text"><?php echo wp_kses_post( $desc ); ?></p>
			<?php } if ( $social == 'enable' && !empty($socials) ) { 
				?>
				<div class="social-btn social-btn-2">
					<ul>
						<?php foreach ( $socials as $social ): ?>
						<li>
							<a class="<?php echo esc_attr( $social['class'] ); ?>" href="<?php echo esc_url( $social['url'] ); ?>" rel="nofollow">
								<i class="<?php echo esc_attr( $social['icon'] ); ?>"></i>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php } ?>
		</div>

        <?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['logo'] = ( ! empty( $new_instance['logo'] ) ) ? sanitize_text_field( $new_instance['logo'] ) : '';
		$instance['logo_img'] = ( ! empty( $new_instance['logo_img'] ) ) ? sanitize_text_field( $new_instance['logo_img'] ) : '';
		$instance['desc']  = ( ! empty( $new_instance['desc'] ) ) ? sanitize_text_field( $new_instance['desc'] ) : '';
		$instance['social'] = ( ! empty( $new_instance['social'] ) ) ? sanitize_text_field( $new_instance['social'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'  	 => '',
			'logo'	 	 => '',
			'logo_img'	 => '',
			'desc'       => '',
			'social'     => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cl-restaurant-core' ),
				'type'    => 'text',
			),
			'logo_img'        => [
				'label' => esc_html__( 'Logo', 'cl-restaurant-core' ),
				'type'  => 'image',
				'desc'  => esc_html__( 'If you don\'t choose logo then default logo will show from Customizer > General', 'cl-restaurant-core' ),
			],
			'desc'        => array(
				'label'   => esc_html__( 'Description', 'cl-restaurant-core' ),
				'type'    => 'textarea',
			),
			'social'        => array(
				'label'   => esc_html__( 'Social', 'cl-restaurant-core' ),
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Social Enable/Disable', 'cl-restaurant-core' ),
					'enable' => esc_html__( 'Enable', 'cl-restaurant-core' ),
					'disable' => esc_html__( 'Disable', 'cl-restaurant-core' ),
				)
			),
		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}