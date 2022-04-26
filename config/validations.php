<?php

use Illuminate\Validation\Rule;

/**
 * This file contains validation rules, messages and parameters for
 * all requests within the api that need validation
 */
return [
    'rules' => [
        //Auth Validations
        'login' => [
            'identifier' => 'required|string|min:1|max:255',
            'password' => 'required',
        ],
        'register' => [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ],
        'like-post' => [
            'post_id' => 'required|string|exists:posts,id',
        ],
    ],
    'messages' => [
        "user_id.exists" => "user not found",
        "post_id.exists" => "post not found",
    ],
];
