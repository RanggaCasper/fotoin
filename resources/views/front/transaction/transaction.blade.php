@extends('front.layouts.main')

@push('styles')
<style>
    .custom-option-item {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .custom-option-item:hover {
        background-color: #f9f9f9;
        border-color: #ccc;
    }

    .custom-option-item-check {
        display: none;
    }

    .custom-option-item-check:checked + .custom-option-item {
        background-color: #fcccaa;
        border-color: #FF6900;
    }

    .custom-option-item img {
        max-width: 75%;
    }

    .custom-option-item table {
        width: 100%;
    }

    .custom-option-item .fw-bolder {
        font-weight: bolder;
    }
    .alert-custom {
        background-color: rgb(255, 242, 224);
        border-color: rgb(255, 242, 224);
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    function fetch_pembayaran(command) {
        if(command === "refresh"){
            toastr.success('Refresh berhasil.','Success');
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('payment_detail', ['invoice' => $transaction->invoice]) }}',
            success: function(response) {
                $('#card-pembayaran').html(response.html);
                countdown();
            },
            error: function(response) {
            }
        });
    }

    function fetch_transaction(command) {
        if(command === "refresh"){
            toastr.success('Refresh berhasil.','Success');
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('transaction_detail', ['invoice' => $transaction->invoice]) }}',
            success: function(response) {
                $('#card-detail').html(response.html);
            },
            error: function(response) {
            }
        });
    }
    
    fetch_pembayaran();
    fetch_transaction();
</script>
<script src="https://cdn.jsdelivr.net/npm/luxon@2.1.1/build/global/luxon.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submit-btn').click(function() {
            var paymentId = $('#payment_id').val();
            var transactionId = $('#transaction_id').val();
            $('#submit-btn').prop('disabled', true);
            $('#submit-btn').html('<span id="loadingSpinner" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

            $.ajax({
                type: 'POST',
                url: '{{ route('create_payment') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    transaction_id: transactionId,
                    payment_id: paymentId
                },
                success: function(response) {
                    if(response.status === false){
                        toastr.error(response.message,'Oops!');
                        $('#submit-btn').prop('disabled', false);
                        $('#submit-btn').html('<i class="feather-shopping-cart me-2"></i>Bayar Pesanan');
                    } else {
                        $('#submit-btn').remove();
                        $('#payment_id').remove();
                        $('#transaction_id').remove();
                        fetch_pembayaran();
                        toastr.success(response.message,'Success!');
                    }
                },
                error: function(response) {
                    $('#submit-btn').prop('disabled', false);
                    $('#submit-btn').html('<i class="feather-shopping-cart me-2"></i>Bayar Pesanan');
                }
            });
        });

        @if($transaction->status === "PROCESSING" && $payment->status === "PAID")
            @if(auth()->user()->id === $transaction->user_id)
                $('#submit-btn-selesai').click(function() {
                    $('#submit-btn-selesai').prop('disabled', true);
                    $('#submit-btn-selesai').html('<span id="loadingSpinner" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

                    $.ajax({
                        type: 'PUT',
                        url: '{{ route('update_transaction', $transaction->invoice) }}',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.status === false){
                                toastr.error(response.message,'Oops!');
                                $('#submit-btn-selesai').prop('disabled', false);
                                $('#submit-btn-selesai').html('<i class="feather-shopping-cart me-2"></i>Bayar Pesanan');
                            } else {
                                $('#submit-btn-selesai').remove();
                                $('#payment_id').remove();
                                $('#transaction_id').remove();
                                fetch_pembayaran();
                                fetch_transaction();
                                toastr.success(response.message,'Success!');
                            }
                        },
                        error: function(response) {
                            $('#submit-btn-selesai').prop('disabled', false);
                            $('#submit-btn-selesai').html('<i class="feather-shopping-cart me-2"></i>Bayar Pesanan');
                        }
                    });
                });
            @endif
        @endif
    });

    function method(id) {
        document.getElementById(id).checked = true;
        var biayaLayanan = document.getElementById(id).getAttribute('data-biaya-layanan');
        var total = document.getElementById(id).getAttribute('data-total');

        document.getElementById('biaya-layanan').innerText = 'Rp. ' + biayaLayanan;
        document.getElementById('total').innerText = 'Rp. ' + total;

        document.getElementById('payment_id').value = id;
    }

    function countdown() {
        var countdownElement = document.getElementById("expired_at");
        var targetDateString = countdownElement.textContent;

        var targetDate = luxon.DateTime.fromFormat(targetDateString, "yyyy-MM-dd HH:mm:ss", { zone: "Asia/Jakarta" });

        var countdown = setInterval(function () {
        var currentDate = luxon.DateTime.local();

        var diff = targetDate.diff(currentDate, ["days", "hours", "minutes", "seconds"]).toObject();

        var days = Math.floor(diff.days);
        var hours = Math.floor(diff.hours);
        var minutes = Math.floor(diff.minutes);
        var seconds = Math.floor(diff.seconds);

        var countdownString = "";
        if (days > 0) {
        countdownString += days + " Hari ";
        }
        if (hours > 0 || days > 0) {
        countdownString += hours + " Jam ";
        }
        if (minutes > 0 || hours > 0 || days > 0) {
        countdownString += minutes + " Menit ";
        }
        countdownString += seconds + " Detik ";
        countdownElement.innerHTML = countdownString.trim();

        if (diff.seconds <= 0) {
            clearInterval(countdown);
            countdownElement.innerHTML = "Transaksi Kadaluarsa!";
            location.reload();
        }
        }, 1000);
    }
    
