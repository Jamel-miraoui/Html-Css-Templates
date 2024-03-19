<?php
// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID
	$prefix = 'hostim_service_options';

	//
	// Create a metabox
	CSF::createMetabox( $prefix, array(
		'title'     => 'Service Options',
		'post_type' => 'services',
	) );
	//
	// Create a section
	CSF::createSection( $prefix, array(
		'fields' => array(
		
			array(
				'id'      => 'service_title',
				'type'    => 'text',
				'title'   => esc_html__( 'Service Title', 'hostim' ),
			),
			array(
				'id'      => 'service_short_desc',
				'type'    => 'textarea',
				'title'   => esc_html__( 'Short Description', 'hostim' ),
			),
			array(
				'id'      => 'service_feature_img',
				'type'    => 'media',
				'title'   => 'Service Feature Image'
			),
			array(
				'id'      => 'service_monthly_price',
				'type'    => 'text',
				'title'   => esc_html__( 'Monthly Price', 'hostim' ),
				'default' => '1.99'
			),

		)
	) );

}
