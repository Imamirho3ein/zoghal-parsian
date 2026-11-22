<?php
/**
 * صفحه اصلی
 *
 * @package Zoghal_Parsian
 */

get_header();

$hero_image = zp_option( 'zp_hero_image', '' );
$hero_sub   = zp_option( 'zp_hero_sub', 'تولید شده از بهترین چوب‌های طبیعی، بدون بو و بدون دود، با حرارت بالا و ماندگاری طولانی.' );
$phone1     = zp_option( 'zp_phone_1', '۰۹۱۲ ۱۲۳ ۴۵۶۷' );
?>

<section class="hero">
	<?php if ( $hero_image ) : ?>
		<div class="hero-bg" style="background-image:url('<?php echo esc_url( $hero_image ); ?>')"></div>
	<?php else : ?>
		<div class="hero-bg" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero-charcoal.svg' ); ?>');background-size:cover;background-position:center;"></div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-copy">
			<h1>فروش انواع زغال <span>کبابی، قلیانی و فشرده</span></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_sub ); ?></p>
			<div class="hero-actions">
				<a class="btn btn-primary" href="<?php echo esc_url( zp_shop_url() ); ?>">مشاهده محصولات</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( 'tel:' . zp_tel( $phone1 ) ); ?>">تماس با ما</a>
			</div>
		</div>

		<ul class="hero-features">
			<li>
				<span class="ico"><?php zp_the_icon( 'box' ); ?></span>
				<span><strong>ارسال سریع</strong><span>به سراسر کشور</span></span>
			</li>
			<li>
				<span class="ico"><?php zp_the_icon( 'badge' ); ?></span>
				<span><strong>کیفیت تضمینی</strong><span>بهترین مواد اولیه</span></span>
			</li>
			<li>
				<span class="ico"><?php zp_the_icon( 'tag' ); ?></span>
				<span><strong>قیمت مناسب</strong><span>برای عمده و جزئی</span></span>
			</li>
		</ul>
	</div>
</section>

<section class="section">
	<div class="container">
		<header class="section-head">
			<h2>محصولات ما</h2>
			<p>انواع زغال با بهترین کیفیت</p>
		</header>

		<div class="products-grid">
			<?php
			$printed = 0;

			if ( zp_has_woo() ) {
				$query = new WP_Query(
					array(
						'post_type'      => 'product',
						'posts_per_page' => 4,
						'post_status'    => 'publish',
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						zp_product_card( get_post() );
						$printed++;
					}
					wp_reset_postdata();
				}
			}

			if ( 0 === $printed ) {
				foreach ( zp_demo_products() as $demo ) {
					zp_product_card( $demo );
				}
			}
			?>
		</div>

		<div class="center shop-more">
			<a class="btn btn-outline" href="<?php echo esc_url( zp_shop_url() ); ?>">مشاهده همه محصولات</a>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0">
	<div class="container">
		<div class="wholesale">
			<div class="wholesale-main">
				<span class="wholesale-icon"><?php zp_the_icon( 'cart' ); ?></span>
				<div>
					<h2><?php echo esc_html( zp_option( 'zp_wholesale_title', 'فروش عمده زغال' ) ); ?></h2>
					<p><?php echo esc_html( zp_option( 'zp_wholesale_text', 'تماس رایگان برای مشاوره و بهترین قیمت' ) ); ?></p>
				</div>
			</div>
			<a class="btn btn-primary" href="<?php echo esc_url( 'tel:' . zp_tel( $phone1 ) ); ?>">برای سفارش عمده تماس بگیرید</a>
		</div>
	</div>
</section>

<section class="section section-soft">
	<div class="container">
		<div class="features">
			<div class="feature">
				<span class="ico"><?php zp_the_icon( 'headset' ); ?></span>
				<span><strong>پشتیبانی ۲۴/۷</strong><span>پشتیبانی و مشاوره در تمام ساعات</span></span>
			</div>
			<div class="feature">
				<span class="ico"><?php zp_the_icon( 'truck' ); ?></span>
				<span><strong>ارسال سریع</strong><span>ارسال به سراسر کشور در کوتاه‌ترین زمان</span></span>
			</div>
			<div class="feature">
				<span class="ico"><?php zp_the_icon( 'tag' ); ?></span>
				<span><strong>قیمت مناسب</strong><span>قیمت مناسب و رقابتی برای همه مشتریان</span></span>
			</div>
			<div class="feature">
				<span class="ico"><?php zp_the_icon( 'badge' ); ?></span>
				<span><strong>کیفیت بالا</strong><span>استفاده از بهترین چوب‌های طبیعی</span></span>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
