<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kevinrevill\Plentific\Exceptions\ApiException;
use Kevinrevill\Plentific\Models\User;
use Kevinrevill\Plentific\Services\UserService;

class UserServiceTest extends TestCase
{
    public function testGetUserById()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 1,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john.doe@example.com',
                    'avatar' => 'https://example.com/avatar.jpg'
                ]
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $service = new UserService($client);

        $user = $service->getUserById(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->toArray()['id']);
    }

    public function testGetUsers()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'email' => 'john.doe@example.com',
                        'avatar' => 'https://example.com/avatar.jpg'
                    ],
                    [
                        'id' => 2,
                        'first_name' => 'Jane',
                        'last_name' => 'Doe',
                        'email' => 'jane.doe@example.com',
                        'avatar' => 'https://example.com/avatar2.jpg'
                    ]
                ]
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $service = new UserService($client);

        $users = $service->getUsers(1);

        $this->assertCount(2, $users);
        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals(1, $users[0]->toArray()['id']);
    }

    public function testGetUserByIdNotFound()
    {
        // Set up the mock handler to return a 404 response
        $mock = new MockHandler([
            new Response(404)
        ]);

        // Create a Guzzle client with the mock handler
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $service = new UserService($client);

        // Expect the ApiException to be thrown
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error retrieving user data');

        // Attempt to retrieve a user by an ID that doesn't exist
        $service->getUserById(999);
    }

    public function testCreateUser()
    {
        $mock = new MockHandler([
            new Response(201, [], json_encode([
                'id' => 101,
                'name' => 'John Doe',
                'job' => 'Software Developer',
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $service = new UserService($client);

        $userId = $service->createUser('John Doe', 'Software Developer');

        $this->assertEquals(101, $userId);
    }

    public function testApiException()
    {
        $this->expectException(ApiException::class);

        $mock = new MockHandler([
            new Response(500)
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $service = new UserService($client);

        $service->getUserById(1);
    }
}