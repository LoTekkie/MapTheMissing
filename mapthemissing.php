<?php
/**
 * @package mapthemissing
 */
/*
Plugin Name:  MapTheMissing
Plugin URI:   https://www.mapthemissing.com
Description:  Custom logic for the site
Version:      1.0
Author:       LoTekkie (Sid Shovan)
Author URI:   https://github.com/LoTekkie
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  mapthemissing
*/

/*
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

Copyright 2022 MapTheMissing.com.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'This plugin cannot be called directly';
    exit;
}

define( 'MAPTHEMISSING_VERSION', '1.0.0-'.time() );
define( 'MAPTHEMISSING_MINIMUM_WP_VERSION', '5.0' );
define( 'MAPTHEMISSING_DESCRIPTION', 'Custom Site Logic');
define( 'MAPTHEMISSING_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MAPTHEMISSING_URL', 'https://mapthemissing.com');
define( 'MAPTHEMISSING_ATTRIBUTION', '?r=ac-wp-plugin&cs=ac-wp-plugin&crs=1653005781');
define( 'MAPTHEMISSING_URL_API', 'https://api.mapthemissing.com/v1');
define( 'MAPTHEMISSING_EMAIL_SUPPORT', 'help@mapthemissing.com');

require_once(MAPTHEMISSING_PLUGIN_DIR . 'helpers.php');

register_activation_hook( __FILE__, array( 'MapTheMissing', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'MapTheMissing', 'plugin_deactivation' ) );

require_once( MAPTHEMISSING_PLUGIN_DIR . 'class.mapthemissing.php' );

add_action( 'init', array( 'MapTheMissing', 'init' ) );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( MAPTHEMISSING_PLUGIN_DIR . 'class.mapthemissing_admin.php' );
    add_action( 'init', array( 'MapTheMissing_Admin', 'init' ) );
}
