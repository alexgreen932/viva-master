<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Viva_Master
 */

get_header();
?>

	<main id="v-main" class="uk-container uk-container-center">
		<div class="uk-grid uk-flex-center">
			<div class="uk-width-3-4@m">

		<section class="error-404 not-found uk-text-center">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'viva-master' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like the page  was not found. Maybe it was renamed or removed, try to use the search below.', 'viva-master' ); ?></p>
				
				<!-- <img src="<?php echo get_template_directory_uri() ?>/assets/images/404.png" alt="not found"> -->

					<?php
					//dev
					echo get_post_type();
					//-----
					get_search_form();

					// the_widget( 'WP_Widget_Recent_Posts' );
					?>
					<img class="uk-align-center uk-margin-remove-adjacent" src="<?php echo get_template_directory_uri() ?>/assets/images/404.png" alt="not found" loading="lazy">
<!--
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'viva-master' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!~~ .widget ~~>

					<?php
					/* translators: %1$s: smiley */
					$viva_master_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'viva-master' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$viva_master_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?>-->

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();
