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
        <h3>EMPLOYMENT CONTRACT</h3>
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
        <h4>1.1. Form of Contract</h4>
        @if($record->end_date)
        <p>The parties agree that the duration of this contract will be for a defined term and its starting date will be from {{ $monthStartDate }} {{ $formattedStartDate  }} {{ $yearStartDate }} to {{ $formattedEndDate  }} {{ $monthEndDate }} {{ $yearEndDate }}. This contract can be extended following agreement in writing.</p>
        @else
        <p>The parties agree that the duration of this contract will be for a indefinite term and its starting date will be from {{ $formattedStartDate  }} {{ $monthStartDate }} {{ $yearStartDate }} to indefinite end date. This contract can be extended following agreement in writing</p>
        @endif
        <p>This contract is subject to {{ $employeeState }} law and social security regulations unless otherwise provided in this contract or required by binding local legislation, conditions or requirements.</p>

        <h4>1.2. Lay-off and termination</h4>
        <p>The Employee can be laid off, if the Employer cannot offer suitable work to the Employee. The notice period for such lay-off is 2 weeks.</p>
        <p>Both parties can terminate this contract by giving 2 weeks’ notice to the other party in writing.</p>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4>1.3. Probation period</h4>
        <p>The Employee will be subject to a probation period of three (3) months. During the probation period this contract can be terminated at two days’ notice by the Employer if the performance of the Employee is not satisfactory.</p>
        <h4>4. Field of Activities</h4>
        <p>Employee’s main task at the beginning of this contract: {{ $employeeJobTitle }}</p>
        <p>The Employee agrees also to perform such other tasks corresponding to his skills and experience as may be required by the Employer.</p>
        <p>The Employee is obliged to devote his working capacity exclusively to Intermediano and not to engage himself in any other business for the duration of this contract without the prior consent of the Employer.</p>
        <p>The Employee home base is {{ $employeeCity }}, {{ $employeeState }} {{ $employeeCountry }}.</p>
        <h4>5. The General Duties of the Employee</h4>
        <p>The Employee is required to perform his duties with due diligence and following any Employer orders regarding safety, quality and scope of work as well as time and place.</p>
        <p>The Employee is required to sign the Non-Disclosure Agreement as attached.</p>
        <h4>6. Working Hours</h4>
        <p>The Employment is classified as salary-exempt, and any overtime required for the performance of the described tasks is compensated with the agreed total salary.</p>
        <p>Week-end work will be recorded for internal productivity measurement and compensated as 1 for 1 additional holidays.</p>
        <h4>7. Salary and Social Insurances</h4>
        <h4>7.1 Salary</h4>
        <p>The total gross salary agreed for the performance of the duties is CAD {{ number_format($employeeGrossSalary * 12, 2) }} per year.</p>
        <p>The salary is paid to the Employee’s bank account. The salary is paid every two weeks.</p>


        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container">

        <h4>7.2 Income Tax, Social Security</h4>
        <p>The Employee is responsible for any personal income taxes. Employer will handle all at-source deductions.</p>
        <p>The Employee must pay any social security contributions / unemployment contributions, statutory pension or other required to be paid by the Employee according to the rules and regulations of the social security scheme in force in the province where the employee is working. Employer will handle all at-source deductions.</p>
        <p>The Employer will pay the Employer's statutory social security, unemployment, statutory pension and similar statutory contributions.</p>
        <p>The Employee will be enrolled in and covered by the Company’s insurance programmes related to risk in the workplace (worker’s compensation).</p>
        <h4>8. Holidays and Vacation</h4>
        <h4>8.1 Vacation</h4>
        <p>The vacation entitlement shall be accrued starting at the beginning of activities. The Employee is entitled to two weeks of vacation per year. (i.e. every week worked earns 10/52 days of vacation).</p>
        <p>The time of the vacation shall be determined by the Employer locally. The Employer can change the time of the vacation two weeks prior to the beginning of the vacation if necessary for the project.</p>
        <h4>8.2 Holidays</h4>
        <p>All local public holidays shall be free days.</p>
        <h4>9. Compensation of Travel Costs</h4>
        <p>In case the Employee uses her own car for business use upon Employer instruction, the Employee shall be reimbursed upon presentation of travel statement according to company policies and procedures.</p>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container" style='page-break-after: avoid'>
        <h4>10. Annulment of This Contract</h4>
        <p>This contract can be annulled for any of the following reasons:</p>
        <p>1. The Employee commits a breach of the provisions of clause 5</p>
        <p>2. The Employee has misled the Employer in fundamental matters while negotiating this contract.</p>
        <p>3. The Employee is incapable of working for a not temporary reason.</p>
        <p>4. The Employee endangers site safety due to negligence or appears on site intoxicated or takes intoxicating substances defying the orders of his superiors. Recurring appearance at work in the state of the physical after-effects of drunkenness shall be deemed comparable with appearing intoxicated.</p>
        <p>5. The Employee grossly insults colleagues, the Employer, their Family members, the Employer’s substitute or the Employer’s Client or commits outrage upon them.</p>
        <p>6. The Employee deliberately or with negligence fails in her obligations and takes no corrective action despite being warned by the Employer.</p>
        <h4>11. Transfer of contract</h4>
        <p>This agreement can be transferred by Intermediano to a third party upon the prior written agreement of both parties.</p>
        <h4>12. Miscellaneous provisions</h4>
        <p>See Appendix 1.</p>
        <h4>13. Disputes</h4>
        <p>It is the intention of the parties of this contract that any disputes arising from this contract shall be primarily resolved through negotiations between the parties.</p>
        <p>If a consensus cannot be reached in the negotiations, disputes shall be settled in the court of Montreal.</p>
        <p>This contract is made in two originals, one for the Employer and one for the Employee.</p>

        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container" style='page-break-after: avoid'>
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
                    <p style="margin: 10px 0; text-align: center;">{{ $adminSignedBy }}</p>
                    <p style="margin: 5px 0; text-align: center;">{{ $adminSignedByPosition }}</p>
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

                        <p style="margin: 5px 0; text-align: center;">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        {{-- @else --}}
                        {{-- <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Blank Signature" style="height: 50px; margin: 10px 0;"> --}}
                        @endif
                    </div>

                    <div style="width: 100%; border-bottom: 1px solid black;"></div>

                    <p style="margin: 10px 0; text-align: center;">{{ $employeeName }}</p>
                </td>

            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>
</html>
