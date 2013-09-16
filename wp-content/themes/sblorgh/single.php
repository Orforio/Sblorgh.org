<?php get_header(); ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php sblorgh_post_nav(); ?>
				<?php comments_template(); ?>

			<?php endwhile; ?>
<?php get_footer(); ?>