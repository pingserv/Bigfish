<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class GraphQLTest extends TestCase
{
    public function testGetUsers()
    {
        $response = $this->postJson('/graphql', ['query' => '{
            users(limit:1, page: 1, order: "id", dir: "asc") {
                data {
                    id
                    name
                    email
                    dateOfBirth
                    phoneNumber {
                        phoneNumber
                    }
                    isActive
                },
                total,
                per_page
            }
        }']);

        $total = User::count();
        $user = User::where('id', 1)->first();
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "users" => [
                        "data" => [
                            [
                                "id" => 1,
                                "name" => $user->name,
                                "email" => $user->email,
                                "dateOfBirth" => $user->dateOfBirth->format('Y-m-d H:i:s'),
                                "phoneNumber" => [
                                    "phoneNumber" => $user->phoneNumber->phoneNumber
                                ],
                                "isActive" => $user->isActive
                            ]
                        ],
                        "total" => $total,
                        "per_page" => 1
                    ]
                ]
            ]);
    }

    public function testGetUser()
    {
        $response = $this->postJson('/graphql', ['query' => '{
            user(id:1) {
                id,
                name,
                email,
                dateOfBirth,
                phoneNumber {
                    phoneNumber
                }
                isActive
            }
        }']);

        $user = User::where('id', 1)->first();
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "user" => [
                        "id" => 1,
                        "name" => $user->name,
                        "email" => $user->email,
                        "dateOfBirth" => $user->dateOfBirth->format('Y-m-d H:i:s'),
                        "phoneNumber" => [
                            "phoneNumber" => $user->phoneNumber->phoneNumber
                        ],
                        "isActive" => $user->isActive
                    ]
                ]
            ]);
    }

    public function testCreateUser()
    {
        $response = $this->postJson('/graphql', ['query' => 'mutation createUser {
            createUser(name: "Proba Bela", email: "proba.bela@gmail.com", dateOfBirth: "2000-01-10", isActive: true, password: "hello", password_confirmation: "hello") {
                id
                name
                email
            }
        }']);

        $user = User::orderBy('id', 'desc')->first();
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "createUser" => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email
                    ]
                ]
            ]);
    }

    public function testUpdateUser()
    {
        $user = User::orderBy('id', 'desc')->first();
        $response = $this->postJson('/graphql', ['query' => 'mutation updateUser {
            updateUser(id: '.$user->id.', name: "Big Fish", email: "bigfish@gmail.com", dateOfBirth: "2005-10-10", isActive: true) {
                id
                name
                email
            }
        }']);

        $user = User::where('id', $user->id)->first();
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "updateUser" => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email
                    ]
                ]
            ]);
    }

    public function testDeleteUser()
    {
        $user = User::orderBy('id', 'desc')->first();
        $response = $this->postJson('/graphql', ['query' => 'mutation deleteUser {
            deleteUser(id: '.$user->id.')
        }']);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "deleteUser" => true
                ]
            ]);
    }
}
