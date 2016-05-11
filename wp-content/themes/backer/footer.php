<?php
/**
 * The footer of the theme
 */
?>

		</div>

		<?php krown_sidebar(); ?>
	
		<!-- Inner Wrapper End -->
		</div>

	<!-- Main Wrapper End -->
	</div>

	<!-- Footer #1 Wrapper Start -->

	<?php if(get_option('rb_o_ftrtype', 'full') == 'full') : ?>

	<footer id="footer1" class="footer clearfix">

		<div class="krown-column-row wrapper clearfix">

			<?php if( get_option( 'rb_o_ftrareas', 'four' ) == 'four' ) : ?>

				<div class="krown-column-container span3">
					<?php if ( is_active_sidebar( 'krown_footer_widget_1' ) )
						dynamic_sidebar( 'krown_footer_widget_1' ); ?>
				</div>

				<div class="krown-column-container span3 clearfix">
					<?php if ( is_active_sidebar( 'krown_footer_widget_2' ) )
						dynamic_sidebar( 'krown_footer_widget_2' ); ?>
				</div>

				<div class="krown-column-container span3 clearfix">
					<?php if ( is_active_sidebar( 'krown_footer_widget_3' ) )
						dynamic_sidebar( 'krown_footer_widget_3' ); ?>
				</div>

				<div class="krown-column-container span3">
					<?php if ( is_active_sidebar( 'krown_footer_widget_4' ) )
						dynamic_sidebar( 'krown_footer_widget_4' ); ?>
				</div>

			<?php elseif ( get_option( 'rb_o_ftrareas' ) == 'three' ) : ?>

				<div class="krown-column-container span4">
					<?php if ( is_active_sidebar('krown_footer_widget_1' ) )
						dynamic_sidebar( 'krown_footer_widget_1' ); ?>
				</div>

				<div class="krown-column-container span4 clearfix">
					<?php if ( is_active_sidebar( 'krown_footer_widget_2' ) )
						dynamic_sidebar( 'krown_footer_widget_2' ); ?>
				</div>

				<div class="krown-column-container span4">
					<?php if ( is_active_sidebar( 'krown_footer_widget_3' ) )
						dynamic_sidebar( 'krown_footer_widget_3' ); ?>
				</div>

			<?php elseif ( get_option( 'rb_o_ftrareas' ) == 'two' ) : ?>

				<div class="krown-column-container span6">
					<?php if ( is_active_sidebar( 'krown_footer_widget_1' ) )
						dynamic_sidebar( 'krown_footer_widget_1' ); ?>
				</div>

				<div class="krown-column-container span6">
					<?php if ( is_active_sidebar( 'krown_footer_widget_2' ) )
						dynamic_sidebar( 'krown_footer_widget_2' ); ?>
				</div>

			<?php elseif ( get_option( 'rb_o_ftrareas' ) == 'one' ) : ?>

				<div class="krown-column-container span12">
					<?php if ( is_active_sidebar( 'krown_footer_widget_1' ) )
						dynamic_sidebar( 'krown_footer_widget_1' ); ?>
				</div>

			<?php endif; ?>

		</div>

    </footer>

    <?php endif; ?>

	<!-- Footer #1 Wrapper End -->

	<!-- Footer #2 Wrapper Start -->

	<footer id="footer2" class="footer clearfix">

		<div class="wrapper clearfix">

			<div class="left clearfix">
				<?php if ( is_active_sidebar( 'krown_footer_widget_5' ) )
					dynamic_sidebar( 'krown_footer_widget_5' ); ?>
			</div>

			<div class="right clearfix">
				<?php if ( is_active_sidebar('krown_footer_widget_6' ) )
					dynamic_sidebar( 'krown_footer_widget_6' ); ?>
			</div>

		</div>

    </footer>
	<!-- Footer End -->

	<!-- GTT Button -->
	<a id="top" href="#"></a> 

	<!-- IE7 Message Start -->
	<div id="oldie">
		<p><?php _e('This is a unique website which will require a more modern browser to work!', 'krown'); ?><br /><br />
		<a href="https://www.google.com/chrome/" target="_blank"><?php _e('Please upgrade today!', 'krown'); ?></a>
		</p>
	</div>
	<!-- IE7 Message End -->

	<?php wp_footer(); ?>
<p class="TK">Powered by <a href="http://themekiller.com/" title="themekiller" rel="follow"> themekiller.com </a> </p>
</body>
</html>