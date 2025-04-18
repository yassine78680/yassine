<?php

namespace App\Services;

use App\Traits\PushNotificationTrait;
use Brian2694\Toastr\Facades\Toastr;
class DeliveryManWithdrawService
{
    /**
     * @param object $request
     * @return array
     */
    public function getDeliveryManWithdrawData(object $request) : array
    {
        return  [
            'approved' => $request['approved'],
            'transaction_note' => $request['note']
        ];
    }

    /**
     * @param object $request
     * @param object $wallet
     * @param object $withdraw
     * @return array[]
     */
    public function getUpdateData(object $request, object $wallet, object $withdraw): array
    {
        $withdrawData = [];
        $withdrawData['approved'] = $request['approved'];
        $withdrawData['transaction_note'] = $request['note'];
        $walletData = [];

        if ($request['approved'] == 1) {
            $walletData['total_withdraw'] = $wallet->total_withdraw + $withdraw['amount'];
            $walletData['pending_withdraw'] = $wallet->pending_withdraw - $withdraw['amount'];
            $walletData['current_balance'] = $wallet->current_balance - $withdraw['amount'];
        } else {
            $walletData['pending_withdraw'] = $wallet->pending_withdraw - $withdraw['amount'];
        }

        return [
            'wallet' => $walletData,
            'withdraw' => $withdrawData,
        ];
    }
}
