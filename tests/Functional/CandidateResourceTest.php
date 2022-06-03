<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\DataSet\CandidateData;

class CandidateResourceTest extends ApiTestCase
{

    public function testCreateCandidateWithAllData(): void
    {
        $candidateData = CandidateData::all();
        static::createClient()->request('POST', '/api/candidates',[
            'json' => $candidateData
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateCandidateWithMinimumData(): void
    {
        $candidateData = CandidateData::minimum();

        static::createClient()->request('POST', '/api/candidates',[
            'json' => $candidateData
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testGetAllCandidate()
    {
        static::createClient()->request('GET', '/api/candidates');

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateCandidate()
    {
        $candidateData = CandidateData::all();

        $name = $candidateData['name'].'_new';

        $responseCreate = static::createClient()->request('POST', '/api/candidates',[
            'json' => $candidateData
        ]);

        $createdCandidate = json_decode($responseCreate->getContent());

        $responseUpdate = static::createClient()->request('PUT', '/api/candidates/'.$createdCandidate->id,[
            'json' => [
                'name' => $name
            ]
        ]);

        $updatedCandidate = json_decode($responseUpdate->getContent());
        $this->assertSame($name,$updatedCandidate->name);
    }

    public function testDeleteCandidate()
    {
        $candidateData = CandidateData::all();

        $responseCreate = static::createClient()->request('POST', '/api/candidates',[
            'json' => $candidateData
        ]);

        $createdCandidate = json_decode($responseCreate->getContent());
        static::createClient()->request('DELETE', '/api/candidates/'.$createdCandidate->id,);

        $this->assertResponseIsSuccessful();
    }

}