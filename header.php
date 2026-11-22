<?php
/**
 * هدر سایت
 *
 * @package Zoghal_Parsian
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main">پرش به محتوا</a>

<header class="site-header" id="site-header">
	<div class="container header-inner">

		<div class="brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<span class="brand-mark" aria-hidden="true">
						<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 22c4 0 7-2.9 7-6.6 0-4.4-4.3-6.3-4.3-10.2 0-.8-.7-1.4-1.4-1.1C9.5 5.4 8 8.4 8 11c-1.2-.5-2-1.6-2.2-2.8-.2-.7-1-.9-1.4-.3a8.4 8.4 0 0 0-1.4 4.7C3 18.1 6.4 22 12 22Z"/></svg>
					</span>
					<span class="brand-text">
						<span class="brand-name">زغال پارسیان</span>
						<span class="brand-tag">تولید و عرضه انواع زغال</span>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="main-nav" id="primary-nav" aria-label="منوی اصلی">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'depth'          => 1,
					)
				);
			} else {
				zp_fallback_menu();
			}
			?>
		</nav>

		<div class="header-actions">
			<a class="btn btn-primary" href="<?php echo esc_url( 'tel:' . zp_tel( zp_option( 'zp_phone_1', '۰۹۱۲ ۱۲۳ ۴۵۶۷' ) ) ); ?>">ثبت سفارش عمده</a>

			<?php if ( zp_has_woo() ) : ?>
				<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="سبد خرید">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="20" r="1.6"/><circle cx="18" cy="20" r="1.6"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.5L21 8H6"/></svg>
					<?php zp_cart_count_fragment(); ?>
				</a>
			<?php endif; ?>

			<button class="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false" aria-label="باز و بسته کردن منو">
				<span></span><span></span><span></span>
			</button>
		</div>

	</div>
</header>
