<?php

namespace LogementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FamilleControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testSendemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendEmail');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list');
    }

}
