<?php

namespace Tests\Feature\Models;

use App\Models\Office;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfficeModelTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Office::factory(1)->create();
        $categories = Office::all();

        $this->assertCount(1, $categories);

        $officeKeys = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'affiliate_id',
            'name',
            'latitude',
            'longitude'
        ], $officeKeys);
    }

    public function testCreate()
    {
        $office = Office::create([
            "affiliate_id" => 1,
            "name" => "test1",
            "latitude" => "52.3660370",
            "longitude" => "-8.5223660"
        ]);
        $office->refresh();

        $this->assertEquals(1, $office->affiliate_id);
        $this->assertEquals('test1', $office->name);
        $this->assertEquals("52.3660370", $office->latitude);
        $this->assertEquals("-8.5223660", $office->longitude);
    }

    public function testUpdate()
    {
        $office = Office::factory()->create([
            'name' => 'test_name',
            'affiliate_id' => 25
        ]);

        $data = [
            "latitude" => "52.3660370",
            "longitude" => "-8.5223660"
        ];
        $office->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $office->{$key});
        }
    }

    public function testDelete() {
        $office = Office::factory()->create();
        $office->delete();
        $this->assertNull(Office::find($office->affiliate_id));
    }
}
