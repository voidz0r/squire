<?php

/*
 * This file is part of the Squire framework.
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
 * This skeleton class should be extended by all the class
 * autoloaders. It provides methods to handle SPL autoload
 * functions.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
abstract class AbstractLoader
{
	/**
	 * Returns the path to a class' definition file.
	 * Returns FALSE if the path cannot be determined.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 */
	abstract public function getClassPath($class);
	
	/**
	 * Registers the loader as an SPL autoload function.
	 * 
	 * @access public
	 * 
	 * @throws \LogicException If the loader has been already registered.
	 */
	final public function register()
	{
		if (in_array($this->getCallback(), spl_autoload_functions())) {
			throw new \LogicException(sprintf(
				'The loader has been already registered.'
			));
		}
		
		spl_autoload_register($this->getCallback());
	}
	
	/**
	 * Unregisters the SPL autoload function.
	 * 
	 * @access public
	 * 
	 * @throws \LogicException If the loader hasn't been registered.
	 */
	final public function unregister()
	{
		if (!in_array($this->getCallback(), spl_autoload_functions())) {
			throw new \LogicException(sprintf(
				'The loader has not been registered yet.'
			));
		}
		
		spl_autoload_unregister($this->getCallback());
	}
	
	/**
	 * Returns the callback that must be provided to the SPL autoload
	 * functions.
	 * 
	 * @return array
	 * @access private
	 */
	protected function getCallback()
	{
		return array($this, 'loadClass');
	}
}
