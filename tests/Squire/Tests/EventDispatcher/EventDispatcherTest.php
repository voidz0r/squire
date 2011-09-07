<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\EventDispatcher;

use Squire\EventDispatcher\ParameterBag;
use Squire\EventDispatcher\EventDispatcher;
use Squire\EventDispatcher\Event;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getListenerManipulationTests
	 */
	public function testListenerManipulation(array $listeners)
	{
		$dispatcher = new EventDispatcher();
		
		foreach ($listeners as $listener) {
			$dispatcher->addListener('foo', $listener);
			$this->assertSame(5, $dispatcher->hasListener('foo', $listener));
			
			$dispatcher->removeListener('foo', $listener);
			$this->assertFalse($dispatcher->hasListener('foo', $listener));
			
			$dispatcher->addListener('foo', $listener);
		}
		
		$listeners = array(
			'foo' => $listeners,
		);
		
		$this->assertSame(
			array_values($listeners),
			array_values($dispatcher->getSortedListeners()
		));
		
		$this->assertSame(array(), $dispatcher->getListeners('bar'));
	}
	
	public function getListenerManipulationTests()
	{
		return array(
			array(
				array(
					function(Event &$event) { },
				),
			),
		);
	}
	
	public function testSorting()
	{
		$dispatcher = new EventDispatcher();
		
		$dispatcher->addListener('foo', function(Event &$event) {
			$event->getParamBag()->set('fruit', 'cherry');
		});
		$dispatcher->addListener('foo', function(Event &$event) {
			$event->getParamBag()->set('fruit', 'pear');
		}, 10);
		$dispatcher->addListener('foo', function(Event &$event) {
			$event->getParamBag()->set('fruit', 'apple');
			$event->stopPropagation();
		}, 9);
		
		$event = new Event(ParameterBag::fromArray(array(
			'fruit' => 'strawberry',
		)));
		$dispatcher->dispatch('foo', $event);
		
		$this->assertEquals('apple', $event->getParamBag()->get('fruit'));
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testExceptionOnInvalidRemove()
	{
		$dispatcher = new EventDispatcher();
		$dispatcher->removeListener('foo', function(Event &$event) { });
	}
}
