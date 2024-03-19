<?php

/**
 * Template for displaying search forms
 *
 * @package  hostim
 * @since    1.0
 */
?>
<?php $unique_id = uniqid( 'search-form-' ); ?>
<div class="search-widget">
	<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
		<input type="text" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'hostim' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="primary-btn submit-btn">
			<i class="fa-solid fa-magnifying-glass"></i>
		</button>
	</form>
</div>