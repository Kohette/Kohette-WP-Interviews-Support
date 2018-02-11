<?php
/*
Plugin Name: Kohette Interview Support
Description: Adds interviews support for WordPress posts
Version: 1.0.2
Author: Rafael Martín
Author URI: http://kohette.com
Text Domain: ktt-interview-support
Domain Path: /languages
*/


/**
* Incluímos Kohette Framework
*/
require_once("includes/kohette-framework/modules/metabox-creator/metabox-creator.php");

/**
* Metabox
*/
require_once("includes/interview-support-metabox.php");

/**
* Shortcode
*/
require_once("includes/interview-buttons-shortcode.php");
