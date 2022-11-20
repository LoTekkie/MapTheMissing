<?php

class MapTheMissing_Admin {
    const NONCE = 'mapthemissing-update-key';

    private static $initiated = false;
    private static $notices   = array();

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }

        if ( isset( $_POST['action'] ) && $_POST['action'] == 'enter-key' ) {
            self::enter_api_key();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;

        add_action( 'admin_init', array( 'MapTheMissing_Admin', 'admin_init' ) );
        add_action( 'admin_menu', array( 'MapTheMissing_Admin', 'admin_menu' ), 5 );
        add_action( 'admin_notices', array( 'MapTheMissing_Admin', 'display_notice' ) );

        add_action( 'admin_enqueue_scripts', array( 'MapTheMissing_Admin', 'load_resources' ) );
        add_filter( 'plugin_action_links', array( 'MapTheMissing_Admin', 'plugin_action_links' ), 10, 2 );
        add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'mapthemissing.php'), array( 'MapTheMissing_Admin', 'admin_plugin_settings_link' ) );
        add_filter( 'all_plugins', array( 'MapTheMissing_Admin', 'modify_plugin_description' ) );
    }

    public static function admin_init() {

        if ( get_option( 'activated_autocomplete' ) ) {
            delete_option( 'activated_autocomplete' );

            if ( ! headers_sent() ) {
                wp_redirect( add_query_arg( array( 'page' => 'mapthemissing-key-config', 'view' => 'start' ), class_exists( 'Jetpack' ) ? admin_url( 'admin.php' ) : admin_url( 'options-general.php' ) ) );
            }
        }

        load_plugin_textdomain( 'mapthemissing' );
    }

    public static function admin_menu() {
        self::load_menu();
    }

    public static function admin_head() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
    }

    public static function admin_plugin_settings_link( $links ) {
        $settings_link = '<a href="'.esc_url( self::get_page_url() ).'">'.__('Settings', 'mapthemissing').'</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function load_menu() {
        $hook = add_options_page( __('mapthemissing', 'mapthemissing'), __('mapthemissing', 'mapthemissing'), 'manage_options', 'mapthemissing-key-config', array( 'MapTheMissing_Admin', 'display_page' ) );
        if ( $hook ) {
            add_action( "load-$hook", array( 'MapTheMissing_Admin', 'admin_help' ) );
        }
    }

    public static function load_resources() {
        global $hook_suffix;

        if ( in_array( $hook_suffix, apply_filters( 'mapthemissing_admin_page_hook_suffixes', array(
            'index.php', # dashboard
            'post.php',
            'settings_page_mapthemissing-key-config',
            'plugins.php',
        ) ) ) ) {
            wp_register_style( 'mapthemissing.css', plugin_dir_url( __FILE__ ) . '_inc/mapthemissing.css', array(), MAPTHEMISSING_VERSION );
            wp_enqueue_style( 'mapthemissing.css');

            wp_register_script( 'mapthemissing.js', plugin_dir_url( __FILE__ ) . '_inc/mapthemissing.js', array('jquery'), MAPTHEMISSING_VERSION );
            wp_enqueue_script( 'mapthemissing.js' );
        }
    }

    /**
     * Add help to the mapthemissing page
     *
     * @return false if not the mapthemissing page
     */
    public static function admin_help() {
        $current_screen = get_current_screen();

        // Screen Content
        if ( current_user_can( 'manage_options' ) ) {
            if ( !MapTheMissing::get_api_key() || ( isset( $_GET['view'] ) && $_GET['view'] == 'start' ) ) {
                //setup page
                $current_screen->add_help_tab(
                    array(
                        'id'		=> 'overview',
                        'title'		=> __( 'Overview' , 'mapthemissing'),
                        'content'	=>
                            '<p><strong>' . esc_html__( 'MapTheMissing Setup' , 'mapthemissing') . '</strong></p>' .
                            '<p>' . esc_html__( constant("MAPTHEMISSING_DESCRIPTION"), 'mapthemissing') . '</p>' .
                            '<p>' . esc_html__( 'On this page, you are able to set up the MapTheMissing plugin.' , 'mapthemissing') . '</p>',
                    )
                );

                $current_screen->add_help_tab(
                    array(
                        'id'		=> 'setup-api-key',
                        'title'		=> __( 'New to MapTheMissing' , 'mapthemissing'),
                        'content'	=>
                            '<p><strong>' . esc_html__( 'MapTheMissing Setup' , 'mapthemissing') . '</strong></p>' .
                            '<p>' . esc_html__( 'You need to enter an MapTheMissing API key to make use of this plugin on your site.' , 'mapthemissing') . '</p>' .
                            '<p>' . sprintf( __( '%s to get an API Key.' , 'mapthemissing'), '<a href="' . mapthemissing_url('signup') . '" target="_blank">Sign up for an account</a>' ) . '</p>',
                    )
                );

                $current_screen->add_help_tab(
                    array(
                        'id'		=> 'setup-manual',
                        'title'		=> __( 'Enter an API Key' , 'mapthemissing'),
                        'content'	=>
                            '<p><strong>' . esc_html__( 'MapTheMissing Setup' , 'mapthemissing') . '</strong></p>' .
                            '<p>' . esc_html__( 'If you already have an API key' , 'mapthemissing') . '</p>' .
                            '<ol>' .
                            '<li>' . esc_html__( 'Copy and paste the API key into the text field.' , 'mapthemissing') . '</li>' .
                            '<li>' . esc_html__( 'Click the \'Use this key\' button.' , 'mapthemissing') . '</li>' .
                            '</ol>',
                    )
                );
            }

            else {
                //configuration page
                $current_screen->add_help_tab(
                    array(
                        'id'		=> 'overview',
                        'title'		=> __( 'Overview' , 'mapthemissing'),
                        'content'	=>
                            '<p><strong>' . esc_html__( 'MapTheMissing Configuration' , 'mapthemissing') . '</strong></p>' .
                            '<p>' . esc_html__( constant('MAPTHEMISSING_DESCRIPTION') , 'mapthemissing') . '</p>' .
                            '<p>' . esc_html__( 'On this page, you are able to update your MapTheMissing API Key.' , 'mapthemissing') . '</p>',
                    )
                );

                $current_screen->add_help_tab(
                    array(
                        'id'		=> 'settings',
                        'title'		=> __( 'Settings' , 'mapthemissing'),
                        'content'	=>
                            '<p><strong>' . esc_html__( 'MapTheMissing Configuration' , 'mapthemissing') . '</strong></p>' .
                            ( MapTheMissing::predefined_api_key() ? '' : '<p><strong>' . esc_html__( 'MapTheMissing API Key' , 'mapthemissing') . '</strong> - ' . esc_html__( 'Enter/Delete an API Key.' , 'mapthemissing') . '</p>' )
                    )
                );
            }
        }

        $current_screen->set_help_sidebar(
            '<p><strong>' . esc_html__( 'For more information:' , 'mapthemissing') . '</strong></p>' .
            '<p><a href="' . mapthemissing_url('documentation') . '" target="_blank">'     . esc_html__( 'Documentation' , 'mapthemissing') . '</a></p>' .
            '<p><a href="mailto:' . constant('MAPTHEMISSING_EMAIL_SUPPORT') .'" target="_blank">' . esc_html__( 'Support' , 'mapthemissing') . '</a></p>'
        );
    }

    public static function enter_api_key() {
        if ( ! current_user_can( 'manage_options' ) ) {
            die( __( "Ah ah ah, you didn't say the magic word...", 'mapthemissing' ) );
        }

        if ( !wp_verify_nonce( $_POST['_wpnonce'], self::NONCE ) )
            return false;

        if ( MapTheMissing::predefined_api_key() ) {
            return false; //shouldn't have option to save key if already defined
        }

        $new_key = preg_replace( '/[^a-f0-9]/i', '', $_POST['key'] );
        $old_key = MapTheMissing::get_api_key();

        if ( empty( $new_key ) ) {
            if ( !empty( $old_key ) ) {
                delete_option( 'mapthemissing_api_key' );
                self::$notices[] = 'new-key-empty';
            }
        }
        elseif ( $new_key != $old_key ) {
            self::save_key( $new_key );
        }

        return true;
    }

    public static function save_key( $api_key ) {
        $key_status = MapTheMissing::verify_key( $api_key );

        if ( $key_status == 'valid' ) {
            update_option( 'mapthemissing_api_key', $api_key );
            update_option('mapthemissing_key_verified', true);
            self::$notices['status'] = 'new-key-valid';
        }
        elseif ( in_array( $key_status, array( 'invalid', 'failed' ) ) ) {
            self::$notices['status'] = 'new-key-'.$key_status;
        }
    }

    public static function plugin_action_links( $links, $file ) {
        if ( $file == plugin_basename( plugin_dir_url( __FILE__ ) . '/mapthemissing.php' ) ) {
            $links[] = '<a href="' . esc_url( self::get_page_url() ) . '">'.esc_html__( 'Settings' , 'mapthemissing').'</a>';
        }

        return $links;
    }

    // Check connectivity between the WordPress blog and mapthemissing's servers.
    // Returns an associative array of server IP addresses, where the key is the IP address, and value is true (available) or false (unable to connect).
    public static function check_server_ip_connectivity() {

        $servers = $ips = array();

        // Some web hosts may disable this function
        if ( function_exists('gethostbynamel') ) {

            $ips = gethostbynamel( constant("MAPTHEMISSING_URL_API"));
            if ( $ips && is_array($ips) && count($ips) ) {
                $api_key = MapTheMissing::get_api_key();

                foreach ( $ips as $ip ) {
                    $response = MapTheMissing::verify_key( $api_key, $ip );
                    // even if the key is invalid, at least we know we have connectivity
                    if ( $response == 'valid' || $response == 'invalid' )
                        $servers[$ip] = 'connected';
                    else
                        $servers[$ip] = $response ? $response : 'unable to connect';
                }
            }
        }

        return $servers;
    }

    // Simpler connectivity check
    public static function check_server_connectivity($cache_timeout = 86400) {

        $debug = array();
        $debug[ 'PHP_VERSION' ]              = PHP_VERSION;
        $debug[ 'WORDPRESS_VERSION' ]        = $GLOBALS['wp_version'];
        $debug[ 'MAPTHEMISSING_VERSION' ]     = MAPTHEMISSING_VERSION;
        $debug[ 'MAPTHEMISSING_PLUGIN_DIR' ]  = MAPTHEMISSING_PLUGIN_DIR;
        $debug[ 'SITE_URL' ]                 = site_url();
        $debug[ 'HOME_URL' ]                 = home_url();

        $servers = get_option('mapthemissing_available_servers');
        if ( (time() - get_option('mapthemissing_connectivity_time') < $cache_timeout) && $servers !== false ) {
            $servers = self::check_server_ip_connectivity();
            update_option('mapthemissing_available_servers', $servers);
            update_option('mapthemissing_connectivity_time', time());
        }

        $response = wp_remote_get( constant('MAPTHEMISSING_URL_API') );

        $debug[ 'gethostbynamel' ]  = function_exists('gethostbynamel') ? 'exists' : 'not here';
        $debug[ 'Servers' ]         = $servers;
        $debug[ 'Test Connection' ] = $response;

        MapTheMissing::log( $debug );

        if ( $response && 'connected' == wp_remote_retrieve_body( $response ) )
            return true;

        return false;
    }

    public static function get_page_url( $page = 'config' ) {

        $args = array( 'page' => 'mapthemissing-key-config' );

        if ( $page == 'delete_key' ) {
            $args = array('page' => 'mapthemissing-key-config', 'view' => 'start', 'action' => 'delete-key', '_wpnonce' => wp_create_nonce(self::NONCE));
        }

        return add_query_arg( $args, class_exists( 'Jetpack' ) ? admin_url( 'admin.php' ) : admin_url( 'options-general.php' ) );
    }

    public static function display_alert() {
        MapTheMissing::view( 'notice', array(
            'type' => 'alert',
            'code' => (int) get_option( 'mapthemissing_alert_code' ),
            'msg'  => get_option( 'mapthemissing_alert_msg' )
        ) );
    }

    public static function display_api_key_warning() {
        MapTheMissing::view( 'notice', array( 'type' => 'plugin' ) );
    }

    public static function display_page() {
        if ( !MapTheMissing::get_api_key() || ( isset( $_GET['view'] ) && $_GET['view'] == 'start' ) ) {
            self::display_start_page();
        } else {
            self::display_configuration_page();
        }
    }

    public static function display_start_page() {
        if ( isset( $_GET['action'] ) ) {
            if ( $_GET['action'] == 'delete-key' ) {
                if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], self::NONCE ) )
                    delete_option( 'mapthemissing_api_key' );
                    update_option('mapthemissing_key_verified', false);
            }
        }

        if ( $api_key = MapTheMissing::get_api_key() && ( empty( self::$notices['status'] ) || 'existing-key-invalid' != self::$notices['status'] ) ) {
            self::display_configuration_page();
            return;
        }

        MapTheMissing::view( 'start', array('notices' => self::$notices));
    }

    public static function display_configuration_page() {
        $api_key = MapTheMissing::get_api_key();
        $details = [];

        if (!empty($api_key)) {
            $response = MapTheMissing::api_fetch_account_details();
            if (!MapTheMissing::is_response_ok($response, $details)) {
                self::$notices['alert'] = 'account-details-failed';
                 update_option('mapthemissing_key_verified', false);
            } else {
                 if (!get_option('mapthemissing_key_verified')) {
                     self::$notices['status'] = 'new-key-valid';
                 }
                 update_option('mapthemissing_key_verified', true);
            }
        }

        MapTheMissing::view( 'config', ['api_key' => $api_key, 'notices' => self::$notices, 'details' => $details]);
    }

   public static function display_notice() {
		global $hook_suffix;

		if ( in_array( $hook_suffix, array( 'jetpack_page_mapthemissing-key-config', 'settings_page_autocomeplete-key-config' ) ) ) {
			return;
		}

		if ( ( 'plugins.php' === $hook_suffix ) && (! get_option('mapthemissing_key_verified') ) ) {
			self::display_api_key_warning();
		}
	}

    /**
     * When mapthemissing is active, remove the "Activate mapthemissing" step from the plugin description.
     */
    public static function modify_plugin_description( $all_plugins ) {
        if ( isset( $all_plugins['mapthemissing/mapthemissing.php'] ) ) {
            if ( MapTheMissing::get_api_key() ) {
                $all_plugins['mapthemissing/mapthemissing.php']['Description'] = __( 'Welcome to MapTheMissing!', 'mapthemissing' );
            }
            else {
                $all_plugins['mapthemissing/mapthemissing.php']['Description'] = __( 'Welcome to MapTheMissing! To get started, just go to <a href="admin.php?page=mapthemissing-key-config">your MapTheMissing Settings page</a> to set up your API Key.', 'mapthemissing' );
            }
        }

        return $all_plugins;
    }
}
