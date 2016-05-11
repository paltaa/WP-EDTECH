<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>

	<?php if ( have_posts() ) the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'article clearfix' ); ?>>

		<?php if ( has_post_thumbnail( $post->ID ) ) : ?>

			<figure class="post-image">

				<?php 

					$retina = krown_retina(); 

					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb, 'full' ); 
					$image = aq_resize( $img_url, $retina === 'true' ? 1960 : 845, null, false, false );  
			    	$title = get_post( $id )->post_title; 

					echo '<img src="' . $image[0] . '" width="' . $image[1]. '" height="' . $image[2] . '" alt="' . $title . '" />';

				?>

			</figure>

		<?php endif; ?>

		<div class="post-body clearfix">

			<section class="post-content clearfix">

				<?php 

					krown_share_buttons( $post->ID );

					the_content();
					wp_link_pages( array(
						'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'krown' ) . '</span>'
						)
					);

					the_tags( '<span class="tags">' . __( 'Tagged with: ', 'krown' ), ', ', '</span>' );

				?>

			</section>

			<?php if( comments_open() )
				comments_template( '', true ); ?>

		</div>

	</article>

<?php get_footer(); ?>