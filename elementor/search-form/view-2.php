<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RadiusTheme\CLRestaurant\Helper;

?>

<!-- Search form 1 -->
<div class="listygo-search-form search-form-2 <?php echo esc_attr( $data['css_class'] ); ?>">
	<?php Helper::get_custom_listing_template( 'listing-search', true, compact( 'data' ) ); ?>
</div>
<!-- Search form 1 End -->