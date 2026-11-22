<?php
/**
 * تنظیمات سفارشی‌سازی تم
 *
 * @package Zoghal_Parsian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ثبت تنظیمات در سفارشی‌ساز.
 *
 * @param WP_Customize_Manager $wp_customize مدیریت سفارشی‌ساز.
 */
function zp_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'zp_contact',
		array(
			'title'    => __( 'اطلاعات تماس و شبکه‌های اجتماعی', 'zoghal-parsian' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'zp_phone_1'     => array( 'label' => 'شماره تماس اول', 'default' => '۰۹۱۲ ۱۲۳ ۴۵۶۷' ),
		'zp_phone_2'     => array( 'label' => 'شماره تماس دوم', 'default' => '۰۹۱۲ ۷۶۵ ۴۳۲۱' ),
		'zp_email'       => array( 'label' => 'ایمیل', 'default' => 'info@zoghalparsian.ir' ),
		'zp_address'     => array( 'label' => 'آدرس', 'default' => 'تهران، شهرک صنعتی نصیرآباد، خیابان صنایع، پلاک ۱۲' ),
		'zp_instagram'   => array( 'label' => 'لینک اینستاگرام', 'default' => 'https://instagram.com/' ),
		'zp_telegram'    => array( 'label' => 'لینک تلگرام', 'default' => 'https://t.me/' ),
		'zp_whatsapp'    => array( 'label' => 'لینک واتساپ', 'default' => 'https://wa.me/' ),
		'zp_map_embed'   => array( 'label' => 'آدرس embed نقشه (اختیاری)', 'default' => '' ),
		'zp_wholesale_title' => array( 'label' => 'عنوان بنر عمده', 'default' => 'فروش عمده زغال' ),
		'zp_wholesale_text'  => array( 'label' => 'متن بنر عمده', 'default' => 'تماس رایگان برای مشاوره و بهترین قیمت' ),
	);

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $field['label'],
				'section' => 'zp_contact',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'zp_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'zp_hero_image',
			array(
				'label'       => __( 'تصویر پس‌زمینه هیرو', 'zoghal-parsian' ),
				'description' => __( 'عکس زغال/شعله با کیفیت بالا (پیشنهاد: ۱۹۲۰×۱۰۸۰)', 'zoghal-parsian' ),
				'section'     => 'zp_contact',
			)
		)
	);

	$wp_customize->add_setting(
		'zp_hero_sub',
		array(
			'default'           => 'تولید شده از بهترین چوب‌های طبیعی، بدون بو و بدون دود، با حرارت بالا و ماندگاری طولانی.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'zp_hero_sub',
		array(
			'label'   => __( 'متن زیر عنوان هیرو', 'zoghal-parsian' ),
			'section' => 'zp_contact',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'zp_customize_register' );
