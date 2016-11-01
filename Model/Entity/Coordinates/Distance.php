<?php

namespace Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates;

/**
 * Distance
 * ==============
 * Calculates distance between two coordinates
 *
 * @package Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates
 */
class Distance
{
    /** @var float $lat1 */
    protected $lat1;

    /** @var float $lat2 */
    protected $lat2;

    /** @var float $lon1 */
    protected $lon1;

    /** @var float $lon2 */
    protected $lon2;

    /**
     * @param float $lat1
     * @param float $lat2
     * @param float $lon1
     * @param float $lon2
     */
    public function __construct($lat1, $lat2, $lon1, $lon2)
    {
        $this->lat1 = $lat1;
        $this->lat2 = $lat2;
        $this->lon1 = $lon1;
        $this->lon2 = $lon2;
    }

    /**
     * Get distance between our two points in kilometers or miles
     */
    public function getDistance()
    {
        $diff = $this->lon1 - $this->lon2;
        $dist = sin(deg2rad($this->lat1))
            * sin(deg2rad($this->lat2))
            + cos(deg2rad($this->lat1))
            * cos(deg2rad($this->lat2))
            * cos(deg2rad($diff));

        $miles      = $dist * 60 * 1.1515;
        $kilometers = $miles * 1.609344;

        return [
            'miles'      => $miles,
            'kilometers' => $kilometers,
        ];
    }

    /**
     * @return float
     */
    public function getInKilometers()
    {
        return $this->getDistance()['kilometers'];
    }

    /**
     * @return float
     */
    public function getInMiles()
    {
        return $this->getDistance()['miles'];
    }
}