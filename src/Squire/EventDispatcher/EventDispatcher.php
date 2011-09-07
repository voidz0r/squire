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
 * Event dispatcher
 * 
 * An event dispatcher notifies the events to all the registered listeners.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class EventDispatcher
{
	/**
	 * @var array Registered listeners.
	 * @access protected
	 */
	protected $listeners = array();
	
	/**
	 * @var array Listeners sorted by priority.
	 * @access protected
	 */
	protected $sorted = array();
	
	/**
	 * Returns the listeners.
	 * 
	 * @param string $eventName Event's name (NULL to get all listeners).
	 * 
	 * @return array
	 * @access public
	 */
	public function getListeners($eventName = null)
	{
		if ($eventName === null) {
			return $this->listeners[$eventName];
		}
		
		if (!isset($this->listeners[$eventName])) {
			return array();
		}
		
		return $this->listeners[$eventName];
	}
	
	/**
	 * Returns the sorted listeners.
	 * 
	 * @param string $eventName Event's name (NULL to get all listeners).
	 * 
	 * @return array
	 * @access public
	 */
	public function getSortedListeners($eventName = null)
	{
		if ($eventName === null) {
			foreach ($this->getListeners() as $event => $priorities) {
				$this->sorted[$event] = $this->getSortedListeners($event);
			}
			
			return $this->sorted;
		}
		
		if (!isset($this->sorted[$eventName])) {
			$priorities = $this->getListeners($eventName);
			krsort($priorities);
			
			$this->sorted[$eventName] = array();
			foreach ($priorities as $priority => $listeners) {
				foreach ($listeners as $listener) {
					$this->sorted[$eventName][] = $listener;
				}
			}
		}
		
		return $this->sorted[$eventName];
	}
	
	/**
	 * Returns the given listener's priority.
	 * 
	 * @param string   $eventName Event's name.
	 * @param callback $listener  A PHP callback.
	 * 
	 * @return integer|boolean The priority. FALSE if not found.
	 * @access public
	 */
	public function hasListener($eventName, $listener)
	{
		foreach ($this->getListeners($eventName) as $priority => $listeners) {
			if (array_search($listener, $listeners, true) !== false) {
				return $priority;
			}
		}
		
		return false;
	}
	
	/**
	 * Adds a listener for the given event.
	 * 
	 * @param string   $eventName Event's name.
	 * @param callback $listener  A PHP callback.
	 * @param integer  $priority  Listener's priority.
	 * 
	 * @access public
	 */
	public function addListener($eventName, $listener, $priority = 5)
	{
		$this->listeners[$eventName][$priority][] = $listener;
		unset($this->sorted[$eventName]);
	}
	
	/**
	 * Removes the given listener from the ones added for the given event.
	 * 
	 * @param string   $eventName Event's name.
	 * @param callback $listener  A PHP callback.
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the listener doesn't exist.
	 */
	public function removeListener($eventName, $listener)
	{
		$priority = $this->hasListener($eventName, $listener);
		
		if (!$priority) {
			throw new \InvalidArgumentException(sprintf(
				'The given listener has not been added to the "%s" event.',
				$eventName
			));
		}
		
		$key = array_search(
			$listener,
			$this->listeners[$eventName][$priority],
			true
		);
		
		unset($this->listeners[$eventName][$priority][$key]);
		unset($this->sorted[$eventName]);
	}
	
	/**
	 * Dispatches the given event to all the registered listeners.
	 * 
	 * @param string                       $eventName Event's name.
	 * @param Squire\EventDispatcher\Event &$event    The event.
	 * 
	 * @access public
	 */
	public function dispatch($eventName, Event &$event)
	{
		$listeners = $this->getSortedListeners($eventName);
		$return = false;
		
		foreach ($listeners as $listener) {
			if ($event->isPropagationStopped()) {
				break;
			}
			
			call_user_func($listener, $event);
		}
	}
}
