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
$formattedDate = now()->format(format: 'jS');
$day = now()->format('j');

$month = now()->format('F');
$translatedMonth = \Carbon\Carbon::now()->locale('es')->translatedFormat('F');

$year = now()->format('Y');
$currentDate = now()->format('d/m/Y');


$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->nationality ?? null;
$employeeState = $record->personalInformation->state ?? null;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeGender = $record->personalInformation->gender ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeCountryWork = $record->country_work ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? null;
$employeePersonalId = $record->document->personal_id ?? null;
$employeeEmail = $record->employee->email ?? null;
$employeeAddress = $record->personalInformation->address ?? null;
$employeeCity = $record->personalInformation->city ?? null;
$employeeDateBirth = $record->personalInformation->date_of_birth ?? null;
$age = $employeeDateBirth ? \Carbon\Carbon::parse($employeeDateBirth)->age : null;

$employeePhone = $record->personalInformation->phone ?? null;
$employeeMobile = $record->personalInformation->mobile ?? null;
$employeeCountry = $record->personalInformation->country ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeStartDateFormated = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\of F \\ Y')
: 'N/A';
$employeeStartDateLocal = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\de F \\ Y')
: 'N/A';

$employeeEndDateFormated = $record->end_date
? \Carbon\Carbon::parse($record->end_date)->translatedFormat('j \\of F \\ Y')
: 'Undefined Period';
$employeeEndDateLocal = $record->end_date
? \Carbon\Carbon::parse($record->end_date)->translatedFormat('j \\de F \\ Y')
: 'Período indefinido';
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$employeeTaxId = $record->document->tax_id ?? null;
$employeeSocialSecurityNumber = $record->socialSecurityInfos->social_security_number ?? 'N/A';
$employeeCurp = $record->socialSecurityInfos->curp ?? 'N/A';
$employeeVoterId = $record->socialSecurityInfos->voter_id ?? 'N/A';

$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('es_CR', \NumberFormatter::SPELLOUT);
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;

$signaturePath = 'signatures/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('public')->exists($signaturePath);

$employeeBankName = $record->employee->bankDetail->bank_name ?? 'NA';
$employeeBankCode = $record->employee->bankDetail->bank_code ?? 'NA';
$employeeBankAccountNumber = $record->employee->bankDetail->account_number ?? 'NA';

$employeeDependents = $record->employee->dependents ?? 'NA';

@endphp

