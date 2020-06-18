<?php
/**
 * Define Enterprise_Site_Walker_Mega_Menu Class (src)
 *
 * Extends base WordPress nav menu walker class and adds mega menu functionality.
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
class Enterprise_Site_Walker_Mega_Menu extends Walker_Nav_Menu {

	/**
	 * Megamenu state.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $mega_menu_toggle    Megamenu state.
	 */
	private $mega_menu_toggle = false;

	/**
	 * Modified menu walker class method used to generate HTML output for
	 * starting/opening a menu item container (e.g. <ul>).
	 *
	 * @since    1.0.0
	 * @var      $output    string      The HTML output of the opening menu item.
	 * @var      $depth     interger    Depth of menu item.
	 * @var      $args      array       An object of wp_nav_menu() arguments.
	 *
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 0 === $depth ) {
			$output .= '<div class="sub-menu-navigation-border">';
			$output .= '</div>';
			parent::start_lvl( $output, $depth, $args );
		} else {
			parent::start_lvl( $output, $depth, $args );
		}
	}

	/**
	 * Modified menu walker class method used to generate HTML output for
	 * starting/opening a menu item (e.g. <li>).
	 *
	 * @since    1.0.0
	 * @var      string      $output    The HTML output of the opening menu item container.
	 * @var      object      $object    The current menu item object
	 * @var      interger    $depth     Depth of menu item.
	 * @var      array       $args      An object of wp_nav_menu() arguments..
	 * @var      interger    $id        ...
	 *
	 */
	function start_el( &$output, $object, $depth = 0, $args = array(), $id = 0 ) {
		$mega_menu_toggle = get_field( 'mega_menu_toggle', $object->ID );

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		if ( $mega_menu_toggle ) {
			$output .= $n;
			$output .= $indent;
			$output .= '<li class="menu-item-is-mega-menu';
			$output .= implode( ' ', $object->classes );
			$output .= '" >';
			$output .= '<a href="';
			$output .= $object->url;
			$output .= '" >';
			$output .= $object->title;
			$output .= '</a>';
			$output .= $n;
			$output .= $indent;
			$output .= '<div class="mega-menu-navigation-border">';
			$output .= '</div>';
			$output .= '<div class="mega-menu-container">';
			$output .= '<div class="grid-container">';
			$output .= '<ul class="mega-menu grid-x grid-margin-x">';
			$output .= '<li class="mega-menu-parent-mobile-link">';
			$output .= '<a href="';
			$output .= $object->url;
			$output .= '">';
			$output .= $object->title;
			$output .= __( ' Home', 'enterprise-site' );
			$output .= '</a>';
			$output .= '</li>'; // End .mega-menu-parent-mobile-link
			if ( have_rows( 'mega_menu_groups', $object->ID ) ) {
				$mega_menu_group_class = ( 3 === count( get_field( 'mega_menu_groups', $object->ID ) ) ) ? 'large-4' : 'large-3';
				while ( have_rows( 'mega_menu_groups', $object->ID ) ) {
					the_row();
					$output .= '<li class="mega-menu-group cell ';
					$output .= $mega_menu_group_class;
					$output .= '">';
					if ( get_sub_field( 'title' ) ) {
						$output .= '<h4 class="mega-menu-group-title">';
						$output .= '<a href="';
						$output .= get_sub_field( 'title' )['url'];
						$output .= '">';
						$output .= get_sub_field( 'title' )['title'];
						$output .= '</a>';
						$output .= '</h4>';
					}
					if ( get_sub_field( 'description' ) ) {
						$output .= '<p class="mega-menu-group-description">';
						$output .= get_sub_field( 'description' );
						$output .= '</p>';
					}
					if ( have_rows( 'links' ) ) {
						$output .= '<ul class="mega-menu-group-items">';
						while ( have_rows( 'links' ) ) {
							the_row();
							$output .= '<li class="mega-menu-group-item">';
							$output .= '<a href="';
							$output .= get_sub_field( 'url' );
							$output .= '">';
							$output .= get_sub_field( 'label' );
							$output .= '</a>';
							if ( have_rows( 'sublinks' ) ) {
								$output .= '<ul class="mega-menu-group-item-sublinks">';
								while ( have_rows( 'sublinks' ) ) {
									the_row();
									$output .= '<li class="mega-menu-group-item-sublink">';
									$output .= '<a href="';
									$output .= get_sub_field( 'url' );
									$output .= '">';
									$output .= get_sub_field( 'label' );
									$output .= '</a>';
									$output .= '</li>'; // End .mega-menu-group-item-sublink
								}
								$output .= '</ul>'; // End .mega-menu-group-item-sublinks
							}
							$output .= '</li>'; // End .mega-menu-group-item
						}
						$output .= '</ul>'; // End .mega-menu-group-items
					}
					$output .= '</li>'; // End .mega-menu-group
				}
			}
			$output .= '</ul>'; // End .mega-menu
			$output .= '</div>'; // End .grid-container
			$output .= '</div>'; // End .mega-menu-container
			$output .= $n;
			$output .= $indent;
			$output .= '</li>'; // End .menu-item-mega-menu
		} else {
			parent::start_el( $output, $object, $depth, $args );
		}
	}
}
