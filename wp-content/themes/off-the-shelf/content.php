<?php
/**
 * @package offtheshelf
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php offtheshelf_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'offtheshelf' ) ); ?>
		<?php
		offtheshelf_wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'offtheshelf' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'offtheshelf' ) );
				if ( $categories_list && offtheshelf_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( esc_html__( 'Posted in %1$s', 'offtheshelf' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'offtheshelf' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( esc_html__( 'Tagged %1$s', 'offtheshelf' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'offtheshelf' ), esc_html__( '1 Comment', 'offtheshelf' ), esc_html__( '% Comments', 'offtheshelf' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( esc_html__( 'Edit', 'offtheshelf' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
