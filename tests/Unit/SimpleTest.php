<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Election;

class SimpleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

        //$this->assertTrue(true);
       // @test
        public function testStub()
        {
            $stub = $this->createMock(Election::class);
            $stub->method('parties')
                 ->willReturn('\Illuminate\Database\Eloquent\Relations\HasMany');

            $this->assertEquals('parties', '\Illuminate\Database\Eloquent\Relations\HasMany');
        }

}
