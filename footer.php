<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Viva_Master
 */
/*if ( is_user_logged_in() ) {
echo 'Вы авторизованы на сайте!';
}
else {
echo 'Вы всего лишь пользователь!';
}
*/
$ava = get_avatar_url(wp_get_current_user(), array(
    'size' => 120,
    'default' => 'wavatar',
));
?>

<footer id="v-footer">


    <div class="v-row">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-child-width-1-<?php echo esc_html($i) ?> uk-flex-center">
                <?php
                if (is_active_sidebar('sidebar-11')) {
                    echo '<div> ';
                    dynamic_sidebar('sidebar-11');
                    echo '</div> ';
                }
                if (is_active_sidebar('sidebar-12')) {
                    echo '<div> ';
                    dynamic_sidebar('sidebar-12');
                    echo '</div> ';
                }
                if (is_active_sidebar('sidebar-13')) {
                    echo '<div> ';
                    dynamic_sidebar('sidebar-13');
                    echo '</div> ';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="v-row">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-flex-center">
                <a class="v-el" href="<?php echo get_site_url() ?>"><i class="far fa-copyright"></i> Copyright
                    VIVAPRO.NET</a>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
<?php include 'extras.php'; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>