<?php
/**
 * A factory decorator that adds an anonymous user to the generated instances.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */

/**
 * A factory decorator that adds an anonymous user to the generated instances.
 *
 * Copyright 2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */
class Horde_Kolab_Session_Factory_Anonymous
implements Horde_Kolab_Session_Factory
{
    /**
     * The factory setup resulting from the configuration.
     *
     * @var Horde_Kolab_Session_Factory
     */
    private $_factory;

    /**
     * Anonymous user ID.
     *
     * @var string
     */
    private $_anonymous_id;

    /**
     * Anonymous password.
     *
     * @var string
     */
    private $_anonymous_pass;

    /**
     * Constructor.
     *
     * @param Horde_Kolab_Session_Factory $factory The base factory.
     * @param string                      $user    ID of the anonymous user.
     * @param string                      $pass    Password of the anonymous
     *                                             user.
     */
    public function __construct(
        Horde_Kolab_Session_Factory $factory,
        $user,
        $pass
    ) {
        $this->_factory        = $factory;
        $this->_anonymous_id   = $user;
        $this->_anonymous_pass = $pass;
    }

    /**
     * Return the kolab user db connection.
     *
     * @return Horde_Kolab_Server The server connection.
     */
    public function getServer()
    {
        return $this->_factory->getServer();
    }

    /**
     * Return the auth handler for sessions.
     *
     * @return Horde_Kolab_Session_Auth The authentication handler.
     */
    public function getSessionAuth()
    {
        return $this->_factory->getSessionAuth();
    }

    /**
     * Return the configuration parameters for the session.
     *
     * @return array The configuration values.
     */
    public function getSessionConfiguration()
    {
        return $this->_factory->getSessionConfiguration();
    }

    /**
     * Return the session storage driver.
     *
     * @return Horde_Kolab_Session_Storage The driver for storing sessions.
     */
    public function getSessionStorage()
    {
        return $this->_factory->getSessionStorage();
    }

    /**
     * Return the session validation driver.
     *
     * @return Horde_Kolab_Session_Valid The driver for validating sessions.
     */
    public function getSessionValidator(
        Horde_Kolab_Session $session,
        Horde_Kolab_Session_Auth $auth
    ) {
        return $this->_factory->getSessionValidator($session, $auth);
    }

    /**
     * Validate the given session.
     *
     * @param string $user The session will be validated for this user ID.
     *
     * @return boolean True if thxe given session is valid.
     */
    public function validate(Horde_Kolab_Session $session, $user = null)
    {
        return $this->_factory->validate($session, $user);
    }

    /**
     * Returns a new session handler.
     *
     * @param string $user The session will be setup for the user with this ID.
     *
     * @return Horde_Kolab_Session The concrete Kolab session reference.
     */
    public function createSession($user = null)
    {
        $session = $this->_factory->createSession($user);
        $session = new Horde_Kolab_Session_Anonymous(
            $session,
            $this->_anonymous_id,
            $this->_anonymous_pass
        );
        return $session;
    }

    /**
     * Returns either a reference to a session handler with data retrieved from
     * the session or a new session handler.
     *
     * @param string             $user   The session will be setup for the user
     *                                   with this ID.
     *
     * @return Horde_Kolab_Session The concrete Kolab session reference.
     */
    public function getSession($user = null)
    {
        return $this->_factory->getSession($user);
    }
}