<style>
    .main-container {
        text-align: justify;
    }

    p {
        line-height: 1.5 !important
    }

    .non-pdf p {
        line-height: 1.7 !important;
    }

    .non-pdf table {
        margin-top: 0px !important
    }

    .listItem {
        line-height: 1.5;
        margin: 5;
        padding: 0
    }

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>INDIVIDUAL EMPLOYMENT CONTRACT FOR AN INDETERMINATE TIME (THE “CONTRACT”) IS EXECUTED BY AND BETWEEN <b>INTERMEDIANO, S.A. DE C.V.</b>, REPRESENTED HEREIN BY LUIS JAVIER ARREGUIN SANCHEZ (HEREINAFTER REFERRED TO AS THE "COMPANY"), AND <b>{{ $employeeName }}</b>
                        (HEREINAFTER REFERRED TO AS THE "EMPLOYEE" AND TOGETHER WITH THE COMPANY, THE "PARTIES"), UNDER THE FOLLOWING DECLARATIONS AND CLAUSES:
                    </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>CONTRATO INDIVIDUAL DE TRABAJO POR TIEMPO INDETERMINADO (EL “CONTRATO”) CELEBRADO, POR UNA PARTE, LA EMPRESA, <b>INTERMEDIANO, S.A. DE C.V.</b> REPRESENTADA EN ESTE ACTO POR LUIS JAVIER ARREGUIN SANCHEZ (EN LO SUCESIVO LA “EMPRESA”) Y, POR LA OTRA PARTE, <b>{{ $employeeName }}</b>
                        (EN LO SUCESIVO EL “TRABAJADOR” Y JUNTAMENTE CON LA EMPRESA, LAS “PARTES”), AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>STATEMENTS</b></p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>DECLARACIONES</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I. The Company declares, through its legal representative and under oath, that:</b></p>
                    <p>a. It is a legally constituted commercial company in accordance with the laws of the United Mexican States (“Mexico”).</p>
                    <p>b. It is duly registered in the Federal Tax-payers Registry under the key <b>SPM240830TR1</b> with its address at: <b>CALZADA GRAL. MARIANO ESCOBEDO 476-PISO 12, CHAPULTEPEC MORALES, VERÓNICA ANZÚRES, MIGUEL HIDALGO, CODIGO POSTAL 11590, EN LA CIUDAD DE MEXICO, MÉXICO</b>.</p>
                    <p>c. Its legal representative has the legal capacity and sufficient authority to bind it under the terms of this Contract.</p>
                    <p>d. The resources to be used for compliance with its obligations under this Contract are of lawful origin.</p>
                    <p>e. and. It is your will to enter into this Contract, in order to hire the Worker for an indefinite period to perform the position of {{ $employeeJobTitle }}.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I. Declara la Empresa, por conducto de su representante legal, y bajo protesta de decir verdad, que:</b></p>
                    <p>a. Es una sociedad mercantil legalmente constituida de conformidad con las leyes de los Estados Unidos Mexicanos (“México”) </p>
                    <p>b. Se encuentra debidamente inscrito en el Registro Federal de Contribuyentes bajo la clave <b>INT241212DU8</b>, con domicilio ubicado en: <b>CALZADA GRAL. MARIANO ESCOBEDO 476-PISO 12, CHAPULTEPEC MORALES, VERÓNICA ANZÚRES, MIGUEL HIDALGO, CODIGO POSTAL 11590, EN LA CIUDAD DE MEXICO, MÉXICO.</b></p>
                    <p>c. Su representante legal cuenta con la capacidad jurídica y facultades suficientes para obligarla en los términos del presente Contrato.</p>
                    <p>d. Los recursos que utilizará para el cumplimiento de sus obligaciones conforme al presente Contrato son de procedencia lícita.</p>
                    <p>e. Es su voluntad celebrar el presente Contrato, a fin de contratar al Trabajador por Tiempo indeterminado para que desempeñe el cargo de {{ $employeeJobTitle }}.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 0px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. The Employee declares, under oath, that:</b></p>
                    <p>a. He is of MEXICAN nationality, {{ $employeeGender }}, estate civi {{ $employeeCivilStatus }} , {{ $age }} years old, his Federal Taxpayers Registry number is {{ $employeeTaxId }}, his Unique Population Registry Code is {{ $employeeCurp }}, and his Social Security Number is, {{ $employeeSocialSecurityNumber }} residing at {{ $employeeAddress }} and {{ $employeeVoterId }} identified with a voter ID with OCR number issued by the National Electoral Institute.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. Declara el Trabajador, por su propio derecho, y bajo protesta de decir verdad, que:</b></p>
                    <p>a. El Trabajador manifiesta ser de nacionalidad MEXICANA, sexo {{ $employeeGender }}, estado civil {{ $employeeCivilStatus }} de {{ $age }} años de edad, que su número de Registro Federal de Contribuyentes es {{ $employeeTaxId }}, su Clave Única de Registro de Población es {{ $employeeCurp }} y su Número de Seguridad Social es {{ $employeeSocialSecurityNumber }} y con domicilio particular ubicado, {{ $employeeAddress }} y que se identifica con credencial para votar con número de OCR {{ $employeeVoterId }} expedida por el INSTITUTO NACIONAL ELECTORAL.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>b. The Worker declares that he has the knowledge, skills and experience necessary to perform the position for which he is hired. Likewise, the Worker expressly acknowledges that he or she agrees to provide his or her personal services to the Company in accordance with the terms and conditions established in this Contract.</p>
                    <p>c. He has the legal capacity and personality to enter into this Contract and to fulfill the obligations contained herein without violating any applicable obligations or regulations.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>b. El Trabajador manifiesta que tiene los conocimientos, habilidades y experiencia necesarios para desempeñar el puesto para el cual es contratado. Asimismo, el Trabajador expresamente reconoce que está de acuerdo en prestar sus servicios personales a la Empresa conforme a los términos y condiciones establecidos en el presente Contrato.</p>
                    <p>c. El Trabajador cuenta con capacidad y personalidad jurídica para celebrar el presente Contrato y cumplir las obligaciones contenidas en el presente sin violar cualquier obligación o regulación que le pudiera aplicar.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>The Parties jointly declare that:</b></p>
                    <p>They mutually recognize each other's capacity and legal personality to enter into this Contract and expressly state their consent to be bound by the following terms and conditions:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Declaran conjuntamente las Partes que: </b></p>
                    <p>Se reconocen mutuamente la capacidad y personalidad con que comparecen a celebrar el presente Contrato y manifiestan expresamente su consentimiento para obligarse al tenor de las siguientes:</p>
                </td>
            </tr>



        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 30px important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center; text-decoration: underline;'><b>CLAUSES</b></p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center; text-decoration: underline;'><b>CLÁUSULAS</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST.</b> Subject to the terms and conditions of this Contract, the EMPLOYEE agrees to provide the COMPANY with the personal and subordinate services described in the document attached to this Contract as Annex A.</p>
                    <p>This Contract will be concluded for an indefinite period and will be governed by the Federal Labor Law and other applicable labor provisions, as well as by the internal policies in force in the COMPANY and those that may be generated in the future, and may not be suspended, rescinded or terminated, except in the cases established in said regulations.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PRIMERA.</b> Sujeto a los términos y condiciones del presente Contrato, en este acto el TRABAJADOR se obliga a prestar a favor de la EMPRESA los servicios, personales y subordinados que se describen en el documento que se adjunta al presente Contrato como Anexo A. </p>
                    <p>Este Contrato se celebrará por tiempo indeterminado y se regirá por la Ley Federal del Trabajo y demás disposiciones laborales aplicables, así como por las políticas internas vigentes en la EMPRESA y aquellas que en el futuro se generen, y no podrá ser suspendido, rescindido o terminado, salvo en los casos establecidos en dichos ordenamientos.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SECOND.</b> The WORKER recognizes the COMPANY as his only employer and undertakes to provide his personal services for an indefinite period of time, in the position of “PRODUCTION TECHNICIAN.” whose services consist of those described in Annex A attached to this Contract, which signed by the Parties forms an integral part. Of it.</p>
                    <p>The tasks performed by the Employee will be under the direction and dependency of the Company's representatives, to whose authority he will be subordinate in all matters related to his work. He will execute these tasks with appropriate care, diligence, and skill, and in the agreed manner, time, and place or in any other assigned according to the needs of the service. The Employee expressly consents that future work conditions may be modified as necessary without prejudice to the agreed wages and category.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEGUNDA.</b> El TRABAJADOR reconoce como su único patrón a la EMPRESA y se obliga a prestar sus servicios personales por tiempo indeterminado, en el puesto de “TÉCNICO DE PRODUCCIÓN” cuyos servicios consisten en los descritos en el Anexo A que se adjunta al presente Contrato, el cual firmado por las Partes forma parte integrante del mismo.</p>
                    <p>Las labores que el Trabajador realice, serán bajo la dirección y dependencia de los representantes de la Empresa a cuya autoridad estará subordinado a todo lo concerniente a sus labores, y ejecutará éstas con el cuidado, diligencia y esmero apropiados y en la forma, tiempo y lugar convenidos o en cualquier otro que se le asigne de acuerdo a las necesidades del servicio; y expresa su consentimiento absoluto de que le sean modificadas las condiciones futuras de trabajo, en la medida que fuere necesario, sin perjuicio de los salarios y categoría convenidos.</p>
                </td>
            </tr>




        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The title given to the EMPLOYEE'S position is indicative and not limiting, so he will be obliged to perform any work related to the nature of the position and as established in this Contract, even if it must be carried out outside his usual place of activities, possibly being transferred to another department or area without detriment to his category and salary, to which he consents.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'>La denominación que se le da al cargo que desempeñará el TRABAJADOR, es enunciativa y no limitativa, de tal suerte que este, tendrá la obligación de atender cualquier trabajo relacionado con la naturaleza del puesto y lo establecido en el presente Contrato, aunque deba desempeñarse fuera de su lugar habitual de actividades, pudiendo ser transferido a otro departamento o área, sin detrimento de su categoría y sin perjuicio de su salario, otorgando desde este momento su conformidad para esta condición de trabajo.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRD.</b> The EMPLOYEE agrees to work at the COMPANY'S address and/or remotely, and/or at the address designated by the employer, and/or at the client's address if commissioned, and/or as requested by the COMPANY, and/or at any of the COMPANY'S offices within the Mexican Republic, consenting to work at any office or place where his services are required according to “THE COMPANY'S” needs.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4 !important'><b>TERCERA.</b> El “TRABAJADOR” conviene que prestará su trabajo en el domicilio de la “EMPRESA” y/o trabajo remoto y/o en el domicilio señalado por el patrón y/o en el domicilio de (los) cliente (s) en caso de ser comisionado y/o cuando así lo solicite la “EMPRESA” y/o en cualquiera de las oficinas de la “EMPRESA” instaladas en el interior de la República Mexicana, otorgando su consentimiento desde este momento el “TRABAJADOR” para desempeñar su trabajo en cualquier oficina y/o lugar en donde sean requeridos sus servicios, de acuerdo con las necesidades de la “EMPRESA”.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTH.</b> For the work performed under this contract, the Employee will receive a gross monthly salary of {{ $employeeGrossSalary }} payable in one monthly installment on the thirtieth day of each calendar month or the previous business day if it falls on a rest day. The COMPANY will make the necessary legal deductions on behalf of the EMPLOYEE, particularly those related to income tax, Social Security contributions, INFONAVIT, SAR, etc.</p>
                    <p>The Parties agree that the details of the perceptions and deductions related to the salary can be consulted by the EMPLOYEE at any time through the systems made available by the COMPANY. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CUARTA.</b> El “TRABAJADOR” percibirá por el trabajo prestado objeto de este contrato, la cantidad de {{ $employeeGrossSalary }} como salario bruto mensual, pagadero en una exhibición mensual los días treinta de cada mes calendario o el día hábil anterior en caso de ser día de descanso. Del salario fijado, la EMPRESA hará por cuenta del TRABAJADOR las deducciones legales correspondientes, particularmente las que se refieran al impuesto sobre la renta, aportaciones al Seguro Social, INFONAVIT, SAR, etcétera.</p>
                    <p style='line-height: 1.4 !important'>Las Partes convienen en que el detalle de las percepciones y las deducciones relacionadas con el salario, podrán ser consultadas por el “TRABAJADOR” en cualquier tiempo a través de los sistemas que la “EMPRESA” ponga a su disposición. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Both Parties agree that the deposit or interbank transfer receipt will serve as a receipt as if it were signed by the EMPLOYEE.</p>
                    <p>The EMPLOYEE hereby requests that for security reasons, his earned wages be deposited by transfer. Furthermore, the EMPLOYEE releases the COMPANY from any misuse of the assigned account or payment instruments delivered by the bank.</p>
                    <p>Promotions for the Employee will be based on demonstrated higher capacity, aptitude, or productivity and will be possible when the COMPANY'S growth or negotiation allows.</p>
                    <p>The salary and other benefits will be paid to the EMPLOYEE by bank deposit or transfer to the following account held by the EMPLOYEE:</p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'>Ambas Partes acuerdan que el comprobante de depósito o transferencia interbancaria harán las veces de recibo como si se encontrara firmada por el “TRABAJADOR”.</p>
                    <p style='line-height: 1.4'>El “TRABAJADOR” en este acto solicita que por razones de seguridad le sea depositado en transferencia el pago de sus salarios devengados. Asimismo, “TRABAJADOR” libera desde este momento a la “EMPRESA” de cualquier mal uso que realice sobre la cuenta asignada, así como de los instrumentos de pago o cobro que le sean entregados por la institución bancaria.</p>
                    <p style='line-height: 1.4'>Los ascensos para el trabajador serán porque este demuestre estar mayor capacitado, mayor aptitud, o acredite mayor productividad y sea apto para el ascenso cuando este sea posible, por el crecimiento de la “EMPRESA” o negociación.</p>
                    <p style='line-height: 1.4'>El salario y otras prestaciones se pagarán al “TRABAJADOR” mediante depósito o transferencia bancaria, en la siguiente cuenta de la que es titular el “TRABAJADOR”:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Bank:</b> {{ $employeeBankName }}</p>
                    <p><b>Account Number:</b> {{ $employeeBankAccountNumber }}</p>
                    <p><b>Interbank Code</b> {{ $employeeBankCode }}</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Banco:</b> {{ $employeeBankName }}</p>
                    <p><b>Número de Cuenta:</b> {{ $employeeBankAccountNumber }}</p>
                    <p><b>Cuenta Clabe</b> {{ $employeeBankCode }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTH.</b> The Parties agree that the EMPLOYEE'S effective weekly daytime work schedule will not exceed 48 hours per week, distributed by the COMPANY according to Articles 59, 60, and 61 of the Federal Labor Law and the internal work regulations. The COMPANY may modify and establish schedules continuously or discontinuously as operational needs require due to the nature of the services performed by the EMPLOYEE.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p><b>QUINTA.</b> Las Partes convienen en que la jornada diurna semanal efectiva de trabajo del “TRABAJADOR” no excederá de 48 horas semanales como máximo, distribuidas por la “EMPRESA” conforme a lo dispuesto en los artículos 59, 60 y 61 de la Ley Federal del Trabajo, y el reglamento interior de trabajo. La “EMPRESA” podrá modificar y establecer los horarios en forma discontinua o continua cuando las necesidades de operación así lo requieran por la naturaleza del servicio que presta el “TRABAJADOR”.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>For every six days of work, the EMPLOYEE will enjoy one day of rest with full salary, which will be Saturdays and Sundays of each week. The EMPLOYEE authorizes the COMPANY to modify the assigned schedule or shift according to its needs without liability for the COMPANY.</p>
                    <p>"The parties agree that 'THE WORKER' shall provide services during a maximum workweek of 48 hours, from Monday to Saturday, between 9:00 AM and 6:00 PM, with a daily break of 1 hour for meals and rest outside the workplace from 1:00 PM to 3:00 PM, and enjoying Saturdays and Sundays as weekly rest days. Based on Article 59 of the Federal Labor Law, the parties may establish arrangements they deem appropriate to distribute the workweek as referred to in this clause. Furthermore, working overtime without prior authorization from the employer is strictly prohibited</p>
                    <p>The EMPLOYEE must start his duties punctually at the established work schedule, recording his attendance as indicated by the COMPANY, and the COMPANY will be responsible for maintaining the EMPLOYEE'S attendance record. In case of delay or unjustified absence, the COMPANY may impose any disciplinary corrections provided by the Internal Work Regulations or the Federal Labor Law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Por cada seis días de trabajo, el "TRABAJADOR" disfrutará de un día de descanso con goce de salario íntegro que serán los sábados y Domingos de cada semana. El “TRABAJADOR” faculta a la “EMPRESA” para modificar el horario o turno que le haya sido asignado por ésta, de acuerdo con las necesidades de esta y sin responsabilidad para la “EMPRESA”.</p>
                    <p>Las partes acuerdan en que “EL TRABAJADOR” prestará sus servicios durante una jornada máxima de 48 horas a la semana, comprendida de lunes a sábado de cada semana de las 09:00 horas a las 18:00 horas, gozando siempre de 1 hora diaria para tomar sus alimentos y descanso fuera del centro de trabajo de las 13:00 horas a las 15:00 horas y, disfrutando de los sábados y domingos como días de descanso semanal. Con fundamento en el artículo 59 de la Ley Laboral, las partes podrán fijar las modalidades que consideren convenientes con objeto de distribuir la jornada a que se refiere la presente cláusula. Asimismo, queda estrictamente prohibido laborar horas extras sin una orden autorizada por el patrón. </p>
                    <p style='line-height: 1.4 !important'>El “TRABAJADOR” deberá iniciar puntualmente sus labores en el horario de trabajo establecido, haciendo constar su asistencia como lo señale la “EMPRESA” y será responsabilidad de este último, conservar el récord de asistencias del “TRABAJADOR”. En caso de retraso o inasistencia injustificada podrá la “EMPRESA” imponerle cualquier corrección disciplinaria de las que contempla el Reglamento Interior de Trabajo, o la Ley Federal de Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SIXTH.</b> The COMPANY will keep a record of the EMPLOYEE'S service sheet or file, performance and punctuality history, which includes the EMPLOYEE'S contributions and innovations, as well as performance evaluations and annotations, recognitions, credits, or warnings about his work conduct.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTA.</b> La “EMPRESA” llevará en su administración, la hoja de servicios o el expediente o archivo de historial, récord o registros del desempeño y puntualidad del TRABAJADOR, que además contiene las opiniones e innovaciones que aporte el “TRABAJADOR”, así como las evaluaciones de su rendimiento y las anotaciones, reconocimientos, créditos o advertencias sobre su conducta laboral.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTH.</b> The EMPLOYEE will enjoy the mandatory rest days established by Article 74 of the Federal Labor Law, as well as those stipulated in the Internal Work Regulations.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SÉPTIMA.</b> El “TRABAJADOR” gozará de los días de descanso obligatorio establecidos por el artículo 74 de la Ley Federal del Trabajo, así como los estipulados en el Reglamento Interior de Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTH.</b> The "EMPLOYEE" shall be entitled to an annual vacation period for each full year of service rendered, in accordance with the provisions established by the "COMPANY." These vacations must be taken within the six months following the completion of the year of service, under conditions even more favorable than those stipulated in Article 76 of the Labor Law, as outlined in the following table:</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>OCTAVA.</b> El “TRABAJADOR” gozará de un periodo anual de vacaciones por cada año completo de servicios prestados conforme a lo establecido por la “EMPRESA”, debiendo hacer uso de éstas, dentro de los seis meses siguientes al cumplimiento del año de servicios en mejores condiciones incluso que las que estipula el Artículo 76 de la Ley Laboral, mismas que se otorgaran de acuerdo con la tabla siguiente:</p>
                </td>
            </tr>



        </table>
        <table border="1" style="border-collapse: collapse; width: 100%;">
            <tr>
                <!-- First Column -->
                <td style="width: 50%; vertical-align: top;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <th style='text-align: center'>Años de Servicio</th>
                            <th style='text-align: center'>Días Laborales Para Disfrutar</th>
                        </tr>
                        <tr>
                            <td style='text-align: center'>1</td>
                            <td style='text-align: center'>12</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>2</td>
                            <td style='text-align: center'>14</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>3</td>
                            <td style='text-align: center'>16</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>4</td>
                            <td style='text-align: center'>18</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>5</td>
                            <td style='text-align: center'>20</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>6-10</td>
                            <td style='text-align: center'>22</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>11-15</td>
                            <td style='text-align: center'>24</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>16-20</td>
                            <td style='text-align: center'>26</td>
                        </tr>
                    </table>
                </td>

                <!-- Second Column -->
                <td style="width: 50%; vertical-align: top;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <th style='text-align: center'>Años de Servicio</th>
                            <th style='text-align: center'>Días Laborales Para Disfrutar</th>
                        </tr>
                        <tr>
                            <td style='text-align: center'>1</td>
                            <td style='text-align: center'>12</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>2</td>
                            <td style='text-align: center'>14</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>3</td>
                            <td style='text-align: center'>16</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>4</td>
                            <td style='text-align: center'>18</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>5</td>
                            <td style='text-align: center'>20</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>6-10</td>
                            <td style='text-align: center'>22</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>11-15</td>
                            <td style='text-align: center'>24</td>
                        </tr>
                        <tr>
                            <td style='text-align: center'>16-20</td>
                            <td style='text-align: center'>26</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>If the employment relationship terminates before the completion of a full year of service, the "EMPLOYEE" shall be entitled to proportional compensation for the time of services rendered.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Si la relación de trabajo termina antes de que se cumpla el año de servicios, el TRABAJADOR tendrá derecho a una remuneración proporcional al tiempo de servicios prestados.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'><b>NINTH.</b> The "COMPANY" shall pay the "EMPLOYEE" a vacation bonus equivalent to 50% of their vacation period.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'><b>NOVENA.</b> La “EMPRESA” pagará al “TRABAJADOR” una prima vacacional equivalente al 50% de sus vacaciones.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TENTH.</b> The EMPLOYEE shall take their vacation periods in accordance with the terms set forth by law, as these are not cumulative and shall expire if not used.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA.</b> El TRABAJADOR deberá de disfrutar sus periodos vacacionales en los términos que marca la ley, ya que las mismas prescriben y no son acumulables.</p>
                </td>
            </tr>
        </table>

        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>ELEVENTH.</b> The parties agree that the Christmas bonus to which the "EMPLOYEE" is entitled shall be paid before December 20th of each year, in accordance with the Federal Labor Law.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA PRIMERA.</b> Las partes convienen que el aguinaldo a que el “TRABAJADOR” tiene derecho deberá pagarse antes del 20 de diciembre de cada año, de acuerdo con la Ley Federal del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWELFTH.</b> The "EMPLOYEE" shall be entitled to the payment of 30 (thirty) days of annual Christmas bonus starting from the first year of service.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA SEGUNDA.</b> el “TRABAJADOR” tendrá derecho al pago de 30 (treinta) días de aguinaldo anual a partir del primer año de servicios.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRTEENTH.</b> The "COMPANY" shall provide training and skills development to the "EMPLOYEE" in accordance with the existing plans and programs or those that may be established, as stipulated by the Federal Labor Law.</p>
                    <p>The "EMPLOYEE's" right to receive training and skills development from the "COMPANY" implies an obligation to attend the courses punctually, participate in group sessions and other related activities, adhere to the instructions of the trainers, comply with the programs, and ultimately, take the required evaluations of knowledge and skills.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA TERCERA.</b> La “EMPRESA” se obliga a capacitar y adiestrar al “TRABAJADOR” en los términos de los planes y programas que existan o se establezcan en la misma, conforme a lo dispuesto por la Ley Federal del Trabajo.</p>
                    <p>El derecho del “TRABAJADOR” a que la “EMPRESA” le proporcione capacitación y adiestramiento, implica la obligación de éste de asistir puntualmente a los cursos y participar en las sesiones de grupo y demás actividades relativas, así como atender las disposiciones de los instructores, cumplir con los programas y finalmente, presentar los exámenes de evaluación de conocimiento y aptitudes que se requieran.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTEENTH.</b> The "EMPLOYEE" expressly declares to the "COMPANY" that they are authorized to enter into this contract; that they have not entered into any other contracts and have not acquired commitments or obligations of any kind with any other person or company that would in any way prevent them from fulfilling the obligations assumed under this contract. Furthermore, the "EMPLOYEE" declares that they do not possess any confidential documents or tangible goods belonging to third parties that could affect the fulfillment of the obligations assumed in this Contract; and that they are ready, willing, and capable of fulfilling each and every one of these obligations.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA CUARTA.</b> El “TRABAJADOR” declara expresamente a la “EMPRESA” que está facultado para celebrar el presente contrato; que no ha celebrado otros contratos y que no ha adquirido compromisos u obligaciones de ningún tipo para con ninguna otra persona o empresa, que le impidan en forma alguna dar cumplimiento a las obligaciones que asume, de conformidad con el presente contrato. Asimismo, el “TRABAJADOR” declara que no tiene en su poder, ningún documento, ni bienes tangibles confidenciales de terceros, que pudieran afectar el cumplimiento de las obligaciones que asume en este Contrato; y que está listo, dispuesto y tiene la capacidad de dar cumplimiento a todas y cada una de ellas.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>



    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTEENTH.</b> 15.1 The "EMPLOYEE" acknowledges that: (a) prior to the date of this Contract, they have had access to information and materials related to the "COMPANY", and (b) subsequent to the date of this Contract and during its term, they will have access to such information and materials, as well as to other information and materials not known in the market, which the "COMPANY" considers proprietary, confidential, and containing trade secrets. Such information and materials (hereinafter referred to as "Confidential Information") may include, but are not limited to, information related to contractual negotiations, works in progress, product planning, customer lists, supplier contacts, computer programs, algorithms, systems, business or financial affairs, operational methods, operations, internal controls, or security procedures of the "COMPANY", its parent company, its subsidiaries, or any existing or potential supplier or customer of the "COMPANY". Moreover, the "EMPLOYEE" understands that the Confidential Information is considered confidential, regardless of whether it has been received from the "COMPANY", its parent company, its subsidiaries, or its clients, or developed as a result of the services provided by the "EMPLOYEE" to the "COMPANY".</p>
                    <p>15.2 The "EMPLOYEE" agrees that during the term of this contract and after its termination, they will: (a) treat all Confidential Information with strict confidentiality; (b) not disclose it to any person, nor allow it to be disclosed to persons who do not need to know it on behalf of the "COMPANY", nor to third parties who are not direct employees of the "COMPANY", without the prior written consent of the legal representative of the "COMPANY";</p>
                    <p>(c) not use any Confidential Information except to the extent required to fulfill their obligations to the "COMPANY";</p>
                    <p>(d) not copy any document or medium containing Confidential Information, nor remove it from the premises of the "COMPANY" or</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA QUINTA.</b> 15.1 El “TRABAJADOR” reconoce que: (a) con anterioridad a la fecha del presente Contrato ha tenido acceso a información y materiales relacionados con la “EMPRESA”, y (b) con posterioridad a la fecha del presente Contrato y durante su vigencia, tendrá acceso a dicha información y materiales, así como a otra información y materiales que no son conocidos en el mercado, que la “EMPRESA” considera propios, confidenciales y que contienen secretos comerciales. Dicha información y materiales (en lo sucesivo “Información Confidencial”) pueden incluir información relacionada con negociaciones contractuales, trabajos en proceso de preparación, planeación de productos, listas de clientes, contactos con proveedores, programas de cómputo, algoritmos, sistemas, negocios o asuntos financieros, métodos de operación, operaciones, controles internos o procedimientos de seguridad de la “EMPRESA”, de su casa matriz, de sus filiales o de cualquier proveedor o cliente existente o potencial de la “EMPRESA”. Asimismo, el “TRABAJADOR” comprende que la Información Confidencial puede ser considerada como tal, independientemente que la haya, recibido de la “EMPRESA”, de su casa matriz o de cualquiera de sus filiales o de los clientes o que se haya desarrollado con motivo o como resultado de los servicios prestados por el “TRABAJADOR” a la “EMPRESA”.</p>
                    <p>15.2 El “TRABAJADOR” se obliga a que durante la vigencia del presente contrato y después de su terminación: (a) Tratará toda la Información Confidencial en forma estrictamente confidencial; (b) no la revelará a ninguna persona, ni permitirá que se dé a conocer a personas que no tengan necesidad de conocerla por cuenta de la “EMPRESA”, ni a terceros que no sean empleados directos de la “EMPRESA”, sin contar con el previo consentimiento por escrito del apoderado legal de la “EMPRESA”; (c) No utilizar  ninguna información confidencial,</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>the location where the "COMPANY" provides services, except as required to fulfill their obligations to the "COMPANY", in which case the "EMPLOYEE" will at all times take necessary measures to prevent its disclosure or unauthorized use. Should the "EMPLOYEE" need to copy any document or medium for what they are authorized, in accordance with the foregoing provisions, they must faithfully reproduce in such copies the copyright notices and the ownership of the information proprietary to the "COMPANY". Furthermore, the "EMPLOYEE" agrees to obtain from the "COMPANY" prior approval of any publications or professional, educational, or technical conferences they draft or prepare during the term of this contract or within six months after its termination, that relate to their obligations to the "COMPANY" or to research and development work performed by the "COMPANY".</p>
                    <p>15.3 Upon termination of the employment relationship with the "EMPLOYEE", they shall immediately return to the "COMPANY" all Confidential Information contained in documents, physical or digital media, and other tangible materials that contain Confidential Information (without retaining any copies), along with any other property and keys of the "COMPANY" that are in their possession or under their control.</p>
                    <p>15.4 The "EMPLOYEE" agrees to comply with all security procedures of the "COMPANY", including, but not limited to, those related to computer equipment and passwords. Similarly, they agree not to access any of the computers of the "COMPANY" or of its clients or suppliers or its affiliates, except those authorized; not to access them after their employment relationship has been terminated; to immediately inform the "COMPANY" as soon as they become aware of any breach or unauthorized access, as well as any unauthorized use or reproductions or interference by third parties with the computer programs, trade secrets,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>excepto en la medida que se requiera para cumplimiento de sus obligaciones para con la “EMPRESA”; (d) No copiará ningún documento o medio que contenga Información Confidencial, ni los extraerá de las instalaciones de la “EMPRESA” o del lugar en el que la “EMPRESA” preste servicios, excepto cuando se requiera para el cumplimiento de sus obligaciones para con la “EMPRESA”, en cuyo caso, el “TRABAJADOR” tomará, en todo momento, las medidas necesarias para evitar darla a conocer, o su uso no autorizado. En caso de que el “TRABAJADOR” deba copiar algún documento o medio para lo que está autorizado, de conformidad con las disposiciones anteriores, deberá reproducir fielmente en dichas copias, los avisos referentes a derechos de autor y a la titularidad de la información propia de la “EMPRESA”. Asimismo, el “TRABAJADOR” se obliga a obtener de la “EMPRESA”, la previa aprobación de las publicaciones o conferencias profesionales, educativas o técnicas que redacte o prepare durante la vigencia del presente contrato o dentro de los 6 meses posteriores a su terminación, que se relacionen con sus obligaciones para con la “EMPRESA” o los trabajos de investigación y desarrollo efectuados por la “EMPRESA”.</p>
                    <p>15.3 A la terminación de la relación laboral con el “TRABAJADOR”, este devolverá a la “EMPRESA”, de inmediato, la Información Confidencial contenida en los documentos, medios físicos o digitales y otros materiales en forma tangible, que contengan Información Confidencial (sin conservar ninguna copia), junto con cualesquiera otros bienes y llaves de la “EMPRESA” que se encuentren en su posesión o bajo su control.</p>
                    <p>15.4 El “TRABAJADOR” se obliga a cumplir con todos los procedimientos de seguridad de la “EMPRESA”, incluyendo de forma enunciativa mas no limitativa, los concernientes a la seguridad del equipo de cómputo y contraseñas. De igual forma, se obliga a no ingresar a ninguna de las computadoras de la “EMPRESA” o de los clientes o proveedores de ésta o sus filiales, </p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Confidential Information, or other materials or research and development equipment owned by the "COMPANY", its affiliates, or the client.</p>
                    <br><br><br><br><br><br><br><br><br>
                    <p>15.5 The "EMPLOYEE" states that they do not possess any inventions, discoveries, written works, developments, technical materials, and development tools made by the "EMPLOYEE" prior to the date of their hiring by the "COMPANY" (hereinafter "Employee's Prior Developments") regarding which the "EMPLOYEE" has any intellectual property rights and declares that: (a) there are no other Employee's Prior Developments, and (b) they have no intellectual property rights regarding the assets of the "COMPANY".</p>
                    <br>
                    <p>15.6 The "EMPLOYEE" acknowledges that all business opportunities (related in any way to the current or future operations of the "COMPANY", whether the "EMPLOYEE" is aware of them or not) that are presented to the "EMPLOYEE" during the term of this contract, are and shall be the exclusive property of the "COMPANY", and the "EMPLOYEE" will immediately disclose such opportunities to the "COMPANY"; and will provide to the "COMPANY", without any additional compensation, the documents it requests to evidence its ownership of the mentioned business opportunities.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>a excepción de las que le hayan sido autorizadas; a no ingresar a las mismas después de que su relación de trabajo se haya dado por terminada; a informar de inmediato a la “EMPRESA”, tan pronto como tenga conocimiento de ello, de cualquier violación o ingreso no autorizado, así como del uso o reproducciones no autorizadas o de interferencia por parte de terceros con los programas de cómputo, secretos industriales, Información Confidencial u otros materiales o equipo de investigación y desarrollo, propiedad de la “EMPRESA” de sus filiales o el cliente.</p>
                    <p>15.5 El “TRABAJADOR” manifiesta que no cuenta con inventos, descubrimientos, obras escritas, desarrollos, materiales técnicos y herramientas de desarrollo hechas por el “TRABAJADOR” con anterioridad a la fecha de su contratación con la “EMPRESA” (en lo sucesivo “Desarrollos Previos del Trabajador”) respecto de los cuales el “TRABAJADOR” tenga algún derecho de propiedad intelectual y declara que: (a) no existe ningún otro Desarrollo Previo del Trabajador, y (b) no tiene ningún derecho de propiedad intelectual respecto de los activos de la “EMPRESA”.</p>
                    <p>15.6 EL “TRABAJADOR” reconoce que todas las oportunidades de negocios (relacionadas en cualquier forma con las operaciones presentes o futuras de la “EMPRESA”, independientemente de que “TRABAJADOR” tenga conocimiento de ellas o no) que se pongan a consideración del “TRABAJADOR” durante la vigencia del presente contrato, son y serán propiedad exclusiva de “EMPRESA” y el “TRABAJADOR” dará a conocer de inmediato dichas oportunidades a la “EMPRESA”; y otorgará a favor de la “EMPRESA”, sin ninguna compensación adicional, los documentos que ésta le solicite para hacer constar su titularidad respecto de las oportunidades de negocios mencionadas.</p>

                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>15.7 Given that the "EMPLOYEE" acknowledges that their services for the "COMPANY" involve activities of research, development, and improvement of procedures, methods, processes, or systems used by the "COMPANY", they agree that during the time they provide services, they will communicate to the "COMPANY" all inventions, discoveries, or improvements developed or conceived by the "EMPLOYEE" individually or in collaboration with others, that relate to the activities of the "COMPANY", or that are a result or derive from any work done for the same, or at its request. Accordingly, the "EMPLOYEE" assigns to the "COMPANY" the ownership or exclusive right over such inventions, discoveries, or improvements and any patents issued in relation with them, agreeing to sign, when required, the necessary documentation to formalize such assignments or transfers. The "EMPLOYEE" agrees that this clause shall be binding on them, their representatives, and their executors, even after the termination of the contractual employment relationship with the "COMPANY".</p>
                    <p>15.8 The "EMPLOYEE" recognizes and accepts that prior to this Contract, they may have acquired confidential information from other employers or entities. The "EMPLOYEE" commits to respect and maintain all confidentiality obligations they have assumed prior to the start of this Contract, including any information received by the "EMPLOYEE" during the course of their previous employment in terms of their respective obligations. The "EMPLOYEE" acknowledges that disclosing, sharing, or using such confidential information in any way during the term of this Contract is strictly prohibited and that any breach could result in disciplinary actions, including the termination of the Contract and any legal actions that may be appropriate for damages and to hold the "COMPANY" harmless from any associated claims.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>15.7 Dado que el “TRABAJADOR” reconoce que sus servicios para la “EMPRESA” implican actividades de investigación, desarrollo y perfeccionamiento de los procedimientos, métodos, procesos o sistemas utilizados por la “EMPRESA”, conviene que durante el tiempo en que le preste servicios, comunicara  a la “EMPRESA” de todas las invenciones, descubrimientos o mejoras desarrollados o concebidos por el “TRABAJADOR” individualmente o en colaboración con otras personas, que se relacionen con las actividades de la “EMPRESA”, o que sean resultado o deriven de cualquier trabajo realizado para la misma, o a su solicitud. En tal virtud, el “TRABAJADOR” cede a la “EMPRESA” la propiedad o derecho exclusivo sobre dichas invenciones, descubrimientos o mejoras y cualquier patente que se expida en relación con las mismas, aceptando firmar, al ser requerido para ello, la documentación necesaria para formalizar dichas cesiones o traspasos. El “TRABAJADOR” está de acuerdo en que esta cláusula será obligatoria para él, sus representantes y sus albaceas, aún con posteridad a la terminación de la relación contractual de trabajo con la “EMPRESA”.</p>
                    <p>15.8 El “TRABAJADOR” reconoce y acepta que, con anterioridad al presente Contrato, pudo haber adquirido información confidencial de otros empleadores o entidades. El “TRABAJADOR” se compromete a respetar y mantener todas las obligaciones de confidencialidad que haya asumido con anterioridad al inicio del presente Contrato, incluyendo cualquier información recibida por el “TRABAJADOR” durante el curso de su empleo anterior en términos de sus respectivas obligaciones. El “TRABAJADOR” reconoce que divulgar, compartir o utilizar de ninguna manera dicha información confidencial durante la vigencia del presente Contrato está estrictamente prohibido y su incumplimiento podría resultar en medidas disciplinarias, incluida la terminación del Contrato y cualesquiera acciones legales que sean procedentes por daños y perjuicios para dejar en paz y a salvo a la “EMPRESA” por cualquier reclamo asociado.</p>

                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 20px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Both Parties agree that any breach by the "EMPLOYEE" of the terms mentioned in sections 15.1, 15.2, 15.3, 15.4, 15.5, 15.6, 15.7, and 15.8 above, will be considered just cause for termination of the employment relationship without liability to the "COMPANY".</p>
                    <p>Furthermore, the "EMPLOYEE" expressly states that in case of non-compliance with the obligations contained in this clause, they will be subject to the legal liability that arises, including, but not limited to, the criminal liability referred to in Article 402, sections III and V of the Federal Law on the Protection of Industrial Property.</p>
                    <p><b>SIXTEENTH.</b> 16.1 The "EMPLOYEE" agrees to properly use the equipment, systems, and computer programs implemented by the "COMPANY", as well as those that the "EMPLOYEE" may develop in the future, personally or as part of the team they belong to. Therefore, under no circumstances will they introduce games into the "COMPANY’s" computer equipment, nor install or use a copy of any other system or computer program not authorized by the "COMPANY". If they do so, they will be solely responsible for any legal actions that may arise, releasing the "COMPANY" from any liability incurred or attributed to it as a result. Additionally, if the "EMPLOYEE", through their actions, causes damage to the "COMPANY’s" computer systems or introduces a virus due to non-compliance with these obligations, they will be solely and wholly responsible for the repair of the damage, along with all corresponding legal consequences.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Ambas Partes convienen en que cualquier incumplimiento del “TRABAJADOR” de los términos mencionados en los incisos 15.1, 15.2, 15.3, 15.4, 15.5, 15.6, 15.7 y 15.8 anteriores, serán considerados como causa justificada de terminación de la relación de trabajo sin responsabilidad para la “EMPRESA”.</p>
                    <p>Asimismo, el “TRABAJADOR” manifiesta expresamente que, en caso de incumplimiento a las obligaciones contenidas en esta cláusula, será sujeto a la responsabilidad legal que derive, incluyendo, pero no limitándose, a la responsabilidad penal a que se hace referencia en el artículo 402 fracciones III y V de la Ley Federal de Protección a la Propiedad Industrial.</p>
                    <p><b>DÉCIMA SEXTA.</b> 16.1 El “TRABAJADOR” se compromete a utilizar adecuadamente los equipos, sistemas y programas de computación que tengan implementados la “EMPRESA”, así como los que el propio “TRABAJADOR” llegue a desarrollar en lo futuro, en lo personal o como parte del equipo de trabajo al que pertenezca. Por lo tanto, bajo ninguna circunstancia introducirá juegos en los equipos de computación de la “EMPRESA”, ni instalará o utilizará copia de cualquier otro sistema o programa de computación ajeno a aquellos que autorice la misma, dado que, de hacerlo será el único responsable de las acciones legales que en su caso procedan, liberando a la “EMPRESA” de cualquier responsabilidad en que se incurra o que se le pretenda atribuir por ello, además de que, de causar el “TRABAJADOR” con su actitud, daño a los sistemas de cómputo de la “EMPRESA” o introducirles algún virus por el incumplimiento de dichas obligaciones, ser  el único y total responsable de la reparación del mismo, con todas las consecuencias legales correspondientes.</p>

                </td>
            </tr>


        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>16.2 In this regard, the "EMPLOYEE" commits to use the computing systems solely as a work tool that will facilitate the information and communications, both internal and external, required in the tasks for which they have been hired. Thus, they will only access information necessary for the communications and operations directly related to the purposes and objectives of the "COMPANY", complying at all times with the policies established by the "COMPANY", without using this work tool for purposes unrelated to the activities for which they have been hired. In the event of losing or destroying the equipment assigned to them, the "EMPLOYEE" agrees to reimburse the "COMPANY" the commercial value of the same.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>16.2 En tal virtud, el “TRABAJADOR” se compromete a que únicamente utilizará los sistemas de computación como una herramienta de trabajo que le facilitará la información y comunicaciones internas y externas requeridas en las labores para las cuales ha sido contratado, por lo que sólo accesará la información que sea necesaria para la realización de comunicaciones y operaciones directamente relacionados con los fines y objetivos de la “EMPRESA”, cumpliendo en todo momento con las políticas establecidas por la misma, sin que pueda utilizar el “TRABAJADOR” dicha herramienta de trabajo para fines ajenos a las actividades para las cuales ha sido contratado. En caso de extraviar o destruir el equipo que le sea asignado, al “TRABAJADOR” acepta reembolsar a la “EMPRESA” el valor comercial del mismo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>16.3 If the "EMPLOYEE" fails to comply with the obligations agreed upon in this clause or in the fifteenth and/or sixteenth clauses of this Contract, they will be subject to civil liability for damages caused to the "COMPANY" and to the criminal sanctions they may incur.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>16.3 Si el “TRABAJADOR” dejara de cumplir con las obligaciones pactadas en esta cláusula o en las cláusulas décima quinta y/o décima sexta de este Contrato, quedará sujeto a la responsabilidad civil por daños y perjuicios que cause a “EMPRESA” y a las sanciones penales a que se haga acreedor.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTEENTH.</b> During the term of this Contract and for 1 (one) year following the termination of the employment relationship, the "EMPLOYEE" agrees not to accept, whether for compensation or for free, directly or indirectly (through third parties, whether individuals or legal entities), activities similar or analogous to those outlined in this Contract, or those that the "COMPANY" may develop in the future, for parties other than the "COMPANY", unless expressly authorized by the "COMPANY". Furthermore, the "EMPLOYEE" agrees, except with prior consent of the "COMPANY", not to invest, nor acquire rights, shares, and/or participations, directly or indirectly, in companies, legal entities, assets, businesses, joint ventures, and/or institutions that engage in activities similar or analogous to those outlined in this Contract or </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA SÉPTIMA.</b> Durante la vigencia del presente Contrato y durante 1 (un) año posterior a la terminación de la relación laboral, el “TRABAJADOR” se obliga a no aceptar, ya sea mediante compensación o de manera gratuita y directa o indirectamente (a través de terceros, ya sean personas físicas o morales), actividades similares o análogas a las previstas en el presente Contrato, o a las que la “EMPRESA” desarrolle en el futuro, para terceros distintos a la “EMPRESA”, a menos que ésta lo autorice expresamente. Asimismo, el “TRABAJADOR” se obliga, salvo por el consentimiento previo de la “EMPRESA”, a no invertir, ni adquirir derechos, acciones y/o participaciones, directa o indirectamente, en compañías, personas morales, activos, empresas, negocios,</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>



    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 45px !important'>



            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>that constitute the corporate purpose of the "COMPANY" or that imply competition for the latter, whether as an owner, co-owner, shareholder, partner, advisor, trustee, representative, agent, advisor, or in any other capacity, whether in their own right or on behalf of any partnership or commercial organization, nor to hire, call, or induce any person who is an employee or advisor of the "COMPANY" with the purpose of terminating their employment contract or otherwise ending their relationship with the "COMPANY.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> coinversiones y/o instituciones que realicen actividades análogas o similares a las previstas en el presente Contrato o que constituyan el objeto social de la “EMPRESA” o que impliquen competencia para esta última, ya sea como propietario, copropietario, accionista, socio, consejero, funcionario, fiduciario, representante, agente, asesor, o en cualquier otro carácter, ya sea por su propio derecho o en representación de alguna sociedad de personas o capital u organización comercial, ni a contratar, llamar o inducir a ninguna persona que sea empleado o asesor de la “EMPRESA” con el objeto de que de por terminado su contrato de trabajo o de alguna otra forma den por terminadas sus relaciones con la “EMPRESA”.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTEENTH.</b> 18.1 Confidentiality and Personal Data Protection. The "COMPANY" will implement confidentiality and data protection policies aimed at ensuring the protection of the "EMPLOYEE’s" information or personal data. At a minimum, such confidentiality and data protection policies and procedures must comply with the "Privacy Notice" of the "COMPANY", which the "EMPLOYEE" acknowledges and agrees to be familiar with. The "COMPANY" will annually evaluate its confidentiality and data protection policies and procedures to ensure that they comply with the Federal Law on Protection of Personal Data Held by Private Parties and its regulations.</p>
                    <p>18.2 Transfer of Personal Data. The "EMPLOYEE" agrees to the transfer of their personal data to third parties for the purpose of complying with the provisions of this Contract.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA OCTAVA.</b> 18.1 Confidencialidad y protección de datos personales. La “EMPRESA” implementará políticas de confidencialidad y protección de datos que busquen asegurar la protección de la información o datos personales del “TRABAJADOR”. Como mínimo, dichas políticas y procedimientos de confidencialidad y protección de datos deberán cumplir con lo dispuesto por el “Aviso de Privacidad” de la “EMPRESA”, el cual el “TRABAJADOR” manifiesta y acepta conocer. La “EMPRESA”, evaluará en forma anual sus políticas y procedimientos de confidencialidad y protección de datos para asegurarse que estos últimos cumplan con lo dispuesto en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares; y su reglamento.</p>
                    <p>18.2 Transferencia de datos personales. El “TRABAJADOR” acepta la transferencia de sus datos personales a terceros con el objeto de dar cumplimiento a lo dispuesto en este Contrato.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NINETEENTH.</b> The "EMPLOYEE" designates as BENEFICIARY(IES) for the payment of wages and benefits accrued and unpaid, in the event of their death, to:</p>
                    @if ($employeeDependents === 'NA' || $employeeDependents->isEmpty())
                    <p>No dependents found.</p>
                    @else

                    @foreach ($employeeDependents as $dependent)

                    <p> Full Name: {{ $dependent->full_name }}: 100%<br>

                        @endforeach

                        @endif
                        <p>Similarly, they will also be the beneficiary(ies) of compensations, benefits, wages, and others that may arise due to the death or disappearance resulting from a criminal act.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA NOVENA.</b> El “TRABAJADOR” designa como BENEFICIARIO(S) para el pago de los salarios y prestaciones devengadas y no cobradas, en caso de su fallecimiento, a:</p>
                    @if ($employeeDependents === 'NA' || $employeeDependents->isEmpty())
                    <p>No dependents found.</p>
                    @else
                    @foreach ($employeeDependents as $dependent)
                    <p> Full Name: {{ $dependent->full_name }}: 100%<br>
                        @endforeach
                        @endif
                        <p>De igual manera, será(n) beneficiario(s) de las indemnizaciones, prestaciones, salarios y demás que se generen por el fallecimiento o desaparición derivada de un acto delincuencial.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTIETH.</b> The "COMPANY" will grant leave to the "EMPLOYEE" when their minor child(ren) are diagnosed with any type of cancer, with the intention of accompanying the aforementioned patients in their respective medical treatments, in accordance with what is referred to in Article 140 Bis of the Social Security Law and 170 Bis of the Federal Labor Law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGÉSIMA.</b> La “EMPRESA” otorgará licencia al “TRABAJADOR” cuando su(s) hijo(s) menor(es) fuera(n) diagnosticado(s) con cualquier tipo de cáncer, con la intención de acompañar a los mencionados pacientes en sus correspondientes tratamientos médicos, de conformidad con lo que refiere el artículo 140 Bis de la Ley del Seguro Social y 170 Bis de la Ley Federal del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTY-FIRST.</b> The Parties recognize that the Federal Labor Law establishes that it will be a cause for termination of the employment relationship without liability for the employer if the employee engages in disobedience, lacks probity, or shows disloyalty or dishonesty, or commits acts of violence, negligence or misconduct against the "COMPANY" and its assets, coworkers, clients and suppliers of the "COMPANY" and their relatives, or the management or administrative staff of the "COMPANY" or establishment.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGÉSIMA PRIMERA.</b> Las Partes reconocen que la Ley Federal del Trabajo establece que será causa de rescisión de la relación laboral sin responsabilidad para el patrón, que el trabajador incurra en desobediencia, faltas de probidad, o deslealtad o deshonestidad, o en actos de violencia, negligencia o malas acciones en contra de la “EMPRESA” y sus bienes, compañeros de trabajo, clientes y proveedores de la “EMPRESA” y sus familiares, o del personal directivo o administrativo de la “EMPRESA” o establecimiento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Similarly, it will be a cause for termination without liability for the "COMPANY" if the "EMPLOYEE" discloses secrets or private or confidential matters, the disclosure of which may affect or harm the "COMPANY", as well as any violation of the confidentiality and noncompete agreements signed between the parties.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Igualmente será causa de rescisión sin responsabilidad para la “EMPRESA”, que el “TRABAJADOR” revele secretos o asuntos privados o reservados, cuya divulgación afecten o perjudiquen a la “EMPRESA”, así como cualquier violación a los contratos de confidencialidad y no competencia suscritos entre las partes.</p>
                </td>
            </tr>


        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTY-SECOND.</b> Both Parties agree that everything not provided for in this Contract will be in accordance with what is established by the Federal Labor Law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGÉSIMA SEGUNDA.</b> Ambas Partes convienen que todo aquello no previsto por el presente Contrato se estará a lo establecido por la Ley Federal del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTY-THIRD.</b> - For the interpretation, execution and compliance of this Contract, the Parties expressly submit to the legislation applicable in Mexico City and the jurisdiction and competence of the Labor Courts.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGESIMA TERCERA.</b> - Para la interpretación, ejecución y cumplimiento del presente Contrato, las Partes se someten expresamente a la legislación aplicable en la Ciudad de México y la jurisdicción y competencia de los Tribunales Laborales.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>This Individual Employment Contract is executed and signed in Mexico City on <b>April 23, 2025</b>, with each party retaining a copy.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>El presente contrato Individual de trabajo se celebra y firma en la, el día <b>23 DE ABRIL DE 2025</b> quedando un ejemplar en poder de cada una de las partes.</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center; width: 100%;">
            <p style='text-align: center'><b>EMPRESA</b></p>

            <div style="width: 70%; border-bottom: 1px solid black; margin: 70px auto 0;"></div>

            <p style="text-align: center"><b>INTERMEDIANO, S.A. DE C.V.</b></p>
            <p style="text-align: center"><b>LUIS JAVIER ARREGUIN SANCHEZ </b></p>
            <p style="text-align: center"><b>Representante legal </b></p>
        </div>
        <div style="width: 100%; border-bottom: 1px solid black; margin: 70px auto 0;"></div>

        <div style="text-align: center; width: 100%; margin-top: 40px;">
            <p style='text-align: center'><b>TRABAJADOR</b></p>

            <div style="text-align: center; position: relative; margin-top: 10px">
                <div style="display: inline-block; position: relative;">
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin: 0 auto;">
                    <p style="text-align: left">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @endif
                </div>

                <div style="width: 70%; border-bottom: 1px solid black; margin: -10px auto 0; z-index:100"></div>
                <p style="text-align: center"><b>{{ $employeeName }}</b></p>
                <p style="text-align: center; margin-top: -10px;"><b>Por su propio derecho</b></p>
            </div>
        </div>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}" style='page-break-after: avoid'>
        <table style='margin-top: -5px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>Annex A</b></p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>Anexo A</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The duties and responsibilities of the <b>"EMPLOYEE"</b> are illustrative but not exhaustive. A detailed list of the job description is provided on the last page of this document for reference.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Las funciones y responsabilidades del <b>"EMPLEADO"</b> son ilustrativas pero no exhaustivas. Una lista detallada de la descripción del puesto se encuentra en la última página de este documento para referencia.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>These duties are illustrative but not exhaustive, allowing the employee to perform other functions inherent to their position, as well as additional functions according to the requirements of the market and the company.</p>
                    <p>This document is signed in duplicate in Mexico City <b>____ __, 20__,</b> with each party retaining a copy</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Estas funciones son enunciativas más no limitativas, pudiendo el trabajador realizar otras funciones inherentes a su cargo, así como realizar funciones adicionales de acuerdo a los requerimientos del mercado y de la empresa. </p>
                    <p>El presente se firma por duplicado en la Ciudad de México, el día <b>___de _______ de 2025</b> quedando un ejemplar en poder de cada una de las partes.</p>
                </td>
            </tr>

        </table>
        <div style="text-align: center; width: 100%;">
            <p style='text-align: center'><b>EMPRESA</b></p>

            <div style="width: 70%; border-bottom: 1px solid black; margin: 70px auto 0;"></div>

            <p style="text-align: center"><b>INTERMEDIANO, S.A. DE C.V.</b></p>
            <p style="text-align: center"><b>LUIS JAVIER ARREGUIN SANCHEZ </b></p>
            <p style="text-align: center"><b>Representante legal </b></p>
        </div>
        <div style="width: 100%; border-bottom: 1px solid black; margin: 70px auto 0;"></div>

        <div style="text-align: center; width: 100%; margin-top: 10px;">
            <p style='text-align: center'><b>TRABAJADOR</b></p>

            <div style="text-align: center; position: relative; margin-top: 0px">
                <div style="display: inline-block; position: relative;">
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin: 0 auto;">
                    <p style="text-align: left">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @endif
                </div>

                <div style="width: 70%; border-bottom: 1px solid black; margin: -10px auto 0; z-index:100"></div>
                <p style="text-align: center"><b>{{ $employeeName }}</b></p>
                <p style="text-align: center; margin-top: -10px;"><b>Por su propio derecho</b></p>
            </div>
        </div>
        @include('pdf.contract.layout.footer')


        @include('pdf.contract.layout.header')
        <div style="border: 1px solid rgb(188, 188, 188); margin: 0px 10px 0 10px; padding: 20px; page-break-after: always;">
            <p style="text-align: center; font-weight: bold;">1. DUTIES AND RESPONSIBILITIES</p>
            {!! $jobDescription !!}
        </div>
        @include('pdf.contract.layout.header')
        <div style="border: 1px solid rgb(188, 188, 188); margin: 0px 10px 0 10px; padding: 20px;">
            <p style="text-align: center; font-weight: bold;">1. FUNCIONES Y RESPONSABILIDADES DEL TRABAJADOR</p>
            {!! $translatedJobDescription !!}
        </div>
        @include('pdf.contract.layout.footer')


    </main>

</body>

</html>
