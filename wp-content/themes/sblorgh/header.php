<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php bloginfo( 'name' ); ?> | <?php is_home() ? bloginfo( 'description' ) : wp_title(''); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="page-header" id="<?php sblorgh_randomise_header(); ?>">
		<div class="header-text">   
			<h1 class="site-title">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">sblorgh.</a>
			</h1>
		</div>
	</header>
	
	<div class="main-container">
		<nav class="menu-sidebar">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			<div class="menu-sidebar-search">
				<?php get_search_form(); ?>
			</div>
			<div class="menu-sidebar-buttons">
				<ul>
					<li><a href='https://alpha.app.net/pkeruno' class='adn-button' target='_blank' data-type='follow' data-width='165' data-height='27' data-user-id='@pkeruno' data-show-username='1' rel='me'>Follow me on App.net</a><script>(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//d2zh9g63fcvyrq.cloudfront.net/adn.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'adn-button-js'));</script></li>
					<li><a href="https://github.com/PkerUNO"><i class="genericon genericon-icon-button genericon-github" title="GitHub">&nbsp;</i></a></li>
					<li><a href="http://uk.linkedin.com/in/richardwhittaker/"><i class="genericon genericon-icon-button genericon-linkedin-alt" title="LinkedIn">&nbsp;</i></a></li>
					<li><a href="http://www.flickr.com/photos/pkeruno/"><i class="genericon genericon-icon-button genericon-flickr" title="Flickr">&nbsp;</i></a></li>
					
				</ul>
			</div>
		</nav>
		<section class="main-content group">