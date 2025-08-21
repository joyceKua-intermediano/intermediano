<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <link rel="stylesheet" href="css/contract.css">
</head>

@php
$contractCreatedDay = $record->created_at->format('jS');
$contractCreatedmonth = $record->created_at->format('F');
$contractCreatedyear = $record->created_at->format('Y');
$companyName = $record->company->name;
$companyContactName = $record->companyContact->contact_name;
$companyContactSurname = $record->companyContact->surname;
$companyAddress = $record->company->address;

$companyPhone = $record->companyContact->phone;
$companyEmail = $record->companyContact->email;
$companyCountry = $record->company->country;
$companyTaxId = $record->company->tax_id ?? 'NA';

$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->country ?? 'N/A';
$employeeState = $record->personalInformation->state ?? 'N/A';
$employeeCivilStatus = $record->personalInformation->civil_status ?? 'N/A';
$employeeJobTitle = $record->job_title ?? 'N/A';
$employeeCountryWork = $record->country_work ?? 'N/A';
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? 'N/A';
$employeeEmail = $record->employee->email ?? 'N/A';
$employeeAddress = $record->personalInformation->address ?? 'N/A';
$employeeCity = $record->personalInformation->city ?? 'N/A';
$employeeDateBirth = $record->personalInformation->date_of_birth ?? 'N/A';
$employeePhone = $record->personalInformation->phone ?? 'N/A';
$employeeMobile = $record->personalInformation->mobile ?? 'N/A';
$employeeCountry = $record->personalInformation->country ?? 'N/A';
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
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
        line-height: 1.5 !important
    }

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4 style='text-align:center; text-decoration: underline; margin: 20px 0px'> SERVICES AGREEMENT</h4>
        <p>This Services Agreement ("Agreement") signed and entered into on {{ $contractCreatedDay }} of {{ $contractCreatedmonth }}, {{ $contractCreatedyear }}, by and between: </p>
        <p><b>GATE INTERMEDIANO INC.</b>, initially referred as
            INTERMEDIANO INC. (the <b>“Provider”</b>) a
            Canadian company with its principal place of
            business at 4388 Rue Saint-Denis Suite200 #763,
            Montreal, QC H2J 2L1, Canada, duly
            represented by its legal representative; AND
            <b>{{ $companyName }} </b> (the <b>“Customer”</b>), a
            {{ $companyCountry }} company, enrolled
            under the fiscal registration number
            {{ $companyTaxId }}, located at
            {{ $companyAddress }}, {{ $companyCountry }}, duly represented by its
            authorized representative, (each, a “Party”
            and together, the “Parties”). </p>
        <p><b>WHEREAS,</b> in the event of any discrepancies
            between the terms and conditions of the
            Agreement and the Freelance Vendor T&C,
            the terms and conditions of this Agreement
            shall prevail and supersede; </p>

        <p><b>NOW, THEREFORE,</b> in consideration of the
            mutual covenants and agreements contained
            herein, the Parties hereby agree as follows: </p>

        <p><b>1) Introduction and Scope of Services:</b>
        </p>
        <p><b>1.1 Scope of Services:</b></p>
        <p>The scope of services to be provided by the Provider to the Customer shall include staffing services support, with the specifics subject to variation based on the Customer's requirements. </p>
        <p><b>1.2 Service Details: </b></p>
        <p>Detailed descriptions of the services to be
            rendered shall be outlined in Appendices A
            and B of this Agreement.</p>
        <p><b>1.3 Indemnification Clause:</b></p>
        <p>The Parties agree that any liability and/or
            indemnification arising from the services and
            activities performed under this Agreement
            shall rest solely with the Subcontractor
            engaged by the Provider. The Provider shall
            bear no liability and is fully released from any
            indemnification obligations to the Customer.</p>
        <p><b>1.4 Subcontracting Authorization:</b></p>
        <p>The Customer acknowledges and hereby formally and expressly grants the Provider authorization to subcontract the services described herein. </p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>1.5 Term:</b></p>
        <p>This Agreement shall become effective as of the date of Customer´s registration as account holder with OneForma, and shall continue in effect until terminated by mutual agreement between both Parties or by either as per Section 1.6 below. </p>
        <p><b>1.6 Termination </b></p>
        <p><b>1.6.1 Termination with Notice:</b></p>
        <p>Either Party may terminate this Agreement by providing the other Party with no less than thirty (30) days' prior written notice of its intention to terminate. </p>
        <p><b>1.6.2 Termination for Default:</b></p>
        <p>Either Party may terminate this Agreement immediately, without prior notice, in the event that the other Party is in default of any of its obligations under this Agreement. Such termination shall be effective upon the defaulting Party's receipt of written notice specifying the nature of the default. </p>
        <p>Upon termination of this Agreement, all rights and obligations of the Parties shall cease, except for any rights and obligations that have accrued prior to the effective date of termination, and any obligations that expressly survive the termination of this Agreement. </p>
        <p><b>2) Entire Agreement:
            </b></p>
        <p>This Agreement, along with its Appendices, represents the entire understanding between the Parties regarding the subject matter herein and supersedes all prior discussions, agreements, and understandings, whether oral or written, including the aforementioned Freelance Vendor T&C. </p>
        <p style=' text-align: center;'> <b style="text-decoration: underline;">SCHEDULE A</b></p>

        <p>Scope of Services / General Scope</p>
        <p>Customer will request staffing support from provider based on Customer’s Client’s requirements. When Customer requests staffing support, Provider will present candidates to Customer subject to final approval by
            Customer’s Client.
        </p>
        <p>Payroll Outsourcing Service </p>
        <p>At Customer’s request, Provider will take whatever steps are necessary under local law to become the employer of record for candidates approved by Customer’s Client or its subcontractor. By law, those individuals will be independent consultants (“freelancers”) or employees of Provider or from its subcontractor (“Workers”) for either an indefinite or definite period. In case of subcontracting a partner for the service, all indemnification responsibilities will be assumed by the subcontractor of the Provider. </p>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p>Provider or subcontractor will place the Workers on engagement with Customer’s Client pursuant to Customer’s instructions. Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be included in the costs. </p>
        <p>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances. </p>
        <p>Provider’s fee for its Payroll Outsourcing Service shall be 4.5% over the total gross earnings of the Freelancer and 32% of the Worker´s hourly rates including all taxes for Canada. Once the Customer confirms the Project and Rates, the Provider will issue a SOW detailing the costs for each case and that SOW will be integral part of this agreement. </p>
        <p><b>Staffing Service </b></p>
        <p>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. Fees for Contract Staffing will be agreed upon in writing on a case-by-case basis. </p>
        <p style='line-height: 1.5; text-align: center; font-weight: bold'>SCHEDULE B</p>

        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>A) WORKER DETAILS:</b> {{ $employeeName }}</p>
        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>START DATE:</b> {{ $employeeStartDate }}</p>
        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>END DATE:</b> {{ $employeeEndDate }}</p>
        <p style="margin: 5; padding: 0; line-height: 1.5;"><b>GROSS WAGES:</b> CAD {{ number_format($employeeGrossSalary, 2) }} as Gross Monthly Salary.</p>
        <br>
        <b style="text-decoration: underline; ">PAYMENT METHOD: </b>
        <p>Every 25th the Provider will submit the worked hours in the month and the Customer shall approve on the same day. Provider will issue an invoice based on it and Customer shall pay on the 10th of the following month to the latest. If payment is not processed in time, there will be a fine of 2% per month. </p>

        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container">
        <b style="text-decoration: underline;">LOCAL PAYMENT CONDITIONS:</b>
        <p>Salaries and/or any other remuneration is set at the local currency of the Country where services is provided. </p>
        <b style="text-decoration: underline;">B) FEES AND PAYMENT TERMS:</b>
        <p style='font-weight: bold'>PAYMENT TERMS</p>
        <p><b>FEES:</b> Customer shall pay the Provider in a
            monthly basis, based on the calculation
            below:</p>
        <div style="margin-top: -20px !important">
            @include('pdf.canada_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container" style='page-break-after: avoid'>
        <p style="text-align: center"><b>Worked Hours x Gross Hourly Rate </b></p>
        <p>Payments can be made by a banking wire transfer or using platforms but regardless of the method, the funds should clear on Provider´s </p>
        <p>Payments can be made by a banking wire
            transfer or using platforms but regardless of
            the method, the funds should clear on
            Provider´s bank account on the 10th of the
            following month when the services have been
            provided.</p>
        <p>In addition to the monthly fee, there may be
            additional costs required by law in the
            Country where the Services are being
            rendered. Additional costs may apply in the
            following cases that Provider cannot
            anticipate or predict, as following:</p>
        <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR</p>
        <p><b>(ii)</b> Any eventual local Government measures.</p>
        <b style="text-decoration: underline;">C) LOCAL LEGISLATION - PREVAILS</b>
        <p>The law that will govern this Service Agreement as well as the Worker’s engagement including their rights as an employee will be the law of the Province of Quebec in Canada where the Worker is providing the services. The Parties agree that all applicable law including but not limited to, labor and tax, and must be fully complied with the purposes of the local and global compliance guidelines. This Service Agreement replaces any other agreement and shall prevail over all other jurisdictions. </p>
        <div style="text-align: center; margin-top: 20px;">
            <b>GATE INTERMEDIANO INC.</b>
        </div>
        <br><br>
        <div style="text-align: center; position: relative; height: 50px;">
            @if($adminSignatureExists)
            <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 15%; left: 50%; transform: translateX(-50%);" />
            @endif
        </div>

        <div style="width: 80%; border-bottom: 1px solid black; text-align: center; margin: 0 auto;"></div>
        @if (!empty($adminSignedBy))
        <p style="text-align: center; margin-top: -20px">{{ $adminSignedBy }}</p>
        <p style="text-align: center;margin-top: -20px">{{ $adminSignedByPosition }}</p>
        @endif

        <p style="text-align: left;margin-top: -10px">Phone: +1 514 907 5393</p>
        <p style="text-align: left;margin-top: -10px">Email: <a href="">sac@intermediano.com</a></p>

        <div style="text-align: center; margin-top: 20px;">
            <b>{{ $companyName }}</b>
        </div>
        <br><br>
        @if($signatureExists)
        <div style="text-align: center; margin-top: 0px">
            <img src="{{ $is_pdf ? storage_path('app/private/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="Signature" style="height: 50px; margin: 0px 0;">
        </div>
        @else
        <div style="text-align: center; margin-top: 0px">
            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px">
        </div>
        @endif

        <div style="width: 80%; border-bottom: 1px solid black; text-align: center; margin: 0 auto;"></div>
        <p style="text-align: center; margin-top: -20px">{{ $companyContactName }} {{ $companyContactSurname }}</p>
        <p style="text-align: center; margin-top: -20px">Name of the legal representative</p>
        <p style="text-align: left;margin-top: -10px">Phone: {{ $companyPhone }}</p>
        <p style="text-align: left;margin-top: -10px">Email: <a href="">{{ $companyEmail }}</a></p>
        @include('pdf.contract.layout.footer')
    </main>





</body>
</html>
