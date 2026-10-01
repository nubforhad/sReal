<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Land Registration - {{ $landRegistration->registration_code ?? 'Print' }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            font-size: 10px;
            line-height: 1.25;
        }

        .print-wrapper {
            width: 100%;
            max-width: 194mm;
            margin: 0 auto;
        }

        /* =========================
           PRINT BUTTON
        ========================= */

        .print-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-bottom: 8px;
        }

        .print-btn,
        .back-btn {
            border: none;
            padding: 7px 14px;
            border-radius: 4px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }

        .print-btn {
            background: #2563eb;
        }

        .back-btn {
            background: #475569;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 7px;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .document-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .document-code {
            font-size: 9px;
            color: #475569;
            margin-top: 2px;
        }

        /* =========================
           SECTION
        ========================= */

        .section {
            margin-bottom: 7px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #e5e7eb;
            border: 1px solid #9ca3af;
            padding: 4px 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        /* =========================
           GRID
        ========================= */

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 12px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 4px 10px;
        }

        .field {
            display: flex;
            min-height: 16px;
            border-bottom: 1px dotted #cbd5e1;
            padding-bottom: 2px;
        }

        .label {
            font-weight: 700;
            width: 40%;
            flex-shrink: 0;
        }

        .value {
            width: 60%;
            word-break: break-word;
        }

        /* =========================
           TABLE
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }

        th,
        td {
            border: 1px solid #9ca3af;
            padding: 4px 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f1f5f9;
            font-weight: 700;
        }

        /* =========================
           REMARKS
        ========================= */

        .remarks {
            border: 1px solid #9ca3af;
            min-height: 32px;
            padding: 5px;
            word-break: break-word;
        }

        /* =========================
           SIGNATURE
        ========================= */

        .signature-area {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 22px;
            page-break-inside: avoid;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #111827;
            margin-bottom: 4px;
        }

        .signature-title {
            font-weight: 700;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;
            font-size: 8px;
            color: #64748b;
            margin-top: 8px;
        }

        /* =========================
           PRINT SETTINGS
        ========================= */

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .print-wrapper {
                width: 194mm;
                max-width: 194mm;
                margin: 0 auto;
            }

            .print-actions {
                display: none !important;
            }

            .section,
            .header,
            .signature-area {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            table {
                page-break-inside: avoid !important;
            }

            tr {
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>

<body>

<div class="print-wrapper">

    {{-- PRINT BUTTONS --}}
    <div class="print-actions">
        <a href="{{ url()->previous() }}" class="back-btn">
            Back
        </a>

        <button onclick="window.print()" class="print-btn">
            Print
        </button>
    </div>


    {{-- =========================
        HEADER
    ========================== --}}

    <div class="header">

        <div class="company-name">
            {{ $landRegistration->company?->name ?? 'Company Name' }}
        </div>

        <div>
            {{ $landRegistration->branch?->name ?? '' }}
        </div>

        <div class="document-title">
            Land Registration
        </div>

        <div class="document-code">
            Registration Code:
            {{ $landRegistration->registration_code ?? 'N/A' }}
        </div>

    </div>


    {{-- =========================
        REGISTRATION INFORMATION
    ========================== --}}

    <div class="section">

        <div class="section-title">
            Registration Information
        </div>

        <div class="grid-3">

            <div class="field">
                <div class="label">Registration Code</div>
                <div class="value">
                    {{ $landRegistration->registration_code ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Deed No</div>
                <div class="value">
                    {{ $landRegistration->deed_no ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Date</div>
                <div class="value">
                    {{ $landRegistration->registration_date
                        ? \Carbon\Carbon::parse($landRegistration->registration_date)->format('d-m-Y')
                        : 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Sub Registry</div>
                <div class="value">
                    {{ $landRegistration->sub_registry_office ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Status</div>
                <div class="value">
                    {{ ucfirst($landRegistration->status ?? 'N/A') }}
                </div>
            </div>

            <div class="field">
                <div class="label">Registration Cost</div>
                <div class="value">
                    {{ number_format((float) ($landRegistration->registration_cost ?? 0), 2) }}
                </div>
            </div>

            <div class="field">
                <div class="label">Other Cost</div>
                <div class="value">
                    {{ number_format((float) ($landRegistration->other_cost ?? 0), 2) }}
                </div>
            </div>

            <div class="field">
                <div class="label">Total Cost</div>
                <div class="value">
                    {{ number_format(
                        (float) ($landRegistration->registration_cost ?? 0)
                        + (float) ($landRegistration->other_cost ?? 0),
                        2
                    ) }}
                </div>
            </div>

            <div class="field">
                <div class="label">Project</div>
                <div class="value">
                    {{ $landRegistration->project?->project_name ?? 'N/A' }}
                </div>
            </div>

        </div>

    </div>


    {{-- =========================
        CLIENT INFORMATION
    ========================== --}}

    <div class="section">

        <div class="section-title">
            Client Information
        </div>

        <div class="grid-3">

            <div class="field">
                <div class="label">Client ID</div>
                <div class="value">
                    {{ $landRegistration->client_id ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Client Name</div>
                <div class="value">
                    {{ $landRegistration->client?->name ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Phone</div>
                <div class="value">
                    {{ $landRegistration->client?->phone ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Email</div>
                <div class="value">
                    {{ $landRegistration->client?->email ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Sale Code</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->sale_code ?? 'N/A' }}
                </div>
            </div>

        </div>

    </div>


    {{-- =========================
        LAND INFORMATION
    ========================== --}}

    <div class="section">

        <div class="section-title">
            Land Information
        </div>

        <div class="grid-3">

            <div class="field">
                <div class="label">Land Name</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->land_name ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Land Code</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->land_code ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">District</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->district ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Upazila</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->upazila ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Mouza</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->mouza ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Khatian</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->khatian ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Dag</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->dag ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">JL No</div>
                <div class="value">
                    {{ $landRegistration->landShareSale?->land?->jl_no ?? 'N/A' }}
                </div>
            </div>

            <div class="field">
                <div class="label">Registered Size</div>
                <div class="value">
                    {{ $landRegistration->registered_land_size ?? 'N/A' }}
                    {{ $landRegistration->landShareSale?->land?->unit ?? '' }}
                </div>
            </div>

        </div>

    </div>


    {{-- =========================
        LAND SHARE SALE
    ========================== --}}

    <div class="section">

        <div class="section-title">
            Land Share Sale & Payment
        </div>

        <table>

            <thead>
                <tr>
                    <th>Sale Code</th>
                    <th>Share Price</th>
                    <th>Total Paid</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $sale = $landRegistration->landShareSale;

                    $totalPaid = $sale?->payments?->sum('amount') ?? 0;

                    $salePrice = (float) ($sale?->land_share_price ?? 0);
                @endphp

                <tr>
                    <td>
                        {{ $sale?->sale_code ?? 'N/A' }}
                    </td>

                    <td>
                        {{ number_format($salePrice, 2) }}
                    </td>

                    <td>
                        {{ number_format($totalPaid, 2) }}
                    </td>

                    <td>
                        {{ $salePrice > 0 && $totalPaid >= $salePrice
                            ? 'Fully Paid'
                            : 'Pending' }}
                    </td>
                </tr>

            </tbody>

        </table>

    </div>


    {{-- =========================
        REMARKS
    ========================== --}}

    <div class="section">

        <div class="section-title">
            Remarks
        </div>

        <div class="remarks">
            {{ $landRegistration->remarks ?? 'No remarks available.' }}
        </div>

    </div>


    {{-- =========================
        SIGNATURE
    ========================== --}}

    <div class="signature-area">

        <div class="signature">

            <div class="signature-line"></div>

            <div class="signature-title">
                Client Signature
            </div>

        </div>

        <div class="signature">

            <div class="signature-line"></div>

            <div class="signature-title">
                Authorized Signature
            </div>

        </div>

    </div>


    <div class="footer">
        Printed on {{ now()->format('d-m-Y h:i A') }}
    </div>

</div>

</body>
</html>