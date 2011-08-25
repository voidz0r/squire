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
 * Universal class loader
 * 
 * This class allows you to use autoloading for classes that
 * follow namespace conventions or PEAR naming standards.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class UniversalLoader extends AbstractLoader
{
	/**
	 * Registered namespaces.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $namespaces = array();
	
	/**
	 * Registered prefixes.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $prefixes = array();
	
	/**
	 * Registers a namespace for autoloading.
	 * 
	 * @param string $namespace
	 * @param string $path
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the namespace is registered
	 * 
	 * @uses Squire\ClassLoader\Loader::hasNamespace()
	 */
	public function registerNamespace($namespace, $path)
	{
		if ($this->hasNamespace($namespace)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" namespace has been already registered.',
				$namespace
			));
		}
		
		$this->namespaces[$namespace] = $path;
	}
	
	/**
	 * Registers the given namespaces for autoloading.
	 * 
	 * @param array $namespaces
	 * 
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\Loader::registerNamespace()
	 */
	public function registerNamespaces(array $namespaces)
	{
		foreach ($namespaces as $namespace => $path) {
			$this->registerNamespace($namespace, $path);
		}
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
	 * Returns the path for the given namespace.
	 * 
	 * @param string $namespace
	 * 
	 * @throws \InvalidArgumentException If the namespace is not registered
	 * 
	 * @uses Squire\ClassLoader\Loader::hasNamespace()
	 * @uses Squire\ClassLoader\Loader::getNamespaces()
	 */
	public function getNamespace($namespace)
	{
		if (!$this->hasNamespace($namespace)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" namespace is not registered.',
				$namespace
			));
		}
		
		$namespaces = $this->getNamespaces();
		return $namespaces[$namespace];
	}
	
	/**
	 * Returns whether the given namespace is registered.
	 * 
	 * @param string $namespace
	 * 
	 * @return boolean
	 * @access public
	 */
	public function hasNamespace($namespace)
	{
		return array_key_exists($namespace, $this->getNamespaces());
	}
	
	/**
	 * Registers a prefix for autoloading.
	 * 
	 * @param string $prefix
	 * @param string $path
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the prefix is registered
	 * 
	 * @uses Squire\ClassLoader\Loader::hasPrefix()
	 */
	public function registerPrefix($prefix, $path)
	{
		if ($this->hasPrefix($prefix)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" prefix has been already registered.',
				$prefix
			));
		}
		
		$this->prefixes[$prefix] = $path;
	}
	
	/**
	 * Registers the given prefixes for autoloading.
	 * 
	 * @param array $prefixes
	 * 
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\Loader::registerPrefix()
	 */
	public function registerPrefixes(array $prefixes)
	{
		foreach ($prefixes as $prefix => $path) {
			$this->registerPrefix($prefix, $path);
		}
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
	 * Returns the path for the given prefix.
	 * 
	 * @param string $prefix
	 * 
	 * @throws \InvalidArgumentException If the prefix is not registered
	 * 
	 * @uses Squire\ClassLoader\Loader::hasPrefix()
	 * @uses Squire\ClassLoader\Loader::getPrefixes()
	 */
	public function getPrefix($prefix)
	{
		if (!$this->hasPrefix($prefix)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" prefix is not registered.',
				$prefix
			));
		}
		
		$prefixes = $this->getPrefixes();
		return $prefixes[$prefix];
	}
	
	/**
	 * Returns whether the given prefix is registered.
	 * 
	 * @param string $prefix
	 * 
	 * @return boolean
	 * @access public
	 */
	public function hasPrefix($prefix)
	{
		return array_key_exists($prefix, $this->getPrefixes());
	}
	
	/**
	 * Returns the path to the given class or FALSE if
	 * the class cannot be found by the loader.
	 * 
	 * @param string $class
	 * 
	 * @return string|boolean
	 * @access public
	 * 
	 * @uses Squire\ClassLoader\Loader::getNamespaces()
	 * @uses Squire\ClassLoader\Loader::getPrefixes()
	 */
	public function findClass($class)
	{
		if (strpos($class, '\\') !== false) {
			if ($class[0] == '\\') {
				$class = substr($class, 1);
			}
			
			foreach ($this->getNamespaces() as $namespace => $path) {
				if (strpos($class, $namespace) !== 0) {
					continue;
				}
				
				$class_path = $path . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

				
				if (!is_file($class_path)) {
					continue;
				}
				
				return $class_path;
			}
		}
		else {
			foreach ($this->getPrefixes() as $prefix => $path) {
				if (strpos($class, $prefix) !== 0) {
					continue;
				}
				
				$class_path = $path . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
				
				if (!is_file($class_path)) {
					continue;
				}
				
				return $class_path;
			}
		}
		
		return false;
	}
}
