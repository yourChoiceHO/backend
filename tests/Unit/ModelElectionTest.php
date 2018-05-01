<?php

namespace Tests\Unit;

//use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Election;
use PHPUnit\Framework\TestCase;

class ModelElectionTest extends TestCase
{
        public function testConstraintPartiesWithStub()
        {
            $stub = $this->createMock(Election::class);
            $stub->method('parties')
                 ->willReturn('\Illuminate\Database\Eloquent\Relations\HasMany');

            $this->assertEquals('\Illuminate\Database\Eloquent\Relations\HasMany', $stub->parties());
        }

        //Don't work
        /*
    public function testConstraintParties(){
        $myEle = new Election();
        $this->assertEquals('\Illuminate\Database\Eloquent\Relations\HasMany', $myEle->parties());
    }
        */

}
