<?php

namespace himito\mailman\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use himito\mailman\Mailman;

class MailmanFunctionTest extends TestCase
{
    public function testLists()
    {
        $mailman = $this->getMailman(200);
        dd($mailman->lists());
    }

    private function getMailman($status, $body=null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler'=>$handler, 'base_uri' => 'http://mock.mailman.org']);

        return new Mailman($client);
    }
}
