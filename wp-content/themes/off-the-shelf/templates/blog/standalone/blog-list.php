<?php
/**
 * The blog index template file for the 'list' layout.
 * @package offtheshelf
 */
if (!is_archive()) {
	$show_sidebar = offtheshelf_option('blog_sidebar_front', true);
}
else {
	$show_sidebar = offtheshelf_option('blog_sidebar_archives', true);
}
$sidebar_position = offtheshelf_option('blog_sidebar_position', 'left');

if ($show_sidebar) $container_col_class = 'col-3-4'; else $container_col_class = 'fullwidth';
?>

<div class="row">
	<?php if ($show_sidebar && $sidebar_position == 'left') offtheshelf_get_sidebar(); ?>
	<div class="<?php echo $container_col_class; ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(array('blog_post', 'teaser')); ?>>
				<!--BlogPost-->
				<?php if (has_post_format('quote')) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()) ?>">
						<blockquote>
							<q><?php the_content(); ?></q>
							<div class="quote_author"><?php the_title(); ?></div>
						</blockquote>
					</a>

					<header>
						<div class="header_meta"><?php offtheshelf_posted_by(); ?> <span class="meta-date"><?php offtheshelf_posted_on(); ?></span></div>
					</header>
				<?php elseif (has_post_format('link')) : ?>
					<?php
					$sanitized_content = wp_strip_all_tags( get_the_content() );

					if ( $links = offtheshelf_get_link($sanitized_content) ) {
						$link = $links;
					}
					else {
						$link = $sanitized_content;
					}

					$link = trim ($link);

					if (offtheshelf_is_valid_url($link)) : ?>
						<a href="<?php echo esc_url($link); ?>" class="format-link-content" title="<?php the_title_attribute(); ?>" target="_blank">
							<h2><?php the_title(); ?></h2>
							<div class="link_url"><?php echo esc_url($link); ?></div>
						</a>
					<?php else: ?>

					<?php endif; ?>

					<header>
						<div class="header_meta"><?php offtheshelf_posted_by(); ?> <span class="meta-date"><?php offtheshelf_posted_on(); ?></span></div>
					</header>

				<?php else : ?>
					<header>
						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="header_meta"><?php esc_html_e('By', 'offtheshelf'); ?> <?php offtheshelf_posted_by(); ?> <span class="meta-date"><?php offtheshelf_posted_on(); ?></span> <?php offtheshelf_categories(); ?> <?php if ( comments_open() ) : ?><span class="meta_comment"><a href="<?php comments_link(); ?>"><?php esc_html_e('Leave a comment', 'offtheshelf'); ?></a></span><?php endif; ?></div>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="post-thumbnail"><?php the_post_thumbnail('ots-post-thumbnail'); ?></a>
					<?php endif; ?>

					<!--Post Content-->
					<?php if (has_post_format('video') || has_post_format('image') || has_post_format('gallery')) : ?>
						<?php the_content(); ?>
					<?php else: ?>
						<!--Post Content-->
						<?php if ( offtheshelf_option('blog_content_mode_archive', 'excerpt') == 'excerpt' && ( is_archive() || is_post_type_archive() ) ) : ?>
							<p><?php echo get_the_excerpt(); ?></p>
						<?php elseif ( offtheshelf_option('blog_content_mode_index', 'excerpt') == 'excerpt' && is_home() ) : ?>
							<p><?php echo get_the_excerpt(); ?></p>
						<?php else : ?>
							<?php the_content(); ?>
						<?php endif; ?>
						<!--End Post Content-->
					<?php endif; ?>
					<!--End Post Content-->

					<?php echo offtheshelf_read_more_link(); ?>


				<?php endif; ?>
			</article>
			<!--EndBlogPost-->
		<?php endwhile; ?>
		<?php offtheshelf_pagination(); ?>
	</div>
	<?php if ($show_sidebar && $sidebar_position == 'right') offtheshelf_get_sidebar(); ?>
</div>