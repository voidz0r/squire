<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\EventDispatcher;

/**
 * Event
 * 
 * This class contains all the data about an event: whether the propagation
 * has stopped and all the additional parameters.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class Event
{
	/**
	 * @var boolean Whether the propagation has stopped.
	 * @access protected
	 */
	protected $propagationStopped = false;
	
	/**
	 * @var array The event's parameters.
	 * @access protected
	 */
	protected $paramBag = null;
	
	/**
	 * Creates the event, setting all the parameters.
	 * 
	 * @param Squire\EventDispatcher\ParameterBag $paramBag Parameters.
	 * 
	 * @return Squire\EventDispatcher\Event
	 * @access public
	 */
	public function __construct(ParameterBag &$paramBag)
	{
		$this->paramBag = $paramBag;
	}
	
	/**
	 * Returns the parameter bag holding all the event's parameters.
	 * 
	 * @return array
	 * @access public
	 */
	public function getParamBag()
	{
		return $this->paramBag;
	}
	
	/**
	 * Stops the propagation of the event, avoiding further listensers to be
	 * called.
	 * 
	 * @access public
	 */
	public function stopPropagation()
	{
		$this->propagationStopped = true;
	}
	
	/**
	 * Whether the event propagation has been stopped.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isPropagationStopped()
	{
		return $this->propagationStopped;
	}
}