</script>
@endpush

@section('content')
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="m-0">
                                DETAIL TRANSAKSI
                            </h4>
                            <a onclick="fetch_transaction('refresh')" style="cursor: pointer;"><i class="feather-refresh-cw"></i></a>
                        </div>
                    </div>
                    <div class="card-body" id="card-detail">
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="m-0">
                                PEMBAYARAN
                            </h4>
                            <a onclick="fetch_pembayaran('refresh')" style="cursor: pointer;"><i class="feather-refresh-cw"></i></a>
                        </div>
                    </div>
                    <div class="card-body" id="card-pembayaran">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $transaction->catalog_image) }}" class="img-fluid mb-3" alt="Katalog Image">
                        <div class="d-flex justify-content-between">
                            <h6 style="text-transform: uppercase;">{{ $transaction->package_name }}</h6>
                            <h6>Rp. {{ number_format($transaction->package_price,0,',','.') }}</h6>
                        </div>
                        <p style="text-align: justify;">{{ $transaction->package_description }}</p>
                        @if ($payment)
                            <div class="border-top mb-3"></div>
                            <div class="d-flex justify-content-between">
                                <h6>Biaya Layanan</h6>
                                <h6 id="biaya-layanan">Rp. {{ number_format($payment->fee,0,',','.') }}</h6>
                            </div>
                            <div class="border-top mb-3"></div>
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Total</h6>
                                <h6 id="total">Rp. {{ number_format($payment->total_price,0,',','.') }}</h6>
                            </div>    
                        @else
                            <div class="border-top mb-3"></div>
                            <div class="d-flex justify-content-between">
                                <h6>Biaya Layanan</h6>
                                <h6 id="biaya-layanan">Rp. 0</h6>
                            </div>
                            <div class="border-top mb-3"></div>
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Total</h6>
                                <h6 id="total">Rp. 0</h6>
                            </div>
                        @endif
                        @if (auth()->user()->id === $transaction->user_id)
                            <a href="{{ route('view_message') }}?id={{ $transaction->freelance_id }}&text=Hallo {{ $transaction->freelance->username }}," class="btn btn-outline-primary w-100 mb-1"><i class="feather-message-square me-2"></i>Chat Freelance</a>
                        @else
                            <a href="{{ route('view_message') }}?id={{ $transaction->user_id }}&text=Hallo {{ $transaction->user->username }}," class="btn btn-outline-primary w-100 mb-1"><i class="feather-message-square me-2"></i>Chat Customer</a>
                        @endif
                        @if ($transaction->approved === "WAITING")
                            <button class="btn btn-primary w-100">Batalkan Pesanan</button>
                        @else
                            @if (!$payment)
                                <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $transaction->id }}">
                                <input type="hidden" name="payment_id" id="payment_id">
                                <button class="btn btn-primary w-100" id="submit-btn"><i class="feather-shopping-cart me-2"></i>Bayar Pesanan</button>
                            @elseif ($transaction->status === "PROCESSING" && $payment->status === "PAID")
                                @if(auth()->user()->id === $transaction->user_id)
                                    <button class="btn btn-primary w-100" id="submit-btn-selesai"><i class="feather-check me-2"></i>Pesanan Selesai</button>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection