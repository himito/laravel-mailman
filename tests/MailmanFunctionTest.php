<?php

namespace himito\mailman\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use himito\mailman\Mailman;

class MailmanFunctionTest extends TestCase
{
    /** @test */
    public function it_returns_an_empty_list_when_there_are_no_mailing_lists()
    {
        $body = file_get_contents(__DIR__.'/Mocks/Lists/empty-body.txt');
        $mailman = $this->get_mailman(200, $body);

        $lists = $mailman->lists();
        $this->assertEmpty($lists);
    }

    private function get_mailman($status, $body=null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);

        $client = new Client([
            'handler'=>$handler, 'base_uri' => 'http://mock.mailman.org']);

        return new Mailman($client);
    }
}
