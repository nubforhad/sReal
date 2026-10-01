<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Money Receipt - {{ $payment->receipt_no }}</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 6mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", serif;
            background: #e5e7eb;
            color: #1f1f1f;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ---------- Toolbar (screen only) ---------- */
        .toolbar {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 12px;
        }

        .toolbar button,
        .toolbar a {
            padding: 8px 18px;
            border: 0;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            font-family: Arial, sans-serif;
        }

        .btn-print { background: #2563eb; color: #fff; }
        .btn-back  { background: #fff; color: #334155; border: 1px solid #cbd5e1 !important; }

        /* ---------- Sheet ---------- */
        .sheet {
            width: 297mm;
            height: 210mm;
            margin: 0 auto 10px;
            background: #fff;
            padding: 1mm;
            display: flex;
            align-items: flex-start;
        }

        .receipts {
            display: flex;
            width: 100%;
            border: 1px solid #c9c3a6;
            position: relative; /* cut line + seal er jonno must */
        }

        /* ---------- One Receipt ---------- */
        .receipt {
            width: 50%;
            height: 122mm;
            background: #f4f0dc;
            padding: 5mm 6mm 4mm;
            position: relative;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            right: 52mm;
            top: 68mm;
            width: 42mm;
            opacity: .07;
        }

        /* ---------- Cut line ---------- */
        .cut-line {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            border-left: 1.5px dashed #6b7280;
            z-index: 5;
        }

        .cut-line span {
            position: absolute;
            top: 3mm;
            left: -9px;
            background: #f4f0dc;
            font-size: 14px;
            line-height: 1;
            color: #374151;
            transform: rotate(90deg);
            padding: 1px 0;
        }

        /* ---------- Round seal (majh borabor) ---------- */
        .seal {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 46mm;
            height: 46mm;
            transform: translate(-50%, -50%) rotate(-8deg);
            z-index: 10;
            opacity: .8;
            mix-blend-mode: multiply;
            pointer-events: none;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1.5px solid #cfc9a8;
            padding-bottom: 3mm;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 2mm;
        }

        .brand img {
            width: 11mm;
            height: 11mm;
            object-fit: contain;
        }

        .brand-name {
            font-family: Arial Black, Arial, sans-serif;
            font-weight: 800;
            font-size: 12pt;
            color: #7b2d2d;
            line-height: 1;
            letter-spacing: .3px;
        }

        .brand-address {
            font-family: Arial, sans-serif;
            font-size: 5.2pt;
            color: #222;
            margin-top: 1mm;
        }

        .garden-box {
            width: 34mm;
            border: 1.2px solid #444;
            background: #fff;
            font-family: Arial, sans-serif;
        }

        .garden-title {
            font-weight: bold;
            font-size: 8.5pt;
            text-align: center;
            padding: 1mm 0;
            border-bottom: 1.2px solid #444;
            color: #5a2222;
        }

        .garden-body {
            height: 8mm;
            font-size: 7pt;
            text-align: center;
            padding-top: 2mm;
        }

        /* No / Title / Date */
        .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4mm;
        }

        .meta-no {
            font-size: 8pt;
            display: flex;
            align-items: baseline;
            gap: 3mm;
        }

        .meta-no strong {
            font-size: 15pt;
            font-weight: normal;
            letter-spacing: 1px;
        }

        .title {
            font-style: italic;
            font-weight: bold;
            font-size: 12pt;
            color: #7b2d2d;
        }

        .date-wrap {
            display: flex;
            align-items: center;
            gap: 1.5mm;
            font-size: 8pt;
        }

        .date-boxes {
            display: flex;
            border: 1px solid #c7c2a6;
            background: #faf8ec;
        }

        .date-boxes span {
            min-width: 9mm;
            height: 6.5mm;
            line-height: 6.5mm;
            text-align: center;
            font-size: 8.5pt;
            border-right: 1px solid #c7c2a6;
        }

        .date-boxes span:last-child {
            border-right: 0;
            min-width: 13mm;
        }

        /* Lines */
        .lines {
            margin-top: 2mm;
            margin-bottom: 2mm;
        }

        .row {
            display: flex;
            align-items: flex-end;
            font-size: 8pt;
            margin-bottom: 3.6mm;
            min-height: 5mm;
        }

        .label {
            white-space: nowrap;
            padding-right: 1mm;
        }

        .fill {
            flex: 1;
            border-bottom: 1px dotted #444;
            padding: 0 1.5mm 0.3mm;
            font-family: Arial, sans-serif;
            font-size: 8pt;
            font-weight: bold;
            color: #111;
            min-height: 4.5mm;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .fill.small {
            flex: 0 0 24mm;
        }

        .gap {
            width: 3mm;
        }

        /* Amount */
        .tk-box {
            display: flex;
            width: 65mm;
            height: 8mm;
            border: 1.5px solid #222;
            background: #fff;
            margin-top: 1mm;
        }

        .tk-label {
            width: 11mm;
            font-weight: bold;
            font-size: 12pt;
            padding: 0.5mm 2mm;
            border-right: 1.5px solid #222;
        }

        .tk-value {
            flex: 1;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 11pt;
            padding: 1.5mm 2mm;
        }

        /* Signature */
        .signatures {
            position: absolute;
            left: 6mm;
            right: 6mm;
            bottom: 4mm;
            display: flex;
            justify-content: space-between;
            font-size: 8pt;
        }

        .sign {
            border-top: 1px solid #333;
            padding-top: 0.8mm;
            min-width: 26mm;
            text-align: center;
        }

        .copy-tag {
            position: absolute;
            right: 6mm;
            top: 1.2mm;
            font-family: Arial, sans-serif;
            font-size: 5pt;
            color: #8a8a8a;
        }

        @media print {
            body { background: #fff; }
            .toolbar { display: none !important; }

            .sheet {
                margin: 0;
                padding: 0;
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>

<div class="toolbar">
    <button class="btn-print" onclick="window.print()">🖨 Print</button>
    <a class="btn-back" href="{{ route('admin.land-share-payments.index') }}">← Back</a>
</div>

@php
    $client     = $payment->client;
    $sale       = $payment->landShareSale;
    $date       = $payment->payment_date;
    $purpose    = $payment->remarks ?: 'Installment';
    $throughTxt = $methodLabel
        . ($payment->cheque_no ? ' / Cheque No: ' . $payment->cheque_no : '')
        . ($payment->transaction_no ? ' / Trx: ' . $payment->transaction_no : '');
    $customerId = $client->client_code ?? $client->id ?? '';
    $address    = $client->address ?? $client->present_address ?? '';
    $copies     = ['Customer Copy', 'Office Copy'];
@endphp

<div class="sheet">
    <div class="receipts">

        @foreach($copies as $copy)
        <div class="receipt">
            <span class="copy-tag">{{ $copy }}</span>
            <img class="watermark" src="{{ asset('assets/images/logo333.png') }}" alt="">

            {{-- Header --}}
            <div class="header">
                <div>
                    <div class="brand">
                        <img src="{{ asset('assets/images/logo333.png') }}" alt="logo">
                        <div class="brand-name">SAFE COMMUNITY GROUP</div>
                    </div>
                    <div class="brand-address">
                        Anowar Plaza (2<sup>nd</sup> Floor), Mintu Chattar, Matuail, Demra, Dhaka. Cell : 01713 167754, 01713 878824
                    </div>
                </div>

                <div class="garden-box">
                    <div class="garden-title">SAFE GARDEN</div>
                    <div class="garden-body">{{ $payment->project?->project_name }}</div>
                </div>
            </div>

            {{-- No / Title / Date --}}
            <div class="meta">
                <div class="meta-no">
                    No. <strong>{{ $payment->receipt_no }}</strong>
                </div>

                <div class="title">Money Receipt</div>

                <div class="date-wrap">
                    Date :
                    <div class="date-boxes">
                        <span>{{ $date?->format('d') }}</span>
                        <span>{{ $date?->format('m') }}</span>
                        <span>{{ $date?->format('Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Fields --}}
            <div class="lines">

                <div class="row">
                    <span class="label">Mr./Mrs./Miss. :</span>
                    <span class="fill">{{ $client?->name }}</span>
                </div>

                <div class="row">
                    <span class="label">Address :</span>
                    <span class="fill">{{ $address }}</span>
                </div>

                <div class="row">
                    <span class="label">Customer ID. No. :</span>
                    <span class="fill">{{ $customerId }}{{ $sale?->sale_code ? ' (' . $sale->sale_code . ')' : '' }}</span>
                </div>

                <div class="row">
                    <span class="label">Purpose (Booking/Down Payment/Inst/Others) :</span>
                    <span class="fill">{{ $purpose }}</span>
                </div>

                <div class="row">
                    <span class="label">Through Cash/RTGS/NPSB/EFTN/PO/Online/Cheque No. :</span>
                    <span class="fill">{{ $throughTxt }}</span>
                    <span class="label" style="padding-left:2mm">Date :</span>
                    <span class="fill small">{{ $date?->format('d/m/Y') }}</span>
                </div>

                <div class="row">
                    <span class="label">Bank :</span>
                    <span class="fill">{{ $payment->bank_name }}</span>
                    <span class="gap"></span>
                    <span class="label">Branch :</span>
                    <span class="fill small"></span>
                </div>

                <div class="row">
                    <span class="label">In words :</span>
                    <span class="fill">{{ $amountInWords }}</span>
                </div>

                <div class="tk-box">
                    <div class="tk-label">Tk.</div>
                    <div class="tk-value">{{ number_format((float) $payment->amount, 2) }}</div>
                </div>

            </div>

            {{-- Signatures --}}
            <div class="signatures">
                <div class="sign">Received By</div>
                <div class="sign">Authorized by</div>
            </div>

        </div>
        @endforeach

        {{-- Cut line --}}
        <div class="cut-line"><span>✂</span></div>

        {{-- Round Seal (50% left + 50% right) --}}
        <svg class="seal" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <path id="sealTop" d="M 32,100 A 68,68 0 0 1 168,100"/>
                <path id="sealBottom" d="M 16,100 A 84,84 0 0 0 184,100"/>
            </defs>

            <g fill="none" stroke="#4338a8">
                <circle cx="100" cy="100" r="96" stroke-width="3"/>
                <circle cx="100" cy="100" r="90" stroke-width="1"/>
                <circle cx="100" cy="100" r="60" stroke-width="2"/>
            </g>

            <g fill="#4338a8" font-family="Arial Black, Arial, sans-serif" font-weight="900">
                <text font-size="17" letter-spacing="5" text-anchor="middle">
                    <textPath href="#sealTop" startOffset="50%">SAFE</textPath>
                </text>
                <text font-size="13" letter-spacing="2" text-anchor="middle">
                    <textPath href="#sealBottom" startOffset="50%">COMMUNITY GROUP</textPath>
                </text>
                <text x="16" y="106" font-size="14" text-anchor="middle">★</text>
                <text x="184" y="106" font-size="14" text-anchor="middle">★</text>
            </g>

            <image href="{{ asset('assets/images/logo333.png') }}"
                   x="68" y="68" width="64" height="64"
                   preserveAspectRatio="xMidYMid meet"/>
        </svg>

    </div>
</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(function () { window.print(); }, 500);
    });
</script>

</body>
</html>