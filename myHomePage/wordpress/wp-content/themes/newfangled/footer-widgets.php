<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Newfangled
 */

if ( ! is_dynamic_sidebar( ) ) {
	return;
}
?>

		<div class="four columns alpha">
			<?php dynamic_sidebar('footer'); ?>
		</div>

		<div class="four columns">
			<?php dynamic_sidebar('footer-2'); ?>
		</div>

		<div class="four columns">
			<?php dynamic_sidebar('footer-3'); ?>
		</div>

		<div class="four columns omega">
			<?php dynamic_sidebar('footer-4'); ?>
		</div>
