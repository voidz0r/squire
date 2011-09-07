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
		}, 9);
		
		$event = new Event(ParameterBag::fromArray(array(
			'fruit' => 'strawberry',
		)));
		$dispatcher->dispatch('foo', $event);
		
		$this->assertEquals('cherry', $event->getParamBag()->get('fruit'));
	}
}
