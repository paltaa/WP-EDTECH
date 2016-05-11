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

	if ( have_posts() ) {

		if ( $type == 'id-product' ) {
			echo '<div id="ign-search" class="krown-id-grid default clearfix">';
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

		krown_pagination( null, true );

	} else {

		echo '<p>' . __( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'krown' ) . '</p>';

	}

?>

<?php get_footer(); ?>