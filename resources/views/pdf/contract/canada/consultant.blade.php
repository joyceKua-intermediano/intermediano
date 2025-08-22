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
$formattedStartDate = (new DateTime($record->start_date))->format('jS');
$monthStartDate = (new DateTime($record->start_date))->format('F');
$yearStartDate = (new DateTime($record->start_date))->format('Y');

$formattedEndDate = (new DateTime($record->end_date))->format('jS');
$monthEndDate = (new DateTime($record->end_date))->format('F');
$yearEndDate = (new DateTime($record->end_date))->format('Y');

$createdDay = (new DateTime($record->created_at))->format('jS');
$createdMonth = (new DateTime($record->created_at))->format('F');
$createdYear = (new DateTime($record->created_at))->format('Y');
$createdDate = (new DateTime($record->created_at))->format('d/m/Y');
$companyAddress = $record->company->address;
$companyCity = $record->company->city;
$companyState = $record->company->state;

$contactName = $record->companyContact->contact_name;
$contactSurname = $record->companyContact->surname;

$companyName = $record->company->name;
$companyCountry = $record->company->country;
$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->country ?? 'N/A';
$employeeState = $record->personalInformation->state ?? 'N/A';
$employeeCivilStatus = $record->personalInformation->civil_status ?? 'N/A';
$employeeDateBirth = $record->personalInformation->date_of_birth ?? 'N/A';
$employeeEducation = $record->personalInformation->education_attainment ?? 'N/A';

$employeeAddress = $record->personalInformation->address ?? 'N/A';
$employeeCity = $record->personalInformation->city ?? 'N/A';
$employeeState = $record->personalInformation->state ?? 'N/A';
$employeeCountry = $record->personalInformation->country ?? 'N/A';
$employeePhone = $record->personalInformation->phone ?? 'N/A';
$employeeMobile = $record->personalInformation->mobile ?? 'N/A';

$employeeJobTitle = $record->job_title ?? 'N/A';
$employeeCountryWork = $record->country_work ?? 'N/A';
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? 'N/A';
$employeeEmail = $record->employee->email ?? 'N/A';
$customerPosition = $record->companyContact->position;

