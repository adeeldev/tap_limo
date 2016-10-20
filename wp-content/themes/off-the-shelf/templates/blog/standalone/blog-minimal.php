<?php
/**
 * The blog index template file for the 'minimal list' layout.
 * @package offtheshelf
 */
if (!is_archive()) {
	$show_sidebar = offtheshelf_option('blog_sidebar_front', true);
}
else {
	$show_sidebar = offtheshelf_option('blog_sidebar_archives', true);
}
$sidebar_position = offtheshelf_option('blog_sidebar_position', 'right');

if ($show_sidebar) $container_col_class = 'col-3-4'; else $container_col_class = 'fullwidth';
?>

<div class="row">
	<?php if ($show_sidebar && $sidebar_position == 'left') offtheshelf_get_sidebar(); ?>
	<div class="<?php echo $container_col_class; ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<!--BlogPost-->
			<article id="post-<?php the_ID(); ?>" <?php post_class(array('blog_post', 'teaser')); ?>>
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="header_meta">
					<?php esc_html_e('By', 'offtheshelf'); ?> <?php offtheshelf_posted_by(); ?> <span class="meta-date"><?php offtheshelf_posted_on(); ?></span>
					<?php offtheshelf_categories(); ?>
				</div>
				<?php if ( ! has_post_format ('video') && ! has_post_format ('gallery') ) : ?>
					<!--Post Content-->
					<p><?php echo get_the_excerpt(); ?></p>
					<!--End Post Content-->
				<?php endif; ?>
			</article>
			<!--EndBlogPost-->
		<?php endwhile; ?>
		<?php offtheshelf_pagination(); ?>
	</div>
	<?php if ($show_sidebar && $sidebar_position == 'right') offtheshelf_get_sidebar(); ?>
</div>