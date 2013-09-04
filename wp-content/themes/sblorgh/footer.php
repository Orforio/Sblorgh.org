			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle">Menu</h3>
					<a class="screen-reader-text skip-link" href="#content" title="Skip to content">Skip to content</a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					<?php get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">

			<div class="site-info">
				&copy; 2012 <a href="/contacts/" title="Contact me">Richard Whittaker</a> | Powered by <a href="http://wordpress.org/" title="Semantic Personal Publishing Platform">Wordpress</a> and <?php echo sblorgh_randomise_footer(); ?> | Amot Melak Matita</a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>