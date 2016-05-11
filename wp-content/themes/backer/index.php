<?php
/**
 * Index file - silence would be golden if Envato would allow this.
 */
get_header();

	$paged_string = is_home() || is_front_page() ? 'page' : 'paged';
	$paged = get_query_var( $paged_string ) ? get_query_var( $paged_string ) : 1;

	$args = array(
		'paged' => $paged, 
		'post_type' => 'post'
	);
	$all_posts = new WP_Query( $args );

	while ( $all_posts->have_posts() ) : $all_posts->the_post();

		get_template_part( 'content' );

	endwhile;

	krown_pagination( $all_posts ); 

get_footer(); ?>