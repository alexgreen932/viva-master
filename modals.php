'<?php
/**
 * The modals template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Viva_Master
 */
?>
<transition-group name="fade" tag="div">
	<div v-if="modal" key="v-modal-bg" class="v-modal-bg" v-on:click="closeAll()" :style="displayWin()"><i class="fas fa-times"></i></div>
	<div v-if="modal=='vkit'" key="vkit" class="v-modal v-modal-1200" :style="displayWin()">
		<h2>VIVA Pro Kit <i class="fas fa-times"></i></h2>
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
			<dd>Visual slideshow* with a lot of transitions and effects</dd>
			<dt>Viva Megamenu</dt>
			<dd>Visual* menu with drag and drop menu items, icons, submenu description, multi column dropdown, preview images etc</dd>
			<dt>Viva Pagebuilder</dt>
			<dd>Visual* pagebuilder with drag and drop elements</dd>
			<dt>Viva Theme Maker</dt>
			<dd>Visual* theme maker where you can easily create theme, just dragging and dropping elements, customize design and set elements to display as on all pages as on selected types of pages</dd>
			<dt>And probably some more...</dt>
			<p class="vv-comment">* - it means what you can see immediately in preview right in admin dashboard, see as example this demo</p>
			<p><strong>The total price of all these plugins will be $150-200, so get your chance, to get the Kit while it's in development for funny price</strong> </p>
		</dl>
		<div class="vv-footer">
			<button class="uk-button v-but-primary" v-on:click="closeAll()">Close</button>
		</div>
	</div>

	<div v-if="modal=='search'" key="search" class="v-modal v-modal-600" :style="displayWin()">
		<i class="fas fa-times v-modal-close" v-on:click="closeAll()"></i>
        <?php the_widget( 'WP_Widget_Search' ); ?>
		<div class="vv-footer">
			<button class="uk-button v-but-primary" v-on:click="closeAll()">Close</button>
		</div>
	</div>

	<div v-if="modal=='login'" key="login" class="v-modal v-modal-600" :style="displayWin()">
		<i class="fas fa-times v-modal-close" v-on:click="closeAll()"></i>
            <?php the_widget( 'WP_Widget_Meta' ); ?>
		<div class="vv-footer">
			<button class="uk-button v-but-primary" v-on:click="closeAll()">Close</button>
		</div>
	</div>

	<div v-if="modal=='account'" key="account" class="v-modal v-modal-800" :style="displayWin()">
		<i class="fas fa-times v-modal-close" v-on:click="closeAll()"></i>
		<?php 
		if (is_plugin_active( 'woocommerce/woocommerce.php')) {
			echo do_shortcode( '[woocommerce_my_account]' );
		}
		 ?>
		<div class="vv-footer">
			<button class="uk-button v-but-primary" v-on:click="closeAll()">Close</button>
		</div>
	</div>
</transition-group>