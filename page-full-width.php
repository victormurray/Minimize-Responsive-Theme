<?php
/*
 * Template Name: Full Width
 * This template is used for the display of full width single pages.
 */

get_header(); ?>
	<section class="content-wrapper page-content full-width-content-wrapper">
		<article class="content full-width-content">
			<?php get_template_part( 'yoast', 'breadcrumbs' ); // Yoast Breadcrumbs ?>

			<?php get_template_part( 'loop', 'page-full-width' ); // Loop - Full Width ?>

			<section class="clear">&nbsp;</section>

			<section id="comments-container" class="comments-container post-comments post-comments-container">
				<?php comments_template(); // Comments ?>
			</section>
		</article>

		<section class="clear">&nbsp;</section>
	</section>

<?php get_footer(); ?>