<?php

/**
 * Factory instantiates your class or returns a previously instantiated class
 * from the Registry. If Factory is creating a new instance of the class then
 * it will save that instance to the Registry so that it can be used later.
 *
 */
Abstract Class Factory
{

	/**
	 * Returns the path of the directory with $name 
	 */
	private static function dir($name){
		return TEMPLATEPATH . '/app/' . $name . '/';
	}

	public static function controller($filename, $args=NULL){
		try {
			$classname = $filename . '_controller';
			$instance = Registry::get($classname);
			return $instance;
		} catch (Exception $e) {
			$instance = Factory::new_instance('controller', $filename, $args);
			return $instance;
		}		
	}

	public static function model($filename, $args=NULL){
		try {
			$classname = $filename . '_model';
			$instance = Registry::get($classname);
			return $instance;
		} catch (Exception $e) {
			$instance = Factory::new_instance('model', $filename, $args);
			return $instance;
		}
	}

	public static function config($filename, $args=NULL){
		try {
			$classname = $filename . '_config';
			$instance = Registry::get($classname);
			return $instance;
		} catch (Exception $e) {
			$instance = Factory::new_instance('config', $filename, $args);
			return $instance;
		}
	}

	public static function helpers($filename, $args=NULL){
		try {
			$classname = $filename . '_helper';
			$instance = Registry::get($classname);
			return $instance;
		} catch (Exception $e) {
			$instance = Factory::new_instance('helper', $filename, $args);
			return $instance;
		}
	}

	/**
	 * new_instance
	 * 
	 * Instantiates a new instance of the requested class and saves it to the Registry
	 */
	public static function new_instance($type, $filename, $args=NULL) {
		switch($type) {
			case 'controller':
				require_once(self::dir('controllers') . $filename . '.php');
				break;
			case 'model':
				require_once(self::dir('models') . $filename . '.php');
				break;
			case 'config':
				require_once(self::dir('config') . $filename . '.php');
				break;
			case 'helper':
				require_once(self::dir('helpers') . $filename . '.php');
				break;
		}
		$classname = $filename . '_' . $type;
		$instance = new $classname($args);
		Registry::set($classname, $instance);
		return $instance;
	}
}

?>