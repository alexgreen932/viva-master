'<?php
/**
 * The modals template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Viva_Master
 */
?>
<!-- modals -->
<transition-group v-if="modal" name="fade" tag="div">
	<div key="v-modal-bg" class="v-modal-bg" v-on:click="closeAll()" :style="displayWin()"><i class="fas fa-times"></i></div>



	<div v-if="modal=='vkit'" key="vkit" class="v-modal v-modal-1200" :style="displayWin()">

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
<!-- side panels -->
<!-- <transition-group name="fade" tag="div"> -->
<transition-group v-if="panel=='cart'" name="slide_right" tag="div">



	<div key="v-panel-bg" class="v-panel-bg" v-on:click="closeAll()" :style="displayWin()"><i class="fas fa-times"></i></div>
	<div key="cart" class="v-panel v-panel-right" :style="displayWin()">
		<h3>Shopping Cart <i class="fas fa-times" v-on:click="closeAll()"></i></h3>
		<?php echo woocommerce_mini_cart(); ?>
	</div>

	
</transition-group>
