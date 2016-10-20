<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package offtheshelf
 */
?>
<!--Start Blog Sidebar-->
<div id="sidebar" class="col-4" role="complementary">
	<?php if ( ! dynamic_sidebar( 'ots-blog-sidebar' ) ) : ?>

	<?php endif; ?>
</div>
<!--End Blog Sidebar-->
