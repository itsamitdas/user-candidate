<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\DataSet\UserData;

class UserResourceTest extends ApiTestCase
{

    public function testCreateUserWithAllData(): void
    {
        $userData = UserData::all();
        static::createClient()->request('POST', '/api/users',[
            'json' => $userData
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserWithMinimumData(): void
    {
        $userData = UserData::minimum();

        static::createClient()->request('POST', '/api/users',[
            'json' => $userData
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testGetAllUser()
    {
        static::createClient()->request('GET', '/api/users');

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateUser()
    {
        $userData = UserData::all();

        $name = $userData['name'].'_new';

        $responseCreate = static::createClient()->request('POST', '/api/users',[
            'json' => $userData
        ]);

        $createdUser = json_decode($responseCreate->getContent());

        $responseUpdate = static::createClient()->request('PUT', '/api/users/'.$createdUser->id,[
            'json' => [
                'name' => $name
            ]
        ]);

        $updatedUser = json_decode($responseUpdate->getContent());

        $this->assertSame($name,$updatedUser->name);
    }

    public function testDeleteUser()
    {
        $userData = UserData::all();

        $responseCreate = static::createClient()->request('POST', '/api/users',[
            'json' => $userData
        ]);

        $createdUser = json_decode($responseCreate->getContent());

        static::createClient()->request('DELETE', '/api/users/'.$createdUser->id,);

        $this->assertResponseIsSuccessful();
    }


}