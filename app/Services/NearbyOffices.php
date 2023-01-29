<?php

namespace App\Services;


use Illuminate\Support\Collection;

class NearbyOffices
{
    const EARTH_RADIUS = 6371000;
    const ONE_HUNDRED_KM = 100000;

    public function execute(
        Collection $offices,
        float $centralPointLatitude,
        float $centralPointLongitude,
        int $expectedDistance = self::ONE_HUNDRED_KM
    ): Collection
    {
        $nearbyOffices = [];

        foreach ($offices as $office) {
            $distanceBetweenOffices = $this->greatCircleDistance(
                $centralPointLatitude,
                $centralPointLongitude,
                $office->latitude,
                $office->longitude
            );

            if($distanceBetweenOffices <= $expectedDistance) {
                $nearbyOffices[] = $office;
            }
        }

        return collect($nearbyOffices);
    }

    private function greatCircleDistance(
        float $latitudeFrom,
        float $longitudeFrom,
        float $latitudeTo,
        float $longitudeTo
    ): float|int
    {
        $latitudeFrom = deg2rad($latitudeFrom);
        $longitudeFrom = deg2rad($longitudeFrom);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);

        $lonDelta = $longitudeTo - $longitudeFrom;
        $a = pow(cos($latitudeTo) * sin($lonDelta), 2) +
            pow(cos($latitudeFrom) * sin($latitudeTo) - sin($latitudeFrom) * cos($latitudeTo) * cos($lonDelta), 2);
        $b = sin($latitudeFrom) * sin($latitudeTo) + cos($latitudeFrom) * cos($latitudeTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        return $angle * self::EARTH_RADIUS;
    }
}
