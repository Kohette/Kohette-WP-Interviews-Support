<?php
/*
Name: Kohette WDT Framework
URI: https://github.com/Kohette/Kohette-WordPress-Dev-Tools/
Description: Load the theme configuration and custom functions & features.
Author: Rafael Martín
Author URI: http://kohette.com/
Version: 1.5.7
*/



/**
* Definimos la global que tendra un array con todas las opciones
* generales del site relacionadas con el themes
* @package Kohette Framework
*/
global $KTT_theme_options;


/**
* Clase que maneja el Framework.
*
* Esta clase inicializa todos los procesos requeridos para implementar kohette en
* el theme.
*
* @package Kohette Framework
*
* @param array $theme_config Array conteniendo las variables iniciales para el framework como textdomain, etc.
*/
class kohette_framework {

    private $theme_config;

    /**
    * Constructor de Clase
    */
    public function __construct($theme_config = '') {

            $this->set_fw_constants();
            $this->set_theme_config($theme_config);
            $this->load_framework_functions(); // load custom functions

            $this->set_theme_options_global();
          	$this->load_framework_modules(); // load framework handy classes
            $this->load_framework_hooks(); // load custom functions
            $this->create_theme_options_page();
            $this->load_plugins();


    }

    /**
    * Constructor de Clase
    */
    public function kohette_framework($theme_config) {
            self::__construct();
    }

    /**
    * Esta funcion se encarga de guardar en una global un array de opciones
    * generales relacionadas con el theme.
    *
    * @global array $KTT_theme_options Array que contiene la informacion inicial de clase.
    * @global object $wpdb.
    */
    private function set_theme_options_global() {

          /**
          * Invocamos la variable wpdb
          */
          global $wpdb, $KTT_theme_options;

          /**
          * En result vamos a formar el array Final
          */
          $result = new stdClass();;

          /**
          * Ejecutamos una query que estraera todas las opciones del theme guardadas
          */
          $options = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE '" . ktt_var_name() . "%%'" );

          /**
          * Si no hemos encontrado opciones salimos de aqui
          */
          if (!$options) return;

          /**
          * Itineramos por cada resultado y lo vamos añadiendo al result
          */
          foreach ($options as $key => $value) if ($key) @$result->{ktt_remove_prefix($value->option_name)} = maybe_unserialize($value->option_value);

          /**
          * Guardamos en la global
          */
          $KTT_theme_options = $result;

    }




    /**
    * set the default constants of the framework
    */
    private function set_fw_constants() {

        /**
        * this defines the path of the resources of the framework
        */
        define("KOHETTE_FW_RESOURCES" , str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname(__FILE__)) . '/resources/');

    }




    /**
    * set the basic configuration of the theme
    */
    private function set_theme_config($theme_config = '') {

        /**
        * We add the default theme config
        */
        $theme_config = wp_parse_args($theme_config, $this->load_theme_data_constants());

        /**
        * Antes de crear la instancia del framework con el array de configuración aplicamos un filter
        * para añadir a la configuración informacion que se haya podido añadir por otras funciones
        * esto es util para que cada theme añada su propia configuración del framework.
        */
        $theme_config = apply_filters( 'KTT_theme_config', $theme_config );

        /**
        * Si no tenemos constants salimos de aqui
        */
        if (!$theme_config) return;


        $this->theme_config = $theme_config;


        /**
        * We create the defined constants for the theme
        */
        if (isset($theme_config['constants'])) {
        foreach($theme_config['constants'] as $item => $value) {

            $this->$item = $theme_config['constants'][$item];
            define("THEME_" . strtoupper($item) , $this->$item);

        }
        }

    }



    /**
    * load framework custom functions
    */
    private function load_framework_functions() {
		include('functions/basic-functions.php');
    }



    /**
    * load framework handy classes
    */
    private function load_framework_modules() {

    	foreach (glob(dirname(__FILE__). "/modules/*", GLOB_ONLYDIR) as $filename) {
        	include('modules/' . basename($filename) . '/' . basename($filename) . '.php') ;
		  };

    }


    /**
    * load framework hooks to improve WordPress
    */
    private function load_framework_hooks() {

        foreach (glob(dirname(__FILE__). "/hooks/*", GLOB_ONLYDIR) as $filename) {
            include('hooks/' . basename($filename) . '/' . basename($filename) . '.php') ;
        };

    }


    /**
    * create the theme options admin page/menu
    */
    public function create_theme_options_page() {

        $args = array();
        $args['id']             = 'theme-options';
        $args['page_title']     = 'Theme Options';
        $args['menu_title']     = 'Theme options';
        $args['page']           = ''; //array( &$this, 'default_theme_options_page');

        $new_admin_page = new KTT_admin_menu($args);

    }

    function default_theme_options_page() {
        global $submenu;

    }



    /**
    * Start trigger
    */
    function start_kohette_framework() {

        global $pagenow;
        if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

            set_default_options();

        }
    }



    /**
    * include the plugin file in the theme
    */
    private function run_activate_plugin( $plugin_source ) {
	    include($plugin_source);
	  }



	  /**
    * load the list of plugins
    */
    function load_plugins($plugins = '') {

      	require_once(ABSPATH . 'wp-admin/includes/plugin.php');

        /**
        * Antes de cargar definitivamente el array de plugins aplicamos un filter para comprobar
        * si otras funciones del theme quieren añadir archivos para incluir
        * Esto es util para que cada theme añada sus archivos (post_types, scripts, etc)
        */
        $plugins = apply_filters( 'KTT_theme_plugins', $plugins);

        /**
        * Si no hay plugins salimos de aqui
        */
        if (!$plugins) return;

      	foreach ($plugins as $plugin => $plugin_config) {

      		$plugin_data = get_plugin_data($plugin_config['source']);

      		$this->run_activate_plugin($plugin_config['source']);

      	}

    }

    /**
    * load theme data through style.css
    */
    function load_theme_data_constants() {

        /**
        * Devolveremos este array con la informacion del theme
        */
        $result = array();

        /**
        * Obtenemos los datos del theme
        */
        $theme_data = wp_get_theme();

        /**
        * Create the array data
        */
        $result['constants']['textdomain'] = $theme_data->get("TextDomain");
        $result['constants']['prefix'] = $result['constants']['textdomain'] . '_';

        /**
        * this define a constant for every folder of the theme directory
        * if the folder is named "the libs" the constant with the path will  defined as THEME_THE_LIBS_PATH
        */
        foreach (glob(get_stylesheet_directory() . "/*", GLOB_ONLYDIR) as $f) {

            $name = basename($f);
            $name = str_replace(' ', '_', $name);
            $name = str_replace('-', '_', $name);

            $result['constants'][strtoupper($name) . '_PATH'] = $f;

        };

        /**
        * Devolvemos el Array
        */
        return $result;


    }




}
