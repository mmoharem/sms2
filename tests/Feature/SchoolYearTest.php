<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SchoolYearTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateSchoolYear()
    {
    	$this->loginAsSuperAdmin();
    	dd("tu");
        $this->assertTrue(true);
    }
}
