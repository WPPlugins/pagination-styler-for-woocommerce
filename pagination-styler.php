<?php
/**
 * Plugin Name: Pagination Styler for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/pagination-styler-for-woocommerce/
 * Description: With WooCommerce pagination styler You can customize pagination as You want without code.
 * Version: 1.0.6
 * Author: BeRocket
 * Requires at least: 4.0
 * Author URI: http://berocket.com
 * Text Domain: BeRocket_Pagination_domain
 * Domain Path: /languages/
 */
define( "BeRocket_Pagination_version", '1.0.6' );
define( "BeRocket_Pagination_domain", 'BeRocket_Pagination_domain'); 
define( "Pagination_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );
load_plugin_textdomain('BeRocket_Pagination_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
require_once(plugin_dir_path( __FILE__ ).'includes/admin_notices.php');
require_once(plugin_dir_path( __FILE__ ).'includes/functions.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class BeRocket_Compare_Products
 */
class BeRocket_Pagination {

    public static $info = array( 
        'id'        => 6,
        'version'   => BeRocket_Pagination_version,
        'plugin'    => '',
        'slug'      => '',
        'key'       => '',
        'name'      => ''
    );

    /**
     * Defaults values
     */
    public static $defaults = array(
        'br_pagination_general_settings'    => array(
            'use_next_prev'                     => '1',
            'page_end_size'                     => '3',
            'page_mid_size'                     => '3',
            'use_dots'                          => '1',
        ),
        'br_pagination_style_settings'      => array(
            'pagination_pos'                    => 'center',
            'default_show'                      => array(
                'after_products'                    => '1',
                'before_products'                   => '',
            ),
            'ul_style'                          => array(
                'background-color'                  => '',
                'border-color'                      => 'd3ced2',
                'border-top-width'                  => '1',
                'border-bottom-width'               => '1',
                'border-left-width'                 => '1',
                'border-right-width'                => '0',
                'padding-top'                       => '0',
                'padding-bottom'                    => '0',
                'padding-left'                      => '0',
                'padding-right'                     => '0',
                'border-top-left-radius'            => '0',
                'border-top-right-radius'           => '0',
                'border-bottom-right-radius'        => '0',
                'border-bottom-left-radius'         => '0',
            ),
            'ul_li_style'                       => array(
                'border-color'                      => 'd3ced2',
                'border-top-width'                  => '0',
                'border-bottom-width'               => '0',
                'border-left-width'                 => '0',
                'border-right-width'                => '1',
                'border-top-left-radius'            => '0',
                'border-top-right-radius'           => '0',
                'border-bottom-right-radius'        => '0',
                'border-bottom-left-radius'         => '0',
                'margin-top'                        => '0',
                'margin-bottom'                     => '0',
                'margin-left'                       => '0',
                'margin-right'                      => '0',
                'float'                             => 'left',
            ),
            'ul_li_hover_style'                 => array(
                'border-color'                      => 'd3ced2',
            ),
            'ul_li_a-span_style'                => array(
                'color'                             => '333',
                'background-color'                  => '',
                'padding-top'                       => '10',
                'padding-bottom'                    => '10',
                'padding-left'                      => '10',
                'padding-right'                     => '10',
            ),
            'ul_li_a-span_hover_style'          => array(
                'color'                             => '8a7e88',
                'background-color'                  => 'ebe9eb',
            ),
        ),
        'br_pagination_text_settings'       => array(
            'dots_prev_text'                    => '…',
            'dots_next_text'                    => '…',
            'prev_text'                         => '«',
            'next_text'                         => '»',
            'current_page'                      => '%PAGE%',
            'page'                              => '%PAGE%',
            'first_page'                        => '1',
            'last_page'                         => '%LAST%',
        ),
        'br_pagination_javascript_settings' => array(
            'page_load'                         => '',
            'custom_css'                        => '',
        ),
    );
    public static $values = array(
        'settings_name' => '',
        'option_page'   => 'br-pagination',
        'premium_slug'  => 'woocommerce-pagination-styler',
    );
    
    function __construct () {

        if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && br_get_woocommerce_version() >= 2.1 ) {
            add_action ( 'init', array( __CLASS__, 'init' ) );
            add_action ( 'admin_init', array( __CLASS__, 'admin_init' ) );
            add_action ( 'admin_menu', array( __CLASS__, 'options' ) );
            add_action ( 'wp_head', array( __CLASS__, 'wp_head_style' ) );
            add_action ( 'wp_footer', array( __CLASS__, 'wp_footer_script' ) );
            
            $style_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_style_settings' );
            add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
            $plugin_base_slug = plugin_basename( __FILE__ );
            add_filter( 'plugin_action_links_' . $plugin_base_slug, array( __CLASS__, 'plugin_action_links' ) );
            add_filter( 'is_berocket_settings_page', array( __CLASS__, 'is_settings_page' ) );
        }
    }
    public static function is_settings_page($settings_page) {
        if( ! empty($_GET['page']) && $_GET['page'] == self::$values[ 'option_page' ] ) {
            $settings_page = true;
        }
        return $settings_page;
    }
    public static function plugin_action_links($links) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page='.self::$values['option_page'] ) . '" title="' . __( 'View Plugin Settings', 'BeRocket_products_label_domain' ) . '">' . __( 'Settings', 'BeRocket_products_label_domain' ) . '</a>',
		);
		return array_merge( $action_links, $links );
    }
    public static function plugin_row_meta($links, $file) {
        $plugin_base_slug = plugin_basename( __FILE__ );
        if ( $file == $plugin_base_slug ) {
			$row_meta = array(
				'docs'    => '<a href="http://berocket.com/docs/plugin/'.self::$values['premium_slug'].'" title="' . __( 'View Plugin Documentation', 'BeRocket_products_label_domain' ) . '" target="_blank">' . __( 'Docs', 'BeRocket_products_label_domain' ) . '</a>',
				'premium'    => '<a href="http://berocket.com/product/'.self::$values['premium_slug'].'" title="' . __( 'View Premium Version Page', 'BeRocket_products_label_domain' ) . '" target="_blank">' . __( 'Premium Version', 'BeRocket_products_label_domain' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
    }

    public static function init () {
        $style_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_style_settings' );
        wp_register_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ) );
        wp_enqueue_style( 'font-awesome' );
        wp_register_style( 'berocket_pagination_style', plugins_url( 'css/pagination.css', __FILE__ ), "", BeRocket_Pagination_version );
        wp_enqueue_style( 'berocket_pagination_style' );
        wp_enqueue_script( 'berocket_pagination_script', plugins_url( 'js/pagination_styler.js', __FILE__ ), array( 'jquery' ), BeRocket_Pagination_version );
        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
        if ( $style_options['default_show']['after_products'] ) {
            add_action ( 'woocommerce_after_shop_loop', 'berocket_pagination', 10 );
        }
        if ( $style_options['default_show']['before_products'] ) {
            add_action ( 'woocommerce_before_shop_loop', 'berocket_pagination', 80 );
        }
        add_filter ( 'woocommerce_pagination_args', array( __CLASS__, 'set_pagination_settings' ) );
    }

    public static function set_pagination_settings ( $args ) {
        $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_general_settings' );
        $text_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_text_settings' );
        $args['prev_next']  = $options['use_next_prev'];
        $args['end_size']   = $options['page_end_size'];
        $args['mid_size']   = $options['page_mid_size'];
        $args['current_page'] = $text_options['current_page'];
        $args['prev_text']   = $text_options['prev_text'];
        $args['next_text']   = $text_options['next_text'];
        $args['dots_prev_text'] = $text_options['dots_prev_text'];
        $args['dots_next_text'] = $text_options['dots_next_text'];
        $args['first_page'] = $text_options['first_page'];
        $args['last_page'] = $text_options['last_page'];
        $args['page'] = $text_options['page'];
        return apply_filters( 'berocket_pagination_styler_page_data', $args );
    }

    public static function admin_init () {
        if( @ $_GET['page'] == 'br-pagination' ) {
            wp_register_style( 'berocket_pagination_fa_select_style', plugins_url( 'css/select_fa.css', __FILE__ ), "", BeRocket_Pagination_version );
            wp_enqueue_style( 'berocket_pagination_fa_select_style' );
            wp_enqueue_script( 'berocket_pagination_admin_fa', plugins_url( 'js/admin_select_fa.js', __FILE__ ), array( 'jquery' ), BeRocket_Pagination_version );
            wp_enqueue_script( 'berocket_aapf_widget-colorpicker', plugins_url( 'js/colpick.js', __FILE__ ), array( 'jquery' ) );
            wp_enqueue_script( 'berocket_pagination_admin_script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ) );
            wp_register_style( 'berocket_aapf_widget-colorpicker-style', plugins_url( 'css/colpick.css', __FILE__ ) );
            wp_enqueue_style( 'berocket_aapf_widget-colorpicker-style' );
            wp_register_style( 'berocket_pagination_admin_style', plugins_url( 'css/admin.css', __FILE__ ), "", BeRocket_Pagination_version );
            wp_enqueue_style( 'berocket_pagination_admin_style' );
        }
        register_setting('br_pagination_general_settings', 'br_pagination_general_settings', array( __CLASS__, 'sanitize_pagination_option' ));
        register_setting('br_pagination_style_settings', 'br_pagination_style_settings', array( __CLASS__, 'sanitize_pagination_option' ));
        register_setting('br_pagination_text_settings', 'br_pagination_text_settings', array( __CLASS__, 'sanitize_pagination_option' ));
        register_setting('br_pagination_javascript_settings', 'br_pagination_javascript_settings', array( __CLASS__, 'sanitize_pagination_option' ));
        register_setting('br_pagination_license_settings', 'br_pagination_license_settings', array( __CLASS__, 'sanitize_pagination_option' ));
        add_settings_section( 
            'br_pagination_general_page',
            'General Settings',
            'br_pagination_general_callback',
            'br_pagination_general_settings'
        );

        add_settings_section( 
            'br_pagination_style_page',
            'Style Settings',
            'br_pagination_style_callback',
            'br_pagination_style_settings'
        );

        add_settings_section( 
            'br_pagination_text_page',
            'Text Settings',
            'br_pagination_text_callback',
            'br_pagination_text_settings'
        );

        add_settings_section( 
            'br_pagination_javascript_page',
            'JavaScript / CSS Settings',
            'br_pagination_javascript_callback',
            'br_pagination_javascript_settings'
        );
    }

    public static function options() {
        add_submenu_page( 'woocommerce', __('Pagination styler settings', 'BeRocket_Pagination_domain'), __('Pagination Styler', 'BeRocket_Pagination_domain'), 'manage_options', 'br-pagination', array(
            __CLASS__,
            'option_form'
        ) );
    }
    /**
     * Function add options form to settings page
     *
     * @access public
     *
     * @return void
     */
    public static function option_form() {
        $plugin_info = get_plugin_data(__FILE__, false, true);
        include Pagination_TEMPLATE_PATH . "settings.php";
    }
    /**
     * Load template
     *
     * @access public
     *
     * @param string $name template name
     *
     * @return void
     */
    public static function br_get_template_part( $name = '' ) {
        $template = '';

        // Look in your_child_theme/woocommerce-wish-list/name.php
        if ( $name ) {
            $template = locate_template( "woocommerce-pagination-styler/{$name}.php" );
        }

        // Get default slug-name.php
        if ( ! $template && $name && file_exists( Pagination_TEMPLATE_PATH . "{$name}.php" ) ) {
            $template = Pagination_TEMPLATE_PATH . "{$name}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'pagination_get_template_part', $template, $name );

        if ( $template ) {
            load_template( $template, false );
        }
    }
    public static function sanitize_pagination_option( $input ) {
        $default = BeRocket_Pagination::$defaults[$input['settings_name']];
        $result = self::recursive_array_set( $default, $input );
        return $result;
    }
    public static function recursive_array_set( $default, $options ) {
        foreach( $default as $key => $value ) {
            if( array_key_exists( $key, $options ) ) {
                if( is_array( $value ) ) {
                    if( is_array( $options[$key] ) ) {
                        $result[$key] = self::recursive_array_set( $value, $options[$key] );
                    } else {
                        $result[$key] = self::recursive_array_set( $value, array() );
                    }
                } else {
                    $result[$key] = $options[$key];
                }
            } else {
                if( is_array( $value ) ) {
                    $result[$key] = self::recursive_array_set( $value, array() );
                } else {
                    $result[$key] = '';
                }
            }
        }
        foreach( $options as $key => $value ) {
            if( ! array_key_exists( $key, $result ) ) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    public static function get_pagination_option( $option_name ) {
        $options = get_option( $option_name );
        if ( @ $options && is_array ( $options ) ) {
            $options = array_merge( BeRocket_Pagination::$defaults[$option_name], $options );
        } else {
            $options = BeRocket_Pagination::$defaults[$option_name];
        }
        return $options;
    }
    public static function wp_head_style() {
        $style_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_style_settings' );
        echo '<style>';
        echo '.woocommerce-pagination.berocket_pagination {';
        echo 'text-align: '.$style_options['pagination_pos'].'!important;';
        echo 'clear: both;';
        echo '}';
        echo '.woocommerce-pagination.berocket_pagination ul{';
        self::array_to_style ( $style_options['ul_style'] );
        echo '}';
        echo '.woocommerce-pagination.berocket_pagination ul li{';
        self::array_to_style ( $style_options['ul_li_style'] );
        echo '}';
        echo '.woocommerce-pagination.berocket_pagination ul li:hover{';
        self::array_to_style ( $style_options['ul_li_hover_style'] );
        echo '}';
        echo '.woocommerce-pagination.berocket_pagination ul li > a, .woocommerce-pagination.berocket_pagination ul li > span{';
        self::array_to_style ( $style_options['ul_li_a-span_style'] );
        echo '}';
        echo '.woocommerce-pagination.berocket_pagination ul li > a:hover, .woocommerce-pagination.berocket_pagination ul li > span.current{';
        self::array_to_style ( $style_options['ul_li_a-span_hover_style'] );
        echo '}';
        $javascript_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_javascript_settings' );
        echo $javascript_options['custom_css'];
        echo '</style>';
    }
    public static function array_to_style ( $styles ) {
        $color = array( 'color', 'background-color', 'border-color' );
        $size = array( 'border-top-width', 'border-bottom-width', 'border-left-width', 'border-right-width',
            'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
            'border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius',
            'margin-top', 'margin-bottom', 'margin-left', 'margin-right', 'top', 'bottom', 'left', 'right' );
        foreach( $styles as $name => $value ) {
            if ( isset( $value ) ) {
                if ( in_array( $name, $color ) ) {
                    if ( $value[0] != '#' ) {
                        $value = '#' . $value;
                    }
                    echo $name . ':' . $value . '!important;';
                } else if ( in_array( $name, $size ) ) {
                    if ( strpos( $value, '%' ) || strpos( $value, 'em' ) || strpos( $value, 'px' ) ) {
                        echo $name . ':' . $value . '!important;';
                    } else {
                        echo $name . ':' . $value . 'px!important;';
                    }
                } else {
                    echo $name . ':' . $value . '!important;';
                }
            }
        }
    }
    public static function wp_footer_script() {
        $style_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_style_settings' );
        echo '<script>';
        $javascript_options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_javascript_settings' );
        echo 'jQuery(document).ready( function () { ';
        echo $javascript_options['page_load'];
        echo '});';
        echo '</script>';
    }
}

new BeRocket_Pagination;

berocket_admin_notices::generate_subscribe_notice();
new berocket_admin_notices(array(
    'start' => 1498413376, // timestamp when notice start
    'end'   => 1504223940, // timestamp when notice end
    'name'  => 'name', //notice name must be unique for this time period
    'html'  => 'Only <strong>$10</strong> for <strong>Premium</strong> WooCommerce Load More Products plugin!
        <a class="berocket_button" href="http://berocket.com/product/woocommerce-load-more-products" target="_blank">Buy Now</a>
         &nbsp; <span>Get your <strong class="red">50% discount</strong> and save <strong>$10</strong> today</span>
        ', //text or html code as content of notice
    'righthtml'  => '<a class="berocket_no_thanks">No thanks</a>', //content in the right block, this is default value. This html code must be added to all notices
    'rightwidth'  => 80, //width of right content is static and will be as this value. berocket_no_thanks block is 60px and 20px is additional
    'nothankswidth'  => 60, //berocket_no_thanks width. set to 0 if block doesn't uses. Or set to any other value if uses other text inside berocket_no_thanks
    'contentwidth'  => 400, //width that uses for mediaquery is image_width + contentwidth + rightwidth
    'subscribe'  => false, //add subscribe form to the righthtml
    'priority'  => 10, //priority of notice. 1-5 is main priority and displays on settings page always
    'height'  => 50, //height of notice. image will be scaled
    'repeat'  => false, //repeat notice after some time. time can use any values that accept function strtotime
    'repeatcount'  => 1, //repeat count. how many times notice will be displayed after close
    'image'  => array(
        'local' => plugin_dir_url( __FILE__ ) . 'images/ad_white_on_orange.png', //notice will be used this image directly
    ),
));
