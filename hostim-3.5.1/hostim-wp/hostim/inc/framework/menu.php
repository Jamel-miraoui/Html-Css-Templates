<?php
// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID
	$prefix = '_prefix_menu_options';

	//
	// Create profile options
	CSF::createNavMenuOptions( $prefix, array(
		'data_type' => 'serialize', // The type of the database save options. `serialize` or `unserialize`
	) );

	//
	// Create a section
	CSF::createSection( $prefix, array(
		'fields' => array(
			array(
				'id'          => 'class',
				'type'        => 'select',
				'title'       => 'Mega Menu Width',
				'placeholder' => 'Select an option',
				'options'     => array(
					'single_width'  	=> '25% Width',
					'menu_half_width'	=> '50% Width',
					'menu_75_width'		=> '75% Width',
					'menu_full_width'	=> '100% Width',
				),
				'default'     => ''
			),
		)
	) );

}
