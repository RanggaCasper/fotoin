<?php

namespace App\Http\Controllers\Callback;

use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\WebsiteConf;
use Illuminate\Http\Request;
use App\Mail\TransactionMail;
use App\Models\TransactionTimeline;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class CallbackController extends Controller
{   
    public function tokopay(Request $request)
    {
        $apiKey = WebsiteConf::where('conf_key', 'tokopay_api')->first()->conf_value;
        $secretKey = WebsiteConf::where('conf_key','tokopay_secret')->first()->conf_value;

        $json = $request->getContent();
        $data = json_decode($json, true);
        if (isset($data['status'], $data['reff_id'], $data['signature'])) {
            $status = $data['status'];
            if ($status === "Success") {
                //hanya proses yg status transaksi sudah di bayar, sukses = dibayar
                $ref_id = $data['reff_id'];

                $signature_from_tokopay = $data['signature'];
                $signature_validasi = md5($apiKey . ":" . $secretKey . ":" . $ref_id);
                if ($signature_from_tokopay === $signature_validasi) {

                    $payments = Payment::where('reference', $data['reference'])->first();
                    if($payments){
                        $payments->status = "PAID";
                        $payments->paid_at = now();
                        if($payments->save()){
                            $transaction = Transaction::where('id', $payments->transaction_id)->first();

                            TransactionTimeline::create([
                                'progress' => 'PENDING',
                                'created_by' => 'SYSTEM',
                                'description' => "Pembayaran berhasil pada " . now() . " WIB.",
                                'transaction_id' => $transaction->id
                            ]);

                            $transaction->status = "PROCESSING";
                            $transaction->note = "Pembayaran berhasil pada " . now() . " WIB.";
                            if($transaction->save()){
                                $user = User::find($transaction->user_id);
                                Mail::to($user->email)->send(new TransactionMail($payments, 'payment_success'));
                            }
                        };
                    }

                    return Response::json(['status' => true]);
                } else {
                    return Response::json(['error' => "Invalid Signature"]);
                }
            } else {
                return Response::json(['error' => "Status payment tidak success"]);
            }
        } else {
            return Response::json(['error' => "Data json tidak sesuai"]);
        }
    }
}