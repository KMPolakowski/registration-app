<?php

namespace App\Service;

use App\Models\Address;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Service\Interfaces\PaymentDataRegistratorInterface;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;

class PaymentDataRegistrator implements PaymentDataRegistratorInterface
{
    private PaymentDetail $payDtRepo;
    private ClientInterface $client;

    public function __construct(PaymentDetail $payDtRepo, ClientInterface $client)
    {
        $this->payDtRepo = $payDtRepo;
        $this->client = $client;
    }

    public function register(User $user): PaymentDetail
    {
        $payDt = $this->payDtRepo::where('user_id', $user->id)
            ->where('deleted', false)
            ->firstOrFail();

        $response = $this->client->request('POST', '', [
            'json' => [
                'customerId' => $user->id,
                'iban' => $payDt->iban,
                'owner' => $payDt->account_owner_name
            ]
        ]);

        $response = json_decode((string) $response->getBody());

        if (!isset($response->paymentDataId)) {
            throw new InvalidArgumentException("Couldn't save payment data", 500);
        }

        $payDt->payment_data_id = $response->paymentDataId;
        $payDt->save();

        return $payDt;
    }
}
