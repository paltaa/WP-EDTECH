<?php
/**
 * Template Name: Slider
 */
get_header(); ?>

	<?php if ( have_posts() ) the_post(); 

		the_content();
		wp_link_pages( array(
			'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'krown' ) . '</span>'
			)
		);

		if( comments_open() && ot_get_option( 'rb_allow_page_comments', 'false' ) == 'true' ) {
			comments_template( '', true );
		} 

get_footer(); ?>