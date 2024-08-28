<?php

namespace Kevinrevill\Plentific\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Kevinrevill\Plentific\Models\User;
use Kevinrevill\Plentific\Exceptions\ApiException;

class UserService
{
    const URL = 'https://reqres.in/api/users/';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getUserById(int $id): User
    {
        try {
            $response = $this->client->get(self::URL . "{$id}");
            $data = json_decode($response->getBody()->getContents(), true)['data'];

            return new User($data['id'], $data['first_name'], $data['last_name'], $data['email'], $data['avatar']);
        } catch (GuzzleException $e) {
            throw new ApiException('Error retrieving user data', $e->getCode(), $e);
        }
    }

    public function getUsers(int $page = 1): array
    {
        try {
            $response = $this->client->get(self::URL, ['query' => ['page' => $page]]);
            $data = json_decode($response->getBody()->getContents(), true)['data'];

            return array_map(fn($user) => new User($user['id'], $user['first_name'], $user['last_name'], $user['email'], $user['avatar']), $data);
        } catch (GuzzleException $e) {
            throw new ApiException('Error retrieving user list', $e->getCode(), $e);
        }
    }

    public function createUser(string $name, string $job): int
    {
        try {
            $response = $this->client->post(self::URL, [
                'json' => [
                    'name' => $name,
                    'job' => $job
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['id'];
        } catch (GuzzleException $e) {
            throw new ApiException('Error creating user', $e->getCode(), $e);
        }
    }
}