<?php

namespace Wolnosciowiec\CoordinatesBundle\Model\Repository;

use Doctrine\ORM\QueryBuilder;
use Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates\Coordinates;
use Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates\FieldsMapping;

/**
 * Adds a possibility to filter objects
 * by distance from a point on the map
 *
 * @package Wolnosciowiec\CoordinatesBundle\Model\Repository
 */
trait CoordinatesFeaturedRepositoryTrait
{
    /**
     * @return FieldsMapping
     */
    abstract protected function getCoordinatesFieldsMapping(): FieldsMapping;


    /**
     * Appends a coordinates radius condition to the QueryBuilder
     *
     * @param QueryBuilder $query
     * @param Coordinates $coordinates
     */
    protected function appendQueryBuilderCoordinatesRadiusSearch(
        QueryBuilder $query, 
        Coordinates $coordinates
    )
    {
        // bounding box
        $boundingBox = $coordinates->getBoundingSquare();
        $query->setParameter('c_dMin', $boundingBox->getLongitude()[0]);
        $query->setParameter('c_dMax', $boundingBox->getLongitude()[1]);
        $query->setParameter('c_sMin', $boundingBox->getLatitude()[0]);
        $query->setParameter('c_sMax', $boundingBox->getLatitude()[1]);

        // point
        $query->setParameter('c_lat', $coordinates->getLatitude());
        $query->setParameter('c_lon', $coordinates->getLongitude());

        // distance, radius
        $query->setParameter('c_od', pow($coordinates->getLatitudeInMeters(), 2));
        $query->setParameter('c_os', pow($coordinates->getLongtitudeUnit(), 2));
        $query->setParameter('c_radiusPOW', pow($coordinates->getDistanceInMeters(), 2));

        $query->andWhere('(' . $this->getCoordinatesFieldsMapping()->getLatitudeFieldName() . ' > :c_sMin AND ' . $this->getCoordinatesFieldsMapping()->getLatitudeFieldName() . ' < :c_sMax AND ' . $this->getCoordinatesFieldsMapping()->getLongitudeFieldName() . ' < :c_dMax AND ' . $this->getCoordinatesFieldsMapping()->getLongitudeFieldName() . ' > :c_dMin)');
        $query->andWhere('(abs(' . $this->getCoordinatesFieldsMapping()->getLongitudeFieldName() . ' - :c_lon) * abs(' . $this->getCoordinatesFieldsMapping()->getLongitudeFieldName() . ' - :c_lon) * :c_od + abs(' . $this->getCoordinatesFieldsMapping()->getLatitudeFieldName() . ' - :c_lat) * abs(' . $this->getCoordinatesFieldsMapping()->getLatitudeFieldName() . ' - :c_lat) * :c_os) < :c_radiusPOW');
    }
}