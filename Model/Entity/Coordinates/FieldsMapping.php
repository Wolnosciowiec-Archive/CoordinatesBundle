<?php

namespace Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates;

/**
 * Describes fields mapping for coordinates
 * that are used in query builder
 *
 * @package Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates
 */
class FieldsMapping
{
    /** @var string $lat */
    private $lat;

    /** @var string $lon */
    private $lon;

    public function __construct($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @return string
     */
    public function getLatitudeFieldName()
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLongitudeFieldName()
    {
        return $this->lon;
    }
}