<?php

defined('SYSPATH') or die('No direct access allowed.');
/**
 * LDAP Model.
 *
 * This is to be extended by actual models.
 *
 * @author     Beau Dacious <dacious.beau@gmail.com>
 * @copyright  (c) 2009 Beau Dacious
 * @license    http://www.opensource.org/licenses/mit-license.php
 */
class Model_LDAP
{
    protected $ldap;

    protected $loaded = false;

    public function __construct()
    {
        $this->ldap = Kadldap::instance();
    }

    public function is_loaded()
    {
        return $this->loaded;
    }
}
