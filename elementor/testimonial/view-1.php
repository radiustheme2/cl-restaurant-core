<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="rt-el-testimonial carousel-testimonial">
    <div class="slide-wrap">
        <div class="rt-global-slider" data-slider-options="<?php echo esc_attr( $data['slider_data'] ); ?>">
            <div class="swiper-wrapper">
				<?php foreach ( $data['items'] as $item ): ?>
                    <div class="swiper-slide slider-item">
                        <div class="testimonial-block">
                            <?php if ( $data['rating'] ) : ?>
                                <ul class="rating ul-ol">
                                    <?php for ( $i=0; $i <=4 ; $i++ ) {
                                        if ( $i < $item['rating'] ) {
                                            $full = 'active';
                                        } else {
                                            $full = 'deactive';
                                        }
                                        echo '<li class="has-rating"><i class="fa-solid fa-star ' . esc_attr( $full ) . '"></i></li>';
                                    } ?>
                                </ul>
                            <?php endif; ?>
                            <div class="qoute-icon"><i class="clr-icon-rt18-quote"></i></div>
                            <p class="testimonial-block__text">
                                <?php echo esc_html( $item['content'] ); ?>
                            </p>
                            <div class="testimonial-content">
                                
                                <?php 
                                    if ( $item['image']['id'] && $data['thum_display']=='yes') {
                                        echo "<div class='testimonial-img'>";
                                        echo wp_get_attachment_image( $item['image']['id'], 'full' );
                                        echo "</div>";
                                    }
                                ?>
                                <div class="content-info">
                                    <h3 class="testimonial-block__heading"><?php echo esc_html( $item['name'] ); ?></h3>
                                    <?php if ( $item['designation'] ): ?>
                                        <span class="testimonial-block__designation"><?php echo esc_html( $item['designation'] ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
            <?php if ($data['arrows']) { ?>
            <div class="sliderNav">
                <div class="sliderNav__btn swiper-button-prev"></div>
                <div class="sliderNav__btn swiper-button-next"></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

