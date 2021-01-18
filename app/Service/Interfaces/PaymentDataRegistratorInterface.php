<?php

namespace App\Service\Interfaces;

use App\Models\PaymentDetail;
use App\Models\User;

interface PaymentDataRegistratorInterface {
    public function register(User $user) : PaymentDetail;
}
