<?php


namespace App\Factory\DataSet;


class CandidateData
{
    use DataSetTrait;


    public static function minimum(): array
    {
        return [
            "email" => self::faker()->email(),
            "name" => self::faker()->name(),
            "isPromoted" => 0
        ];
    }


    public static function all(): array
    {
        return array_merge(
            self::minimum(),
            [
                "mobile" => self::faker()->phoneNumber(),
                "address" => self::faker()->address()
            ]
        );
    }
}