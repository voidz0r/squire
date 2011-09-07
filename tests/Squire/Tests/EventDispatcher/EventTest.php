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

use Squire\EventDispatcher\Event;
use Squire\EventDispatcher\ParameterBag;

class EventTest extends \PHPUnit_Framework_TestCase
{
	public function testStopPropagation()
	{
		$event = new Event(new ParameterBag());
		$this->assertFalse($event->isPropagationStopped());
		
		$event->stopPropagation();
		$this->assertTrue($event->isPropagationStopped());
	}
}
