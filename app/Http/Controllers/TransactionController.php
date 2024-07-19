<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\TransactionMail;
use App\Models\PaymentChannel;
use App\Services\TokopayService;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function view_transaction(Request $request, $invoice)
    {
        $payments = PaymentChannel::get();
        $transaction = Transaction::with('package','catalog','user')->where('invoice', $invoice)->where('user_id', auth()->user()->id)->first();
        $payment = Payment::where('transaction_id',$transaction->id)->first();

        if(!$transaction){
            toastr()->error('Invoice tidak ditemukan.');
            return redirect()->back();
        }
        
        return view('front.transaction.transaction', compact('transaction','invoice','payments', 'payment'));
    }

    public function create_transaction(Request $request)
    {
        if($request->ajax()){
            $package = Package::with('catalog')->find($request->package_id);

            if (!$package) {
                return response()->json(['success' => false, 'message' => 'Paket tidak ditemukan.']);
            }

            if (!$package->catalog) {
                return response()->json(['success' => false, 'message' => 'Katalog tidak ditemukan.']);
            }

            if (auth()->user()->id === $package->catalog->user_id) {
                return response()->json(['success' => false, 'message' => 'Tidak bisa melakukan order di katalog sendiri.']);
            }

            $data = [
                'invoice' => Transaction::generateInvoice(),
                'note' => 'Menunggu Persetujuan Dari Freelance',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'catalog_name' => $package->catalog->title_name,
                'catalog_image' => $package->catalog->portofolios->first()->path_image,
                'package_name' => $package->package_name,
                'package_price' => $package->price,
                'package_description' => $package->description,
                'user_id' => auth()->user()->id,
                'freelance_id' => $package->catalog->user_id
            ];

            $transaction = Transaction::create($data);

            if ($transaction) {
                Mail::to(auth()->user()->email)->send(new TransactionMail($data, 'transaction_created'));
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil dibuat, Invoice # ' . $transaction->invoice . '.',
                    'redirect_url' => route('view_transaction', ['invoice' => $transaction->invoice])
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal membuat transaksi.']);
        }
        abort(404);
    }

    public function create_payment(Request $request)
    {
        if($request->payment_id === null){
            return response()->json(['status' => false, 'message' => 'Silahkan pilih metode Pembayaran.']);
        }

        if($request->transaction_id === null){
            return response()->json(['status' => false, 'message' => 'Gagal menemukan id transaksi.']);
        }

        $payment_channel = PaymentChannel::where('id', $request->payment_id)->first();
        // dd($payment_channel);
        $transaction = Transaction::where('id', $request->transaction_id)->first();

        $fee = $payment_channel->flat_fee + ($transaction->package_price * $payment_channel->percent_fee / 100);
        $price = $transaction->package_price + $fee;
        $price = ceil($price);

        $tokopay = new TokopayService();

        $result = $tokopay->createOrder($price, $payment_channel->code, $transaction->invoice);
        $result = json_decode($result, true);
        $result = $result['data'];

        $data = [
          'reference' => $result['trx_id'],
          'checkout_url' => $result['checkout_url'] ?? null,
          'nomor_va' => $result['nomor_va'] ?? null,
          'qr_link' => $result['qr_link'] ?? null,
          'expired_at' => now()->addHours(24),
          'status' => 'UNPAID',
          'price' => $transaction->package_price,
          'fee' => $fee,
          'total_price' => $price,
          'payment_channel_id' => $payment_channel->id,
          'transaction_id' => $transaction->id,
        ];
        
        if($data){
            $validasi = Payment::where('reference', $result['trx_id'])->first();
            if($validasi){
                return response()->json(['status' => false, 'message' => 'Silahkan selesaikan pembayaran sebelumnya.']);
            }

            $validasi = Payment::where('transaction_id', $transaction->id)->first();
            if($validasi){
                return response()->json(['status' => false, 'message' => 'Silahkan selesaikan transaksi sebelumnya.']);
            }

            $note = "Pembayaran berhasil dibuat, silahkan lakukan pembayaran.";
            $transaction->note = $note;
            $transaction->save();

            $data = Payment::create($data);
            Mail::to(auth()->user()->email)->send(new TransactionMail($data, 'payment_created'));
            return response()->json(['status' => true, 'message' => $note]);
        }

        return response()->json(['status' => false, 'message' => 'Data yang anda masukan tidak valid.']);
    }

    public function payment_detail(Request $request, $invoice)
    {
        if($request->ajax()){
            $transaction = Transaction::where('invoice', $invoice)->first();
            $payment = Payment::where('transaction_id',$transaction->id)->first();

            if($payment){
                return response()->json(['status' => true, 'html' => view('front.transaction.payment-detail', compact('payment'))->render()]);
            }

            if($transaction->approved === "APPROVED"){
                $payments = PaymentChannel::get();
                $transaction = Transaction::with('package','catalog','user')->where('invoice', $invoice)->where('user_id', auth()->user()->id)->first();
                return response()->json(['status' => true, 'html' => view('front.transaction.payment-channel', compact('payments','transaction'))->render()]);
            } else {
                return response()->json(['status' => true, 'html' => view('front.transaction.payment-waiting')->render()]);
            }

            return response()->json(['status' => false]);
        }
        abort(404);
    }

    public function transaction_detail(Request $request, $invoice)
    {
        if($request->ajax()){
            $transaction = Transaction::where('invoice', $invoice)->first();

            if($transaction){
                $transaction = Transaction::with('package','catalog','user')->where('invoice', $invoice)->where('user_id', auth()->user()->id)->first();
                return response()->json(['status' => true, 'html' => view('front.transaction.transaction_detail', compact('transaction'))->render()]);
            }
    
            return response()->json(['status' => false]);
        }
        abort(404);
    }
}
