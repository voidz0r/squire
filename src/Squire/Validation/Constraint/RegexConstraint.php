<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Validation\Constraint;

/**
 * PCRE validation constraint
 * 
 * This constraint checks whether the given value matches
 * the specified PCRE (Perl-compatible regular expression).
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class RegexConstraint implements ConstraintInterface
{
	/**
	 * The PCRE.
	 * 
	 * @var    string
	 * @access protected
	 */
	protected $regex = '';
	
	/**
	 * Sets the PCRE to validate against.
	 * 
	 * @param string $regex
	 * 
	 * @return Squire\Validation\Constraint\RegexConstraint
	 * @access public
	 */
	public function __construct($regex)
	{
		$this->regex = $regex;
	}
	
	/**
	 * Returns the previously specified regular expression.
	 * 
	 * @return string
	 * @access public
	 */
	public function getRegex()
	{
		return $this->regex;
	}
	
	/**
	 * Checks whether the given value matches the specified
	 * regular expression.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isValid($value)
	{
		return (bool)preg_match($this->getRegex(), $value);
	}
}
