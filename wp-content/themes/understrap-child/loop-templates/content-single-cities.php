<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

					<?
					$city = 'a:1:{i:0;s:2:"'.$post->ID.'";}'; 
					$realty_args = array(
					   'post_type' => 'realty',
					   'publish' => true,
					   'paged' => get_query_var('paged'),
					   'posts_per_page' => -10,
					   'meta_query' => array(
						array(
							'key' => 'city',
							'value' => array(
								'0' => $city
							)
						)
					   )
				       	);
					/* Start the Loop */
					global $post; 
					$myposts = get_posts( $realty_args );
					foreach( $myposts as $post ){ setup_postdata($post);
						get_template_part( 'loop-templates/content', get_post_format() );
					}
					wp_reset_postdata();
					?><!-- .entry-realty -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
