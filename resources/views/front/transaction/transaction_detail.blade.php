<table style="width: 100%;">
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