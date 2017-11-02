<?php
/**
 * Plugin Name: Pickle Divi Builder Addons
 * Plugin URI: 
 * Description: A collection of modules that make the Divi Builder more awesome
 * Version: 1.0.0
 * Author: 
 * Author URI: 
 * Requires at least: 4.0
 * Tested up to: 4.8.3
 * Text Domain: pickle-divi
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!defined('PICKLE_DIVI_PLUGIN_FILE')) {
	define('PICKLE_DIVI_PLUGIN_FILE', __FILE__);
}

final class PickleDivi {

	public $version='1.0.0';

	protected static $_instance=null;

	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance=new self();
		}
		
		return self::$_instance;
	}

	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	private function define_constants() {
		$this->define('PICKLE_DIVI_VERSION', $this->version);
		$this->define('PICKLE_DIVI_PATH', plugin_dir_path(__FILE__));
		$this->define('PICKLE_DIVI_URL', plugin_dir_url(__FILE__));
		
	}

	private function define($name, $value) {
		if (!defined($name)) {
			define($name, $value);
		}
	}

	public function includes() {

	}

	private function init_hooks() {
		add_action('et_builder_ready', array($this, 'load_modules'));
		add_action('init', array($this, 'init'), 0);
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts_styles'));
	}

	public function init() {

	}

	public function frontend_scripts_styles() {
		wp_enqueue_style('pickle-divi-modules-layout', PICKLE_DIVI_URL.'css/modules-layout.css', '', PICKLE_DIVI_VERSION);
	}

	public function load_modules() {
		include_once(PICKLE_DIVI_PATH.'modules/functions.php');
		
		if (class_exists('ET_Builder_Module')) :
			include_once(PICKLE_DIVI_PATH.'modules/posts.php');	    
		endif;
	}

}

function pickle_divi() {
	return PickleDivi::instance();
}

// Global for backwards compatibility.
$GLOBALS['pickle_divi']=pickle_divi();