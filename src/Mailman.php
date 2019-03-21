<?php

namespace himito\mailman;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Mailman implements MailmanInterface
{
    /**
     * Guzzle client.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    public function __construct($options)
    {
        ['host' => $host, 'port' => $port, 'api_version' => $api_version, 'admin_user' => $admin_user, 'admin_pass' => $admin_pas] = $options;

        $clientOptions = [
            'base_uri' => "{$host}:{$port}/{$api_version}/",
            'auth' => [$admin_user, $admin_pas],
        ];

        $this->client = new Client($clientOptions);
    }

    /**
     * Send an HTTP request.
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $body request's parameters
     * @return string
     */
    protected function send_request($method, $endpoint, $body = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, ['query' => $body]);
            $content = $response->getBody()->getContents();

            return $content;
        } catch (ClientException $e) {
            echo "<script>console.log('".ClientException::getResponseBodySummary($e->getResponse())."')</script>";
        }
    }

    /**
     * Get the entries of a response.
     *
     * @param string $response request's response
     * @return array
     */
    protected function get_entries($response)
    {
        $json = json_decode($response, false, 512, JSON_BIGINT_AS_STRING);
        $array = isset($json->entries) ? $json->entries : [];

        return $array;
    }

    /**
     * Returns if a request was successful or not.
     *
     * @param string|null $response request's response
     * @return bool
     */
    protected function get_status($response)
    {
        return ! is_null($response);
    }

    public function membership($user)
    {
        $response = $this->send_request('GET', "addresses/{$user}/memberships");

        return $this->get_entries($response);
    }

    public function members($list_id)
    {
        $response = $this->send_request(
            'GET',
            'members/find',
            ['list_id' => $list_id]
        );

        return $this->get_entries($response);
    }

    public function lists()
    {
        $response = $this->send_request('GET', 'lists');

        return $this->get_entries($response);
    }

    public function update_list($list, $options)
    {
        $response = $this->send_request('PATCH', "lists/{$list}/config", $options);

        return $this->get_status($response);
    }

    public function create_list($name)
    {
        $response = $this->send_request(
            'POST',
            'lists',
            ['fqdn_listname' => $name]
        );

        return $this->get_status($response);
    }

    public function remove_list($name)
    {
        $response = $this->send_request('DELETE', "lists/{$name}");

        return $this->get_status($response);
    }

    public function subscribe($list_id, $user_name, $user_email)
    {
        $response = $this->send_request(
            'POST',
            'members',
            [
                'list_id' => $list_id,
                'display_name' => $user_name,
                'subscriber' => $user_email,
                'pre_verified' => true,
                'pre_confirmed' => true,
                'pre_approved' => true,
            ]
        );

        return $this->get_status($response);
    }

    public function unsubscribe($list_id, $user_email)
    {
        $members = $this->membership($user_email);
        $key = array_search($list_id, array_column($members, 'list_id'));
        $response = null;

        if ($key !== false) {
            $member_id = $members[$key]->member_id;
            $response = $this->send_request('DELETE', "members/{$member_id}");
        }

        return $this->get_status($response);
    }
}
