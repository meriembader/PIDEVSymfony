<?php

namespace Projet\ProjBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');
    }

    public function testRedirect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeAdmin');
    }

}
