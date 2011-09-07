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
 * Universal class loader
 * 
 * The universal class loader allows you to automatically load
 * classes that follow the PHP 5.3 and PEAR naming conventions.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class UniversalLoader extends AbstractLoader
{
	/**
	 * @var array Registered namespaces.
	 * @access private
	 */
	protected $namespaces = array();
	
	/**
	 * @var array Registered prefixes.
	 * @access private
	 */
	protected $prefixes = array();
	
	/**
	 * Registers the given namespaces.
	 * 
	 * @param array $namespaces The namespaces to register.
	 * 
	 * @access public
	 */
	public function registerNamespaces(array $namespaces)
	{
		foreach ($namespaces as $namespace => $paths) {
			$this->registerNamespace($namespace, $paths);
		}
	}
	
	/**
	 * Registers a namespace.
	 * 
	 * @param string       $namespace The namespace.
	 * @param string|array $paths     The path(s) to look in.
	 * 
	 * @access public
	 */
	public function registerNamespace($namespace, $paths)
	{
		if (!is_array($paths)) {
			$paths = (array)$paths;
		}
		
		$this->namespaces[$namespace] = $paths;
	}
	
	/**
	 * Returns the registered namespaces.
	 * 
	 * @return array
	 * @access public
	 */
	public function getNamespaces()
	{
		return $this->namespaces;
	}
	
	/**
	 * Registers the given prefixes.
	 * 
	 * @param array $prefixes The prefixes to register.
	 * 
	 * @access public
	 */
	public function registerPrefixes(array $prefixes)
	{
		foreach ($prefixes as $prefix => $paths) {
			$this->registerPrefix($prefix, $paths);
		}
	}
	
	/**
	 * Registers a prefix.
	 * 
	 * @param string       $prefix The prefix.
	 * @param string|array $paths  The path(s) to look in.
	 * 
	 * @access public
	 */
	public function registerPrefix($prefix, $paths)
	{
		if (!is_array($paths)) {
			$paths = (array)$paths;
		}
		
		$this->prefixes[$prefix] = $paths;
	}
	
	/**
	 * Returns the registered prefixes.
	 * 
	 * @return array
	 * @access public
	 */
	public function getPrefixes()
	{
		return $this->prefixes;
	}
	
	/**
	 * Returns the path to a class' definition file.
	 * Returns FALSE if the path cannot be determined.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 */
	public function getClassPath($class)
	{
		if (strpos($class, '\\') !== false) {
			$class = ltrim($class, '\\');
			$fname = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
			
			foreach ($this->getNamespaces() as $namespace => $paths) {
				if (strpos($class, $namespace) === false) {
					continue;
				}
				
				foreach ($paths as $path) {
					$class_path = $path . DIRECTORY_SEPARATOR . $fname;
					
					if (is_file($class_path)) {
						return $class_path;
					}
				}
			}
		}
		else {
			$fname = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
			
			foreach ($this->getPrefixes() as $prefix => $paths) {
				if (strpos($class, $prefix) === false) {
					continue;
				}
				
				foreach ($paths as $path) {
					$class_path = $path . DIRECTORY_SEPARATOR . $fname;
					
					if (is_file($class_path)) {
						return $class_path;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Loads the given class' definition file.
	 * 
	 * @param string $class
	 * 
	 * @access public
	 * 
	 * @throws \LogicException If the class isn't defined in the expected file.
	 */
	public function loadClass($class)
	{
		$path = $this->getClassPath($class);
		
		if ($path !== false) {
			require_once $path;
			
			if (!class_exists($class) && !interface_exists($class)) {
				throw new \LogicException(sprintf(
					'"%s" should be defined in "%s", but it is not.',
					$class,
					$path
				));
			}
		}
	}
}
