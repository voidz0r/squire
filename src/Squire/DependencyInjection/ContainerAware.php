<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\DependencyInjection;

/**
 * Container aware class
 * 
 * This abstract class must be extended by all those classes
 * who want to provide an API for accessing the services that
 * were registered in another container.
 * 
 * This allows you to use just one container instead of one
 * container per class. Note that this class allows just
 * read-only access to the container.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @abstract
 */
abstract class ContainerAware
{
	/**
	 * The service container.
	 * 
	 * @var    Squire\DependencyInjection\ServiceContainer
	 * @access protected
	 */
	protected $container = null;
	
	/**
	 * Sets the service container.
	 * 
	 * @param Squire\DependencyInjection\ServiceContainer &$container
	 * 
	 * @return Squire\DependencyInjection\ContainerAware
	 * @access public
	 */
	public function __construct(ServiceContainer &$container)
	{
		$this->container = $container;
	}
	
	/**
	 * Returns the service container.
	 * 
	 * @return Squire\DependencyInjection\ServiceContainer
	 * @access public
	 * 
	 * @throws \LogicException If no container has been set
	 * 
	 * @uses Squire\DependencyInjection\ContainerAware::hasServiceContainer()
	 */
	public function getServiceContainer()
	{
		if (!$this->hasServiceContainer()) {
			throw new \LogicException('No service container set.');
		}
		
		return $this->container;
	}
	
	/**
	 * Returns whether the service container has been set.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function hasServiceContainer()
	{
		return !is_null($this->container);
	}
	
	/**
	 * Returns a service registered in the container. Note that
	 * instead of returning a `Squire\DependencyInjection\Service`
	 * instance, this method will return the value returned by the
	 * callback specified while creating the service.
	 * 
	 * @param string $service
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @throws \LogicException If no container has been set
	 * 
	 * @uses Squire\DependencyInjection\ContainerAware::hasServiceContainer()
	 * @uses Squire\DependencyInjection\Service::getInstance()
	 */
	public function getService($service)
	{
		if (!$this->hasServiceContainer()) {
			throw new \LogicException('No service container set.');
		}
		
		return $this->getServiceContainer()->get($service)->getInstance();
	}
}
