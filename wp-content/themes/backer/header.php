<!DOCTYPE html>
<!--[if lt IE 8]> <html <?php language_attributes(); ?> class="ie7 ie" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8 ie" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

	<!-- META -->

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="format-detection" content="telephone=no">

	<!-- LINKS -->

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if ( get_option( 'krown_fav' ) != '' ) : ?>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option( 'krown_fav' ); ?>" />

	<?php endif; ?>

	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- WP HEAD -->

	<?php wp_head(); ?>
		
</head>

<body id="body" <?php body_class( get_option( 'krown_sticky', 'regular-header' ) . ' no-touch ' . ( isset( $post ) ? get_post_meta( $post->ID, 'krown_page_layout', true ) : '' ) . ' no-js' ); ?>>

    <!-- Header Start -->
    <header id="header" class="clearfix" style="height:<?php echo get_option( 'krown_logo_height', '23' ) + 77; ?>px">

    	<div class=" clearfix">

    		<div class="wrapper clearfix">

				<!-- Logo Start -->
				<?php 

				$logo = get_option( 'krown_logo' );
				$logo_x2 = get_option( 'krown_logo_x2' );

				if ( $logo == '' ) {
					$logo = get_template_directory_uri() . '/images/logo.png';
				}
				if ( $logo_x2 == '' ) {
					$logo_x2 = $logo;
				}

				?>

				<a id="logo" href="<?php echo home_url(); ?>" style="width:<?php echo get_option( 'krown_logo_width', '117' ); ?>px;height:<?php echo get_option( 'krown_logo_height', '23' ); ?>px">
					<img class="default" src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name' ); ?>" />
					<img class="retina" src="<?php echo $logo_x2; ?>" alt="<?php bloginfo('name'); ?>" />
				</a>
				<!-- Logo End -->

		        <!-- Menu Start -->
		        <nav id="main-menu" class="clearfix right" data-nav-text="<?php _e( '--- Navigate ---', 'krown' ); ?>">

					<?php if ( has_nav_menu( 'primary' ) ) {

						wp_nav_menu( array(
							'container' => false,
							'menu_class' => 'clearfix top-menu',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 2,
							'theme_location' => 'primary',
							'walker' => new Krown_Nav_Walker()
							)
						);

					} ?>

				</nav>	
				<!-- Menu End -->

			</div>

		</div>

	</header>
	<!-- Header End -->

	<!-- Main Wrapper Start -->

	<div id="content" class="clearfix <?php echo krown_sidebar_class(); ?><?php echo krown_md_ch_class(); ?>"<?php echo get_option( 'krown_sticky' ) == 'sticky-header' ? ' style="top:' . ( get_option( 'krown_logo_height', '23' ) + 77 ) . 'px"' : ''; ?>>

		<?php krown_custom_header(); ?>

		<div class="clearfix wrapper">

			<?php echo krown_check_page_title(); ?>

			<?php if ( krown_sidebar_class() == 'layout-left-sidebar' || krown_sidebar_class() == 'layout-right-sidebar' ) : ?>

				<div class="sidebar-content <?php echo get_post_meta( $post->ID, 'krown_page_style', true ); ?>">

			<?php else : ?>

				<div class="normal-content <?php echo get_post_meta( $post->ID, 'krown_page_style', true ); ?>">

			<?php endif; ?>