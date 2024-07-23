<table style="width: 100%;" class="mb-3">
    <tbody>
        <tr>
            <td style="white-space: nowrap;">Nomor Invoice</td>
            <td class="text-end"><a href="{{ route('view_transaction',['invoice' => $transaction->invoice]) }}"><b>#{{ $transaction->invoice }}</b></a></td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Waktu Pemesanan</td>
            <td class="text-end">{{ $transaction->created_at }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Katalog</td>
            <td class="text-end">{{ $transaction->catalog_name }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Nama Paket</td>
            <td class="text-end">{{ $transaction->package_name }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Harga</td>
            <td class="text-end">Rp. {{ number_format($transaction->package_price,0,',','.') }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Status Transaksi</td>
            <td class="text-end"><span class="badge @if($transaction->status == 'COMPLETED') bg-success @elseif($transaction->status == 'CANCLED') bg-danger @elseif($transaction->status == 'PENDING') bg-warning @elseif($transaction->status == 'PROCESSING') bg-info @endif rounded-pill px-3">{{ $transaction->status }}</span></td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Status Persetujuan</td>
            <td class="text-end"><span class="badge  @if($transaction->approved == 'APPROVED') bg-success @elseif($transaction->approved == 'WAITING') bg-warning @else bg-danger @endif rounded-pill px-3">{{ $transaction->approved }}</span></td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Catatan</td>
            <td class="text-end">{{ $transaction->note }}</td>
        </tr>
    </tbody>
</table>

@php
    $check_feedback = $transaction->feedbacks->where('user_id', $transaction->user_id)->first();
@endphp

@if($transaction->status === "COMPLETED" && $transaction->user_id === auth()->user()->id)
<div class="card">
    <div class="card-header">
        <h5>FEEDBACK</h5>
    </div>
    <div class="card-body">
        <h5 class="text-center">Berikan penilaian untuk transaksi ini!</h5>
        @if ($check_feedback)
            <div class="star-rate mb-3">
                <div class="d-flex justify-content-center">
                    <span class="ratings">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= $check_feedback->rate ? 'filled' : '' }}" data-value="{{ $i }}"></i>
                        @endfor
                    </span>
                    <span class="rating-count">{{ $check_feedback->rate }}.0</span>
                </div>
            </div>
            <div class="mb-0">
                <textarea class="form-control" name="feedback" id="feedback" rows="5" disabled>{{ $check_feedback->feedback }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
                <span class="text-muted small">Dikirim pada {{ $check_feedback->created_at }} WIB.</span>
            </div>
        @else
            <form id="feedback-form">
                @csrf
                <div class="star-rate mb-3">
                    <div class="d-flex justify-content-center">
                        <span class="ratings">
                            <i class="fa-solid fa-star filled" data-value="1"></i>
                            <i class="fa-solid fa-star filled" data-value="2"></i>
                            <i class="fa-solid fa-star filled" data-value="3"></i>
                            <i class="fa-solid fa-star filled" data-value="4"></i>
                            <i class="fa-solid fa-star filled" data-value="5"></i>
                        </span>
                        <span class="rating-count">5.0</span>
                    </div>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
                <input type="hidden" name="catalog_id" id="catalog_id" value="{{ $transaction->catalog_id }}">
                <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $transaction->id }}">
                <div class="mb-3">
                    <textarea class="form-control" name="feedback" id="feedback" rows="5" placeholder="Feedback anda tentang produk ini"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="ti ti-send me-2"></i> Kirim Feedback</button>
                </div>
            </form>
        @endif
    </div>
</div>

@if (!$check_feedback)
<script>
    $(document).ready(function() {
        $('.ratings i').on('click', function() {
            var rating = $(this).data('value');
            $('#rating').val(rating);

            $('.ratings i').each(function() {
                if ($(this).data('value') <= rating) {
                    $(this).addClass('filled');
                } else {
                    $(this).removeClass('filled');
                }
            });

            $('.rating-count').text(rating + '.0');
        });

        $('#feedback-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route("create_feedback") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire(
                        'Sukses!',
                        response.message,
                        'success'
                    );
                    $('#feedback-form')[0].reset();
                    $('#rating').val('5');
                    $('.ratings i').addClass('filled');
                    $('.rating-count').text('5.0');
                    fetch_transaction();
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan saat mengirim feedback.';
                    Swal.fire(
                        'Error!',
                        errorMessage,
                        'error'
                    );
                }
            });
        });
    });
</script>
@endif
@else
    @if ($check_feedback)
    <div class="card">
        <div class="card-header">
            <h5>FEEDBACK</h5>
        </div>
        <div class="card-body">
            <h5 class="text-center">Berikan penilaian untuk transaksi ini!</h5>
                <div class="star-rate mb-3">
                    <div class="d-flex justify-content-center">
                        <span class="ratings">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $check_feedback->rate ? 'filled' : '' }}" data-value="{{ $i }}"></i>
                            @endfor
                        </span>
                        <span class="rating-count">{{ $check_feedback->rate }}.0</span>
                    </div>
                </div>
                <div class="mb-0">
                    <textarea class="form-control" name="feedback" id="feedback" rows="5" disabled>{{ $check_feedback->feedback }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <span class="text-muted small">Dikirim pada {{ $check_feedback->created_at }} WIB.</span>
                </div>
        </div>
    </div>
    @endif
@endif
