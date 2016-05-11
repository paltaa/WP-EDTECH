<?php
/**
 * The template for displaying archives.
 */
get_header(); ?>

	<?php 

	if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ignition_product' ) {
		$type = 'id-product';
	} else {
		$type = 'post';
	}

	if ( $type == 'id-product' ) {
		echo '<div id="ign-archive" class="krown-id-grid default clearfix">';
	}

	while ( have_posts() ) : the_post();

		if ( $type == 'id-product' ) {

			get_template_part( 'content-ignition_product' );

		} else {

			get_template_part( 'content' );

		}

	endwhile;

	if ( $type == 'id-product' ) {
		echo '</div>';
	}

	if ( is_author() ) {
		krown_author_profile();
	}

	krown_pagination( null, true );

?>

<?php get_footer(); ?>