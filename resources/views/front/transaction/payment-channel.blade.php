@php
    $availablePayments = $payments->filter(function($payment) use ($transaction) {
        return $transaction->package_price >= $payment->min_amount && $transaction->package_price <= $payment->max_amount;
    });
@endphp

<div class="row gx-1">
    @forelse ($availablePayments as $payment)
    @php
        $totalPrice = $transaction->package_price + $payment->flat_fee + ($transaction->package_price * $payment->percent_fee / 100);
    @endphp
    <div class="col-12 col-md-6">
        <input class="custom-option-item-check pay-method" type="radio" name="method" id="{{ $payment->id }}" value="{{ $payment->code }}" data-biaya-layanan="{{ number_format($payment->flat_fee + ($transaction->package_price * $payment->percent_fee / 100), 0, ',', '.') }}"  data-total="{{ number_format($totalPrice, 0, ',', '.') }}">
        <label id="label-meth-{{ $payment->id }}" class="custom-option-item p-2" onclick="method('{{ $payment->id }}')" for="{{ $payment->id }}">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="mb-0 py-2">
                            <span class="d-flex fw-bolder text-uppercase" style="white-space: nowrap;">{{ $payment->name }}</span>
                            <small style="white-space: nowrap;" class="text-muted text-warning d-flex"><i>{{ $payment->desc }}</i></small>
                        </td>
                        <td class="d-flex justify-content-end py-2">
                            <img src="{{ $payment->image }}" alt="Saldo Akun" class="img-fluid" style="max-width: 75%;">
                        </td>
                    </tr>
                    <tr class="border-top">
                        <td>
                            <span id="method-{{ $payment->id }}" style="white-space: nowrap;">
                                Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </label>
    </div>
    @empty
    <div class="d-flex justify-content-center align-items-center flex-column">
        <img src="{{ asset('undraw/payment-not-found.svg') }}" class="img-fluid" alt="Pending">
        <h6 class="text-center mt-3">Metode Pembayaran tidak ditemukan.</h6>
    </div>
    @endforelse
</div>
