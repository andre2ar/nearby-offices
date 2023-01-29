<?php

namespace Tests\Unit\Models;

use App\Models\Office;
use PHPUnit\Framework\TestCase;

class OfficeUnitTest extends TestCase
{
    private Office $office;
    protected function setUp(): void
    {
        parent::setUp();
        $this->office = new Office();
    }

    public function testFillableAttributes()
    {
        $fillable = [
            'affiliate_id',
            'name',
            'latitude',
            'longitude'
        ];

        $this->assertEquals($fillable, $this->office->getFillable());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->office->incrementing);
    }

    public function testTimestampsAttribute()
    {
        $this->assertFalse($this->office->timestamps);
    }
}
