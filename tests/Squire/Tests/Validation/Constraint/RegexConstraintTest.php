<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Validation\Constraint;

use Squire\Validation\Constraint\RegexConstraint;

/**
 * Tests for `Squire\Validation\Constraint\RegexConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\RegexConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class RegexConstraintTest extends TestCase
{
	/**
	 * Tests for `testValidation()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getValidationTests()
	{
		return array(
			array(
				// constraint object
				new RegexConstraint('(foo|bar)'),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'foo',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'bar',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'baz',
						
						// result
						'result' => false,
					),
				),
			),
		);
	}
}
