<?php

namespace App\Service\Interfaces;

use App\Models\User;

interface UserRegistratorInterface {
    public function register(array $userData) : User;
}