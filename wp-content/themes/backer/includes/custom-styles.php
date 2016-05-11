<?php 
/**
 * This file contains the output of the WordPress Theme Customizer (frontend)
 */

if( ! function_exists( 'krown_custom_css' ) ) {

	function krown_custom_css() {

		// Get Options

		$f_head = is_serialized( get_option('krown_type_heading' ) ) ? unserialize( get_option('krown_type_heading' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_body = is_serialized( get_option( 'krown_type_body' ) ) ? unserialize( get_option( 'krown_type_body' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		
		$colors = get_option( 'krown_colors' );

		$protocol = is_ssl() ? 'https' : 'http';

		// Enequeue Google Fonts

		if ( ! isset( $f_head['default'] ) ) {
			wp_enqueue_style( 'krown-font-head', "$protocol://fonts.googleapis.com/css?family=" . $f_head['css-name'] . ":300,400,400italic,500,600,700,700,800" );
		}

		if ( $f_body != $f_head && !isset( $f_body['default'] ) ) {
			wp_enqueue_style( 'krown-font-body', "$protocol://fonts.googleapis.com/css?family=" . $f_body['css-name'] . ":300,400,400italic,500,600,700,700,800" );
		}

		// Create Custom CSS

		$custom_css = '

			/* CUSTOM FONTS */

			h1, h2, h3, h4, h5, h6, .ignitiondeck.id-creatorprofile .id-creator-name, #custom-header .cta a, .krown-tabs .titles li h5, #content .memberdeck .dashboardmenu li a, .ignitiondeck .id-product-days, .ignitiondeck .id-product-days-to-go, .krown-button, .krown-pie .value, .krown-id-item li span, .id-widget .id-progress-raised, .id-widget .id-product-total, .id-widget .id-product-days, .ignitiondeck.id-mini .id-product-days, .id-level-title, #main-menu ul, .rtitle, .regular-select-cover {
			  font-family: ' . $f_head['font-family'] . ';
			}

			body, input, textarea, button, .memberdeck form .form-row input, .memberdeck form .form-row textarea, blockquote cite {
			  font-family: ' . $f_body['font-family'] . ';
			}

			/* CUSTOM COLORS */

			a, .footer .widget a:hover, .footer .widget ul li.current-cat a:hover, .footer .widget ul li.current_page_item a:hover, .footer .krown-social a:hover i:before, .no-touch .krown-tabs .titles li h5:hover a, .no-touch #content .memberdeck .dashboardmenu li a:hover, .poweredbyID a:hover, #project-p-author .author-meta li, #project-p-author .author-meta a, .id-widget .icon-user:before, .md-projects-list .buttons a:hover i, .memberdeck .md-profile a i:hover, .krown-id-item .container a:hover h3, .ignitiondeck h2.id-product-title a:hover, .ignitiondeck .id-backer-links a:hover, .ignitiondeck.id-creatorprofile .id-creator-links a:hover:before, a.post-title:hover h2, a.post-title:hover h1, .share-buttons a:hover, .comment-title a:hover, .comment-reply-link:hover, .widget ul a:hover, .widget .tagcloud a:hover, .no-touch .krown-accordion h5:hover, .posts-grid a:hover h3, .krown-social li:hover:before, .no-touch .krown-tabs .titles li:hover h5, .krown-tabs .titles .opened h5, .no-touch .memberdeck .dashboardmenu li:hover a, .memberdeck .dashboardmenu li.active a, .krown-twitter a:hover, .rtitle, .print-details .table a.receipt:hover, .social-sharing-options-wrapper .friendlink .text a:hover, .memberdeck form a:hover, .memberdeck a:hover {
				color: ' . $colors['main1'] . ';
			}
			.no-touch #top:hover, .pagination a:hover, .krown-button:hover, .krown-button.color, .krown-button.empty:hover, .fancybox-nav span:hover, .fancybox-close:hover, .fancybox-thumb span:before, input[type="submit"]:hover, .memberdeck button:hover, .memberdeck input[type="submit"]:hover, .memberdeck form .form-row input[type="submit"]:hover, .memberdeck .button:hover, .ignitiondeck form .main-btn:hover, .ignitiondeck form input[type="submit"]:hover, .ignitiondeck a.learn-more-button:hover, .ignitiondeck.idc_lightbox .form-row.submit input[type="submit"]:hover, .md-requiredlogin #wp-submit:hover, .krown-promo.color, .flex-control-nav li a.flex-active, .flexslider.krown-tour .flex-direction-nav a:hover, .tp-bullets.simplebullets.round .bullet.selected, .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current, .mejs-overlay:hover .mejs-overlay-button {
				background-color: ' . $colors['main1'] . ';
			}
			.krown-tabs.horizontal .titles .opened {
				border-top-color: ' . $colors['main1'] . ';
			}
			.krown-team:hover {
				border-color: ' . $colors['main1'] . ';
			}
			.footer input[type="submit"], .flex-direction-nav a:hover, .tparrows.default:hover {
				background-color: ' . $colors['main2'] . ' !important;
			}
			.top-menu > li.selected > a {
				border-bottom-color: ' . $colors['menu1'] . ';
				color: ' . $colors['menu1'] . ';
			}
			.sub-menu li:hover {
				background-color: ' . $colors['menu1'] . ';
			}
			.sub-menu li:hover, .sub-menu li:hover + li {
				border-color: ' . $colors['menu1'] . ';
			}
			.top-menu li.green > a {
				color: ' . $colors['menu2'] . ';
			}
			.top-menu li.green:hover > a {
				border-bottom-color: ' . $colors['menu2'] . ';
				color: ' . $colors['menu2'] . ';
			}

			/* CUSTOM CSS */

		';

		$custom_css .= ot_get_option( 'krown_custom_css', '' );

		// Embed Custom CSS

		wp_add_inline_style( 'krown-style', $custom_css );

	}

}

add_action( 'wp_enqueue_scripts', 'krown_custom_css', 101 );


?>