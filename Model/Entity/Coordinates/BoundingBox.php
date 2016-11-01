<?php

namespace Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates;

/**
 * BoundingBox
 * ===========
 * Calculates coordinates of a square which could be used to limit
 * count of results in geo location search
 *
 * @package Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates
 */
class BoundingBox
{
    /** @var float[] $longitude */
    protected $latitude = [0, 0];

    /** @var float[] $longitude */
    protected $longitude = [0, 0];

    /**
     * @param float $lat Latitude of the point
     * @param float $lon Longitude of the point
     * @param float|int $distance And the distance radius
     */
    public function __construct($lat, $lon, $distance)
    {
        $latInMeters = ((1 - $lat/90)*2*M_PI*6371000)/360;
        $lonInMeters = (2*M_PI*6371000)/360;
        $mDist       = $distance * 1000;

        $this->longitude = [
            ($lon - $mDist * 1/$lonInMeters),
            ($lon + $mDist * 1/$lonInMeters),
        ];

        $this->latitude = [
            ($lat - $mDist * 1/$latInMeters),
            ($lat + $mDist * 1/$latInMeters),
        ];
    }

    /**
     * @return \float[]
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return \float[]
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}