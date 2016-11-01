<?php

namespace Wolnosciowiec\CoordinatesBundle\Tests\Model\Entity\Coordinates;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Wolnosciowiec\CoordinatesBundle\Model\Entity\Coordinates\Coordinates;

/**
 * CoordinatesTest
 * ===============
 *
 * @see Coordinates
 */
class CoordinatesTest extends WebTestCase
{
    /**
     * Test bounding square calculation
     */
    public function testBoundingSquare()
    {
        // Wrocław, okolice ronda
        $coords = new Coordinates(51.090041, 17.018763);
        $coords->setMaxAcceptedDistance(20);

        // villages nearby to Wrocław are shown
        $this->assertSame([50.67400897831277, 51.506073021687229], $coords->getBoundingSquare()->getLatitude());
        $this->assertSame([16.838898678816253, 17.198627321183746], $coords->getBoundingSquare()->getLongitude());
        $this->assertSame(20, $coords->getMaxAcceptedDistance());
    }

    /**
     * Test distance comparison
     */
    public function testDistanceComparison()
    {
        // Wrocław, centrum
        $coords = new Coordinates(51.090041, 17.018763);

        // Trzebnica
        $comparison = $coords->compareWith(new Coordinates(51.308600, 17.070917));

        $this->assertLessThan(60, $comparison->getInMiles());
        $this->assertGreaterThan(30, $comparison->getInMiles());

        $this->assertLessThan(100, $comparison->getInKilometers());
        $this->assertGreaterThan(35, $comparison->getInKilometers());
    }

    /**
     * Test validation of invalid coordinates (non-float values)
     * =========================================================
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCoordinates()
    {
        new Coordinates(1, 2);
    }
}