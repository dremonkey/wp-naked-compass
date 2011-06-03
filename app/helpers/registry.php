<?php

/**
 * Helps us keep track of what objects have been instantiated and what hasn't
 * http://www.brandonsavage.net/use-registry-to-remember-objects-so-you-dont-have-to/
 */
Abstract Class Registry 
{
	
	protected static $_cache;

	public static function set($k, $v){
		if(!is_array(self::$_cache))
			self::$_cache = array();
		
		self::$_cache[$k] = $v;
	}

	public static function get($k){
		if(isset(self::$_cache[$k]))
			return self::$_cache[$k];
		else
			throw new Exception("Key doesn't exist");
	}

	public static function delete($k){
		if(isset(self::$_cache[$k]))
			unset(self::$_cache[$k]);
	}

}

?>