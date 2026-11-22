<?php
/**
 * فوتر سایت
 *
 * @package Zoghal_Parsian
 */

$phone1   = zp_option( 'zp_phone_1', '۰۹۱۲ ۱۲۳ ۴۵۶۷' );
$phone2   = zp_option( 'zp_phone_2', '۰۹۱۲ ۷۶۵ ۴۳۲۱' );
$email    = zp_option( 'zp_email', 'info@zoghalparsian.ir' );
$address  = zp_option( 'zp_address', 'تهران، شهرک صنعتی نصیرآباد، خیابان صنایع، پلاک ۱۲' );
$map      = zp_option( 'zp_map_embed', '' );
$insta    = zp_option( 'zp_instagram', 'https://instagram.com/' );
$telegram = zp_option( 'zp_telegram', 'https://t.me/' );
$whatsapp = zp_option( 'zp_whatsapp', 'https://wa.me/' );
?>
<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">

			<div class="footer-col">
				<div class="brand" style="margin-bottom:16px">
					<span class="brand-mark" aria-hidden="true">
						<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 22c4 0 7-2.9 7-6.6 0-4.4-4.3-6.3-4.3-10.2 0-.8-.7-1.4-1.4-1.1C9.5 5.4 8 8.4 8 11c-1.2-.5-2-1.6-2.2-2.8-.2-.7-1-.9-1.4-.3a8.4 8.4 0 0 0-1.4 4.7C3 18.1 6.4 22 12 22Z"/></svg>
					</span>
					<span class="brand-text">
						<span class="brand-name" style="color:#fff">زغال پارسیان</span>
						<span class="brand-tag">تولید و عرضه انواع زغال</span>
					</span>
				</div>
				<p>تولید و عرضه انواع زغال چوب، زغال فشرده، کبابی و قلیانی با بهترین کیفیت و مناسب‌ترین قیمت. ارسال به سراسر کشور.</p>
				<div class="socials">
					<a href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener" aria-label="اینستاگرام"><?php zp_the_icon( 'instagram' ); ?></a>
					<a href="<?php echo esc_url( $telegram ); ?>" target="_blank" rel="noopener" aria-label="تلگرام"><?php zp_the_icon( 'telegram' ); ?></a>
					<a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener" aria-label="واتساپ"><?php zp_the_icon( 'whatsapp' ); ?></a>
				</div>
			</div>

			<div class="footer-col">
				<h3>تماس با ما</h3>
				<ul class="contact-list">
					<li><?php zp_the_icon( 'phone' ); ?><a href="<?php echo esc_url( 'tel:' . zp_tel( $phone1 ) ); ?>"><?php echo esc_html( $phone1 ); ?></a></li>
					<li><?php zp_the_icon( 'phone' ); ?><a href="<?php echo esc_url( 'tel:' . zp_tel( $phone2 ) ); ?>"><?php echo esc_html( $phone2 ); ?></a></li>
					<li><?php zp_the_icon( 'pin' ); ?><span><?php echo esc_html( $address ); ?></span></li>
					<li><?php zp_the_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h3>لینک‌های مفید</h3>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'items_wrap'     => '<ul>%3$s</ul>',
							'depth'          => 1,
						)
					);
				} else {
					zp_fallback_menu();
				}
				?>
			</div>

			<div class="footer-col">
				<h3>موقعیت ما</h3>
				<div class="map-card">
					<?php if ( $map ) : ?>
						<?php
						if ( false !== strpos( $map, '<iframe' ) ) {
							echo wp_kses( $map, array( 'iframe' => array( 'src' => array(), 'width' => array(), 'height' => array(), 'style' => array(), 'allowfullscreen' => array(), 'loading' => array(), 'referrerpolicy' => array(), 'title' => array() ) ) );
						} else {
							printf( '<iframe src="%s" loading="lazy" title="نقشه موقعیت"></iframe>', esc_url( $map ) );
						}
						?>
					<?php else : ?>
						<span class="map-pin" aria-hidden="true"><?php zp_the_icon( 'pin' ); ?></span>
						<a class="btn" href="<?php echo esc_url( 'https://maps.google.com/?q=' . rawurlencode( $address ) ); ?>" target="_blank" rel="noopener">مشاهده موقعیت ما در نقشه</a>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			تمامی حقوق این سایت محفوظ می‌باشد © <?php echo esc_html( zp_year_fa() ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>">زغال پارسیان</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
