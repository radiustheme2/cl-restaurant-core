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

use radiustheme\ClCar\Helper;
use \WP_Query;

$thumb_size = $data['project_thumbnail_size'] ?? 'rdtheme-size2';
$args = [
	'post_type'           => 'post',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => $data['post_limit'],
	'post_status'         => 'publish',
];
if ( $data['orderby'] ) {
	$args['orderby'] = $data['orderby'];
}
if ( $data['order'] ) {
	$args['order'] = $data['order'];
}

if ( $data['post_source'] == 'by_category' && $data['categories'] ) :
	$args = wp_parse_args(
		[
			'cat' => $data['categories'],
		]
		, $args );
endif;

if ( $data['post_source'] == 'by_tags' && $data['tags'] ) :
	$args = wp_parse_args(
		[
			'tag_slug__in' => $data['tags'],
		]
		, $args );
endif;

// if ( $data['post_source'] == 'by_id' && $data['post_id'] ) :
// 	$post_ids         = explode( ',', $data['post_id'] );
// 	$args['post__in'] = $post_ids;
// endif;

if ( $data['post_source'] == 'by_title' && !empty( $data['titles'] ) ) {
	$args['post__in'] = $titles;
}


if ( $data['exclude'] ) :
	$excluded_ids         = explode( ',', $data['exclude'] );
	$args['post__not_in'] = $excluded_ids;
endif;


if ( $data['offset'] ) {
	$args['offset'] = $data['offset'];
}

$query               = new \WP_Query( $args );
$gird_column_desktop = ( $data['gird_column_desktop'] ? $data['gird_column_desktop'] : '4' );
$gird_column_tab     = ( $data['gird_column_tab'] ? $data['gird_column_tab'] : '6' );
$gird_column_mobile  = ( $data['gird_column_mobile'] ? $data['gird_column_mobile'] : '6' );

$col_class = "col-lg-{$gird_column_desktop} col-md-{$gird_column_tab} col-sm-{$gird_column_mobile}";
?>
<div class="rt-el-post-wrapper <?php echo esc_attr($data['layout']) ?>">
	<?php if ( $query->have_posts() ) : ?>
        <div class="row justify-content-center">
			<?php while ( $query->have_posts() ) : $query->the_post(); 
                $has_thumbnail = has_post_thumbnail() ? ' has-thumbnail' : ' has-no-thumbnail'; ?>
                <div class="<?php echo esc_attr($col_class); ?>">
                    <div class="blog-post blog-grid <?php echo esc_attr($has_thumbnail) ?>">
						<?php if ( has_post_thumbnail()):
							$thumb = get_the_post_thumbnail( get_the_ID(), $thumb_size);
							?>
                            <div class="blog-post__figure">
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo wp_kses_post($thumb); ?>
                                </a>
								<?php if ( $data['date_visibility'] ) : ?>
									<div class="date-meta">
										<?php
										if ( 'default' == $data['p_date_format'] ) {
											?>
											<i class="clr-icon-calendar1-1"></i><?php the_time( get_option( 'date_format' ) ); ?>
											<?php
										} else {
											?>
											<i class="clr-icon-calendar1-1"></i><?php echo class_exists( 'radiustheme\ClCar\Helper' ) ? wp_kses_post( Helper::time_elapsed_string() )
												: esc_html( get_the_time( get_option( 'date_format' ) ) ); ?>
											<?php
										}
										?>
									</div>
								<?php endif; ?>
                            </div>
						<?php endif; ?>
                        <div class="blog-post__content">
							<div class="blog-post__content__meta">
                                <ul class="list-inline">
									<?php if ( $data['author_visibility'] ) : ?>
                                        <li class="author-meta">
                                            <span class="author vcard">
                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                                    <?php
                                                    if ( 'image' == $data['author_avatar'] ) {
														echo get_avatar( get_the_author_meta( 'user_email' ), 35 );
                                                    } elseif ( 'icon' == $data['author_avatar'] ) {
														echo '<i class="clr-icon-rt18-user2"></i>';
                                                    }
                                                    echo esc_html( get_the_author() );
                                                    ?>
                                                </a>
                                            </span>
                                        </li>
									<?php endif; ?>
									<?php if ( $data['reading_time_visibility'] ) : ?>
                                        <li class="reading-time">
                                        <i class="fa-solid fa-clock"></i><?php echo wp_kses_post( Helper::reading_time_count( get_the_content() ) ); ?>
                                        </li>
									<?php endif; ?>
									<?php if ( $data['comment_visibility'] ) : ?>
                                        <li class="comments-meta">
                                        <i class="icon-comment" aria-hidden="true"></i><span class="post-comments-number">
                                                <?php
                                                comments_popup_link(
													esc_html__( 'No Comment', 'cl-restaurant-core' ),
													esc_html__( '1 Comment', 'cl-restaurant-core' ),
													esc_html__( '% Comments', 'cl-restaurant-core' ), '',
													esc_html__( 'Comments are Closed', 'cl-restaurant-core' )
                                                ); ?>
                                            </span>
                                        </li>
									<?php endif; ?>
                                </ul>
                            </div>
                            <?php if ( $data['cat_visibility'] ) : ?>
                                <div class="category-meta">
                                    <?php echo wp_kses_post( get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'cl-restaurant-core' ) ) );
                                    ?>
                                </div>
							<?php endif; ?>
							<?php
								$title = strip_shortcodes( wp_strip_all_tags( get_the_title() ) );
								$title = wp_trim_words( $title, $data['title_limit'], '' );
							?>
                            <h3 class="blog-post__content__heading"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( $title ); ?></a></h3>
							<?php if ( 'visible' == $data['content_visibility'] ) : ?>
								<div class="blog-post__content__excerpt">
									<?php
									$content = strip_shortcodes( wp_strip_all_tags( get_the_content() ) );
									$content = wp_trim_words( $content, $data['content_limit'], '' );
									echo wp_kses_post( $content );
									?>
								</div>
							<?php endif; ?>
							<?php if($data['read_more_btn_display']){ ?>
								<div class="btn-wrap">
									<a href="<?php the_permalink(); ?>" class="item-btn">
										<span class="btn__text"><?php echo esc_html($data['read_more_btn_text']); ?></span>
									</a>
								</div>
							<?php } ?>
                        </div>
                    </div>
                </div>
			<?php endwhile; ?>
        </div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>