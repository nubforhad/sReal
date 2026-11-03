
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Building Information - {{ $building->building_name }}</title>

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
    width: 100%;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 9px;
    line-height: 1.25;
    color: #222;
}

.print-container {
    width: 100%;
    max-width: 194mm;
    margin: 0 auto;
    padding: 0;
}

/* Header */
.print-header {
    text-align: center;
    border-bottom: 1.5px solid #222;
    padding-bottom: 5px;
    margin-bottom: 9px;
}

.print-header h2 {
    font-size: 16px;
    margin: 0 0 3px;
}

.print-header p {
    font-size: 9px;
    margin: 2px 0;
}

/* Document title */
.document-title {
    text-align: center;
    margin-bottom: 9px;
}

.document-title h3 {
    display: inline-block;
    font-size: 12px;
    border: 1px solid #333;
    padding: 4px 15px;
    margin: 0;
}

/* Sections */
.section {
    margin-bottom: 7px;
}

.section-title {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    padding: 4px 6px;
    font-size: 9px;
    font-weight: bold;
    margin: 0;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

td {
    border: 1px solid #d1d5db;
    padding: 4px 6px;
    font-size: 9px;
    overflow-wrap: anywhere;
    vertical-align: middle;
}

td:first-child {
    width: 28%;
    font-weight: bold;
    background: #fafafa;
}

/* Image */
.building-image {
    max-width: 100px;
    max-height: 65px;
    object-fit: contain;
    display: block;
}

/* Signature */
.signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
}

.signature {
    width: 30%;
    border-top: 1px solid #222;
    text-align: center;
    padding-top: 4px;
    font-size: 9px;
}

/* Print button */
.print-actions {
    text-align: center;
    margin-bottom: 15px;
}

.print-button {
    background: #2563eb;
    color: white;
    padding: 8px 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

@media screen {
    body {
        background: #e5e7eb;
        padding: 15px;
    }

    .print-container {
        background: white;
        padding: 8mm;
        box-shadow: 0 2px 10px rgba(0,0,0,.12);
    }
}

@media print {
    html,
    body {
        width: 100%;
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        font-size: 8px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-container {
        width: 100%;
        max-width: none;
        margin: 0;
        padding: 0;
        box-shadow: none;
    }

    .print-actions {
        display: none !important;
    }

    .section-title,
    td:first-child {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .section,
    .signature-section {
        page-break-inside: auto;
        break-inside: auto;
    }
}

  </style>
  

</head>

<body>

<div class="print-container">

    <div class="print-actions">
        <button class="print-button" onclick="window.print()">
            Print Building Information
        </button>
    </div>

    <div class="print-header">
        <h2>{{ $building->company?->name ?? 'Company Name' }}</h2>

        <p>{{ $building->branch?->name ?? 'Branch Name' }}</p>

        <p>
            Project:
            {{ $building->project?->project_name ?? 'N/A' }}
        </p>
    </div>

    <div class="document-title">
        <h3>BUILDING INFORMATION</h3>
    </div>

    {{-- Building Overview --}}
    <div class="section">
        <h4 class="section-title">1. Building Overview</h4>

        <table>
            <tr>
                <td>Building Name</td>
                <td>{{ $building->building_name }}</td>
            </tr>
            <tr>
                <td>Building Code</td>
                <td>{{ $building->building_code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Building Type</td>
                <td>{{ $building->building_type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Number of Floors</td>
                <td>{{ $building->number_of_floors ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Basements</td>
                <td>{{ $building->number_of_basements ?? 0 }}</td>
            </tr>
            <tr>
                <td>Total Flats</td>
                <td>{{ $building->total_flats ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ ucfirst(str_replace('_', ' ', $building->status)) }}</td>
            </tr>
        </table>
    </div>

    {{-- Project Information --}}
    <div class="section">
        <h4 class="section-title">2. Project Information</h4>

        <table>
            <tr>
                <td>Project Name</td>
                <td>{{ $building->project?->project_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Project Code</td>
                <td>{{ $building->project?->project_code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Company</td>
                <td>{{ $building->company?->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Branch</td>
                <td>{{ $building->branch?->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- RAJUK Approval --}}
    <div class="section">
        <h4 class="section-title">3. RAJUK Approval Information</h4>

        <table>
            <tr>
                <td>Application No</td>
                <td>{{ $building->rajukApproval?->application_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Approval Number</td>
                <td>{{ $building->rajukApproval?->approval_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Applicant Name</td>
                <td>{{ $building->rajukApproval?->applicant_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Approval Date</td>
                <td>{{ $building->rajukApproval?->approval_date?->format('d M Y') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Plan Type</td>
                <td>{{ $building->rajukApproval?->plan_type ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- Construction Details --}}
    <div class="section">
        <h4 class="section-title">4. Construction Details</h4>

        <table>
            <tr>
                <td>Construction Start</td>
                <td>{{ $building->construction_start_date?->format('d M Y') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Expected Completion</td>
                <td>{{ $building->expected_completion_date?->format('d M Y') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Actual Completion</td>
                <td>{{ $building->actual_completion_date?->format('d M Y') ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- Contractor Information --}}
    <div class="section">
        <h4 class="section-title">5. Contractor & Technical Team</h4>

        <table>
            <tr>
                <td>Contractor Name</td>
                <td>{{ $building->contractor_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Contractor Phone</td>
                <td>{{ $building->contractor_phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Architect Name</td>
                <td>{{ $building->architect_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Engineer Name</td>
                <td>{{ $building->engineer_name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- Description --}}
    @if($building->description)
        <div class="section">
            <h4 class="section-title">6. Description</h4>

            <table>
                <tr>
                    <td>{{ $building->description }}</td>
                </tr>
            </table>
        </div>
    @endif

    {{-- Building Image --}}
    @if($building->building_image)
        <div class="section">
            <h4 class="section-title">7. Building Image</h4>

            <table>
                <tr>
                    <td>
                        <img
                            src="{{ asset('storage/' . $building->building_image) }}"
                            class="building-image"
                            alt="Building Image"
                        >
                    </td>
                </tr>
            </table>
        </div>
    @endif

    {{-- Signature --}}
    <div class="signature-section">
        <div class="signature">
            Prepared By
        </div>

        <div class="signature">
            Authorized Signature
        </div>
    </div>

</div>

</body>
</html>
