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
 * Abstract class loader
 * 
 * This abstract class provides the basic methods for a
 * class loader and also defines the ones that must be
 * implemented.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @abstract
 */
abstract class AbstractLoader
{
	/**
	 * Returns the path to the given class or FALSE if
	 * it couldn't be found by the loader.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 * 
	 * @abstract
	 */
	abstract public function findClass($class);
	
	/**
	 * Loads the given class. Returns the path to the
	 * loaded class or FALSE if it couldn't be found
	 * by the loader.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\AbstractLoader::findClass()
	 * 
	 * @throws \LogicException If the class isn't defined in the expected file
	 */
	public function loadClass($class)
	{
		$path = $this->findClass($class);
		
		if (!$path) {
			return false;
		}
		
		require_once $path;
		
		if (!class_exists($path, false) && !interface_exists($path, false)) {
			throw new \LogicException(sprintf(
				'"%s" is not defined in "%s".',
				$class,
				$path
			));
		}
		
		return $path;
	}
	
	/**
	 * Registers the loader as an SPL autoloader.
	 * 
	 * @param boolean $prepend Whether to prepend the loader
	 * 
	 * @access public
	 * 
	 * @throws \LogicException If the component is already registered
	 * 
	 * @uses Squire\ClassLoader\Loader::isSplRegistered()
	 */
	public function splRegister($prepend = false)
	{
		if ($this->isSplRegistered()) {
			throw new \LogicException('The loader is already registered as an SPL autoloader.');
		}
		
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
	}
	
	/**
	 * Returns whether the loader is registered as an
	 * SPL autoloader.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isSplRegistered()
	{
		return in_array(array($this, 'loadClass'), spl_autoload_functions(), true);
	}
}
