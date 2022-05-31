<?php

namespace App\Factory\DataSet;

use Faker;

trait DataSetTrait
{
    private static function faker(): Faker\Generator
    {
        return Faker\Factory::create();
    }
}
