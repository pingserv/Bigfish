<?php

namespace App\GraphQL\Types;

use App\Models\PhoneNumber;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PhoneNumberType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PhoneNumber',
        'description' => 'Phone number of users',
        'model' => PhoneNumber::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a phone number',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The user that has phone number',
            ],
            'phoneNumber' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The user\'s phone number',
            ],
        ];
    }
}
