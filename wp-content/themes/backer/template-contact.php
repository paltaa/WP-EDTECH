<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php

			if ( get_post_meta( $post->ID, 'krown_show_map', true ) == 'w-custom-header-map' ) {

				echo '<div id="map-contact" class="insert-map" data-map-lat="' . get_post_meta( $post->ID, 'krown_map_lat', true ) . '" data-map-long="' . get_post_meta( $post->ID, 'krown_map_long', true ) . '" data-marker-img="' . get_post_meta( $post->ID, 'krown_map_img', true ) . '" data-zoom="' . get_post_meta( $post->ID, 'krown_map_zoom', true ) . '" data-greyscale="d-' . get_post_meta( $post->ID, 'krown_map_style', true ) . '" data-marker="d-' . get_post_meta( $post->ID, 'krown_map_marker', true ) . '"></div>';
				
			}

			the_content();
			wp_link_pages( array(
				'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'krown' ) . '</span>'
				)
			);

			if( comments_open() && ot_get_option( 'krown_allow_page_comments', 'false' ) == 'true' ) {
				comments_template( '', true );
			}

		?>

	<?php endwhile;     

get_footer(); ?>