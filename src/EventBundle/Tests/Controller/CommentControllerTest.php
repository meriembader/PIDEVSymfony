<?php

namespace EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testAddcomment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addComment');
    }

    public function testShowcommentbyidevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showCommentByIdEvent/{id}');
    }

}
