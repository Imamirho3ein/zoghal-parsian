<?php
/**
 * یکپارچه‌سازی با ووکامرس
 *
 * @package Zoghal_Parsian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// حذف پوشش پیش‌فرض ووکامرس و جایگزینی با پوشش تم.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * شروع پوشش محتوای ووکامرس.
 */
function zp_woo_wrapper_start() {
	echo '<main id="main" class="content-area"><div class="container">';
}
add_action( 'woocommerce_before_main_content', 'zp_woo_wrapper_start', 10 );

/**
 * پایان پوشش محتوای ووکامرس.
 */
function zp_woo_wrapper_end() {
	echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'zp_woo_wrapper_end', 10 );

/**
 * تعداد ستون‌های محصولات.
 *
 * @return int
 */
function zp_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'zp_loop_columns' );

/**
 * تعداد محصول در هر صفحه.
 *
 * @return int
 */
function zp_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'zp_products_per_page', 20 );

/**
 * تعداد شمارنده سبد خرید (برای هدر و قطعه‌های ووکامرس).
 *
 * @return int
 */
function zp_cart_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return (int) WC()->cart->get_cart_contents_count();
}

/**
 * قطعه HTML شمارنده سبد خرید.
 */
function zp_cart_count_fragment() {
	printf( '<span class="cart-count">%s</span>', esc_html( zp_fa_digits( (string) zp_cart_count() ) ) );
}
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	ob_start();
	zp_cart_count_fragment();
	$fragments['span.cart-count'] = ob_get_clean();
	return $fragments;
} );

/**
 * دکمه افزودن به سبد در کارت محصولات.
 *
 * @param string $html دکمه پیش‌فرض.
 * @param WC_Product $product محصول.
 * @return string
 */
function zp_loop_add_to_cart_text( $html, $product ) {
	return $html;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'zp_loop_add_to_cart_text', 10, 2 );

/**
 * افزودن واحد پول «تومان» به ووکامرس.
 *
 * @param array $currencies واحدهای پول.
 * @return array
 */
function zp_add_toman_currency( $currencies ) {
	$currencies['IRT'] = 'تومان';
	return $currencies;
}
add_filter( 'woocommerce_currencies', 'zp_add_toman_currency' );

/**
 * نمایش نماد تومان.
 *
 * @param string $symbol   نماد پیش‌فرض.
 * @param string $currency کد واحد پول.
 * @return string
 */
function zp_toman_symbol( $symbol, $currency ) {
	return 'IRT' === $currency ? 'تومان' : $symbol;
}
add_filter( 'woocommerce_currency_symbol', 'zp_toman_symbol', 10, 2 );

/**
 * اجازه آپلود تصاویر SVG برای تصاویر محصولات.
 *
 * @param array $mimes نوع‌های مجاز.
 * @return array
 */
function zp_allow_svg_upload( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'zp_allow_svg_upload' );

/**
 * اصلاح نوع فایل SVG در آپلودها.
 *
 * @param array  $data     اطلاعات فایل.
 * @param string $file     مسیر فایل.
 * @param string $filename نام فایل.
 * @param array  $mimes    نوع‌های مجاز.
 * @return array
 */
function zp_fix_svg_filetype( $data, $file, $filename, $mimes ) {
	if ( 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'zp_fix_svg_filetype', 10, 4 );
