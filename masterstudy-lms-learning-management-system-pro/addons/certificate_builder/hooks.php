<?php

use MasterStudy\Lms\Pro\addons\certificate_builder\DemoImporter;
use MasterStudy\Lms\Pro\addons\certificate_builder\Http\Controllers\AdminPageController;
use MasterStudy\Lms\Pro\addons\certificate_builder\Http\Controllers\AjaxController;

add_action(
	'init',
	function() {
		$args = array(
			'labels'              => array(
				'name'          => esc_html__( 'Certificates', 'masterstudy-lms-learning-management-system-pro' ),
				'singular_name' => esc_html__( 'Certificate', 'masterstudy-lms-learning-management-system-pro' ),
			),
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'thumbnail' ),
		);
		register_post_type( 'stm-certificates', $args );
		wp_register_script( 'jspdf', STM_LMS_PRO_URL . '/assets/js/certificate-builder/jspdf.umd.js', array(), stm_lms_custom_styles_v(), true );
		wp_register_script( 'pdfjs', STM_LMS_PRO_URL . '/assets/js/certificate-builder/pdf.min.js', array(), stm_lms_custom_styles_v(), true );
		wp_register_script( 'pdfjs_worker', STM_LMS_PRO_URL . '/assets/js/certificate-builder/pdf.worker.min.js', array(), stm_lms_custom_styles_v(), true );
		wp_register_script( 'masterstudy_certificate_fonts', STM_LMS_PRO_URL . '/assets/js/certificate-builder/certificates-fonts.js', array(), stm_lms_custom_styles_v(), true );
	}
);

add_action(
	'admin_init',
	function() {
		// TODO: consider add this to addon activation hook
		( new DemoImporter() )->import();

		// TODO: remove after next major release (v4.5.0)
		$is_imported = get_option( 'stm_lms_new_certificates_imported', '' );
		if ( empty( $is_imported ) ) {
			update_option( 'stm_lms_new_certificates_imported', '1' );

			( new DemoImporter() )->create_demo_certificates( array( 'demo-1', 'demo-2' ) );
		}
	}
);

add_action(
	'admin_menu',
	function() {
		add_menu_page(
			esc_html__(
				'Certificate Builder',
				'masterstudy-lms-learning-management-system-pro'
			),
			esc_html__(
				'Certificates',
				'masterstudy-lms-learning-management-system-pro'
			),
			'manage_options',
			'certificate_builder',
			new AdminPageController(),
			'dashicons-awards',
			20
		);
	}
);

add_filter(
	'stm_lms_menu_items',
	function ( $menus ) {
		$menus[] = array(
			'order'        => 155,
			'id'           => 'certificates',
			'slug'         => 'certificates',
			'lms_template' => 'stm-lms-certificates',
			'menu_title'   => esc_html__( 'Certificates', 'masterstudy-lms-learning-management-system-pro' ),
			'menu_icon'    => 'fa-medal',
			'menu_url'     => \STM_LMS_Course::certificates_page_url(),
			'menu_place'   => 'learning',
		);

		return $menus;
	}
);

add_filter(
	'masterstudy_lms_certificate_fields_data',
	function ( $fields, $certificate ) {
		$user_id     = get_current_user_id();
		$field_types = array(
			'student_name',
			'author',
		);

		foreach ( $fields as &$field ) {
			if ( ! in_array( $field['type'], $field_types, true ) ) {
				continue;
			}

			$meta_key   = "certificate_{$field['type']}_{$certificate['id']}";
			$meta_value = get_user_meta( $user_id, sanitize_text_field( $meta_key ), true );

			if ( empty( $meta_value ) ) {
				update_user_meta( $user_id, sanitize_text_field( $meta_key ), $field['content'] );
				continue;
			}

			$author      = get_post_field( 'post_author', intval( sanitize_text_field( $certificate['course_id'] ) ) );
			$author_name = get_the_author_meta( 'display_name', $author );

			if ( 'author' === $field['type'] && $meta_value === $author_name ) {
				$field['content'] = html_entity_decode( $meta_value );
			}
		}

		return $fields;
	},
	10,
	2
);

add_action( 'wp_ajax_stm_get_certificates', array( AjaxController::class, 'get_certificates' ) );
add_action( 'wp_ajax_stm_get_certificate_fields', array( AjaxController::class, 'get_fields' ) );
add_action( 'wp_ajax_stm_save_certificate', array( AjaxController::class, 'save_certificate' ) );
add_action( 'wp_ajax_stm_generate_certificates_preview', array( AjaxController::class, 'generate_previews' ) );
add_action( 'wp_ajax_stm_save_default_certificate', array( AjaxController::class, 'save_default_certificate' ) );
add_action( 'wp_ajax_stm_delete_default_certificate', array( AjaxController::class, 'delete_default_certificate' ) );
add_action( 'wp_ajax_stm_save_certificate_category', array( AjaxController::class, 'save_certificate_category' ) );
add_action( 'wp_ajax_stm_delete_certificate_category', array( AjaxController::class, 'delete_certificate_category' ) );
add_action( 'wp_ajax_stm_delete_certificate', array( AjaxController::class, 'delete_certificate' ) );
add_action( 'wp_ajax_stm_get_certificate_categories', array( AjaxController::class, 'get_categories' ) );
add_action( 'wp_ajax_stm_get_certificate', array( AjaxController::class, 'get_certificate' ) );
