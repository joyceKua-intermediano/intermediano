<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <link rel="stylesheet" href="css/contract.css">
</head>

@php

$companyName = $record->company->name;
$companyContactName = $record->companyContact->contact_name;
$companyContactSurname = $record->companyContact->surname;
$companyAddress = $record->company->address;

$companyPhone = $record->companyContact->phone ?? 'N/A';
$companyEmail = $record->companyContact->email ?? 'N/A';
$companyCountry = $record->company->country ?? 'N/A';
$companyTaxId = $record->company->tax_id ?? 'NA';

$employeeName = $record->employee->name;
$employeeJobTitle = $record->job_title ?? 'N/A';
$employeeCountryWork = $record->country_work ?? 'N/A';
$employeeGrossSalary = $record->gross_salary;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$quotationDate = $record->quotation->title;
$signatureExists = Storage::disk('private')->exists($record->signature);
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name ?? '';
$adminSignedByPosition = $adminSignedBy === 'Fernando Guiterrez' ? 'CEO' : ($adminSignedBy === 'Paola Mac Eachen' ? 'VP' : 'Legal Representative');
$user = auth()->user();
$isAdmin = $user instanceof \App\Models\User;
$type = $isAdmin ? 'admin' : 'employee';
@endphp

<style>
    .main-container {
        text-align: justify;
        padding-left: 50px;
        padding-right: 50px;
    }

    .clause-header {
        margin-top: 20px
    }

    .clause-header span {
        text-decoration: underline
    }

    p {
        line-height: 1.5 !important;
        font-size: 12px
    }

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4 style='text-align:center;  margin: 20px 0px'> ADDENDUM 2025.01</h4>
        <h4 style='text-align:center; t'> TO THE PARTNERSHIP AGREEMENT </h4>
        <p>This Addendum to the Service Agreement ("Agreement") signed on March 23rdof 2022 and following the
            Amendment #1 signed on January 14th of 2025, is entered into on <b>{{ $quotationDate }}</b>, by
            and between:</p>

        <p><b>GATE INTERMEDIANO INC.</b>, initially referred as INTERMEDIANO INC. (the “Provider”) a Canadian company
            with its principal place of business at 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada,
            duly represented by its legal representative; AND <b>{{ $companyName }}</b> (the
            “Customer”), with its principal place of business at {{ $companyCountry }}, and holding offices at {{ $companyAddress }}, duly represented by its authorized representative, (each, a “Party “and together, the
            “Parties”).</p>

        <h4 style='text-align:center; t'> SCHEDULE B</h4>
        <p><b>A) WORKER DETAILS:</b></p>
        <p><b>NAME OF WORKER:</b> {{ $employeeName }}</p>
        <p><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
        <p><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
        <p><b>START DATE:</b> {{ $employeeStartDate }}</p>
        <p><b>END DATE:</b> {{ $employeeEndDate }}</p>
        <p><b>GROSS WAGES:</b> {{ $employeeGrossSalary }}</p>
        <br>
        <p><b>DATE OF PAYMENT (every month):</b> Local legislation requires payment by the last day of the worked month.
            For efficiency, Provider will issue payment on the last day of every month. </p>

        <p><b>LOCAL PAYMENT CONDITIONS:</b> Salaries and/or any other remuneration is set at the local currency of the
            Country where services is provided. </p>
        <br>
        <p><b>B) FEES AND PAYMENT TERMS: </b></p>
        <h4 style='text-align:center; t'> PAYMENT TERMS </h4>

        <p><b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below: </p>
        <p>The Customer pays the Provider a monthly fee based on the calculations below:
        </p>

        @include('pdf.contract.layout.footer')
    </main>



    @include('pdf.contract.layout.header')
    <main class="main-container" style='page-break-after: avoid'>
        <div style="margin-top: -30px !important">
            @include('pdf.hong_kong_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>

        <p>In addition to the monthly fee, there may be additional costs required by law in the Country where the
            Services are being rendered. Additional costs may apply in the following cases that Provider cannot
            anticipate or predict, as following:</p>
        <p>(i) Additional bonuses awarded by the Customer’s client; OR </p>
        <p>(ii) Any eventual local Government measures </p>
        <p><b>C) LOCAL LEGISLATION - PREVAILS </b></p>
        <p>The law that will govern the Worker’s engagement including their rights as an employee will be the law of
            the country where the Worker is providing the services. The Parties agree that all applicable law including
            but not limited to, labor and tax, and must be fully complied with the purposes of the local and global
            compliance guidelines. </p>
        <br>
        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none;">
            <tr style="border: none;">

                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>GATE INTERMEDIANO INC.</h4>
                    <div style="text-align: center; position: relative; height: 100px;">
                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        @endif
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="margin-top: -30px; text-align: center;"> {{ $adminSignedBy }}</p>
                    <p style="margin-top: -15px; text-align: center;"> {{ $adminSignedByPosition }}</p>
                </td>
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>{{ $companyName }}</h4>
                    @if($signatureExists)
                    <div style="text-align: center; position: relative; height: 100px">
                        <img src="{{ $is_pdf ? storage_path('app/private/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                    </div>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-top: 40px;">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black"></div>

                    <p style="margin-top: -30px;  text-align: center;">{{ $companyContactName }} </p>
                    <p style="margin-top: -15px;  text-align: center;"> Authorized Responsible </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')

    </main>

</body>
</html>
