<?php

defined('SYSPATH') or die('No direct script access.');

// Kadldap testing and demonstration page.
Route::set('kadldap', 'kadldap(/<action>)')
    ->defaults([
        'controller' => 'Kadldap',
        'action'     => 'index',
    ]);
