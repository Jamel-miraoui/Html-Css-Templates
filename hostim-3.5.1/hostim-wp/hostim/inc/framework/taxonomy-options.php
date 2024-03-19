<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//
// Set a unique slug-like ID
//
$prefix = '_hostim_taxonomy_options';

//
// Create taxonomy options
//
CSF::createTaxonomyOptions( $prefix, array(
  'taxonomy' => 'services_cat',
) );

// Create a section
CSF::createSection( $prefix, array(
    'fields' => array(

        array(
			'id'    => 'service_cat_icon',
			'type'  => 'icon',
			'title' => esc_html__( 'Icon', 'hostim' )
        ),

        array(
			'id'    => 'service_cat_img',
			'type'  => 'media',
			'title' => esc_html__( 'Image', 'hostim' )
        ),

    )
) );
