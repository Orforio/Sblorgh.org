<?php
function sblorgh_setup() {
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Switches default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', 'Sidebar Menu' );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );
}
add_action( 'after_setup_theme', 'sblorgh_setup' );

/**
 * Enqueues scripts and styles for front end.
 *
 */
function sblorgh_scripts_styles() {
	// Loads JavaScript file with functionality specific to Twenty Thirteen.
//	wp_enqueue_script( 'sblorgh-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-07-18', true );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', false, '2.1.3' );
	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'sblorgh-style', get_stylesheet_uri(), array(), '2013-09-07' );

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
	<nav class="navigation paging-navigation" role="navigation">
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( 'Older posts <div class="meta-nav genericon genericon-rightarrow"></div>' ); ?></div>
			<?php endif; ?>
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( '<div class="meta-nav genericon genericon-leftarrow"></div> Newer posts' ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'sblorgh_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*
* @return void
*/
function sblorgh_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">

			<?php previous_post_link( '%link', '<div class="meta-nav genericon genericon-leftarrow"></div> %title' ); ?>
			<?php next_post_link( '%link', '%title <div class="meta-nav genericon genericon-rightarrow"></div>' ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'sblorgh_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own sblorgh_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function sblorgh_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'sblorgh' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		sblorgh_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'sblorgh' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'sblorgh' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'sblorgh' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'sblorgh_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own sblorgh_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function sblorgh_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'sblorgh' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'sblorgh' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'sblorgh_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function sblorgh_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'sblorgh_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function sblorgh_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}


/**
 * Loads stylesheets and scripts
 */
/*function sblorgh_load_scripts_styles() {
	wp_enqueue_style('sblorgh-style', get_stylesheet_uri());
	wp_enqueue_script( 'retina', get_template_directory_uri() . '/js/retina.js', false, false, true);
}
add_action('wp_enqueue_scripts', 'sblorgh_load_scripts_styles');*/

/**
 * Registers sidebar
 */
/*register_sidebar(array(
  'name' => 'Right Sidebar',
  'id' => 'sidebar-1',
  'description' => 'The right-hand sidebar.',
  'before_title' => '',
  'after_title' => '',
  'before_widget' => '<ul>',
  'after_widget' => '</ul>'
));*/

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
