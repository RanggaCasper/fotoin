@if ($payment->status === "UNPAID")    
    <div class="alert alert-custom" role="alert">
        <div class="alert-body">
            <div class="text-center">
                <h4 class="text-primary fw-bolder">Selesaikan Pembayaran Sebelum</h4>
                <p id="expired_at" class="text-danger m-0">{{ $payment->expired_at }}</p>
            </div>
        </div>
    </div>
@endif
@if ($payment->status === "UNPAID")    
    <h6>Bayar Dengan <b>{{ $payment->payment_channel->name }}</b></h6>
    <p>Silahkan lakukan pembayaran dengan <b>{{ $payment->payment_channel->name }}</b>. 
        @if ($payment->qr_link != null) 
            (Klik QRIS Untuk Memperbesar Gambar). 
        @endif 
        Lakukan pembayaran sesuai dengan total yang tertera di halaman invoice ini.
    </p>
    
    @if ($payment->qr_link != null)
        <img src="{{ $payment->qr_link }}" class="img-fluid w-50 mb-3" alt="QRIS">
    @endif
    
    @if ($payment->nomor_va != null)
        <input type="text" class="form-control mb-3" value="{{ $payment->nomor_va }}" disabled>
    @endif
    
    @if ($payment->checkout_url != null)
        <a href="{{ $payment->checkout_url }}" class="btn btn-primary mb-3">Bayar Pesanan!</a>
    @endif
@endif

@if ($payment->status === "PAID")
<div class="d-flex justify-content-center align-items-center flex-column mb-3">
    <img src="{{ asset('undraw/success.svg') }}" class="img-fluid w-50" alt="Pending">
</div>
@endif
@if ($payment->status === "EXPIRED")
<div class="d-flex justify-content-center align-items-center flex-column mb-3">
    <img src="{{ asset('undraw/expired.svg') }}" class="img-fluid w-50" alt="Pending">
</div>
@endif
@if ($payment->status === "FAILED")
<div class="d-flex justify-content-center align-items-center flex-column mb-3">
    <img src="{{ asset('undraw/failed.svg') }}" class="img-fluid w-50" alt="Pending">
</div>
@endif
<div class="card">
    <div class="card-header">
        <h4 class="m-0 p-0">DETAIL PEMBAYARAN</h4>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0 p-0">DETAIL HARGA</h4>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="white-space: nowrap;">Harga</td>
                            <td class="text-end">Rp. {{ number_format($payment->price, 0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td style="white-space: nowrap;">Biaya Layanan</td>
                            <td class="text-end">Rp. {{ number_format($payment->fee, 0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td style="white-space: nowrap;">Total Harga</td>
                            <td class="text-end">Rp. {{ number_format($payment->total_price, 0,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="white-space: nowrap;">Channel Pembayaran</td>
                    <td class="text-end"><b><img src="{{ $payment->payment_channel->image }}" class="img-fluid me-2" width="15%" alt="{{ $payment->payment_channel->name }}">{{ $payment->payment_channel->name }}</b></td>
                </tr>
                <tr>
                    <td style="white-space: nowrap;">Status Pembayaran</td>
                    <td class="text-end"><b>{{ $payment->status }}</b></td>
                </tr>
                <tr>
                    <td style="white-space: nowrap;">Waktu Dibuat</td>
                    <td class="text-end">{{ $payment->created_at }}</td>
                </tr>
                @if ($payment->status === "PAID")
                <tr>
                    <td style="white-space: nowrap;">Waktu Dibayar</td>
                    <td class="text-end">{{ $payment->paid_at }}</td>
                </tr>
                @endif
                @if ($payment->status === "EXPIRED")
                <tr>
                    <td style="white-space: nowrap;">Waktu Kadaluarsa</td>
                    <td class="text-end">{{ $payment->expired_at }}</td>
                </tr>
                @endif
                @if ($payment->status === "FAILED")
                <tr>
                    <td style="white-space: nowrap;">Terakhir Diupdate</td>
                    <td class="text-end">{{ $payment->updated_at }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>