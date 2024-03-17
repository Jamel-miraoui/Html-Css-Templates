<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

STM_LMS_Templates::show_lms_template(
	'components/curriculum-list/main',
	array(
		'course_id' => get_the_ID(),
		'style'     => 'classic',
	)
);
