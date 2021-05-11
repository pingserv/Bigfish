<?php

namespace App\graphql\Mutations;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::nonNull(Type::int()),
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ],
            'dateOfBirth' => [
                'name' => 'dateOfBirth',
                'type' => Type::string(),
            ],
            'isActive' => [
                'name' => 'isActive',
                'type' => Type::boolean(),
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
            'name' => ['sometimes', 'required'],
            'email' => ['sometimes', 'required', 'string', 'email ', 'max:255', 'unique:users,email'],
            'dateOfBirth' => ['sometimes', 'required', 'date'],
            'isActive' => ['sometimes', 'required'],
            'password' => ['nullable', 'required_with:password_confirmation', 'string', 'confirmed'],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        $user->fill($args);
        $user->save();

        return $user;
    }
}
