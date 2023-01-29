<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;

class OfficeController extends Controller
{
    public function show($id)
    {
        return Office::query()->findOrFail($id);
    }

    public function index()
    {
        return Office::query()->paginate();
    }

    public function store(StoreOfficeRequest $request)
    {
        $validated = $request->validated();

        $office = new Office($validated);
        $office->save();

        return $office;
    }

    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $validated = $request->validated();

        Office::where('affiliate_id', $office->affiliate_id)
            ->update($validated);

        return $office->refresh();
    }

    public function destroy($id)
    {
        $office = Office::query()->findOrFail($id);
        $office->delete();

        return response()->noContent();
    }
}
