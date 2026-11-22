<?php
/**
 * زغال پارسیان — توابع تم
 *
 * @package Zoghal_Parsian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ZP_VERSION', '1.0.0' );

/**
 * راه‌اندازی تم
 */
function zp_setup() {
	load_theme_textdomain( 'zoghal-parsian', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// ووکامرس
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'منوی اصلی', 'zoghal-parsian' ),
			'footer'  => __( 'منوی فوتر (لینک‌های مفید)', 'zoghal-parsian' ),
		)
	);

	add_image_size( 'zp-product', 600, 450, true );
	add_image_size( 'zp-card', 720, 460, true );
}
add_action( 'after_setup_theme', 'zp_setup' );

/**
 * بارگذاری استایل و اسکریپت
 */
function zp_assets() {
	wp_enqueue_style(
		'zp-fonts',
		'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'zp-main', get_template_directory_uri() . '/assets/css/main.css', array(), ZP_VERSION );
	wp_enqueue_style( 'zp-style', get_stylesheet_uri(), array( 'zp-main' ), ZP_VERSION );

	wp_enqueue_script( 'zp-main', get_template_directory_uri() . '/assets/js/main.js', array(), ZP_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'zp_assets' );

/**
 * خواندن تنظیمات تم با مقدار پیش‌فرض
 *
 * @param string $key     کلید تنظیم.
 * @param mixed  $default مقدار پیش‌فرض.
 * @return mixed
 */
function zp_option( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return ( '' === $value || null === $value ) ? $default : $value;
}

/**
 * شماره تماس بدون فاصله برای لینک tel:
 *
 * @param string $phone شماره.
 * @return string
 */
function zp_tel( $phone ) {
	$phone = zp_latin_digits( (string) $phone );
	return preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * تبدیل ارقام فارسی/عربی به لاتین.
 *
 * @param string $text متن.
 * @return string
 */
function zp_latin_digits( $text ) {
	$map = array(
		'۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
		'۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
		'٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
		'٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
	);
	return strtr( $text, $map );
}

/**
 * تبدیل ارقام لاتین به فارسی.
 *
 * @param string $text متن.
 * @return string
 */
function zp_fa_digits( $text ) {
	return strtr(
		(string) $text,
		array(
			'0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
			'5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
		)
	);
}

/**
 * سال شمسی تقریبی برای فوتر.
 *
 * @return string
 */
function zp_year_fa() {
	$gy = (int) date_i18n( 'Y' );
	$jy = $gy - 621;
	return zp_fa_digits( (string) $jy );
}

/**
 * منوی جایگزین وقتی هنوز منویی در وردپرس ساخته نشده است.
 */
function zp_fallback_menu() {
	$items = array(
		home_url( '/' )                    => 'صفحه اصلی',
		zp_shop_url()                      => 'محصولات',
		zp_page_url( 'قیمت-روز', 'prices' ) => 'قیمت روز',
		zp_page_url( 'درباره-ما', 'about' ) => 'درباره ما',
		zp_page_url( 'تماس-با-ما', 'contact' ) => 'تماس با ما',
	);

	echo '<ul>';
	foreach ( $items as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * آدرس فروشگاه (ووکامرس) یا آرشیو محصولات.
 *
 * @return string
 */
function zp_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'shop' );
	}
	return home_url( '/products' );
}

/**
 * تلاش برای پیدا کردن صفحه با اسلاگ/عنوان، وگرنه بازگشت به خانه.
 *
 * @param string $slug  اسلاگ صفحه.
 * @param string $fallback اسلاگ جایگزین.
 * @return string
 */
function zp_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );
	if ( ! $page && $fallback ) {
		$page = get_page_by_path( $fallback );
	}
	return $page ? get_permalink( $page ) : home_url( '/' );
}

/**
 * تعداد کلمات خلاصه نوشته.
 *
 * @param int $length طول.
 * @return int
 */
function zp_excerpt_length( $length ) {
	return 22;
}
add_filter( 'excerpt_length', 'zp_excerpt_length' );

/**
 * آیکن‌های SVG درون‌خطی.
 *
 * @param string $name نام آیکن.
 * @return string
 */
