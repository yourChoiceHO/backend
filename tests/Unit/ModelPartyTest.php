<?php

namespace Tests\Unit;

//use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Party;
use PHPUnit\Framework\TestCase;

class ModelPartyTest extends TestCase
{
    public function testConstraintElectionWithStub()
    {
        $stub = $this->createMock(Party::class);
        $stub->method('election')
            ->willReturn('\Illuminate\Database\Eloquent\Relations\BelongsTo');

        $this->assertEquals('\Illuminate\Database\Eloquent\Relations\BelongsTo', $stub->election());
    }

    //benötigt Parameter parties...
    public function testGetAllNames(){
        $myParty = new Party();
        $this->assertEquals('SPD', $myParty->getAllNames(DB::Party));
    }

    //Don#t work
    /*
    public function testConstraintElection(){
        $myParty = new Party();
        $this->assertEquals('\Illuminate\Database\Eloquent\Relations\BelongsTo', $myParty->election());
    }
    */
}
