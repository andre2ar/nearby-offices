<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestResources;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class OfficeControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves, TestResources;
    private Office $office;
    private array $serializedFields = [
        'affiliate_id',
        'name',
        'latitude',
        'longitude'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->office = Office::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('offices.index'));

        $response->assertStatus(200)
            ->assertJson([
                'per_page' => 15
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->serializedFields
                ],
                'links' => [],
            ]);

        $resource = OfficeResource::collection([$this->office]);
        $this->assertResource($response, $resource);
    }

    public function testShow()
    {
        $response = $this->get(route('offices.show', ['office' => $this->office->affiliate_id]));
        $response->assertStatus(200)
            ->assertJsonStructure($this->serializedFields)
            ->assertJson($this->office->toArray());
    }

    public function testInvalidationData()
    {
        $data = [
            'name' => ''
        ];
        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');

        $data = [
            'name' => str_repeat('a', 256),
        ];
        $this->assertInvalidationInStoreAction($data, 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max' => 255]);
    }

    public function testStore()
    {
        $data = [
            "affiliate_id" => 1,
            "name" => "test1",
            "latitude" => "52.3660370",
            "longitude" => "-8.5223660"
        ];
        $response = $this->assertStore($data, $data);
        $response->assertJsonStructure($this->serializedFields);
    }

    public function testUpdate() {
        $data = [
            "affiliate_id" => $this->office->affiliate_id,
            "name" => "test1",
            "latitude" => "52.3660370",
            "longitude" => "-8.5223660"
        ];
        $response = $this->assertUpdate($data, $data);
        $response->assertJsonStructure($this->serializedFields);

        $data = [
            "affiliate_id" => $this->office->affiliate_id,
            "name" => "test2",
            "latitude" => "52.3660370",
            "longitude" => "-8.5223660"
        ];
        $this->assertUpdate($data, $data);
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE', route('offices.destroy', [
            'office' => $this->office->affiliate_id,
        ]));
        $response->assertStatus(204);
        $this->assertNull(Office::find($this->office->affiliate_id));
    }

    protected function routeStore()
    {
        return route('offices.store');
    }

    protected function routeUpdate()
    {
        return route('offices.update', ['office' => $this->office->affiliate_id]);
    }

    protected function model()
    {
        return Office::class;
    }
}