function zp_icon( $name ) {
	$icons = array(
		'truck'    => '<path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="17.5" cy="18" r="2"/>',
		'badge'    => '<circle cx="12" cy="9" r="5"/><path d="M8.5 13.5 7 21l5-2 5 2-1.5-7.5"/>',
		'tag'      => '<path d="M20.6 12.6 12 21.2 2.8 12V3h9l8.8 8.8a1.4 1.4 0 0 1 0 1.8Z"/><circle cx="7.5" cy="7.5" r="1.4"/>',
		'headset'  => '<path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v5a2 2 0 0 0 2 2h1v-7H6a2 2 0 0 0-2 2Z"/><path d="M20 13v5a2 2 0 0 1-2 2h-1v-7h1a2 2 0 0 1 2 2Z"/>',
		'cart'     => '<circle cx="9" cy="20" r="1.6"/><circle cx="18" cy="20" r="1.6"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.5L21 8H6"/>',
		'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1Z"/>',
		'pin'      => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.7"/>',
		'mail'     => '<rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'instagram'=> '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/>',
		'telegram' => '<path d="M21.5 4.3 2.9 11.5c-.8.3-.8 1.4.1 1.6l4.5 1.4 1.7 5.2c.2.7 1 .8 1.5.3l2.4-2.4 4.6 3.4c.6.4 1.4.1 1.6-.6l3.3-15.3c.2-.8-.6-1.3-1.1-.8Z"/><path d="m7.5 14.5 9-6.5"/>',
		'whatsapp' => '<path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.3-4.5a8.4 8.4 0 1 1 15.7-4.2Z"/><path d="M8.8 8.4c.3 0 .6.2.8.6l.5 1.2c.1.3 0 .6-.2.8l-.6.6a6 6 0 0 0 3 3l.6-.6c.2-.2.5-.3.8-.2l1.2.5c.4.2.6.5.6.8 0 1-.8 1.8-1.8 1.8a7.6 7.6 0 0 1-7.5-7.5c0-1 .8-1.8 1.8-1.8Z"/>',
		'box'      => '<path d="m12 2 9 5v10l-9 5-9-5V7z"/><path d="M3 7l9 5 9-5M12 22V12"/>',
		'chevron'  => '<path d="m15 18-6-6 6-6"/>',
		'flame'    => '<path d="M12 22c4 0 7-2.9 7-6.6 0-4.4-4.3-6.3-4.3-10.2 0-.8-.7-1.4-1.4-1.1C9.5 5.4 8 8.4 8 11c-1.2-.5-2-1.6-2.2-2.8-.2-.7-1-.9-1.4-.3a8.4 8.4 0 0 0-1.4 4.7C3 18.1 6.4 22 12 22Z"/>',
	);

	$path = isset( $icons[ $name ] ) ? $icons[ $name ] : '';

	return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $path . '</svg>';
}

/**
 * چاپ آیکن.
 *
 * @param string $name نام.
 */
function zp_the_icon( $name ) {
	echo zp_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * کارت محصول (نوع سفارشی یا نمونه).
 *
 * @param WP_Post|null $post محصول.
 */
function zp_product_card( $post = null ) {
	$products_page = zp_shop_url();

	if ( $post instanceof WP_Post ) {
		$title = get_the_title( $post );
		$link  = get_permalink( $post );
		$desc  = wp_trim_words( wp_strip_all_tags( $post->post_excerpt ? $post->post_excerpt : $post->post_content ), 12, '…' );
		$thumb = get_the_post_thumbnail( $post, 'zp-product', array( 'loading' => 'lazy' ) );
		$price = '';

		if ( function_exists( 'wc_get_product' ) ) {
			$product = wc_get_product( $post->ID );
			if ( $product ) {
				$price = $product->get_price_html();
				$link  = $product->add_to_cart_url() ? $product->add_to_cart_url() : $link;
			}
		}
	} else {
		$demo  = $post;
		$title = $demo['title'];
		$desc  = $demo['desc'];
		$link  = $demo['link'];
		$thumb = $demo['thumb'];
		$price = $demo['price'];
	}
	?>
	<article class="product-card">
		<a class="product-thumb" href="<?php echo esc_url( $link ); ?>">
			<?php
			if ( $thumb ) {
				echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</a>
		<h3><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h3>
		<div class="product-excerpt"><?php echo esc_html( $desc ); ?></div>
		<div class="product-price"><?php echo wp_kses_post( $price ); ?></div>
		<div class="product-actions">
			<a class="btn btn-primary" href="<?php echo esc_url( $link ); ?>">سفارش محصول</a>
			<a class="btn btn-outline" href="<?php echo esc_url( $link ); ?>">جزئیات</a>
		</div>
	</article>
	<?php
}

/**
 * محصولات نمونه (تا وقتی ووکامرس و محصولی ثبت نشده).
 *
 * @return array
 */
function zp_demo_products() {
	$img = get_template_directory_uri() . '/assets/img/';
	return array(
		array(
			'title' => 'زغال فشرده مکعبی',
			'desc'  => 'مناسب برای قلیان و کباب، بدون بو و دود',
			'price' => 'تماس بگیرید',
			'link'  => zp_shop_url(),
			'thumb' => '<img src="' . esc_url( $img . 'product-cube.svg' ) . '" alt="زغال فشرده مکعبی" loading="lazy">',
		),
		array(
			'title' => 'زغال لیمویی',
			'desc'  => 'مناسب قلیان، حرارت بالا و ماندگاری طولانی',
			'price' => 'تماس بگیرید',
			'link'  => zp_shop_url(),
			'thumb' => '<img src="' . esc_url( $img . 'product-lemon.svg' ) . '" alt="زغال لیمویی" loading="lazy">',
		),
		array(
			'title' => 'زغال کبابی',
			'desc'  => 'مناسب کباب و انواع پخت و پز',
			'price' => 'تماس بگیرید',
			'link'  => zp_shop_url(),
			'thumb' => '<img src="' . esc_url( $img . 'product-bbq.svg' ) . '" alt="زغال کبابی" loading="lazy">',
		),
		array(
			'title' => 'زغال چوب درجه یک',
			'desc'  => 'تهیه‌شده از چوب درختان با دوام و کیفیت بالا',
			'price' => 'تماس بگیرید',
			'link'  => zp_shop_url(),
			'thumb' => '<img src="' . esc_url( $img . 'product-wood.svg' ) . '" alt="زغال چوب درجه یک" loading="lazy">',
		),
	);
}

/**
 * بررسی فعال بودن ووکامرس.
 *
 * @return bool
 */
function zp_has_woo() {
	return class_exists( 'WooCommerce' );
}

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/woocommerce.php';
