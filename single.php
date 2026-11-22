<?php
/**
 * قالب نوشته
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
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">صفحه اصلی</a> /
				<?php the_date(); ?> /
				<?php the_title(); ?>
			</div>
		</div>
	</div>

	<main id="main" class="content-area">
		<div class="container">
			<?php if ( has_post_thumbnail() ) : ?>
				<div style="margin-bottom:28px"><?php the_post_thumbnail( 'large', array( 'style' => 'border-radius:16px;width:100%' ) ); ?></div>
			<?php endif; ?>

			<article class="entry-content">
				<?php the_content(); ?>
			</article>

			<nav class="post-nav" style="display:flex;justify-content:space-between;gap:16px;margin-top:40px;border-top:1px solid #eee;padding-top:20px">
				<div><?php previous_post_link( '%link', '‹ %title' ); ?></div>
				<div><?php next_post_link( '%link', '%title ›' ); ?></div>
			</nav>
		</div>
	</main>
	<?php
endwhile;

get_footer();
