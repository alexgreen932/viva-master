<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Viva_Master
 */
//START DEV BLOCK

// END DEV ------------
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="v-app" class="site">
		<a class="skip-link screen-reader-text"
			href="#primary"><?php esc_html_e('Skip to content', 'viva-master'); ?></a>
		<header id="v-header">
			<div id="v-headerbar" class="v-row">
				<div class="uk-container uk-container-center">
					<div class="uk-grid uk-flex-center uk-flex-right">
						<?php if (is_plugin_active('woocommerce/woocommerce.php')): ?>
							<div class="v-el v-cart" data-v-side="v-cart">
								<i class="fas fa-shopping-cart"></i>
								<span class="v-cart-total">
									<?php
									global $woocommerce;
									echo $woocommerce->cart->get_cart_total();
									?>
								</span>
							</div>
						<?php endif ?>
						<?php if (is_plugin_active('google-language-translator/google-language-translator.php')): ?>
							<div class="v-el">
								<?php echo do_shortcode('[google-translator]'); ?>
							</div>
						<?php endif ?>
						<div>
							<span class="v-woo-account v-but-secondary v-but-small v-el" data-v-side="v-cart">Your
								Account</span>
						</div>
					</div>
				</div>
			</div>
			<div id="v-navbar" class="v-row v-navbar">
				<div class="uk-container uk-container-center">
					<div class="uk-grid uk-flex-center uk-flex-middle">
						<div class="v-el v-logo uk-width-auto">
							<a href="<?php echo get_site_url() ?>">
								<img src="<?php echo VTROOT ?>/assets/images/logo.png" alt="">
							</a>
						</div>
						<div class="menu-primary uk-width-expand v-menu-f-r">
							<?php
							wp_nav_menu(
								array(
									'container' => 'ul',
									'theme_location' => 'menu-1',
									'menu_class' => 'v-menu',
									// 'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
									// 'items_wrap' => '%3$s',
									'menu_id' => 'primary-menu',
								)
							);
							?>
							<span data-v-show="primary-menu" class="uk-hidden@m v-mobile" uk-navbar-toggle-icon></span>
						</div>
						<span class="v-el v-p-h-micro uk-light" data-v-modal="v-search"><i
								class="fas fa-search"></i></span>
						<span class="v-el v-p-h-micro uk-light" data-v-modal="v-login"><i
								class="fas fa-user"></i></span>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->