<?php

namespace App\GraphQL\Types;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Collection of users',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the user',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email address of the user',
            ],
            'dateOfBirth' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Date of birth of the user',
            ],
            'phoneNumber' => [
                'type' => Type::nonNull(GraphQL::type('PhoneNumber')),
                'description' => 'Phone number of the user',
            ],
            'isActive' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Activated status of the user',
            ],
        ];
    }
}
