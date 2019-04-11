<?php

namespace himito\mailman\Tests;

use GuzzleHttp\Client;
use himito\mailman\Mailman;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class MailmanFunctionTest extends TestCase
{
    /** @test */
    public function it_allows_to_get_all_the_lists()
    {
        $body = file_get_contents(__DIR__.'/Mocks/Lists/test-list-body.txt');
        $mailman = $this->get_mailman([[200, $body]]);
        $lists = $mailman->lists();
        $this->assertCount(1, $lists);
    }

    /** @test */
    public function it_returns_an_empty_list_when_there_are_no_mailing_lists()
    {
        $body = file_get_contents(__DIR__.'/Mocks/Lists/empty-body.txt');
        $mailman = $this->get_mailman([[200, $body]]);

        $lists = $mailman->lists();
        $this->assertEmpty($lists);
    }

    /** @test */
    public function it_allows_to_create_lists()
    {
        $mailman = $this->get_mailman([[201, '']]);

        $response = $mailman->create_list('test@lists.example.com');
        $this->assertTrue($response);
    }

    /** @test */
    public function it_allows_to_remove_a_list()
    {
        $mailman = $this->get_mailman([[201, '']]);
        $response = $mailman->remove_list('test@lists.example.com');
        $this->assertTrue($response);
    }

    /** @test */
    public function it_returns_an_empty_list_when_there_are_no_members()
    {
        $body = file_get_contents(__DIR__.'/Mocks/Members/empty-body.txt');
        $mailman = $this->get_mailman([[200, $body]]);

        $lists = $mailman->members('test@lists.example.com');
        $this->assertEmpty($lists);
    }

    /** @test */
    public function it_allows_to_subscribe_a_user()
    {
        $body = file_get_contents(__DIR__.'/Mocks/Lists/test-list-body.txt');
        $mailman = $this->get_mailman([[200, $body], [201, '']]);
        $response = $mailman->subscribe('test@lists.example.com', 'Test', 'test@test.com');
        $this->assertTrue($response);
    }

    /** @test */
    public function it_allows_to_unsubscribe_a_user()
    {
        $lists = file_get_contents(__DIR__.'/Mocks/Lists/test-list-body.txt');
        $body = file_get_contents(__DIR__.'/Mocks/Members/memberships-body.txt');
        $mailman = $this->get_mailman([[200, $lists], [200, $body], [201, '']]);
        $response = $mailman->unsubscribe('test@lists.example.com', 'test@test.com');
        $this->assertTrue($response);
    }

    private function get_mailman($responses)
    {
        $output = [];
        foreach ($responses as $r) {
            $output[] = new Response($r[0], [], $r[1]);
        }

        $mock = new MockHandler($output);
        $handler = HandlerStack::create($mock);

        $client = new Client([
            'handler'=>$handler, 'base_uri' => 'http://mock.mailman.org', ]);

        return new Mailman($client);
    }
}
