<?php

namespace Tests;

use App\Models\User;
use Sentinel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAsSuperAdmin()
    {
	    $user = factory(User::class);

	    $super_admin = Sentinel::registerAndActivate(array(
		    'email' => $user->email,
		    'password' => $user->password,
		    'first_name' => $user->first_name,
		    'last_name' => $user->last_name,
	    ));

	    $role = Sentinel::findRoleBySlug('super_admin');
	    $role->users()->attach($super_admin);
	    Sentinel::login($super_admin);

	    dd(Sentinel::getUser()->id);
    }
}
