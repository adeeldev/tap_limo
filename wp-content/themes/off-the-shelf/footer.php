<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package offtheshelf
 */
?>
</div>
<?php offtheshelf_sub_footer(); ?>
</main>
<!--End of Main Content-->

<?php offtheshelf_footer(); ?>

<?php if (offtheshelf_is_layout('boxed')) : ?></div><!--End of Wrapper--><?php endif; ?>

<a href="#" class="scrollup"><span><?php esc_html_e('Scroll up', 'offtheshelf'); ?></span></a>
<?php do_action ( 'offtheshelf_before_wp_footer' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>