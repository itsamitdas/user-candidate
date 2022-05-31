<?php


namespace App\Factory\DataSet;


interface DataSetInterface
{
    /**
     * Get the minimum required values for the data to be accepted.
     */
    public static function minimum(): array;

    /**
     * Get the whole possible set of data to be accepted.
     */
    public static function all(): array;

}