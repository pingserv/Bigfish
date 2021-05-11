<?php

namespace App\graphql\Mutations;

use App\Models\User;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
            ],
            'dateOfBirth' => [
                'name' => 'dateOfBirth',
                'type' => Type::nonNull(Type::string()),
            ],
            'isActive' => [
                'name' => 'isActive',
                'type' => Type::nonNull(Type::boolean()),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
            ],
            'password_confirmation' => [
                'name' => 'password_confirmation',
                'type' => Type::string(),
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'string', 'email ', 'max:255', 'unique:users,email'],
            'dateOfBirth' => ['required', 'date'],
            'isActive' => ['required'],
            'password' => ['nullable', 'required_with:password_confirmation', 'string', 'confirmed'],
        ];
    }

    public function resolve($root, $args)
    {
        $user = new User();
        $user->fill($args);
        $user->save();

        return $user;
    }
}
