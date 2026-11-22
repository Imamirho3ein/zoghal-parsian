<?php
/**
 * قالب آرشیو
 *
 * @package Zoghal_Parsian
 */

get_header();

$title = get_the_archive_title();
$title = preg_replace( '/^[^:]+:\s*/u', '', $title );
?>
<div class="page-hero">
	<div class="container">
		<h1><?php echo esc_html( $title ); ?></h1>
		<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">صفحه اصلی</a> / <?php echo esc_html( $title ); ?></div>
	</div>
</div>

<main id="main" class="content-area">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="post-card">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'zp-card' ); ?>
							<?php endif; ?>
						</a>
						<div class="post-card-body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16, '…' ) ); ?></p>
							<a class="btn btn-outline" href="<?php the_permalink(); ?>">ادامه مطلب</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="center" style="margin-top:36px">
				<?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => 'قبلی', 'next_text' => 'بعدی' ) ); ?>
			</div>
		<?php else : ?>
			<p class="center">موردی یافت نشد.</p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
