<?php

defined('SYSPATH') or die('No direct access allowed.');
/*
 * Configuration variables for the AD/LDAP Module for Kohana3.
 *
 * @author     Beau Dacious <dacious.beau@gmail.com>
 * @author     Sam Wilson <sam@samwilson.id.au>
 * @copyright  (c) 2009 Beau Dacious
 * @license    http://www.opensource.org/licenses/mit-license.php
 */
return [
    'kadldap' => [
        'domain_controllers' => [], // array('dc.example.com','dc1.example.com')
        'account_suffix'     => '', // '@example.com'
        'base_dn'            => '', // 'dc=example,dc=com',
        'admin_username'     => null,
        'admin_password'     => null,
    ],
];
