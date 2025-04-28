<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <link rel="stylesheet" href="css/contract.css">
</head>

@php
$formattedDate = now()->format('jS');
$month = now()->format('F');
$year = now()->format('Y');
$currentDate = now()->format('[d/m/Y]');

$employeeName = $record->employee->name;
$employeeJobTitle = $record->job_title ?? null;
$employeeCountryWork = $record->country_work ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$quotationDate = $record->quotation->title;

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
            duly represented by its legal representative; AND <b>WMBE PAYROLLING INC. DBA TCW Global</b> (the
            “Customer”), with its principal place of business at United States and holding offices at 3545 Aero Ct, San
            Diego, CA 92123, USA, duly represented by its authorized representative, (each, a “Party “and together, the
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

        @include('pdf.contract.layout.canada_footer')
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

                <td style="width: 40%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>GATE INTERMEDIANO INC.</h4>
                    <div style="text-align: center; margin-top: 0px">
                        <img src="{{ public_path('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="margin-top: -30px; text-align: center;"> Fernando Gutierrez </p>
                    <p style="margin-top: -15px; text-align: center;"> CEO</p>
                </td>
                <td style="width: 60%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>WMBE PAYROLLING INC. DBA TCW Global </h4>
                    <div style="width: 100%; border-bottom: 1px solid black; margin-top: 60px"></div>

                    <p style="margin-top: -30px;  text-align: center;"> Sarah Love </p>
                    <p style="margin-top: -15px;  text-align: center;"> Authorized Responsible </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.canada_footer')

    </main>

</body>
</html>
