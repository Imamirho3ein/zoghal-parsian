<?php
/**
 * قالب برگه
 *
 * @package Zoghal_Parsian
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="page-hero">
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">صفحه اصلی</a> / <?php the_title(); ?></div>
		</div>
	</div>

	<main id="main" class="content-area">
		<div class="container">
			<article class="entry-content">
				<?php the_content(); ?>
			</article>
		</div>
	</main>
	<?php
endwhile;

get_footer();
