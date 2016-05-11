<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article clearfix' ); ?>>

	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>

		<figure class="post-image">

			<?php 

				$retina = krown_retina(); 

				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url( $thumb, 'full' ); 
				$image = aq_resize( $img_url, $retina === 'true' ? 1690 : 845, null, false, false );  
		    	$title = get_post( $id )->post_title; 

				echo '<img src="' . $image[0] . '" width="' . $image[1]. '" height="' . $image[2] . '" alt="' . $title . '" />';

			?>

		</figure>

	<?php endif; ?>

	<div class="post-body">

		<header class="post-header">

			<a href="<?php the_permalink(); ?>" class="post-title">
				<h2><?php the_title(); ?></h2>
			</a>

			<aside class="post-meta">
				<ul>
					<li class="date"><a href="<?php echo get_permalink(); ?>"><time pubdate datetime="<?php the_time( 'c' ); ?>"><?php the_time( __( 'F j, Y', 'krown' ) ); ?></time></a></li>
					<li class="comments"><a href="<?php echo get_permalink(); ?>#comments"><?php echo __( 'Comments', 'krown' ) . ' ' . get_comments_number( '0', '1', '%' ); ?></a></li>
				</ul>
			</aside>

		</header>

		<section class="post-content clearfix">

			<p class="post-excerpt"><?php echo krown_excerpt( 'krown_excerptlength_post_big'); ?></p>

			<a class="krown-button small light post-more" href="<?php echo get_permalink(); ?>" class="krown-button small dark"><?php _e( 'Read More', 'krown' ); ?></a>

		</section>

	</div>

</article>