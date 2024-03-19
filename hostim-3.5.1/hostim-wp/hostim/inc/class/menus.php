<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

/**
 * Register theme menus
 */

class Hostim_Main_Nav_Walker extends Walker_Nav_Menu {
	private $current_Item;

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );

		if ( $args->has_children ) {
			$output .= "\n$indent<ul role=\"menu\" class=\"icon-menu submenu-wrapper \">\n";
		}
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent               = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$this->current_Item   = $item;
		$menu_icon_class      = get_post_meta( $item->ID, '_menu_item_icon', true );
		$menu_container_class = get_post_meta( $item->ID, '_menu_item_fullwidth_menu', true );
		$meta = get_post_meta( $item->ID, '_prefix_menu_options', true );

		$theme_opt = get_option('hostim_cs_options');
		$dropdown_icon_type = $theme_opt['dropdown_icon_type'];
		$drop_icon = !empty( $theme_opt['menu_dropdown_icon'] ) ? $theme_opt['menu_dropdown_icon'] : 'fa fa-angle-down';
		

		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp( $item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';
			$dropdown_icon = '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'menu-item';

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children ) {
				$class_names .= ' has-submenu ';
				if( $dropdown_icon_type == 'icon' && !empty($drop_icon) ){
					$dropdown_icon = '<i class="'. esc_attr( $drop_icon ) .'"></i>'; 
				}
				else if( $dropdown_icon_type == 'image' && !empty($theme_opt['menu_dropdown_img']) ){
					$dropdown_icon = '<i class="dropdown_icon_image">'. wp_get_attachment_image($theme_opt['menu_dropdown_img']['id']) .'</i>'; 
				}
			}
			if( $depth == 1 ){
				$class_names .= ' depth-1';
			}
			if( $depth == 2 ){
				$class_names .= ' depth-2';
			}
			if ( ! empty( $meta['class'] )  && $depth == 0 ) {
				$class_names .= ' ' .$meta['class'] .' ' . 'mega-menu';
			}

			if ( in_array( 'current-menu-parent', $classes ) ) {
				$class_names .= ' current-menu-item';
			}
			if ( in_array( 'current_page_parent', $classes ) ) {
				$class_names .= ' current-menu-item';
			}
			if ( in_array( 'current-menu-item', $classes ) ) {
				$class_names .= ' current-menu-item';
			}

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names . '>';


			$atts           = array();
			// $atts['title']  = ! empty( $item->title ) ? $item->title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			if ( $menu_icon_class != "" ) {
				$menu_icon_html = '<i class="' . esc_attr( $menu_icon_class ) . '"></i>';
			} else {
				$menu_icon_html = '';
			}
			$item_output = $args->before;
			if ( $item->object == 'mega_menu' && $depth == 1 ) {

				$content = '';
				if ( class_exists( 'Elementor\Plugin' ) ) {
					$elementor = Elementor\Plugin::instance();
					$content   = $elementor->frontend->get_builder_content_for_display( $item->object_id );
				}
				$class       = ! empty( $menu_container_class ) ? $menu_container_class : '';
				$item_output .= '<div class="mega-menu-wrapper ' . $class . '">' . $content . '</div>';
			} else {

				$item_output .= '<a' . $attributes . '>';
				$item_output .= $menu_icon_html;
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= '</a>'.$dropdown_icon;
			}

			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}


