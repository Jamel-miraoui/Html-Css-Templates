<?php

namespace MasterStudy\Lms\Pro\addons\certificate_builder;

use MasterStudy\Lms\Repositories\AbstractRepository;

final class CertificateRepository extends AbstractRepository {
	const DEFAULT_CERTIFICATE = 'stm_default_certificate';

	protected static string $post_type = 'stm-certificates';

	protected static array $fields_post_map = array(
		'id'    => 'ID',
		'title' => 'post_title',
	);

	protected static array $fields_meta_map = array(
		'orientation' => 'stm_orientation',
		'fields'      => 'stm_fields',
		'category'    => 'stm_category',
	);

	public function get_first_for_categories( array $categories ): int {
		global $wpdb;
		$categories_list = implode( ',', array_map( 'intval', $categories ) );

		$certificate_ids = $wpdb->get_col(
			$wpdb->prepare(
				"
				SELECT p.ID
				FROM {$wpdb->posts} AS p
				INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
				WHERE p.post_type = 'stm-certificates'
				AND pm.meta_key = 'stm_category'
				AND (pm.meta_value REGEXP CONCAT('(^|,)', %s, '(,|$)'))
				ORDER BY pm.meta_value ASC
				LIMIT 1
				",
				$categories_list
			)
		);

		if ( empty( $certificate_ids ) ) {
			$certificate_ids[] = self::get_default_certificate();
		}

		return $certificate_ids[0] ?? 0;
	}

	public function get_all(): array {
		$args  = array(
			'post_type'      => 'stm-certificates',
			'posts_per_page' => -1,
		);
		$query = new \WP_Query();

		$certificates = array();

		foreach ( $query->query( $args ) as $post ) {
			$certificate = $this->map_post( $post );

			foreach ( static::$fields_meta_map as $field => $meta ) {
				$certificate[ $field ] = $this->cast( $field, get_post_meta( $post->ID, $meta, true ) );
			}

			$certificates[] = $certificate;
		}

		return $certificates;
	}

	public static function get_default_certificate() {
		return get_option( self::DEFAULT_CERTIFICATE, '' );
	}

	public static function set_default_certificate( $certificate_id ): void {
		update_option( self::DEFAULT_CERTIFICATE, $certificate_id );
	}

	protected function update_meta( $id, $data ): void {
		parent::update_meta( $id, $data );

		if ( ! empty( $data['thumbnail_id'] ) ) {
			set_post_thumbnail( $id, intval( $data['thumbnail_id'] ) );
		}

		$code = get_post_meta( $id, 'code', true );
		if ( empty( $code ) ) {
			update_post_meta( $id, 'code', CodeGenerator::generate() );
		}
	}
}
