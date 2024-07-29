<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Profit;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Calendar;
use App\Models\Feedback;
use App\Models\Transaction;
use App\Models\WebsiteConf;
use Illuminate\Http\Request;
use App\Mail\TransactionMail;
use App\Models\PaymentChannel;
use App\Models\TransactionTimeline;
use App\Services\TokopayService;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function view_transaction(Request $request, $invoice)
    {
        $payments = PaymentChannel::get();
        $transaction = Transaction::with('package', 'catalog', 'user', 'feedbacks')
        ->where('invoice', $invoice)
        ->where(function($query) {
            $query->where('user_id', auth()->user()->id)
                  ->orWhere('freelance_id', auth()->user()->id);
        })
        ->first();

        if(!$transaction){
            toastr()->error('Invoice tidak ditemukan.');
            return redirect()->back();
        }
        
        $status_timeline = TransactionTimeline::where('transaction_id',$transaction->id)->where('progress','COMPLETED')->where('created_by','FREELANCER')->first();
        $payment = Payment::where('transaction_id',$transaction->id)->first();
        
        return view('front.transaction.transaction', compact('transaction','invoice','payments','status_timeline','payment'));
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

            if (!$request->booked_at) {
                return response()->json(['success' => false, 'message' => 'Waktu booking harus di isi.']);
            }

            $activity = Calendar::where('user_id', $package->catalog->user_id);

            $bookedAt = Carbon::parse($request->booked_at);

            $conflict = $activity->where(function($query) use ($bookedAt) {
                $query->where('start', '<=', $bookedAt)
                    ->where('end', '>=', $bookedAt);
            })->exists();

            if ($conflict) {
                return response()->json(['success' => false, 'message' => 'Freelance tidak ready di tanggal tersebut.']);
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
                'booked_at' => $request->booked_at,
                'package_description' => $package->description,
                'catalog_id' => $package->catalog->id,
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

    public function update_transaction(Request $request, $invoice)
    {
        $transaction = Transaction::where('invoice', $invoice)->first();
        $status_timeline = TransactionTimeline::where('transaction_id',$transaction->id)->where('progress','COMPLETED')->where('created_by','FREELANCER')->first();
        
        if (!$transaction) {
            return response()->json(['status' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        if (auth()->user()->id !== $transaction->user_id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
        }

        if ($transaction->status !== 'PROCESSING') {
            return response()->json(['status' => false, 'message' => 'Transaksi status tidak processing.'], 400);
        }

        if (!$status_timeline) {
            return response()->json(['status' => false, 'message' => 'Freelance status tidak completed.'], 400);
        }

        $note = 'Pesanan berhasil diselesaikan pada '.now().' WIB.';

        $transaction->status = 'COMPLETED';
        $transaction->note = $note;
        if($transaction->save()){
            Mail::to(auth()->user()->email)->send(new TransactionMail($transaction, 'transaction_success'));
        }

        $freelance = User::find($transaction->freelance_id);
        $web_fee_percentage = WebsiteConf::where('conf_key', 'take_fee')->first()->conf_value ?? 0;
        $web_fee = ($web_fee_percentage / 100) * $transaction->package_price;

        Profit::create([
            'profit' => $web_fee,
            'transaction_id' => $transaction->id
        ]);
        $balance = $freelance->balance;
        $price = $transaction->package_price - $web_fee;
        if ($freelance) {
            $freelance->balance = $balance + $price;
            $freelance->save();
        }

        return response()->json(['status' => true, 'message' => $note]);
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
                $transaction = Transaction::with('package', 'catalog', 'user')
                ->where('invoice', $invoice)
                ->where(function($query) {
                    $query->where('user_id', auth()->user()->id)
                          ->orWhere('freelance_id', auth()->user()->id);
                })
                ->first();
                return response()->json(['status' => true, 'html' => view('front.transaction.transaction_detail', compact('transaction'))->render()]);
            }
    
            return response()->json(['status' => false]);
        }
        abort(404);
    }

    public function transaction_timeline(Request $request, $id)
    {
        if($request->ajax()){
            $transaction = Transaction::with('package', 'catalog', 'user')
                ->where('id', $id)
                ->where(function($query) {
                    $query->where('user_id', auth()->user()->id)
                          ->orWhere('freelance_id', auth()->user()->id);
                })
                ->first();
            $timelines = TransactionTimeline::where('transaction_id', $id)->orderBy('created_at', 'asc')->get();

            if($timelines){
                return response()->json(['status' => true, 'html' => view('front.transaction.transaction_timeline', compact('timelines','transaction'))->render()]);
            }
    
            return response()->json(['status' => false]);
        }
        abort(404);
    }

    public function create_transaction_timeline(Request $request,$id)
    {
        $request->validate([
            'progress' => 'required|in:PENDING,IN_PROGRESS,COMPLETED,CANCELED',
            'description' => 'nullable|string'
        ]);

        try {
            $transaction = Transaction::findOrFail($id);
            $created_by = "CLIENT";
            if(auth()->user()->id === $transaction->freelance_id) {
                $created_by = "FREELANCER";
            }
            TransactionTimeline::create([
                'progress' => $request->progress,
                'created_by' => $created_by,
                'description' => $request->description,
                'transaction_id' => $id
            ]);
    
            return response()->json(['success' => true, 'message' => 'Timeline berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat timeline.']);
        }
    }


    public function create_feedback(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:255',
            'catalog_id' => 'required|exists:catalogs,id',
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        $existingFeedback = Feedback::where('transaction_id', $request->transaction_id)
                                    ->where('user_id', auth()->user()->id)
                                    ->first();

        if ($existingFeedback) {
            return response()->json(['status' => false, 'message' => 'Anda sudah pernah memberikan feedback untuk transaksi ini.'], 400);
        }

        Feedback::create([
            'rate' => $request->rating,
            'feedback' => $request->feedback,
            'user_id' => auth()->user()->id,
            'catalog_id' => $request->catalog_id,
            'transaction_id' => $request->transaction_id,
        ]);

        return response()->json(['status' => true, 'message' => 'Feedback berhasil disimpan.']);
    }
}
