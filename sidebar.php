<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Viva_Master
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
//dev comon style v-sidebar-default
?>

<aside id="v-sidebar" class="uk-width-1-4@m">
    <div class="v-sidebar-cards uk-padding-small">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>   
    </div>
<?php 

/*if (is_plugin_active( 'woocommerce/woocommerce.php')) {
    echo "<hr> WOO Active";
} else {
     echo "<hr> WOO NOT Active";
}*/


 ?>

</aside><!-- #secondary -->
