<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\ClassLoader;

/**
 * Map class loader
 * 
 * This is a static loader: you must provide the full paths
 * to the classes and it will load them.
 * 
 * You should always use a naming standard in your projects,
 * so this loader shouldn't be needed. However, it becomes
 * handy in certain situations (for example when you want to
 * overwrite a class of an external library without hacking
 * the core).
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class MapLoader extends AbstractLoader
{
	/**
	 * Registered classes.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $classes = array();
	
	/**
	 * Registers the given classes.
	 * 
	 * @param array $classes
	 * 
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\MapLoader::registerClass()
	 */
	public function registerClasses(array $classes)
	{
		foreach ($classes as $name => $path) {
			$this->registerClass($name, $path);
		}
	}
	
	/**
	 * Registers a class.
	 * 
	 * @param string $name
	 * @param string $path
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the class is already registered
	 * 
	 * @uses Squire\ClassLoader\MapLoader::hasClass()
	 */
	public function registerClass($name, $path)
	{
		if ($this->hasClass($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" class is already registered.',
				$name
			));
		}
		
		$this->classes[$name] = $path;
	}
	
	/**
	 * Returns the registered classes.
	 * 
	 * @return array
	 * @access public
	 */
	public function getClasses()
	{
		return $this->classes;
	}
	
	/**
	 * Returns the registered path to the given class.
	 * 
	 * @param string $name
	 * 
	 * @return string
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the class is not registered
	 * 
	 * @uses Squire\ClassLoader\MapLoader::hasClass()
	 */
	public function getClass($name)
	{
		if (!$this->hasClass($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" class is not registered.',
				$name
			));
		}
		
		$classes = $this->getClasses();
		return $classes[$name];
	}
	
	/**
	 * Returns whether the given class is registered.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\MapLoader::getClasses()
	 */
	public function hasClass($name)
	{
		return array_key_exists($name, $this->getClasses());
	}
	
	/**
	 * If the class is registered returns the path to
	 * it. Otherwise returns FALSE.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\MapLoader::hasClass()
	 * @uses Squire\ClassLoader\MapLoader::getClass()
	 */
	public function findClass($class)
	{
		if (!$this->hasClass($class)) {
			return false;
		}
		
		return $this->getClass($class);
	}
	
	/**
	 * Registers the loader as an SPL autoloader. This
	 * is overwritten because this loader is always
	 * prepended.
	 * 
	 * @access public
	 */
	public function splRegister()
	{
		parent::splRegister(true);
	}
}
