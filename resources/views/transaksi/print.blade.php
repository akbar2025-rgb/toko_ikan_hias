<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {
            font-family: 'Courier New', monospace;
        }
        .struk {
            width: 80mm;
            margin: 20px auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .detail {
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 100%;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="struk">
        <div class="header">
            <h3>TOKO IKAN HIAS</h3>
            <p class="mb-0">Jl. Atletik No. 12</p>
            <p class="mb-0">Telp: 0812-3456-7890</p>
        </div>

        <div class="detail">
            <table>
                <tr>
                    <td>No. Transaksi</td>
                    <td>: #{{ str_pad($transaksi->id, 3, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ optional($transaksi->tanggal_transaksi)->format('d/m/Y H:i') ?? optional($transaksi->created_at)->format('d/m/Y H:i') ?? date('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>: {{ optional($transaksi->user)->name ?? 'Sistem' }}</td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Total</th>
                </tr>
                <tr>
                    <td colspan="4"><hr style="margin: 5px 0; border-top: 1px dashed #000;"></td>
                </tr>
            </thead>
            <tbody>
                @if($transaksi->detailTransaksi && $transaksi->detailTransaksi->count() > 0)
                    @foreach($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td>{{ $detail->ikan->nama_ikan ?? 'Item' }}</td>
                        <td style="text-align: center;">{{ $detail->jumlah }}</td>
                        <td style="text-align: right;">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada item</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4"><hr style="margin: 5px 0; border-top: 1px dashed #000;"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">TOTAL:</th>
                    <th style="text-align: right;">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p class="mb-1">Terima Kasih</p>
            <p class="mb-0">Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>
    </div>

    <div class="text-center no-print mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            Tutup
        </button>
    </div>

    <script>
        window.onload = function() {
            // Auto print when page loads
            // window.print();
        }
    </script>
</body>
</html>