<?php
/**
 * The blog's banner
 * @package offtheshelf
 */
?>
<?php if ( ! offtheshelf_custom_block('sub_banner_blog') ) : ?>
	<header id="page-header">
		<div class="row<?php if (offtheshelf_option('header_sub_banner_full_width', false)) echo ' row-full-width'; ?>">
			<h1 class="page-title"><?php echo offtheshelf_get_blog_title(); ?></h1>
			<?php if (!is_home()) : ?>
				<div id="breadcrumb">
					<span><?php esc_html_e('You are here:', 'offtheshelf'); ?></span>
					<?php offtheshelf_breadcrumb(); ?>
				</div>
			<?php else : ?>
				<div id="breadcrumb">
					<span><?php esc_html_e('You are here:', 'offtheshelf'); ?></span>
					<ul xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumb">
						<li>
							<span typeof="v:Breadcrumb"><?php esc_html_e('Blog', 'offtheshelf'); ?></span>
						</li>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</header>
<?php endif; ?>