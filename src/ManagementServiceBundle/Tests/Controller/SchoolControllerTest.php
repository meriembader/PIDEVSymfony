<?php

namespace ManagementServiceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SchoolControllerTest extends WebTestCase
{
    public function testAddschool()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addSchool');
    }

    public function testEditschool()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editSchool');
    }

    public function testDeleteschool()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteSchool');
    }

    public function testShowschools()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showSchools');
    }

    public function testAffectusertoschool()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/affectUserToSchool');
    }

}
