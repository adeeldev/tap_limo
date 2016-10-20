<?php
/**
 * The page banner
 * @package offtheshelf
 */
?>
<?php if ( ! offtheshelf_custom_block('sub_banner_page') ) : ?>
<header id="page-header">
	<div class="row<?php if (offtheshelf_option('header_sub_banner_full_width', false)) echo ' row-full-width'; ?>">
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<?php if (!is_home()) : ?>
			<div id="breadcrumb">
				<span><?php esc_html_e('You are here:', 'offtheshelf'); ?></span>
				<?php offtheshelf_breadcrumb(); ?>
			</div>
		<?php endif; ?>
	</div>
</header>
<?php endif; ?>