<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
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
        $response = $this->get('/');
        $response->assertStatus(302);

        $response = $this->get('/nearby-offices');
        $response->assertStatus(200)
            ->assertViewIs('nearby-offices');
    }

    public function testStore()
    {
        $file = UploadedFile::fake()->createWithContent('affiliates.txt', '{"latitude": "53.5642260", "affiliate_id": 12, "name": "nearby", "longitude": "-7.1310710"}
        {"latitude": "54.3140370", "affiliate_id": 1, "name": "faraway", "longitude": "-9.2917540"}');

        $response = $this->post(route('nearby-offices.store'), [
            'offices' => $file,
        ]);

        $response->assertStatus(200)
            ->assertViewIs('nearby-offices')
            ->assertViewHas('nearbyOffices');

        $this->assertEquals(12, $response['nearbyOffices'][0]->affiliate_id);
    }
}
