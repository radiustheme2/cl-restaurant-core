<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/locations/view-2.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Link;

extract( $data );

$class = $data['display_count'] ? 'rtin-has-count' : '';
?>

<div class="listing-box-wrap listing-shortcode location-shortcode listing-slider-shortcode">
    <div class="rt-global-slider" data-slider-options="<?php echo esc_attr( $data['slider_data'] ); ?>">
        <?php if ($slider_arrow) { ?>
        <div class="sliderNav sliderNav--style1">
            <div class="sliderNav__btn swiper-button-prev"></div>
            <div class="sliderNav__btn swiper-button-next"></div>
        </div>
        <?php } ?>
        <div class="swiper-wrapper">
            <?php
                foreach ( $data['locations'] as $item ) {
                    $term = get_term( $item['location_name'], 'rtcl_location' );
                    if ( $term && !is_wp_error( $term ) ) {
                        $item['title']     = $term->name;
                        $item['count']     = $this->rt_term_post_count( $term->term_id );
                        $item['permalink'] = Link::get_location_page_link( $term );
                    } else {
                        $item['permalink'] = '';
                        $item['title'] = esc_html__( 'Please Select a Location and Background', 'cl-restaurant-core' );
                        $item['count'] = 0;
                        $item['display_count'] = $data['display_count'] = false;
                    }
                    /* translators: %s: number of listings */
                    $count_html = sprintf( _nx( '%s Listing', '%s Listings', $item['count'], 'Number of Listings', 'cl-restaurant-core' ), number_format_i18n( $item['count'] ) );
                    ?>
                    <div class="swiper-slide">
                        <?php if ( $data['style'] == 1 ) { ?>
                            <div class="location-box-layout-1 common-style">
                                <div class="item-img">
                                    <?php echo wp_get_attachment_image( $item['bgimg']['id'], 'full' ); ?>
                                </div>
                                <div class="img-location">
                                    <div class="location-count">
                                        <h4 class="item-title"><a
                                                href="<?php echo esc_url( $item['permalink']); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                                        </h4>
                                        <?php if ( $data['display_count'] ): ?>
                                        <div class="listing-number"><?php echo esc_html( $count_html ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ( $data['style'] == 2 ) { ?>
                            <div class="location-box-layout-2 common-style">
                                <div class="item-img">
                                    <?php echo wp_get_attachment_image( $item['bgimg']['id'], 'full' ); ?>
                                </div>
                                <div class="img-location">
                                    <div class="shape"></div>
                                    <div class="location-count">
                                        <h4 class="item-title"><a
                                                href="<?php echo esc_url( $item['permalink']); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                                        </h4>
                                        <?php if ( $data['display_count'] ): ?>
                                        <div class="listing-number"><?php echo esc_html( $count_html ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $data['enable_link'] ): ?>
                                    <div class="btn-box"><a href="<?php echo esc_url( $item['permalink']); ?>">
                                    <i class="clr-icon-rt18-arrow2-left"></i></a></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } elseif ( $data['style'] == 3 ) { ?>
                            <div class="location-box-layout-3 common-style">
                                <div class="item-img">
                                    <?php echo wp_get_attachment_image( $item['bgimg']['id'], 'full' ); ?>
                                </div>
                                <div class="img-location">
                                    <div class="location-count">
                                        <h4 class="item-title"><a
                                                href="<?php echo esc_url( $item['permalink']); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                                        </h4>
                                        <?php if ( $data['display_count'] ): ?>
                                        <div class="listing-number"><?php echo esc_html( $count_html ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $data['enable_link'] ): ?>
                                    <div class="btn-box"><a href="<?php echo esc_url( $item['permalink']); ?>">
                                    <i class="clr-icon-rt18-arrow2-left"></i></a></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="location-box-layout-1 common-style">
                                <div class="item-img">
                                    <?php echo wp_get_attachment_image( $item['bgimg']['id'], 'full' ); ?>
                                </div>
                                <div class="img-location">
                                    <div class="location-count">
                                        <h4 class="item-title"><a
                                                href="<?php echo esc_url( $item['permalink']); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                                        </h4>
                                        <?php if ( $data['display_count'] ): ?>
                                        <div class="listing-number"><?php echo esc_html( $count_html ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $data['enable_link'] ): ?>
                                    <div class="btn-box btn-box2"><a href="<?php echo esc_url( $item['permalink']); ?>"><i
                                                class="fa-solid fa-arrow-right"></i></a></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
        </div>
        <?php if ($slider_dots) { ?>
        <div class="swiper-pagination"></div>
        <?php } ?>
    </div>
</div>