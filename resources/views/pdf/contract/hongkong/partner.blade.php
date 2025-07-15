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
$contractCreatedDate = (new DateTime($record->created_at))->format('[m/d/Y]');

$partnerName = $record->partner->partner_name ?? $record->intermedianoCompany->name;
$partnerTaxId = $record->partner->tax_id ?? $record->intermedianoCompany->tax_id;
$partnerCountry = $record->partner->country->name ?? $record->intermedianoCompany->country->name;
$partnerAddress = $record->partner->address ?? $record->intermedianoCompany->address;

$partnerContactName = $record->partner->contact_name ?? $record->intermedianoCompany->contact_name;

$partnerPhone = $record->partner->mobile_number ?? $record->intermedianoCompany->mobile_number;
$partnerEmail = $record->partner->email ?? $record->intermedianoCompany->email;

$employeeName = $record->employee->name;
$employeeCountryWork = $record->country_work;
$employeeJobTitle = $record->job_title;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$employeeGrossSalary = $record->gross_salary;
$signatureExists = Storage::disk('public')->exists($record->signature);
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

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4 style='text-align:center; text-decoration: underline; margin: 20px 0px'> SERVICE AGREEMENT</h4>

        <p>This Payroll and HR Service Agreement (the “Agreement”) is made on <b>{{ $contractCreatedDate }}</b> (the
            “Effective Date”), by and between <b>INTERMEDIANO HONG KONG LIMITED</b> (the “Provider”),
            enrolled under the registration number 77682459, located at Flat A11/F. Cheung Lung Ind
            Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong, duly represented by its legal
            representative; AND <b>{{ $partnerName }}</b> (the “Customer”), a company duly
            incorporated with {{ $partnerTaxId }} under the laws of {{ $partnerCountry }} and holding
            offices at {{ $partnerAddress }}.</p>
        <p> <b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services; and</p>
        <p><b>WHEREAS</b> Customer wishes to obtain the services and Provider wishes to provide the services on the terms and conditions set forth herein</p>
        <p> <b>WHEREAS</b> services will be provided by Provider in {{ $partnerCountry }}</p>
        <p> <b>WHEREAS</b> Provider will render directly</p>
        <p> <b>NOW, THEREFORE</b>, in consideration of the premises and the mutual covenants set forth herein, the parties hereby agree as follows:</p>
        <p> Provider and Customer hereinafter jointly referred to as "Parties" and individually a "Party";</p>
        <p> The Parties decide to enter into the present Services Agreement (“Agreement”), which shall be governed by the following terms and conditions:</p>

        <p class='clause-header'><b> I. <span>PURPOSE</span> </b></p>
        <p> Service Offerings. <b>Provider shall provide to Customer the services of payroll, consulting and</b>
            HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein
            (collectively, the “Services”), during the Term (defined in Section VII) subject to the terms
            and conditions of this Agreement.</p>
        <p class='clause-header'><b> II. <span>PROVIDER RESPONSIBILITIES</span> </b></p>
        <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby
            undertakes to:</p>

        <p><b>a)</b> to meet the requirements and quality standards required by Customer, which may
            periodically review the Services performed by the Provider;</p>
        <p><b>b)</b> to collect all taxes related to its activities, considering each different local law, rules and
            compliance demand;</p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>c)</b> to provide, whenever customer requests it, all reports, spreadsheets and other information relating to the Services and its country local aspects;</p>
        <p><b>d)</b> to comply with all global and local laws, decrees, regulations, resolutions, decisions,
            norms and other provisions considered by law concerning the provision of the service and
            labor matters, in particular, but not limited to, those related to the protection of the
            environment, exempting Customer from any responsibility resulting therefrom. Therefore,
            the Provider declares in this Agreement that its activities and services, used now and in the
            future, comply with the legislation and protection and safety standards concerning
            sanitation and environment;</p>

        <p class='clause-header'><b> III. <span>CUSTOMER RESPONSABILITIES</span></b></p>
        <p> Notwithstanding the other obligations under this Agreement, the Customer, hereby
            undertakes to:</p>

        <p><b>a)</b> to process the monthly payment to the Provider set forth in Schedule B (the “Schedule
            B”), following strictly the local labor legislation, considering where the service is being
            provided</p>
        <p><b>b)</b> to supply the technical information required for the Services to be performed;
        </p>
        <p class='clause-header'> <b> IV. <span>PAYMENT AND FEES</span></b></p>
        <p><b>a)</b> For the Services agreed herein, Customer shall pay to the Provider the amount set forth
            and described in Schedule B.</p>
        <p><b>b)</b> EachParty shall pay all taxes, charges, fees and social contributions due in terms of their
            activities and / or contractual obligations.</p>
        <p class='clause-header'> <b> V. <span>CONFIDENTIALITY</span></b></p>
        <p> <b>a)</b> Both parties agree to endeavor to take all reasonable measures to keep in confidence
            the execution, terms and conditions as well as performance of this Agreement, and the
            confidential data and information of any party that another party may know or access
            during performance of this Agreement (hereinafter referred to as “Confidential
            Information”), and shall not disclose, make available or assign such Confidential
            Information to any third party without the prior written consent of the party providing the
            information.</p>
        <p> <b>b)</b> Information received by a Party which: (i) is information of general or public knowledge;
            (ii) has been previously approved or consented to in writing, generally and without
            restriction, by the Party from which the information originates; and/or (iii) has been
            requested by acompetent administrative or judicial authority, shall not be covered by the
            confidentiality obligation provided herein. In the latter case, the Party receiving such a request shall inform the other Party as promptly as possible and provided that the nature of
            the administrative or judicial proceedings so permits.</p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">

        <p> <b>c)</b> During the term of this Agreement and for a period of five (5) years after its termination,
            bothParties undertake to maintain themostcompleteandabsoluteconfidentiality onany
            information.</p>

        <p class='clause-header'> <b>VI.GDPR DATA PROTECTION</b></p>
        <p> Any information containing personal data shall be handled in accordance with all
            applicable privacy laws and regulations, including without limitation the GDPR
            REGULATION (EU) 2016/679 OF THE EUROPEAN PARLIAMENT AND OF THE COUNCIL) of April
            27th., 2016 and equivalent laws and regulations. If for the performance of the services it is
            necessary to exchangepersonaldata,therelevant Parties shall determine their respective
            positions towards each other (either as controller, joint controllers or processor) and the
            subsequent consequences and responsibilities according to the GDPR as soon as possible
            after the Effective Date.</p>

        <p class='clause-header'><b> VII. <span>INTELLECTUAL AND INDUSTRIAL PROPERTY</span></b> </p>
        <p> <b>a)</b> Every document, report, data, know-how, method, operation, design, trademarks
            confidential information, patents and any other information provided by Customer to the
            Provider shall be and remain exclusive property of the Customer that have disclosed the
            information.</p>


        <p><b>b)</b> After the termination or the expiry hereof, neither Party shall use trademarks or names
            that may be similar to those of the other Party and/or may somewhat be confused by
            customers and companies. Each Party undertakes to use its best efforts to avoid mistakes
            or improper disclosure of the trademarks and names of the other Parties by unauthorized
            people.</p>

        <p class='clause-header'> <b>VIII. <span>TERM AND TERMINATION</span></b></p>

        <p>This Agreement shall be in force and remain valid from the date of signature for
            undetermined period. Each of the Parties is free to terminate this Agreement at any time
            without cause by previous written notice of 30 (thirty) days.</p>
        <p>The Agreement maybeterminated for justified cause regardless of any previous notice, in
            the occurrence of the following events by the Parties:</p>

        <p><b>a)</b> consecutives delays or failure to comply by Customer with the payments due to the
            Provider remuneration or repeated non-delivery or late delivery of the Services by the
            Provider;</p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>b)</b> if any party breaches any term or condition of this Agreement and fails to remedy to
            such failure within five (5) days from the date of receipt of written notification from the
            other party, in this sense;</p>

        <p> <b>c)</b> If either party becomes or is declared insolvent or bankrupt, is the subject of any
            proceedings relating to its liquidation or insolvency or for the appointment of a receiver,
            conservator, or similar officer, or makes an assignment for the benefit of all or substantially
            all of its creditors or enters into any agreement for the composition, extension, or
            readjustment of all or substantially all of its obligations, then the other party may, by giving
            prior written notice thereof to the non-terminating party, terminate this Agreement as of a
            date specified in such notice;</p>

        <p> Upon termination of this Agreement or at its termination, Provider undertakes to:</p>

        <p> <b>a)</b> return to Customer the day of termination of this Agreement, any and all equipment,
            promotional material, and other documents which have been provided by Customer in
            relation to the Services agreed upon in this Agreement; as well as any compensation
            defined as cash advanced, among which is: deposit or guarantee, unsatisfied provisions,
            etc., deducted from the expenses actually incurred.</p>
        <p> <b>b)</b> respect and comply with all Service requests forwarded by Customer before the date of
            expiration or early termination of this Agreement;</p>
        <p class='clause-header'> <b>IX. <span>ACT OF GOD OR FORCE MAJEURE</span></b></p>
        <p> In the event either Party is unable to perform its obligations under the terms of this
            Agreement because of acts of God or force majeure, such party shall not be liable for
            damagesto the other for any damages resulting from such failure to perform or otherwise
            from such causes.</p>
        <p class='clause-header'> <b>X.<span> GENERAL PROVISIONS</span></b></p>
        <p><b>(a)</b> Changes– Anychanges or inclusions to this Agreement shall be made with the mutual
            consent of the Parties and in writing and consider any local mandatory local rule.</p>
        <p><b>(b)</b> Independence– In case any provision in this Agreement shall be invalid, illegal or
            unenforceable, the validity, legality and enforceability of the remaining provisions shall not
            in any waybeaffected or impaired thereby and such provision shall be ineffective only to
            the extent of such invalidity, illegality or unenforceability.</p>
        <p><b>(c)</b> Transfer–this Agreement maynotbetransferred orassignedinwholeorinpartbyeither
            Party without the prior written consent of the other Party.</p>

        @include('pdf.contract.layout.footer')

    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(d)</b> Entire Agreement– This Agreement contains the entire agreement and understanding
            among the parties hereto with respect to the subject matter hereof, and supersedes all
            prior and contemporaneous agreements, understandings, inducements and conditions,
            express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express termshereof control and supersede any course of performance
            and/or usage of the trade inconsistent with any of the terms hereof.</p>

        <p><b>(e)</b> Tolerance and Absence of Waiver and Novation. The tolerance of any failure to fulfill,
            evenif repeated, by anyParty, the provisions of this Agreement does not constitute or shall
            not be interpreted as a waiver by the other Party or as novation. If any court or tribunal
            finds that any provision or article of this Agreement is null, void, or without any binding
            effect, the rest of this Contract will remain in full force and effect as if such provision or part
            had not integrated this Agreement.</p>

        <p><b>(f)</b> Succession- This Agreement binds the Parties and their respective successors, particulars
            and universals, authorized assignees and legal representatives.</p>

        <p><b>(g)</b> Communication between the Parties- All warnings, communications, notifications and
            mailing resulting from the performance of this Agreement shall be done in writing, with
            receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by
            registry at the Registry of Deeds and Documents, and will only be valid when directed and
            delivered to the Parties at the addresses indicated below in accordance with the
            applicable law</p>
        <b>If to Provider:</b>
        <b> A/C: Fernando Gutierrez</b>
        <p><b>Address: </b>Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong</p>
        <p><b>Phone:</b> +1 514 907 5393</p>
        <p><b> E-mail:</b> sac@intermediano.com</p>

        <b style='margin-top:30px'>If to Customer:</b>
        <p>
            <b> A/C:</b>
            {{ $partnerName }}
        </p>
        <p>
            <b> Address:</b> {{ $partnerAddress }}
        </p>
        <p> <b> Phone:</b> {{ $partnerPhone }}</p>
        <p> <b> E-mail:</b> {{ $partnerEmail }}</p>




        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container'>
        <p class='clause-header'> <b>XI.<span> JURISDICTION</span></b></p>
        <p>The parties elect the courts of Hong Kong to settle any doubts and/or disputes arising out of
            this instrument, with the exclusion of any other jurisdiction, as privileged as it may be and
            the applicable law shall be of Hong Kong.</p>

        <p>The full text of this contract, as well as the documents derived from it, including the
            Annexes, have been drawn up in the English, being considered official.</p>

        <p> In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and
            content, for one sole purpose.</p>

        <p> Hong Kong, {{ $contractCreatedDate }}</p>

        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>INTERMEDIANO HONG KONG LIMITED</h4>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;" />

                        @else
                        <div style="text-align: center; margin-top: 0px">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px">
                        </div>
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);"> {{ $adminSignedBy }}</p>
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                    </div>

                </td>
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>{{ $partnerName }}</h4>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? storage_path('app/private/signatures/clients/partner_' . $record->partner_id . '.webp')
                                : url('/signatures/customer/' . $record->partner_id . '/partner') . '?v=' . filemtime(storage_path('app/private/signatures/clients/partner_' . $record->partner_id . '.webp')) 
                        }}" alt="Employee Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;" />
                        @else
                        <div style="text-align: center; position: relative; height: 100px;">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;">
                        </div>
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $partnerContactName }}</p>
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                    </div>


                </td>
            </tr>
        </table>

        <h4 style='text-align:center; margin: 20px 0px'> SCHEDULE A</h4>
        <h4 style='text-align:center;'> Scope of Services / General Scope </h4>
        <p> Customer will either (a) present individuals to Provider that Customer’s Clients would like to
            engage, or (b) request staffing support from provider based on Customer’s Client’s
            requirements. When Customer requests staffing support, Provider will present candidates
            to Customer subject to final approval by Customer’s Client.</p>
        <p><b> Payroll Outsourcing Service</b></p>
        <p> At Customer’s request, Provider will take whatever steps are necessary under local law to
            become the employer of record for candidates approved by Customer’s Client. By law,
            those individuals will be employees of Provider (“Workers”) for either an indefinite or
            definite period. Provider will place the Workers on engagement with Customer’s Client
            pursuant
            to
            Customer’s
            instructions.
            Provider will manageall legal, fiscal, administrative, and similar employer obligations under
            local law. That includes, but is not limited to, executing aproper employmentcontract with
            the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate
            wages,collecting/remitting social charges and tax or the like as required by local law, and
            offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring
            process such as background checks shall be charged separately by Provider, and
            payment shall be equally made as stated in clause.</p>
        @include('pdf.contract.layout.footer')

    </main>


    @include('pdf.contract.layout.header')

    <main class='main-container'>
        <p> Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s
            Client/Worker and the Provider as it relates to any pay rate changes, reimbursement
            needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker
            are informed of any local legal nuances.</p>
        <p> Provider’s fee for its Payroll Outsourcing Service shall be 12% over the total gross earnings of
            the Worker´s for the related countries: Chile, Colombia, Costa Rica, Peru and Uruguay,
            considered a minimum fee of USD350,00. For other Countries not listed herein, shall be
            checked case by case. Provider shall invoice the EOR service fees as a separate line item
            on each invoice.</p>

        <p><b> Staffing Service</b></p>

        <p> At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to
            Customer’s Client’s requirements as communicated by Customer and following the local
            legislation. Provider will present such candidates to Customer subject to final approval by
            Customer’s Client.</p>
        <p> In the event that Provider presents the same candidate to Customer as another vendor,
            the search firm that presented the candidate to Customer first shall be deemed to have
            made the placement. Timing will be determined based on the time of receipt by
            Customer.</p>
        <p> Once a candidate is approved by Customer’s Client, Provider may either be asked to
            provide its EOR service for that individual (“Contract Staffing”) or Customer’s Client will
            elect to employ the individual themselves or through another vendor (“Direct Hire”).
            Fees for Contract Staffing will be agreed upon in writing on a case-by-case basis.
            In all Direct Hire cases, Customer will pay Provider a placement fee of 18% of that Direct
            Hire’s gross annual salary. Such fee is subject to Customer’s Client (or a vendor) issuing a
            formal job offer and the candidate accepting the same. If the candidate resigns or
            Customer’s Client terminates the engagement for any reason within the first 90 (ninety)
            days, Provider will replace the Direct Hire individual at no cost, Provider will replace the
            direct hire, at no recruiting cost, as far the recruitment has been done by the Provider. In
            this case, Customer shall pay for all termination cost related the Worker.</p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container'>
        <h4 style='text-align: center'> SCHEDULE B</h4>
        <div>
            <p style="margin: 0 0 2px;"><b>A) WORKER DETAILS:</b></p>
            <p style="margin: 0 0 2px;"><b>NAME OF WORKER:</b> {{ $employeeName }}</p>
            <p style="margin: 0 0 2px;"><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
            <p style="margin: 0 0 2px;"><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
            <p style="margin: 0 0 2px;"><b>START DATE:</b> {{ $employeeStartDate }}</p>
            <p style="margin: 0 0 2px;"><b>END DATE:</b> {{ $employeeEndDate }}</p>
            <p style="margin: 0 0 2px;"><b>GROSS WAGES:</b> {{ number_format($employeeGrossSalary, 2) }}</p>
        </div>

        <p style=""> <b>DATE OFPAYMENT(every month):</b> Local legislation requires payment by the last day of the
            worked month. For efficiency, Provider will issue payment on the last day of every month.</p>
        <p style=""><b>LOCAL PAYMENT CONDITIONS:</b> Salaries and/or any other remuneration is set at the local
            currency of the Country where services is provided.</p>
        <b> B) FEES AND PAYMENT TERMS:</b>
        <h4 style=''> PAYMENT TERMS</h4>
        <p> <b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below:</p>
        <div style="margin-top: -35px !important">
            @include('pdf.hong_kong_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container' style='page-break-after: avoid'>
        <p> In addition to the monthly fee, there may be additional costs required by law in the
            Country where the Services are being rendered. Additional costs may apply in the
            following cases that Provider cannot anticipate or predict, as following:</p>



        <p>(i) Additional bonuses awarded by the Customer’s client; OR</p>
        <p> (ii) Any eventual local Government measures
        </p>

        <p><b>C) LOCAL LEGISLATION - PREVAILS</b></p>
        <p> The law that will govern the Worker’s engagement including their rights as an employee will
            be the law of the country where the Worker is providing the services., The Parties agree that
            all applicable law including but not limited to, labor and tax, and must be fully complied
            with the purposes of the local and global compliance guidelines.</p>
        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>INTERMEDIANO HONG KONG LIMITED</h4>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;" />

                        @else
                        <div style="text-align: center; margin-top: 0px">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px">
                        </div>
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);"> {{ $adminSignedBy }}</p>
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                    </div>

                </td>
                <td style="width: 50%; vertical-align: top; border: none; text-align:center !important;">
                    <h4>{{ $partnerName }}</h4>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? storage_path('app/private/signatures/clients/partner_' . $record->partner_id . '.webp')
                                : url('/signatures/customer/' . $record->partner_id . '/partner') . '?v=' . filemtime(storage_path('app/private/signatures/clients/partner_' . $record->partner_id . '.webp')) 
                        }}" alt="Employee Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;" />
                        @else
                        <div style="text-align: center; position: relative; height: 100px;">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;">
                        </div>
                        @endif
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $partnerContactName }}</p>
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                    </div>


                </td>
            </tr>
        </table>

        @include('pdf.contract.layout.footer')

    </main>
</body>
</html>