$employeeSocialSecurityNumber = $record->socialSecurityInfos->social_security_number ?? 'N/A';
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$signaturePath = 'signatures/employee/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('private')->exists($signaturePath);
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name ?? '';
$adminSignedByPosition = $adminSignedBy === 'Fernando Guiterrez' ? 'CEO' : ($adminSignedBy === 'Paola Mac Eachen' ? 'VP' : 'Legal Representative');
$user = auth()->user();
$isAdmin = $user instanceof \App\Models\User;
$type = $isAdmin ? 'admin' : 'employee';
@endphp
<style>
    main {
        padding: 40px
    }

    h3 {
        font-weight: bold
    }

    p {
        line-height: 1.5 !important;
        padding-left: 25px
    }

    h4 {
        padding-left: 15px;
        font-weight: bold
    }

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h3 style='margin-top: -10px'>EMPLOYMENT CONTRACT</h3>
        <b>{{ $employeeName }}</b> <br>
        <b style='margin-top: -10px'>{{ $createdDate }}</b>

        <h4>1. Employer</h4>
        <p><b> Gate Intermediano Inc.</b></p>
        <p>4388 Rue Saint-Denis Suite 200 #763 Montreal, QC H2J 2L1 Canada</p>

        <p><b>Employee’s Immediate Supervisor at the Beginning of the Contract: </b>Fernando Gutierrez</p>
        <h4>2. Employee</h4>
        <p><b>Complete Name:</b> {{ $employeeName }}</p>
        <p><b>Social Insurance Number:</b> {{ $employeeSocialSecurityNumber }}</p>
        <p><b>Date of Birth:</b> {{ $employeeDateBirth }}</p>
        <p><b>Education:</b> {{ $employeeEducation }}</p>
        <p><b>Permanent Address:</b> {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeState }} {{ $employeeCountry }}</p>
        <h4>3. Validity of Contract</h4>
        <h4>3.1. Form of Contract</h4>

        <p style="text-decoration: underline">Fixed Term</p>
        <p>This Agreement shall be in force for a fixed term of twelve (12) months (the <b>“Term”</b>), starting on {{ $monthStartDate }} {{ $formattedStartDate  }} {{ $yearStartDate }}, unless terminated sooner in accordance with the provisions of this Agreement.</p>
        <p style="text-decoration: underline">Extensions</p>
        <p>At any time prior to the end of the Term, the Parties may agree in writing to extend the Agreement for a subsequent Term of twelve (12) months.</p>
        <p style="text-decoration: underline">Governing Law</p>
        <p>This Agreement shall be governed by and construed in accordance with the laws of the Province of Alberta and the laws of Canada applicable in that Province.</p>
        <p><b>“ESC”</b> means the Employment Standards Code, R.S.A. 2000, c. E-9, as amended or such other employment standards legislation as may be applicable to the Employee’s employment with the Employer.</p>


        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4>3.2 Termination</h4>
        <p style="text-decoration: underline">Resignation</p>
        <p>The Employee may terminate this Agreement and their employment at any time by providing written notice to the Employer specifying the effective Date of Termination (the <b>“Resignation Date”</b>), such date being not less than thirty (30) days after the date of the written notice.</p>
        <p>If the Agreement is terminated under this provision, the Employer shall pay to the Employee an amount equal to the Base Salary and vacation pay earned by and payable to the Employee up to the Resignation Date and the Employee shall have no entitlement to any further notice of termination, payment in lieu of notice of termination, severance, or any damages whatsoever thereafter. </p>
        <p>Notwithstanding the forgoing, following the receipt of the notice of resignation by the Employee, the Employer may, in its sole discretion, elect to terminate the employment of the Employee immediately or at such other earlier date prior to the Resignation Date, and where so elected, the Employer shall pay to the Employee the amount of Base Salary the Employee would have earned up to and including the Resignation Date. In any case, the Employee’s entitlement to and participation in any other entitlements whatsoever shall terminate upon the Resignation Date. The Employee’s participation in and eligibility for all bonus or incentive plans or other equity or profit participation plans shall terminate upon the Resignation Date.</p>
        <p style="text-decoration: underline">Resignation</p>
        <p>The Employer may terminate this Agreement for Cause in the circumstances set forth in Section 10 of this Agreement.</p>
        <p style="text-decoration: underline">Termination Without Cause</p>
        <p>Following the Probationary Period, the Employer may terminate this Agreement prior to the end of the Term on a “without cause basis” by providing the Employee with three (3) weeks’ written notice or payment in lieu of notice equivalent to three (3) weeks of the Employee’s Base Salary. For greater certainty, the payment in lieu of notice by the Employer to the Employee on the termination of employment under this Section shall be in lieu of the Employee’s entitlement to minimum notice under the ESC or any additional notice period under common law, or payment thereof in lieu, including payment for the balance of the Term. </p>
        <p>In addition, should the Employer elect to provide the Employee with payment in lieu of notice, the Employee shall only be entitled to receive the amount of Base Salary the Employee would have earned during the notice period. Upon providing the Employee with notice or payment in lieu of notice under this Section, the Employer shall not be required to make any further payment to the Employee and any further liability of the Employer to the Employee shall be fully released. In exchange for any payment in lieu of notice in excess of the minimum statutory requirements, the Employee shall execute a Release in a form acceptable to the Employer.</p>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p style="text-decoration: underline">Minimum Standards</p>
        <p>To the extent that the ESC requires any notice of termination, termination pay or severance pay greater than the notice, termination pay and severance pay provided for in this Agreement, then such minimum employment standards legislation shall be deemed to be incorporated into this Agreement and shall prevail to the extent greater.</p>
        <h4>3.3. Probation period</h4>
        <p>The Employee’s employment under this Agreement shall be subject to review during a probationary period of three (3) months from the date of commencement of employment under this Agreement to ensure fit with the Employer and the position. At the end of the Probationary period, the Employer may choose to end the Employee’s employment, in which case no additional amounts shall be paid to the Employee, notwithstanding Section 1.2 above. During the probationary period, this Agreement can be terminated by the Employer upon two (2) days’ written notice by the Employer to the Employee if the Employer determines that the performance of the Employee is not satisfactory or if the Employer determines that the Employee is not suitable for the position.</p>
        <h4>4. Job Title and Scope of Work:</h4>
        <p style="text-decoration: underline">Employer of Record</p>
        <p>Gate Intermediano Inc. will act as the Employee’s Employer of Record and will be responsible for all payroll, benefits, human resources activity and direction.</p>
        <p>The Employee will be placed on contract with Doughboy Depot LLC (the <b>“Client”</b>), a client of the Employer, and may take instructions directly from the Client for day-to-day activities.</p>
        <p style="text-decoration: underline">Job Title</p>
        <p>The Employee’s Job title is “{{ $employeeJobTitle }}”. </p>
        <h4>5. The General Duties of the Employee</h4>
        <p>Employee’s main task at the beginning of this Agreement: Lead the operations team - including but not limited to process review, process optimization, process implementation, process execution - of the Client, a company focusing on the custom apparel industry. </p>
        <p>The Employee agrees also to perform such other tasks corresponding to his skills and experience as may be required by the Employer.</p>
        <p>The Employee is required to perform his duties with due diligence and following any Employer orders regarding safety, quality and scope of work as well as time and place.</p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p>The Employee is required to sign the Confidentiality/Proprietary Information Agreement and Representation and Warranties Regarding Prior Agreements, as per Exhibit A attached to this Agreement.</p>

        <h4>6. Working Hours</h4>
        <p>The Employee’s position with the Employer is intended to be full-time. It is understood that as a managerial and supervisory position, the hours of work involved will vary and may be irregular. The Employee acknowledges that this clause constitutes agreement to work such hours. The Employee shall devote their full working time and attention on an exclusive basis to the business and affairs of the Employer, acting in the best interests of the Employer at all times.</p>
        <p>The Employee shall not to engage himself in any other business for the duration of this Agreement without the prior written consent of the Employer.</p>
        <p>The Employee’s home base is {{$employeeCity }} {{ $employeeState }}.</p>


        <h4>7. Salary and Social Insurances</h4>
        <h4>7.1 Salary</h4>
        <p>The total gross salary agreed for the performance of the duties is CAD {{ number_format($employeeGrossSalary, 2) }} per annum.</p>
        <p>The salary is paid to the Employee’s bank account. less all applicable deductions, payable bi-weekly during the Term.</p>
        <h4>Bonus</h4>
        <p>Client Bonus Plans</p>
        <p>The Client may, in its sole discretion, offer participation in any bonus compensation, stock option plan, equity participation or similar program established for its eligible participants including third party contractors such as Employee. Any such agreement shall be entered into between Employee and such organization(s) and Employer will have no liability or responsibility in respect of any such plan or grants received by Employee under such plan. It is Employee’s responsibility to consult with its own financial, tax, legal and other advisors.</p>
        <h4>7.3 Income Tax, Social Security</h4>
        <p>The Employee is responsible for any personal income taxes. Employer will handle all at-source deductions.</p>

        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container">

        <p>The Employee must pay any social security contributions / unemployment contributions, statutory pension or other required to be paid by the Employee according to the rules and regulations of the social security scheme in force in the province where the employee is working. Employer will handle all at-source deductions.</p>
        <p>The Employer will pay the Employer’s statutory social security, unemployment, statutory pension and similar statutory contributions.</p>
        <p>If required for the nature of the Employee’s Duties as determined by the Employer, the Employee will be enrolled in and covered by the Employer’s insurance programs related to risk in the workplace (worker’s compensation).</p>
        <p style='font-weight: bold'>The Employee is not entitled to any other payment, benefit, perquisite, allowance or entitlement other than as specifically set out in this Agreement.</p>
        <h4>8. Holidays and Vacation</h4>
        <h4>8.1 Vacation</h4>
        <p>The vacation entitlement shall be accrued starting at the beginning of activities. The Employee is entitled to two weeks of paid vacation per year (i.e. every week worked earns 10/52 days of vacation).</p>
        <p>The Employee shall be entitled to vacation in accordance with the policies of the Employer, to be taken at such periods and during such intervals as shall be upon by the Employer and the Employee. </p>
        <p>Accumulated vacation time or pay may not be carried forward except in accordance with the Employer’s policies or with the Employer’s prior written approval.</p>
        <h4>8.2 Holidays</h4>
        <p>All local statutory holidays in Alberta shall be free days.</p>
        <h4>9. Expenses Reimbursement</h4>
        <p>In case the Employee is requested by Employer or Client to incur additional costs, such expenses shall be reimbursed only if:</p>
        <p>1. The costs are reasonable and properly documented in accordance with the Employer’s Expense Policy; and</p>
        <p>2. Prior written approval has been obtained from the Client for any expense to be reimbursed. Reimbursement shall be made upon presentation of a statement or other supporting documentation, subject to the Employer’s policies and procedures.</p>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4>10. Annulment of This Contract (Termination for Cause)</h4>
        <p>The Employer may terminate your employment for Cause. <b>“Cause”</b> means any one or more of the following events or actions by you, as determined by the Employer:</p>
        <p>1. The Employee commits a material breach of any provision of Clause 5.</p>
        <p>2. The Employee has misled the Employer in fundamental matters while negotiating this Agreement.</p>
        <p>3. Material violation of the Client’s or Employers policies or procedures, including but not limited to harassment, discrimination, or breach of confidentiality;</p>
        <p>4. Willful misconduct or gross negligence in the performance of duties;</p>
        <p>5. Conviction of, or plea of guilty or no contest to, a felony or any crime involving moral turpitude;</p>
        <p>6. Fraud, embezzlement, or dishonesty materially injuring the Client or Employer;</p>
        <p>7. Failure to perform duties after written warning and a reasonable opportunity to cure; or</p>
        <p>8. Any act or omission that constitutes a material breach of this Agreement or any other agreement with the Client.</p>
        <p>If this Agreement and the Employee’s employment is terminated for Cause pursuant to this Section, the Employer shall pay to the Employee an amount equal to the Base Salary and vacation pay earned by and payable to the Employee up to the Date of Termination and the Employee shall have no entitlement to any further notice of termination, payment in lieu of notice of termination, severance, or any damages whatsoever. The Employee’s participation in and eligibility for all bonus or incentive plans or other equity or profit participation plans shall terminate immediately upon the Date of Termination and the Employee shall only be entitled to any amounts that may have been earned and owing as of the Date of Termination.</p>
        <h4>11. Transfer of Contract</h4>
        <p>This Agreement can be transferred by Employer to a third party upon the prior written agreement of both parties.</p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4>12. Miscellaneous provisions</h4>
        <p style="text-decoration: underline">12.1 Background Checks</p>
        <p>The Employer may conduct background checks (including criminal background checks) as a condition of employment during the Probationary Period and the Employee consents to the Employer conducting such background checks.</p>
        <p style="text-decoration: underline">12.2 Injunctions</p>
        <p>The Employee acknowledges and agrees that in the event of a breach of the covenants, provisions and restrictions in Exhibit A by the Employee, the Employer’s remedy in the form of monetary damages will be inadequate. Therefore, the Employer shall be and is hereby authorized and entitled, in addition to all other rights and remedies available to it (which shall not be limited by the provisions of this Section 12.2), to apply to a court of competent jurisdiction for interim and permanent injunctive relief and an accounting of all profits and benefits arising out of such breach.</p>
        <p style="text-decoration: underline">12.3 Independent Legal Advice</p>
        <p>The parties acknowledge that, prior to executing this Agreement, they have received independent legal advice and confirm that they fully understand this Agreement and that they are entering into this Agreement voluntarily.</p>
        <p style="text-decoration: underline">12.4 Entire Agreement</p>
        <p>This Agreement constitutes the entire agreement between the parties pertaining to the subject matter of this Agreement and supersedes all prior agreements, understandings, negotiations and discussions, whether oral or written. There are no conditions, warranties, representations or other agreements between the parties in connection with the subject matter of this Agreement (whether oral or written, express or implied, statutory or otherwise) except as specifically set out in this Agreement.</p>

        <p style="text-decoration: underline">12.5 Counterparts</p>
        <p>This Agreement may be signed in one or more counterparts, each of which so signed shall be deemed to be an original, and such counterparts together shall constitute one and the same instrument. The transmission by facsimile of, or e-mail transmission of a portable document format (.pdf), copy of the execution page hereof reflecting the execution of this Agreement by any party shall be effective to evidence the party's intention to be bound by this Agreement and that party's agreement to the terms.</p>


        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container">

        <p style="text-decoration: underline">12.6 Survival</p>
        <p>The provisions of Exhibit A shall survive the termination of this Agreement and of the Employee’s employment regardless of the reason for such termination.</p>
        <p style="text-decoration: underline">12.7 Severability</p>
        <p>Any provision of this Agreement that is prohibited or unenforceable in any jurisdiction shall, as to that jurisdiction, be ineffective to the extent of the prohibition or unenforceability and shall be severed from the balance of this Agreement, all without affecting the remaining provisions of this Agreement or affecting the validity or enforceability of such provision in any other jurisdiction.</p>

        <h4>13. EXHIBITS</h4>
        <p><b>Exhibit A:</b> Confidentiality/Proprietary Information Agreement and Representations and Warranties Regarding Prior Agreements</p>
        <p>Executed this {{ $createdDay }} day of {{ $createdMonth }} {{ $createdYear }} for an Effective Date of {{ $monthStartDate }} {{ $formattedStartDate  }} {{ $yearStartDate }}.</p>

        <h4 style="text-align: center">Montreal Canada, {{ $createdDate }}</h4>

        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <td style="width: 50%; vertical-align: top; border: none; text-align: center; padding: 10px;  padding-top: -20px">
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
                    @if (!empty($adminSignedBy))
                    <p style="margin: 8px 0; text-align: center;">{{ $adminSignedBy }}</p>
                    <p style="margin: 3px 0; text-align: center;">{{ $adminSignedByPosition }}</p>
                    <p style="margin: 0px 0; text-align: center;">{{ $createdDate }}</p>
                    @endif
                </td>

                <td style="width: 50%; vertical-align: top; border: none; text-align: center; padding: 10px; padding-top: -20px">
                    <h4>Employee</h4>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($signatureExists)
                        <img src="{{ 
        $is_pdf
            ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
            : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
    }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />

                        {{-- @else --}}
                        {{-- <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Blank Signature" style="height: 50px; margin: 10px 0;"> --}}
                        @endif
                    </div>

                    <div style="width: 100%; border-bottom: 1px solid black;"></div>

                    <p style="margin: 8px 0; text-align: center;">{{ $employeeName }}</p>
                    <p style="margin: 3px 0; text-align: center;">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                </td>

            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container" style='page-break-after: avoid'>
        <div style='margin-top: -30px'>
            <p style='text-align: center; font-weight: bold'>Exhibit A: Confidentiality/Proprietary Information Agreement</p>
            <p style='text-align: center; font-weight: bold; margin-top: -16px;'>and Representation and Warranties Regarding Prior Agreements</p>
        </div>

        <p>As a condition of your employment, the Employee (you) agree to the following:</p>
        <div style='margin-left: 16px; margin-top: -10px;'>
            <p>1. <b>Confidentiality</b> : You shall not disclose, use, or share any confidential, proprietary, or trade secret information belonging to the Employer or the Client during or after your employment, except as required to perform your duties or as ordered by a court or governmental agency. Confidential information includes, but is not limited to, customer lists, designs, pricing strate-gies, marketing plans, company financial performance and related financial data, compensa-tion structure and employee renumeration details, and business processes.</p>
            <p>2. <b>Intellectual Property and Work Product:</b> Any and all materials, designs, concepts, docu-ments, or other work products created, developed, or contributed by you during your em-ployment with the Employer shall be the sole and exclusive property of the Client. You agree that all intellectual property rights, including copyrights, trademarks, and patents, are owned by the Client.</p>
            <p>3. <b>Return of Materials:</b> Upon termination of your employment, you shall promptly return all Employer and Client property, including documents, digital files, and any other confidential or proprietary information in your possession.</p>
            <p>4. <b>Survival of Obligations:</b> Your obligations under these Paragraphs 1 through 4 shall survive the termination of your employment.</p>

        </div>
        <p style='font-weight: bold'>Representations and Warranties Regarding Prior Agreements</p>
        <div style='margin-left: 16px; margin-top: -10px;'>
            <p>1. <b>No Violation of Prior Agreements.</b> You represent and warrant that by entering into this Agreement, you are not in violation of any non-compete, non-solicitation, confidentiality, or other restrictive covenant, or any other agreement with any prior employer, contractor, or third party.</p>
            <p>2. <b>Right to Work.</b> You further represent and warrant that, to the best of your knowledge, em-ployment with the Employer, including for the benefit of the Client, will not result in a breach or violation of any such agreement or obligation.</p>
            <p> 3. <b>Notice of Potential Violation.</b> You agree to promptly notify the Client in writing or by email if at any time during the term of employment you become aware of any claim, potential claim, or belief that their employment with the Client may violate any non-compete, non-solicitation, confidentiality, or other restrictive agreement.</p>
            <p>4. <b>Immediate Termination for Violation.</b> The Employer reserves the right to terminate your employment immediately for Cause, without prior notice or severance, if you fail to provide such notice as required above or if the Client reasonably determines that your continued em-ployment violates any such agreement or imposes a material risk of legal liability on the Cli-ent.</p>
        </div>
        <p>By accepting this offer, you acknowledge your understanding of and agreement to these terms.</p>
        @include('pdf.contract.layout.footer')
    </main>
</body>
</html>
