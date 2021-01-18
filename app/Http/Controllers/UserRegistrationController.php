<?php

namespace App\Http\Controllers;

use App\Service\Interfaces\PaymentDataRegistratorInterface;
use App\Service\Interfaces\UserRegistratorInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserRegistrationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function register(
        Request $request,
        UserRegistratorInterface $userReg,
        PaymentDataRegistratorInterface $payDataReg
    ) {
        $this->validate($request, [
            "form.personal.first_name" => "required|string",
            "form.personal.last_name" => "required|string",
            "form.personal.telephone" => "required|int",
            "form.address.street_name" => "required|string",
            "form.address.street_addition" => "required|string",
            "form.address.zip_code" => "required|int",
            "form.address.city" => "required|string",
            "form.payment.account_owner_name" => "required|string",
            "form.payment.iban" => "required|string"
        ]);

        $user = $userReg->register($request->get('form'));
        $payDt = $payDataReg->register($user);

        return [
            'payment_data_id' => $payDt->payment_data_id
        ];
    }
}
