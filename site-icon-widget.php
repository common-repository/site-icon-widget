<?php
/**
 * Plugin Name: Site Icon Widget
 * Plugin URI: http://celloexpressions.com/plugins/site-icon-widget
 * Description: Display your site icon on your site in a widget area.
 * Version: 1.1.1
 * Author: Nick Halsey
 * Author URI: http://celloexpressions.com/
 * Tags: site icon, widget
 * License: GPL
 
=====================================================================================
Copyright (C) 2016 Nick Halsey

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
=====================================================================================
*/

// Register the Site Icon widget.
add_action( 'widgets_init', 'init_site_icon_widget' );
function init_site_icon_widget() { 
	return register_widget( 'Site_Icon_Widget' );
}

class Site_Icon_Widget extends WP_Widget {
	// Constructor.
	function __construct() {
		parent::__construct( 'site_icon', $name = 'Site Icon', array(
			'customize_selective_refresh' => true,
		) );
	}

	// Front-end widget display.
	function widget( $args, $instance ) {
		global $post;
		extract( $args );

		echo $before_widget;
		if ( has_site_icon() ) {
			echo '<img alt="site icon" class="site-icon-widget" src="' . esc_url( get_site_icon_url() ) . '">';
		} elseif ( is_customize_preview() ) {
			_e( 'Please set up your site icon in the "Site Identity" section.' );
		}
		echo $after_widget;
	}

	// Update widget settings.
	function update( $new_instance, $old_instance ) {
		// No options.
		return $instance;
	}

	// Widget admin settings form.
	function form( $instance ) {
		?>
		<p><a class="button" href="javascript:wp.customize.control('site_icon').focus()"><?php _e( 'Set up or change site icon', 'site-icon-widget' ); ?></a></p>
		<?php
	}
}

// Refresh the Customizer preview when the site icon is changed.
add_action( 'customize_register', 'site_icon_widget_customize_register', 11 );
function site_icon_widget_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'site_icon' )->transport = 'refresh';
}
?>