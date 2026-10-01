<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        RAJUK Approval - {{ $rajukApproval->application_no ?: 'Details' }}
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            font-size: 10px;
        }

        .page {
            width: 190mm;
            min-height: 277mm;
            margin: 10mm auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 7px;
            margin-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 3px 0 0;
            font-size: 9px;
            color: #4b5563;
        }

        .top-row {
            display: table;
            width: 100%;
            margin-bottom: 7px;
        }

        .top-left,
        .top-right {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
        }

        .top-right {
            text-align: right;
        }

        .label {
            color: #6b7280;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .value {
            margin-top: 2px;
            font-size: 10px;
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 4px 9px;
            border: 1px solid #9ca3af;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
        }

        .section {
            border: 1px solid #d1d5db;
            margin-bottom: 7px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #f3f4f6;
            border-bottom: 1px solid #d1d5db;
            padding: 5px 7px;
            font-size: 10px;
            font-weight: 700;
        }

        .section-body {
            padding: 6px 7px;
        }

        .grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .col {
            display: table-cell;
            vertical-align: top;
            padding-right: 8px;
        }

        .col:last-child {
            padding-right: 0;
        }

        .col-2 {
            width: 50%;
        }

        .col-3 {
            width: 33.333%;
        }

        .col-5 {
            width: 20%;
        }

        .item {
            margin-bottom: 4px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .remarks {
            min-height: 35px;
            white-space: pre-line;
            line-height: 1.4;
        }

        .documents {
            display: table;
            width: 100%;
        }

        .document {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .document-name {
            font-weight: 600;
        }

        .document-status {
            color: #4b5563;
            font-size: 9px;
        }

        .footer {
            margin-top: 10px;
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }

        .print-button {
            position: fixed;
            top: 15px;
            right: 15px;
            padding: 9px 16px;
            border: 0;
            border-radius: 6px;
            background: #111827;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        @media print {

            html,
            body {
                width: 210mm;
                background: #fff !important;
            }

            .page {
                width: 190mm;
                min-height: auto;
                margin: 0;
            }

            .print-button {
                display: none !important;
            }

            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <button class="print-button" onclick="window.print()">
        Print
    </button>

    <div class="page">

        {{-- Header --}}
        <div class="header">

            <h1>RAJUK APPROVAL DETAILS</h1>

            <p>
                Real Estate Management System
            </p>

        </div>

        {{-- Top Information --}}
        <div class="top-row">

            <div class="top-left">

                <div class="label">
                    Application No.
                </div>

                <div class="value">
                    {{ $rajukApproval->application_no ?: 'N/A' }}
                </div>

            </div>

            <div class="top-right">

                <span class="status">
                    {{ ucwords(str_replace('_', ' ', $rajukApproval->status)) }}
                </span>

            </div>

        </div>


        {{-- Company / Branch / Project --}}
        <div class="section">

            <div class="section-title">
                Company, Branch & Project
            </div>

            <div class="section-body">

                <div class="grid">

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Company</div>

                            <div class="value">
                                {{ $rajukApproval->company->name ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Branch</div>

                            <div class="value">
                                {{ $rajukApproval->branch->name ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Project</div>

                            <div class="value">
                                {{ $rajukApproval->project->project_name ?? 'N/A' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Applicant --}}
        <div class="section">

            <div class="section-title">
                Applicant Information
            </div>

            <div class="section-body">

                <div class="grid">

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Applicant Name</div>

                            <div class="value">
                                {{ $rajukApproval->applicant_name ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Phone</div>

                            <div class="value">
                                {{ $rajukApproval->applicant_phone ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Approval Number</div>

                            <div class="value">
                                {{ $rajukApproval->approval_number ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Land Information --}}
        <div class="section">

            <div class="section-title">
                Land Information
            </div>

            <div class="section-body">

                <div class="grid">

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Plot No.</div>
                            <div class="value">
                                {{ $rajukApproval->plot_number ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Road No.</div>
                            <div class="value">
                                {{ $rajukApproval->road_number ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Block</div>
                            <div class="value">
                                {{ $rajukApproval->block ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Mouza</div>
                            <div class="value">
                                {{ $rajukApproval->mouza ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Land Area</div>
                            <div class="value">
                                {{ $rajukApproval->land_area ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Building Information --}}
        <div class="section">

            <div class="section-title">
                Building Information
            </div>

            <div class="section-body">

                <div class="grid">

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Plan Type</div>
                            <div class="value">
                                {{ $rajukApproval->plan_type ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Floors</div>
                            <div class="value">
                                {{ $rajukApproval->number_of_floors ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Flats</div>
                            <div class="value">
                                {{ $rajukApproval->number_of_flats ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Architect</div>
                            <div class="value">
                                {{ $rajukApproval->architect_name ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-5">

                        <div class="item">
                            <div class="label">Consultant</div>
                            <div class="value">
                                {{ $rajukApproval->consultant_name ?: 'N/A' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Dates --}}
        <div class="section">

            <div class="section-title">
                Application Timeline
            </div>

            <div class="section-body">

                <div class="grid">

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Application Date</div>

                            <div class="value">
                                {{ $rajukApproval->application_date?->format('d M Y') ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Submission Date</div>

                            <div class="value">
                                {{ $rajukApproval->submission_date?->format('d M Y') ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="col col-3">

                        <div class="item">
                            <div class="label">Approval Date</div>

                            <div class="value">
                                {{ $rajukApproval->approval_date?->format('d M Y') ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Documents --}}
        <div class="section">

            <div class="section-title">
                Documents
            </div>

            <div class="section-body">

                <div class="documents">

                    <div class="document">

                        <div class="document-name">
                            Plan Document
                        </div>

                        <div class="document-status">

                            @if($rajukApproval->plan_document)
                                Uploaded
                            @else
                                Not uploaded
                            @endif

                        </div>

                    </div>


                    <div class="document">

                        <div class="document-name">
                            Approval Document
                        </div>

                        <div class="document-status">

                            @if($rajukApproval->approval_document)
                                Uploaded
                            @else
                                Not uploaded
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Remarks --}}
        <div class="section">

            <div class="section-title">
                Remarks
            </div>

            <div class="section-body">

                <div class="remarks">
                    {{ $rajukApproval->remarks ?: 'No remarks available.' }}
                </div>

            </div>

        </div>


        {{-- Footer --}}
        <div class="footer">

            Printed on
            {{ now()->format('d M Y h:i A') }}

        </div>

    </div>

</body>

</html>