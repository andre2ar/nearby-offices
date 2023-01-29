<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadOfficesFilesRequest;
use App\Services\NearbyOffices;
use Illuminate\Http\Request;

class NearbyOfficesController extends Controller
{
    public function __construct(protected NearbyOffices $nearbyOffices) {}

    public function index()
    {
        return view('nearby-offices');
    }

    public function store(UploadOfficesFilesRequest $request)
    {
        $officesFile = $request->file('offices');
        $officesJson = explode("\n", $officesFile->getContent());
        $offices = array_map(fn($office) => json_decode($office), $officesJson);

        $nearbyOffices = $this->nearbyOffices->execute(
            collect($offices),
            config('app.gambling_office_location.latitude'),
            config('app.gambling_office_location.longitude'),
        );

        return view('nearby-offices', ['nearbyOffices' => $nearbyOffices->sortBy('affiliate_id')]);
    }
}
