<?php
/**
 * Test the Kolab session singleton pattern.
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
 * Prepare the test setup.
 */
require_once dirname(__FILE__) . '/../Autoload.php';

/**
 * Test the Kolab session singleton pattern.
 *
 * Copyright 2009-2010 The Horde Project (http://www.horde.org/)
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
class Horde_Kolab_Session_Integration_SingletonTest extends Horde_Kolab_Session_SessionTestCase
{
    public function setUp()
    {
        global $conf;

        /** Provide a minimal configuration for the server */
        $conf['kolab']['ldap']['basedn'] = 'dc=test';
        $conf['kolab']['ldap']['mock']   = true;
        $conf['kolab']['ldap']['data']   = array(
            'dn=user,dc=test' => array(
                'dn' => 'dn=user,dc=test',
                'data' => array(
                    'uid' => array('user'),
                    'mail' => array('user@example.org'),
                    'userPassword' => array('pass'),
                    'objectClass' => array('top', 'kolabInetOrgPerson'),
                )
            )
        );
    }

    public function testMethodSingletonHasResultHordekolabsession()
    {
        $this->assertType(
            'Horde_Kolab_Session_Interface',
            Horde_Kolab_Session_Singleton::singleton(
                'user', array('password' => 'pass')
            )
        );
    }

    public function testMethodSingletonHasResultHordekolabsessionAlwaysTheSameIfTheSessionIsValid()
    {
        $session1 = Horde_Kolab_Session_Singleton::singleton(
            'user', array('password' => 'pass')
        );
        $session2 = Horde_Kolab_Session_Singleton::singleton(
            'user', array('password' => 'pass')
        );
        $this->assertSame($session1, $session2);
    }
}