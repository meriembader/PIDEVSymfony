<?php

namespace LogementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogementControllerTest extends WebTestCase
{
    public function testNewlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newLogement');
    }

    public function testEditlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editLogement');
    }

    public function testDeletelogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteLogement');
    }

    public function testListlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listLogement');
    }

    public function testListlogementadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ListLogementAdmin');
    }

    public function testJoinlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/joinLogement');
    }

}
