<?php


namespace App\Factory\DataSet;


class UserData implements DataSetInterface
{
    use DataSetTrait;
    public static function minimum(): array
    {
        return [
            "email" => self::faker()->email(),
            "roles" => ["ROLE_EMPOLYEE"],
            "password" => self::faker()->password(),
            "name" => self::faker()->name()
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