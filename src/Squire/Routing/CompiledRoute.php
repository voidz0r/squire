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
 * Compiled route
 *
 * A compiled route can be used by a matcher to check whether the
 * route matches a specific URI.
 *
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class CompiledRoute
{
    /**
     * @var Squire\Routing\Route The route.
     * @access protected
     */
    protected $route = null;

    /**
     * @var string The regex to match against.
     * @access protected
     */
    protected $regex = '';

    /**
     * @var Squire\Routing\Matcher The matcher.
     * @access protected
     */
    protected $matcher = null;

    /**
     * Creates the compiled route object.
     *
     * @param Squire\Routing\Route &$route The route.
     * @param string               $regex  The compiled PCRE.
     *
     * @return Squire\Routing\CompiledRoute
     * @access public
     */
    public function __construct(Route &$route, $regex)
    {
        $this->route = $route;
        $this->regex = $regex;
    }

    /**
     * Returns the route.
     *
     * @return Squire\Routing\Route
     * @access public
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Returns the PCRE to match against.
     *
     * @return string
     * @access public
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Returns a matcher configured to match against this compiled route.
     * Note that this method will return the same object through multiple
     * calls in order to avoid instantiating too many matchers.
     *
     * @return Squire\Routing\UriMatcher
     * @access public
     */
    public function getMatcher()
    {
        if ($this->matcher !== null) {
            return $this->matcher;
        }

        $this->matcher = new UriMatcher($this);
        return $this->matcher;
    }
}
