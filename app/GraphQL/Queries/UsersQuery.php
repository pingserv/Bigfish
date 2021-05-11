<?php

namespace App\graphql\Queries;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('User');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'defaultValue' => 10,
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
                'defaultValue' => 1,
            ],
            'order' => [
                'name' => 'order',
                'type' => Type::string(),
                'defaultValue' => 'id'
            ],
            'dir' => [
                'name' => 'dir',
                'type' => Type::string(),
                'defaultValue' => 'asc'
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();


        $query = User::with($fields->getRelations())
            ->select($fields->getSelect());

        if ($args['order'] == 'phoneNumber')
        {
            $query->join('phone_numbers', 'users.id', '=', 'phone_numbers.user_id')
                ->orderBy('phone_numbers.phoneNumber', $args['dir']);
        } else {
            $query->orderBy($args['order'], $args['dir']);
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
