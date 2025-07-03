<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    @if($is_pdf)
    <link rel="stylesheet" href="css/contract.css">

    @else
    <link rel="stylesheet" href="{{ asset('css/contract.css') }}">
    @endif
</head>

@php
$formattedDate = now()->format('jS');
$month = now()->format('F');
$year = now()->format('Y');
$currentDate = now()->format('[d/m/Y]');
$companyName = $record->company->name;
$companyTaxId = $record->company->tax_id;
$companyCountry = $record->company->country;
$companyAddress = $record->company->address;
$companyCity = $record->company->city;
$companyState = $record->company->state;

$contactName = $record->companyContact->contact_name;
$contactSurname = $record->companyContact->surname;

$customerPhone = $record->companyContact->phone;
$customerEmail = $record->companyContact->email;
$customerName = $record->companyContact->contact_name;
$customerPosition = $record->companyContact->position;
$customerTranslatedPosition = $record->translatedPosition;
$employeeCity = $record->personalInformation->city ?? null;

$employeeName = $record->employee->name;
$employeeCountryWork = $record->country_work;
$employeeJobTitle = $record->job_title;
$employeeStartDate = \Carbon\Carbon::parse($record->start_date)->format('d m Y');
$employeeEndDate = \Carbon\Carbon::parse($record->end_date)->format('d m Y');
$employeeGrossSalary = $record->gross_salary;
$employeeJobDescription = $record->job_description;
$signaturePath = 'signatures/employee/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('private')->exists($signaturePath);
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name;

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
        line-height: 1.5;
    }

    .non-pdf p {
        line-height: 1.7 !important;
    }

    .non-pdf .clause-header b span {
        margin-bottom: 20px !important;
    }

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <h4 style='text-align:center; text-decoration: underline; margin: 20px 0px'> SERVICE AGREEMENT</h4>

        <p> This Service Agreement (the "Agreement") is made on [DATE] (the "Effective Date"), by
            and between INTERMEDIANO HONG KONG LIMITED, a Hong Kong company, enrolled
            under the registration number 77682459, located at Flat A11/F. Cheung Lung Ind Bldg 10
            CheungYeeST,CheungShaWan,HongKong,herein referred to simply as (the"Provider");
            AND <b>{{ $companyName }}</b>, a company duly incorporated with {{ $companyTaxId }} under the laws of {{ $companyCountry }} and holding offices at {{ $companyAddress }}, {{ $companyCity }}, {{ $companyState }}, {{ $companyCountry }},
            herein referred to simply as (the "Provider").</p>


        <p><b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services globally
            either directly or indirectly through its local partners;</p>

        <p><b>WHEREAS</b> Customer wishes to obtain the services and Provider wishes to provide the
            services on the terms and conditions set forth herein</p>
        <p><b>WHEREAS</b> services will be provided by Provider in {{ $companyCountry }}.</p>
        <p> WHEREAS Provider will directly render services</p>
        <p><b>NOW, THEREFORE</b>, in consideration of the premises and the mutual covenants set forth
            herein, the parties hereby agree as follows:</p>

        <p>Provider and Customer hereinafter jointly referred to as "Parties" and individually a "Party";</p>

        <p> The Parties decide to enter into the present Services Agreement ("Agreement"), which shall be governed by the following terms and conditions:</p>


        <p class='clause-header'><b><span>PURPOSE</span></b></p>
        <p><b>Service Offerings.</b> Provider shall provide to Customer the services of payroll, consulting and
            HR attached hereto as Schedule A (the "Schedule A") and incorporated herein
            (collectively, the "Services"), during the Term (defined in Section VIII) subject to the terms
            and conditions of this Agreement.</p>

        <p class='clause-header'><b><span> PROVIDER RESPONSIBILITIES</span></b></p>
        <p> Notwithstanding the other obligations under this Agreement, the Provider; hereby
            undertakes to:</p>

        <p> to meet the requirements and quality standards required by Customer, which may
            periodically review the Services performed by the Provider;</p>

        <p> to collect all taxes related to its activities, considering each different local law, rules, and
            compliance demand;</p>
        <p> to provide, whenever customer requests it, all reports, spreadsheets, and other information
            relating to the Services and its country local aspects;</p>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <p> to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms
            andother provisions considered by law concerning the provision of the service and labour
            matters, in particular, but not limited to, those related to the protection of the environment,
            exempting Customer from any responsibility resulting therefrom. Therefore, the Provider
            declares in this Agreement that its activities and services, used now and in the future,
            comply with the legislation and protection and safety standards concerning sanitation
            and environment.</p>


        <p class='clause-header'><b> <span> CUSTOMER RESPONSABILITIES:</span></b></p>
        <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby
            undertakes to:</p>

        <p> to process the monthly payment to the Provider set forth in <b>Schedule B</b> (the "Schedule B"),
            following strictly the local labour legislation, considering where the service is being
            provided to supply the technical information required for the Services to be performed;
        </p>
        <p class='clause-header'><b> <span> PAYMENT AND FEES:</span></b></p>
        <p> For the Services agreed herein, Customer shall pay to the Provider the amount set forth
            and described in <b>Schedule B.</b></p>

        <p> Each Party shall pay all taxes, charges, fees and social contributions due in terms of their
            activities and / or contractual obligations.</p>
        <p class='clause-header'><b> <span> CONFIDENTIALITY</span></b></p>
        <p> Both parties agree to endeavour to take all reasonable measures to keep in confidence
            the execution, terms and conditions as well as performance of this Agreement, and the
            confidential data and information of any party that another party may know or access
            during performance of this Agreement (hereinafter referred to as "Confidential
            Information"), and shall not disclose, make available or assign such Confidential
            Information to any third party without the prior written consent of the party providing the
            information.</p>
        <p> Information received by aParty which: (i) is information of general or public knowledge; (ii)
            has beenpreviously approved or consented to in writing, generally and without restriction,
            by the Party from which the information originates; and/or (iii) has been requested by a
            competent administrative or judicial authority, shall not be covered by the confidentiality
            obligation provided herein. In the latter case, the Party receiving such a request shall
            inform the other Party as promptly as possible and provided that the nature of the
            administrative or judicial proceedings so permits.</p>

        <p> During the term of this Agreement and for a period of five (5) years after its termination,
            bothParties undertake to maintain the most complete and absolute confidentiality on any
            information.</p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <p class='clause-header'> <b> <span>GDPR DATA PROTECTION</span> </b></p>
        <p> Any information containing personal data shall be handled in accordance with all
            applicable privacy laws and regulations, including without limitation the GDPR
            REGULATION (EU) 2016/679 OF THE EUROPEAN PARLIAMENT AND OF THE COUNCIL) of April
            27th., 2016 and equivalent laws and regulations. If for the performance of the services it is
            necessary to exchangepersonaldata,therelevant Parties shall determine their respective
            positions towards each other (either as controller, joint controllers or processor) and the
            subsequent consequences and responsibilities according to the GDPR as soon as possible
            after the Effective Date.</p>


        <p class='clause-header'> <b><span>INTELLECTUAL AND INDUSTRIAL PROPERTY</span></b></p>
        <p>Every document, report, data, know-how, method, operation, design, trademarks
            confidential information, patents and any other information provided by Customer to the
            Provider shall be and remain exclusive property of the Customer that have disclosed the
            information.</p>

        <p> After the termination or the expiry hereof, neither Party shall use trademarks or names that
            maybelikethoseoftheotherPartyand/ormaysomewhatbeconfusedbycustomersand
            companies. Each Party undertakes to use its best efforts to avoid mistakes or improper
            disclosure of the trademarks and names of the other Parties by unauthorized people.</p>

        <p class='clause-header'> <b> <span>TERM AND TERMINATION</span></b></p>
        <p> This Agreement shall be in force and remain valid from the date of signature for
            undetermined period. Each of the Parties is free to terminate this Agreement at any time
            without cause by previous written notice of 30 (thirty) days.</p>
        <p> The Agreement maybeterminated for justified cause regardless of any previous notice, in
            the occurrence of the following events by the Parties:</p>
        <p> consecutives delays or failure to comply by Customer with the payments due to the
            Provider remuneration or repeated non-delivery or late delivery of the Services by the
            Provider;</p>
        <p> if any party breaches any term or condition of this Agreement and fails to remedy to such
            failure within five (5) days from the date of receipt of written notification from the other
            party, in this sense;</p>
        <p> If either party becomes or is declared insolvent or bankrupt, is the subject of any
            proceedings relating to its liquidation or insolvency or for the appointment of a receiver,
            conservator, or similar officer, or makes an assignment for the benefit of all or substantially</p>
        <p> all of its creditors or enters into any agreement for the composition, extension, or
            readjustment of all or substantially all of its obligations, then the other party may, by giving
            prior written notice thereof to the non-terminating party, terminate this Agreement as of a
            date specified in such notice;</p>

        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <p> Upon termination of this Agreement or at its termination, Provider undertakes to:
        </p>
        <p> return to Customer the day of termination of this Agreement, all equipment, promotional
            material, and other documents which have been provided by Customer in relation to the
            Services agreed upon in this Agreement.</p>

        <p> respect and comply with all Service requests forwarded by Customer before the date of
            expiration or early termination of this Agreement;</p>

        <p class='clause-header'> <b> <span> ACT OF GOD OR FORCE MAJEURE</span></b></p>
        <p> In the event either Party is unable to perform its obligations under the terms of this
            Agreement because of acts of God or force majeure, such party shall not be liable for
            damagesto the other for any damages resulting from such failure to perform or otherwise
            from such causes.</p>

        <p class='clause-header'> <b> <span>GENERAL PROVISIONS</span></b></p>
        <p> Changes– Any changes or inclusions to this Agreement shall be made with the mutual
            consent of the Parties and in writing and consider any local mandatory local rule.</p>
        <p> Independence– In case any provision in this Agreement shall be invalid, illegal or
            unenforceable, the validity, legality and enforceability of the remaining provisions shall not
            in any waybeaffected or impaired thereby and such provision shall be ineffective only to
            the extent of such invalidity, illegality or unenforceability.</p>
        <p> Transfer– this Agreement may not be transferred or assigned in whole or in part by either
            Party without the prior written consent of the other Party.</p>
        <p> Entire Agreement– This Agreement contains the entire agreement and understanding
            among the parties hereto with respect to the subject matter hereof, and supersedes all
            prior and contemporaneous agreements, understandings, inducements, and conditions,
            express or implied, oral or written, of any nature whatsoever with respect to the subject
            matter hereof. The express termshereof control and supersede any course of performance
            and/or usage of the trade inconsistent with any of the terms hereof.</p>
        <p>Tolerance and Absence of Waiver and Novation. The tolerance of any failure to fulfill, even
            if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds
            that anyprovision or article of this Agreement isnull, void, or without any binding effect, the
            rest of this Contract will remain in full force and effect as if such provision or part had not
            integrated this Agreement.</p>
        <p> Succession - This Agreement binds the Parties and their respective successors, particulars
            and universals, authorized assignees and legal representatives.</p>
        @include('pdf.contract.layout.footer')

    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <p> Communication between the Parties- All warnings, communications, notifications and
            mailing resulting from the performance of this Agreement shall be done in writing, with
            receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by
            registry at the Registry of Deeds and Documents, and will only be valid when directed and
            delivered to the Parties at the addresses indicated below in accordance with the
            applicable law</p>


        <b>If to Customer:</b>
        <p><b>A/C:</b> Fernando Gutierrez</p>
        <p><b>Address: </b>Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong</p>
        <p><b>Phone:</b> +1 514 907 5393</p>
        <p><b> E-mail:</b> sac@intermediano.com</p>

        <b style='margin-top:30px'>If to Provider:</b>
        <p>
            <b> A/C:</b>
            {{ $contactName }} {{ $contactSurname }}
        </p>
        <p>
            <b> Address:</b> {{ $companyAddress }} {{ $companyCity }} {{ $companyState }} {{ $companyCountry }}
        </p>
        <p> <b> Phone:</b> {{ $customerPhone }}</p>
        <p> <b> E-mail:</b> {{ $customerEmail }}</p>

        <p class='clause-header'> <b> <span>JURISDICTION</span></b></p>

        <p> The parties elect the courts of Hong Kong, to settle any doubts and/or disputes arising out
            of this instrument, with the exclusion of any other jurisdiction, as privileged as it may be, and
            the applicable law shall be of Hong Kong.</p>
        <p> The full text of this contract, as well as the documents derived from it, including the
            Annexes, have been drawn up in the English, being considered official.</p>
        <p> In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and
            content, for one sole purpose.</p>
        <p> Hong Kong, {{ $currentDate }}</p>
        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>INTERMEDIANO HONG KONG LIMITED</h4>

                    <div style="text-align: center; position: relative; height: 100px;">
                        @if($adminSignatureExists)
                        <img src="{{ $is_pdf 
        ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
        : url('/signatures/' . $type. '/' . $record->id . '/admin') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />


                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>


                        <p style="position: absolute; bottom: -25px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ \Carbon\Carbon::parse($record->admin_signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 1000; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $adminSignedBy }}</p>
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                    </div>


                </td>
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>{{ $companyName }}</h4>
                    <div style="display: inline-block; position: relative; height: 100px; width: 100%;">
                        @if($signatureExists)
                        <img src="{{ $is_pdf
            ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
            : url('/signatures/' . $type. '/' . $record->employee_id . '/employee') }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -25px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 1000; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $employeeName }}</p>

                    </div>

                </td>
            </tr>
        </table>

        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <h4 style='text-align:center; margin: 20px 0px'> ANNEX I</h4>
        <h4 style='text-align:center;'> Services </h4>
        <div>
            <p style="margin: 0 0 2px;"><b>Consultant:</b> {{ $employeeName }}</p>
            <p style="margin: 0 0 2px;"><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
            <p style="margin: 0 0 2px;"><b>START DATE:</b> {{ $employeeStartDate }}</p>
            <p style="margin: 0 0 2px;"><b>END DATE:</b> {{ $employeeEndDate }}</p>
            <p style="margin: 0 0 2px;"><b>Job description:</b> {!! $employeeJobDescription !!}</p>

        </div>
        @include('pdf.contract.layout.footer')

    </main>


    @include('pdf.contract.layout.header')

    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}" style='page-break-after: avoid'>
        <h4 style='text-align:center; margin: 20px 0px'> ANNEX II</h4>
        <div>
            <b>PRICE:</b>
            <p> The amount to be paid is of {{ $employeeGrossSalary }} dollars (USD).</p>
            <p> Every month Provider shall submit the time sheet duly approved by the End Client.</p>
            <p> The Customer shall pay the corresponding approved fees to Provider until the last day of
                the following worked month by Provider.</p>
            <p> The total tax payment for the Agreement is the responsibility of the Provider.</p>
            <p> Payments to be processed to the bank account informed by Provider</p>
        </div>
        @include('pdf.contract.layout.footer')

    </main>

</body>
</html>
