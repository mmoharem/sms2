<?php

class RoleSeeder extends DatabaseSeeder
{

    public function run()
    {
        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Super Admin',
            'slug' => 'super_admin',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Admin',
            'slug' => 'admin',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Admin Super Admin',
            'slug' => 'admin_super_admin',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Human resources',
            'slug' => 'human_resources',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Librarian',
            'slug' => 'librarian',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Teacher',
            'slug' => 'teacher',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Student',
            'slug' => 'student',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Parent',
            'slug' => 'parent',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Visitor',
            'slug' => 'visitor',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Accountant',
            'slug' => 'accountant',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Supplier',
            'slug' => 'supplier',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Kitchen admin',
            'slug' => 'kitchen_admin',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Kitchen staff',
            'slug' => 'kitchen_staff',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Doorman',
            'slug' => 'doorman',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Applicant',
            'slug' => 'applicant',
        ));

    }

}