<?php

namespace App\Mail;

use App\Models\PaymentChannel;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TransactionMail extends Mailable
{
    use Queueable, SerializesModels;

    private $result;
    private $type;
    private $user;

    public function __construct($result, $type)
    {
        $this->result = $result;
        $this->type = $type;
        $this->user = auth()->user();
    }

    public function build()
    {
        switch ($this->type) {
            case 'transaction_created':
                return $this->transactionCreated();
            case 'transaction_success':
                return $this->transactionSuccess();
            case 'payment_success':
                return $this->paymentSuccess();
            case 'transaction_failed':
                return $this->transactionFailed();
            case 'payment_created':
                return $this->paymentCreated();
            default:
                throw new \InvalidArgumentException('Invalid email type.');
        }
    }

    private function transactionCreated()
    {
        return $this->subject('Notifikasi Transaksi #' . $this->result['invoice'])
            ->view('mail.transaction_created')
            ->with([
                'result' => $this->result,
                'user' => $this->user
            ]);
    }

    private function transactionSuccess()
    {
        return $this->subject('Notifikasi Transaksi #' . $this->result['invoice'])
            ->view('mail.transaction_success')
            ->with([
                'result' => $this->result,
                'user' => $this->user
            ]);
    }

    private function paymentSuccess()
    {
        $transaction = Transaction::where('id', $this->result['transaction_id'])->first();
        $user = User::find($transaction->user_id);
        $channel = PaymentChannel::where('id', $this->result['payment_channel_id'])->first();
        return $this->subject('Notifikasi Transaksi #' . $transaction['invoice'])
            ->view('mail.payment_success')
            ->with([
                'result' => $this->result,
                'transaction' => $transaction,
                'channel' => $channel,
                'user' => $user
            ]);
    }

    private function transactionFailed()
    {
        return $this->subject('Notifikasi Transaksi #' . $this->result['invoice'])
            ->view('mail.transaction_failed')
            ->with([
                'result' => $this->result,
                'user' => $this->user
            ]);
    }

    private function paymentCreated()
    {
        $transaction = Transaction::where('id', $this->result['transaction_id'])->first();
        $channel = PaymentChannel::where('id', $this->result['payment_channel_id'])->first();
        return $this->subject('Notifikasi Transaksi #' . $transaction['invoice'])
            ->view('mail.payment_created')
            ->with([
                'result' => $this->result,
                'transaction' => $transaction,
                'channel' => $channel,
                'user' => $this->user
            ]);
    }
}
