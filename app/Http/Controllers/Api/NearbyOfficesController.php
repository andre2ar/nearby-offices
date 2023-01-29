<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Services\NearbyOffices;
use Illuminate\Http\Request;

class NearbyOfficesController extends Controller
{
    public function __construct(protected NearbyOffices $nearbyOffices) {}

    public function __invoke(Request $request)
    {
        $offices = Office::all();

        $nearbyOffices = $this->nearbyOffices->execute(
            $offices,
            config('app.gambling_office_location.latitude'),
            config('app.gambling_office_location.longitude'),
        );

        return $nearbyOffices->sortBy('affiliate_id');
    }
}
