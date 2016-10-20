<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package offtheshelf
 */

$sidebar_layout = offtheshelf_option('template_layout', false);
get_header(); ?>

<div class="row<?php if (!$sidebar_layout) : ?> clearfix<?php endif; ?>">
	<?php if ($sidebar_layout == "sidebar-left") offtheshelf_get_sidebar('ots-blog-sidebar'); ?>
	<?php if ($sidebar_layout) : ?><div class="col-3-4"><?php endif; ?>

		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'offtheshelf' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'offtheshelf' ); ?></p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

			<?php if ( offtheshelf_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
				<div class="widget widget_categories">
					<h2 class="widgettitle"><?php esc_html_e( 'Most Used Categories', 'offtheshelf' ); ?></h2>
					<ul>
						<?php
						wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
						) );
						?>
					</ul>
				</div><!-- .widget -->
			<?php endif; ?>

			<?php
			/* translators: %1$s: smiley */
			$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'offtheshelf' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
			?>

			<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

		</div><!-- .page-content -->

		<?php if ($sidebar_layout) : ?></div><?php endif; ?>
	<?php if ($sidebar_layout == "sidebar-right") offtheshelf_get_sidebar('ots-blog-sidebar'); ?>
</div>

<?php get_footer(); ?>
