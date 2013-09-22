<?php
function sblorgh_setup() {
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Switches default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', 'Sidebar Menu' );
}
add_action( 'after_setup_theme', 'sblorgh_setup' );

/**
 * Enqueues scripts and styles for front end.
 *
 */
function sblorgh_scripts_styles() {
	wp_enqueue_script( 'retinajs', get_template_directory_uri() . '/js/retina.js', false, '1.0.1', true);
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', false, '3.6', true);
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', false, '2.1.3' );
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', false, '2.09' );
	wp_enqueue_style( 'webfonts', 'http://fonts.googleapis.com/css?family=Gudea:400,700,400italic|Roboto:700', false);
	wp_enqueue_style( 'sblorgh-style', get_stylesheet_uri(), array('normalize', 'genericons', 'webfonts'), '2013-09-21' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'sblorgh-ie', get_template_directory_uri() . '/css/ie.css', array( 'sblorgh-style' ), '2013-07-18' );
	wp_style_add_data( 'sblorgh-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'sblorgh_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
/*function sblorgh_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'sblorgh' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'sblorgh_wp_title', 10, 2 );*/

if ( ! function_exists( 'sblorgh_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 */
function sblorgh_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation group" role="navigation">
		<div class="nav-links">
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( ' Newer posts' ); ?></div>
			<?php endif; ?>
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( 'Older posts ' ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Displays navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'sblorgh_post_nav' ) ) :
function sblorgh_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation group" role="navigation">
		<div class="nav-links">
			<?php if ( $previous ) : ?>
			<div class="nav-next"><?php previous_post_link( '%link', ' %title', true ); ?></div>
			<?php endif; ?>
			<?php if ( $next ) : ?>
			<div class="nav-previous"><?php next_post_link( '%link', '%title ', true ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 */
if ( ! function_exists( 'sblorgh_entry_meta' ) ) :
function sblorgh_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . 'Sticky' . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		sblorgh_entry_date();

	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}
}
endif;

/**
 * Prints HTML with date information for current post.
 */
if ( ! function_exists( 'sblorgh_entry_date' ) ) :
function sblorgh_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'sblorgh' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

/**
 * Returns the URL from the post.
 *
 */
function sblorgh_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Changes the number of posts displayed on homepage
 */
function sblorgh_change_numberposts($query) {
/*    if (is_home()) {
        // Display only 1 post for the original blog archive
        $query->set('posts_per_page', 1);
        return;
    } */
}
//add_action('pre_get_posts', 'sblorgh_change_numberposts', 1);

/**
 * Randomises the headers
 */
function sblorgh_randomise_header() {
	$randomnumber = rand(1, 6);
	
	switch ($randomnumber) {
		case 1: // Red
			echo "header-red";
			break;
		case 2: // Orange
			echo "header-orange";
			break;
		case 3: // Light Green
			echo "header-lightgreen";
			break;
		case 4: // Dark Green
			echo "header-darkgreen";
			break;
		case 5: // Light Blue
			echo "header-lightblue";
			break;
		case 6: // Dark Blue;
			echo "header-darkblue";
			break;
	}	
}

/**
 * Randomises the footer text
 */
function sblorgh_randomise_footer() {
	$footertext[1] = 'SaracinescaOS';
	$footertext[2] = 'sheer bloody-mindedness';
	$footertext[3] = '<a href="http://www.panic.com/coda/">Coda 2</a>';
	$footertext[4] = 'midnight lashings of chicken soup';
	$footertext[5] = 'banging tunes';
	$footertext[6] = 'tons and tons and tons of <a href="http://www.discogs.com/artist/Sota+Fujimori">Sota Fujimori</a>';
	$footertext[7] = 'Tlentifini Maarhaysu';
	
	$randomnumber = rand(1, count($footertext));
	
	return $footertext[$randomnumber];
}
