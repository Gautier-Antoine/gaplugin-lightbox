<?php
/*
Plugin Name: LightBox-AGPlugin
Plugin URI: https://github.com/Pepite61/agplugin-lightbox
Description: Plugin for the gallery in WordPress
Version: 0.00.01

Requires at least: 5.2
Requires PHP: 7.2

Author: GAUTIER Antoine
Author URI: gautierantoine.com
Text Domain: lightbox-text
Domain Path: /languages
License:     GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

LightBox-AGPlugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.

LightBox-AGPlugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with LightBox-AGPlugin.
If not, see https://www.gnu.org/licenses/gpl-3.0.en.html.
*/

defined('ABSPATH') or die('You cannot enter');
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'You are not currently logged in', 'lightbox-text' ),
            array( 'status' => 401 )
        );
    }
    return $result;
});

  if (!class_exists('AGPlugin\AdminPage')){
    require_once 'includes/AdminPage.php';
  }
  require_once 'includes/LightBox.php';
  register_uninstall_hook( __FILE__, ['AGPlugin\LightBox', 'removeOptions']);
  add_action(
    'init',
    function () {
      AGPlugin\LightBox::register();
    }
  );
