<?php
/**
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

extract( $data );
$align = $data['align'];
$heading_tag_html = sprintf( '<%1$s %2$s class="heading-title">%3$s</%1$s>', $data['heading_tag'], $this->get_render_attribute_string( 'title' ), $data['title'] );

$attr = '';
if ( !empty( $url['url'] ) ) {
	$attr  = 'href="' . esc_url( $data['url']['url'] ) . '"';
	$attr .= !empty( $data['url']['is_external'] ) ? ' target="_blank"' : '';
	$attr .= !empty( $data['url']['nofollow'] ) ? ' rel="nofollow"' : '';
}

?>
<div class="section-heading">
	<?php if ( !empty( $data['subtitle'] ) ){ ?>
        <div class="heading-subtitle"><?php echo wp_kses_post( $data['subtitle'] ); ?></div>
    <?php } echo wp_kses_post( $heading_tag_html ); ?>
    <?php echo wp_kses_post( $data['desc'] ); ?>
    <?php if ( !empty( $url['url'] ) ) { ?>
        <div class="btn-wrap btn-v2">
            <a <?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="item-btn">
                <?php echo esc_html( $data['btntext'] ); ?>
            </a>
        </div>
	<?php } ?>
</div>