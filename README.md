CoordinatesBundle
=================

Adds a simple support for searching objects from database in selected distance.
It's a fast method based on a square box, that is not so powerful like circle radius, but its very fast.

## Usage

Use a trait `CoordinatesFeaturedRepositoryTrait` in your repository, and then
use methods that are injecting conditions to query builder.