<?php
/**
* The modals template file
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Viva_Master
*/
?>
<div id="v-search" class="v-modal">
	<div class="v-bg v-close-all"><i class="fas fa-times"></i></div>
	<div class="v-modal-600 v-modal-content">
		<?php the_widget( 'WP_Widget_Search' ); ?>
	</div>
</div>

<div id="v-login" class="v-modal">
	<div class="v-bg v-close-all"><i class="fas fa-times"></i></div>
	<div class="v-modal-600 v-modal-content">
		<?php the_widget( 'WP_Widget_Meta' ); ?>
	</div>
</div>

<div id="vkit" class="v-modal">
	<div class="v-bg v-close-all"><i class="fas fa-times"></i></div>
	<div class="v-modal-1200 v-modal-content">
		<h3>VIVA Pro Kit <i class="fas fa-times v-close-all"></i></h3>
		<ul class="uk-list uk-list-hyphen">
			<li>Getting VIVA Pro Kit you support further development of our product!</li>
			<li>You will be able to download all Pro plugins which will be released within an year!</li>
			<li>You have the unique opportunity, to get it for very low price!</li>
		</ul>
		<h3>What plugins will be released?</h3>
		<p>Now we have the following plugins in development:</p>
		<dl class="uk-description-list uk-description-list-divider">
			<dt>Viva(OSS) Content Cards</dt>
			<dd>Released...</dd>
			<dt>Viva Content Slideshow</dt>
			<dd>Released - for Early Access(publishing August 10). Stable version, and version Pro follow soon</dd>
			<dt>Viva Megamenu</dt>
			<dd>Released - for Early Access(publishing August 10). Stable version, and version Pro follow soon</dd>
			<dt>Viva Nice Admin</dt>
			<dd>Smart Organizer of your admin dashboard, you will be able create favorites bar with most used menu items group them and highlte with different colors.  And much more...(approximate release date is August)</dd>
			<dt>Viva Theme Kit(theme builder)</dt>
			<dd>Visual* theme maker where you can easily create theme, just dragging and dropping elements, customize design and set elements to display as on all pages as on selected types of pages(approximate release date is September-October)</dd>
			<dt>Viva Page Kit(page builder)</dt>
			<dd>Visual* pagebuilder with drag and drop elements(approximate release date is October-November)</dd>
			<dt>And probably some more...</dt>
			<p class="vv-comment">* - it means what you can see immediately in preview right in admin dashboard, see as example this demo</p>
			<p><strong>The total price of all these plugins will be $150-200, so get your chance, to get the Kit while it's in development for funny price</strong> </p>
		</dl>
		<div class="vv-footer uk-padding uk-text-center">
			<a class="uk-button uk-button-primary" href="http://vivapro.net/product/viva-pro-kit/">Get VIVA PRO Kit</a>
			<button class="uk-button uk-button-default" v-on:click="closeAll()">Close</button>
		</div>
	</div>
</div>

<div id="v-account" class="v-modal">
	<div class="v-bg v-close-all"><i class="fas fa-times"></i></div>
	<div class="v-modal-1200 v-modal-content">
		<h3>My Account <i class="fas fa-times v-close-all"></i></h3>
		<?php 
		if (is_plugin_active( 'woocommerce/woocommerce.php')) {
			echo do_shortcode( '[woocommerce_my_account]' );
		}
		 ?>
		<div class="vv-footer v-close-all">
			<button class="uk-button v-but-primary">Close</button>
		</div>
	</div>
</div>

<div id="v-cart" class="v-panel-right">
	<div class="v-bg v-close-all"><i class="fas fa-times"></i></div>
	<div class="v-panel-conent">
		<h3>My Account <i class="fas fa-times v-close-all"></i></h3>
		<?php 
		if (is_plugin_active( 'woocommerce/woocommerce.php')) {
			echo do_shortcode( '[woocommerce_my_account]' );
		}
		 ?>
		<div class="vv-footer v-close-all">
			<button class="uk-button uk-button-primary">Close</button>
		</div>
	</div>
</div>