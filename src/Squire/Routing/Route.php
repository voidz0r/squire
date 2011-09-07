<?php

/*
 * This file is part of the Squire framework.
 *
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 *
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Routing;

/**
 * Route
 *
 * This class holds all the data about a route, like its pattern, default
 * values and requirements.
 *
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class Route
{
    /**
     * @var string The pattern.
     * @access protected
     */
    protected $pattern = '';

    /**
     * @var array Default values.
     * @access protected
     */
    protected $defaults = array();

    /**
     * @var array Requirements.
     * @access protected
     */
    protected $requirements = array();

    /**
     * Sets up the route's information.
     *
     * @param string $pattern      Pattern.
     * @param array  $defaults     Default values.
     * @param array  $requirements Parameters' requirements.
     *
     * @return Squire\Routing\Route
     * @access public
     */
    public function __construct($pattern, array $defaults = array(),
        array $requirements = array())
    {
        $this->pattern      = '/' . ltrim($pattern, '/');
        $this->defaults     = $defaults;
        $this->requirements = $requirements;
    }

    /**
     * Returns the pattern.
     *
     * @return string
     * @access public
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Returns the default values.
     *
     * @return array
     * @access public
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Returns whether there's a default value for the given parameter.
     *
     * @param string $param Parameter.
     *
     * @return boolean
     * @access public
     */
    public function hasDefault($param)
    {
        return isset($this->defaults[$param]);
    }

    /**
     * Returns the default value for the given parameter.
     *
     * @param string $param Parameter.
     *
     * @return mixed
     * @access public
     *
     * @throws \InvalidArgumentException If the given parameter has no default
     *      value.
     */
    public function getDefault($param)
    {
        if (!$this->hasDefault($param)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" parameter has no default value.',
                $param
            ));
        }

        return $this->defaults[$param];
    }

    /**
     * Returns the requirements.
     *
     * @return array
     * @access public
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Returns whether the given parameter needs any requirement.
     *
     * @param string $param Parameter.
     *
     * @return boolean
     * @access public
     */
    public function hasRequirement($param)
    {
        return isset($this->requirements[$param]);
    }

    /**
     * Returns the requirements for the given parameter.
     *
     * @param string $param Parameter.
     *
     * @return string
     * @access public
     *
     * @throws \InvalidArgumentException If the parameter needs no requirement.
     */
    public function getRequirement($param)
    {
        if (!$this->hasRequirement($param)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" parameter needs no requirement.',
                $param
            ));
        }

        return $this->requirements[$param];
    }
}
