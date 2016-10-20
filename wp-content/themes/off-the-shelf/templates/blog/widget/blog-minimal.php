<?php
/**
 * The blog index template file for the 'minimal list' layout.
 * This template will be used for the Blog Content widget.
 * @package offtheshelf
 */

global $offtheshelf_widget_excerpt_length;
$classes = array();
$classes[] = 'fullwidth';
$classes[] = 'blog-layout-minimal';
?>

<div class="<?php echo implode($classes, ' ') ?>">
	<?php while ( $r->have_posts() ) : $r->the_post(); ?>
		<!--BlogPost-->
		<article id="post-<?php the_ID(); ?>" <?php post_class(array('blog_post', 'teaser')); ?>>
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="header_meta">
				<?php esc_html_e('By', 'offtheshelf'); ?> <?php offtheshelf_posted_by(); ?> <span class="meta-date"><?php offtheshelf_posted_on(); ?></span>
				<?php offtheshelf_categories(); ?>
			</div>
			<?php if (!has_post_format('video') && !has_post_format('gallery')) : ?>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo wp_trim_words( get_the_excerpt(), $offtheshelf_widget_excerpt_length, null ); ?></p>
				<?php else: ?>
					<p><?php echo wp_trim_words( get_the_content(), $offtheshelf_widget_excerpt_length, null ) ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</article>
		<!--EndBlogPost-->
	<?php endwhile; ?>
</div>
