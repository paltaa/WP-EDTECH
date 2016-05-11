<?php
/**
 * Template Name: Sitemap
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

		<div class="krown-column-row">

			<section class="widget widget_archive span8 krown-column-container clearfix cwidget swidget">
				<div class="widget_title">
					<h4><?php _e( 'All pages', 'krown' ); ?>
				</div>
			   <ul><?php wp_list_pages( 'title_li=' ); ?></ul> 
			</section>
			
			<section class="widget widget_archive span4 krown-column-container clearfix cwidget">
				<div class="widget_title">
					<h4><?php _e( 'Latest 20 posts', 'krown' ); ?>
				</div>
			   <ul><?php wp_get_archives( 'type=postbypost&limit=20&show_post_count=1' ); ?></ul> 
			</section>

		</div>

	<?php endwhile; ?>      

<?php get_footer(); ?>