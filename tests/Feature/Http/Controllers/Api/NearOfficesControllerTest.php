<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestResources;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class NearOfficesControllerTest extends TestCase
{
    use DatabaseMigrations;
    private Office $nearbyOffice;
    private Office $farawayOffice;
    private array $serializedFields = [
        'affiliate_id',
        'name',
        'latitude',
        'longitude'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->nearbyOffice = Office::factory()->create([
            "affiliate_id" => 1,
            "name" => "nearby",
            "latitude" => "53.5642260",
            "longitude" => "-7.1310710"
        ]);

        $this->farawayOffice = Office::factory()->create([
            "affiliate_id" => 2,
            "name" => "far away",
            "latitude" => "54.3140370",
            "longitude" => "-9.2917540"
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('nearby-offices'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => $this->serializedFields
            ])->assertJsonCount(1)
            ->assertJson([$this->nearbyOffice->toArray()])
            ->assertJsonMissing([$this->farawayOffice->toArray()]);
    }
}
