<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Moesia
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if ( get_theme_mod('site_favicon') ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('site_favicon')); ?>" />
<?php endif; ?>

<?php if ( get_theme_mod('apple_touch_144') ) : ?>
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url(get_theme_mod('apple_touch_144')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_114') ) : ?>
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url(get_theme_mod('apple_touch_114')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_72') ) : ?>
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url(get_theme_mod('apple_touch_72')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_57') ) : ?>
	<link rel="apple-touch-icon" href="<?php echo esc_url(get_theme_mod('apple_touch_57')); ?>" />
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'moesia' ); ?></a>

	<?php if ( get_header_image() ) : ?>
		<?php if ( get_theme_mod('moesia_banner') == 1 && !is_front_page() ) : ?>
			<header id="masthead" class="site-header" role="banner">
		<?php else : ?>
			<header id="masthead" class="site-header has-banner" role="banner">
		<?php endif; ?>
		<?php if ( (get_theme_mod('moesia_banner') == 1 && is_front_page()) ||  (get_theme_mod('moesia_banner') != 1)) : ?>
			<?php if ( get_theme_mod('header_overlay') != 1 ) : ?>
				<div class="overlay"></div>
			<?php endif; ?>
			<?php if ( get_theme_mod('header_title') ) : ?>
				<div class="welcome-title"><?php echo esc_attr(get_theme_mod('header_title')); ?></div>
			<?php endif; ?>
			<?php if ( get_theme_mod('header_desc') ) : ?>
				<div class="welcome-desc"><?php echo esc_html(get_theme_mod('header_desc')); ?></div>
			<?php endif; ?>
			<?php if (get_theme_mod('header_btn_text') && get_theme_mod('header_btn_link')) : ?>
				<a href="<?php echo esc_url(get_theme_mod('header_btn_link')); ?>" class="welcome-button"><?php echo esc_html(get_theme_mod('header_btn_text')); ?></a>
			<?php endif; ?>
		<?php endif; ?>
		</header><!-- #masthead -->
		<div class="top-bar">
			<div class="container">
				<div class="site-branding col-md-4">
					<?php if ( get_theme_mod('site_logo') ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img class="site-logo" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
					<?php else : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php endif; ?>
				</div>
				<nav id="site-navigation" class="main-navigation col-md-8" role="navigation">
					<button class="menu-toggle btn"><i class="fa fa-bars"></i></button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
			</div>
		</div>			
	<?php else : ?>
		<header id="masthead" class="site-header top-bar" role="banner">
		<div class="container">
			<div class="site-branding col-md-4">
				<?php if ( get_theme_mod('site_logo') ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img class="site-logo" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
				<?php else : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="main-navigation col-md-8" role="navigation">
				<button class="menu-toggle btn"><i class="fa fa-bars"></i></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #site-navigation -->
		</div>	
	</header><!-- #masthead -->
	<?php endif; ?>

	<?php if (!is_front_page() || ( 'posts' == get_option( 'show_on_front' ) ) ) : ?>
		<?php $container = "container"; ?>
	<?php else : ?>
		<?php $container = ""; ?>
	<?php endif; ?>
	<div id="content" class="site-content clearfix <?php echo $container; ?>">
