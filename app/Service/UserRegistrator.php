<?php

namespace App\Service;

use App\Models\Address;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Service\Interfaces\UserRegistratorInterface;

class UserRegistrator implements UserRegistratorInterface
{
    private User $userRepo;

    public function __construct(User $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $form): User
    {
        $personal = $form["personal"];
        $payment = $form["payment"];
        $address = $form["address"];

        $user = new User();
        $user->first_name = $personal["first_name"];
        $user->last_name = $personal["last_name"];
        $user->telephone_number = $personal["telephone"];
        $user->save();

        $newAddress = new Address();
        $newAddress->address_addition = $address["street_addition"];
        $newAddress->street_name = $address["street_name"];
        $newAddress->city = $address["city"];
        $newAddress->zip_code = $address["zip_code"];

        $payDt = new PaymentDetail();
        $payDt->iban = $payment["iban"];
        $payDt->account_owner_name = $payment["account_owner_name"];

        $user->paymentDetails()->save($payDt);
        $user->addresses()->save($newAddress);

        return $user;
    }
}
