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

use Squire\Tests\TestCase as BaseTestCase;
use Squire\Validation\Constraint\ConstraintInterface;

/**
 * Custom test case for `Squire\Validation\Constraint`
 * 
 * This is a custom test case to suit the needs of the
 * `Squire\Validation\Constraint` namespace.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @abstract
 */
abstract class TestCase extends BaseTestCase
{
	/**
	 * Tests that the tested constraint validates the
	 * values correctly.
	 * 
	 * @param object  $constraint The constraint object
	 * @param boolean $results    Multi-dimensional assoc array with values and results
	 * 
	 * @access public
	 * 
	 * @dataProvider getValidationTests
	 * 
	 * @throws \InvalidArgumentException If the constraint isn't the tested one
	 */
	public function testValidation(ConstraintInterface $constraint, array $results)
	{
		if (get_class($constraint) != $this->getTestedClass()) {
			throw new \InvalidArgumentException(sprintf(
				'The provided constraint should be an instance of "%s" while it is an instance of "%s".',
				$this->getTestedClass(),
				get_class($constraint)
			));
		}
		
		foreach ($results as $result) {
			$expected = (bool)$result['result'];
			$real     = $constraint->isValid($result['value']);
			
			$expected ? $this->assertTrue($real) : $this->assertFalse($real);
		}
	}
	
	/**
	 * Returns the tests for the constraint.
	 * 
	 * @return array
	 * @access public
	 * 
	 * @abstract
	 */
	abstract public function getValidationTests();
}
