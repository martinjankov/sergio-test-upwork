<?php
/**
 * Plugin Name: Sergio Upwork Test
 * Description: Print "Hello World" in console for latest post only
 * Author:      SergioUpworkTest
 * Author URI:  https://www.martincv.com
 * Version:     1.0.0
 * Text Domain: sut
 * Domain Path: /languages
 *
 * @package    SergioUpworkTest
 * @author     SergioUpworkTest
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2020, SergioUpworkTest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class SergioUpworkTest {
    /**
     * Instance of the plugin
     *
     * @var SergioUpworkTest
     */
	private static $_instance;

    /**
     * Plugin version
     *
     * @var string
     */
	private $_version = '1.0.0';

	public static function instance() {
		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof SergioUpworkTest ) ) {
			self::$_instance = new SergioUpworkTest;
            self::$_instance->constants();
			self::$_instance->includes();

            add_action( 'plugins_loaded', [ self::$_instance, 'objects' ] );
            add_action( 'plugins_loaded', [ self::$_instance, 'load_textdomain' ] );
        }

		return self::$_instance;
	}

    /**
     * 3rd party includes
     *
     * @return  void
     */
	private function includes() {
		require_once SUT_PLUGIN_DIR . 'inc/core/autoloader.php';
	}

    /**
     * Define plugin constants
     *
     * @return  void
     */
	private function constants() {
		// Plugin version
		if ( ! defined( 'SUT_VERSION' ) ) {
			define( 'SUT_VERSION', $this->_version );
		}

		// Plugin Folder Path
		if ( ! defined( 'SUT_PLUGIN_DIR' ) ) {
			define( 'SUT_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'SUT_PLUGIN_URL' ) ) {
			define( 'SUT_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}
	}

    /**
     * Initialize classes / objects here
     *
     * @return  void
     */
	public function objects() {
		// Global objects
        \SergioUpworkTest\Post::get_instance();
	}

    /**
     * Register textdomain
     *
     * @return  void
     */
    public function load_textdomain() {
		load_plugin_textdomain( 'sut', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
}

function sut() {
	return SergioUpworkTest::instance();
}
sut();
