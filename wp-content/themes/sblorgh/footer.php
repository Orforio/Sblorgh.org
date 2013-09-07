	</div>
	<nav class="menubar">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		<?php get_search_form(); ?>
	</nav>
	<footer>
		<p>&copy; <a href="/contacts/" title="Contact me">Richard Whittaker</a> | Powered by <a href="http://www.wordpress.org/" title="Visit WordPress.org">WordPress</a> and <?php echo sblorgh_randomise_footer(); ?> | Amot Melak Matita</p>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>