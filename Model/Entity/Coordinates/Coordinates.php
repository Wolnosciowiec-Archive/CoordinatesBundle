<?php

namespace Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates;

/**
 * Coordinates
 * ===========
 *
 * @package Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates
 */
class Coordinates
{
    /** @var float $lat */
    protected $lat;

    /** @var float $lon */
    protected $lon;

    /** @var float $distance */
    protected $distance = 0.0;

    /**
     * @param float $lat Latitude
     * @param float $lon Longitude
     * @param int $distance Defaults to 20 km
     */
    public function __construct($lat, $lon, $distance = 20)
    {
        if (!is_float($lat) || !is_float($lon) || $lat <= -90.0 || $lon <= -90.0) {
            throw new \InvalidArgumentException('$lat and $lon should be float, and in acceptable range, got $lat = ' . $lat . ', $lon = ' . $lon);
        }

        $this->lat = $lat;
        $this->lon = $lon;
        $this->distance = $distance;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->lon;
    }

    /**
     * @param Coordinates $coordinates
     * @return Distance
     */
    public function compareWith(Coordinates $coordinates)
    {
        return new Distance(
            $this->getLatitude(),
            $this->getLongitude(),

            $coordinates->getLatitude(),
            $coordinates->getLongitude()
        );
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingSquare()
    {
        return new BoundingBox(
            $this->getLatitude(),
            $this->getLongitude(),
            $this->getMaxAcceptedDistance()
        );
    }

    /**
     * @return float|int
     */
    public function getMaxAcceptedDistance()
    {
        return $this->distance;
    }

    /**
     * @return float|int
     */
    public function getDistanceInMeters()
    {
        return $this->getMaxAcceptedDistance() * 1000;
    }

    /**
     * @return float|int
     */
    public function getLongtitudeUnit()
    {
        return 2 * M_PI * 6371000 / 360;
    }

    /**
     * @return float|int
     */
    public function getLatitudeInMeters()
    {
        return (1 - $this->getLatitude() / 90) * 2 *M_PI * 6371000 / 360;
    }

    /**
     * @param float $distance
     */
    public function setMaxAcceptedDistance(float $distance)
    {
        $this->distance = $distance;
    }
}
