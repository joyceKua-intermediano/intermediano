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
$employeePhone = $record->personalInformation->phone ?? null;
$employeeMobile = $record->personalInformation->mobile ?? null;
$employeeCountry = $record->personalInformation->country ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeStartDateFFormated = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\of F \\of Y')
: 'N/A';$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$employeeTaxId = $record->document->tax_id ?? null;

$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('es_EC', \NumberFormatter::SPELLOUT);
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;

$signaturePath = 'signatures/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('public')->exists($signaturePath);

@endphp

<style>
    .main-container {
        text-align: justify;
    }

    p {
        line-height: 1.4 !important
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
    .footer {
        height: 70px;
    }
    .footer img {
        padding-top: 10px;

    }
    .footer-address {
        width: 50% !important
    }


</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">INDEFINITE-TERM EMPLOYMENT CONTRACT WITH PROBATIONARY PERIOD</h4>
                    <p>In the city of Quito, on the {{ $day }} day of the month of {{ $month }} of the year {{ $year }}, appear, on the one hand, Intermediano Ecuador Intermecu SAS with RUC number 0993273333001, duly represented by Mr. Carlos Arturo Garcia Luzuriaga, holder of citizenship ID No. 1708047186, in his capacity as EMPLOYER; and on the other hand, {{ $employeeName }}, holder of citizenship ID No. {{ $employeePersonalId }}, in his capacity as WORKER. The appearing parties are of {{ $employeeNationality }}, respectively domiciled at Av. Francisco Orellana E12-148 and Av. 12 de Octubre, Office 206, Mariscal Sucre, Quito, Pichincha, Ecuador, and {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeCountry }} and are capable of entering into contracts. They freely and voluntarily agree to execute this INDEFINITE CONTRACT subject to the declarations and stipulations contained in the following clauses:</p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE TRABAJO POR TIEMPO INDEFINIDO CON PERÍODO DE PRUEBA</h4>
                    <p>En la ciudad de Quito, a los {{ $day }} días del mes de {{ $translatedMonth }} del año {{ $year }}, comparecen, por una parte Intermediano Ecuador Intermecu SAS con número de RUC 0993273333001 debidamente representada por el Sr. Carlos Arturo Garcia Luzuriaga, portador de la cédula de ciudadanía Nro. 1708047186, en calidad de EMPLEADOR; y por otra parte, el señor [NOMBRE DEL TRABAJADOR], portador de la cédula de ciudadanía Nro. [CÉDULA DEL TRABAJADOR], en calidad de TRABAJADOR. Los comparecientes son de nacionalidad [NACIONALIDAD], respectivamente domiciliado en Av. Francisco Orellana E12-148 y Av. 12 de Octubre, Oficina 206, Mariscal Sucre, Quito, Pichincha, Ecuador, y [DOMICILIO DEL TRABAJADOR], y son capaces para contratar, quienes libre y voluntariamente convienen en celebrar este CONTRATO INDEFINIDO con sujeción a las declaraciones y estipulaciones contenidas en las siguientes cláusulas:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST- BACKGROUND:</b> The EMPLOYER, for the fulfillment of its activities and the development of tasks inherent to its stable and permanent activity, needs to hire the labor services of {{ $employeeName }}. After reviewing the background of Mr./Ms. {{ $employeeName }}, he/she declares to have the necessary knowledge for the performance of the indicated position. Based on the above considerations and as expressed in the following paragraphs, the EMPLOYER and the WORKER proceed to enter into this Employment Contract.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PRIMERA - ANTECEDENTES:</b> El EMPLEADOR, para el cumplimiento de sus actividades y el desarrollo de las tareas inherentes a su actividad estable y permanente, necesita contratar los servicios laborales de {{ $employeeName }}. Revisados los antecedentes del Sr./Sra. {{ $employeeName }}, él/ella declara tener los conocimientos necesarios para el desempeño del cargo indicado. Con base en las consideraciones anteriores y lo expresado en los párrafos siguientes, el EMPLEADOR y el TRABAJADOR proceden a celebrar el presente Contrato de Trabajo.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SECOND - SCOPE:</b> The EMPLOYEE (a) agrees to provide his legal and personal services under the EMPLOYER (a) as {{ $employeeJobTitle }} with responsibility and care, who will perform them in accordance with the Law, the general provisions,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEGUNDA - OBJETO:</b>El TRABAJADOR (a) se compromete a prestar sus servicios lícitos y personales bajo la dependencia del EMPLEADOR (a) en calidad de {{ $employeeJobTitle }} con responsabilidad y esmero,</p>
                </td>
            </tr>

            @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 0px !important'>



            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>the orders and instructions given by the EMPLOYER, dedicating his best effort and capacity in the performance of the activities for which he has been hired. Maintain the degree of efficiency necessary for the performance of the tasks, keep confidentiality in matters that by their nature have this quality and that on the occasion of the work were known, proper handling of documents, assets and values of the EMPLOYER and that are under her responsibility.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>que los desempeñará de conformidad con la Ley, las disposiciones generales, las órdenes e instrucciones que imparta El EMPLEADOR, dedicando su mayor esfuerzo y capacidad en el desempeño de las actividades para las cuales ha sido contratado. Mantener el grado de eficiencia necesaria para el desempeño de sus labores, guardar reserva en los asuntos que por su naturaleza tuviere esta calidad y que con ocasión de su trabajo fueran de su conocimiento, manejo adecuado de documentos, bienes y valores del EMPLEADOR y que se encuentran bajo su responsabilidad.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRD - WORKING SCHEDULE:</b>The EMPLOYEE undertakes to work within the maximum legal working day established in article 47 of the Labor Code, from Monday to Friday at [WORKING HOURS], with a break of one hour, with one hour rest for lunch, according to article 57 of the same legal body, the same one she declares to know and accept it.</p>
                    <p>Saturdays and Sundays will be days of forced rest, as established in article 50 of the Labor Code,
                        (Explanatory note: If due to circumstances work cannot be interrupted, by mutual agreement another equal time may be established for said rest).
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TERCERA - HORARIO DE TRABAJO:</b>El TRABAJADOR se obliga a laborar en la jornada legal máxima establecida en el artículo 47 del Código del Trabajo, de lunes a viernes en el horario de [HORARIO], con descanso de una hora para el almuerzo, de acuerdo al artículo 57 del mismo cuerpo legal, el mismo que declara conocerlo y aceptarlo.</p>
                    <p>Los sábados y domingos serán días de descanso forzoso, según lo establece el artículo 50 del Código del Trabajo,
                        (Nota explicativa: Si por las circunstancias no se puede interrumpir el trabajo, de mutuo acuerdo se podrá establecer otro tiempo igual para dicho descanso).
                    </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(Explanatory note: In the event that the employer needs special schedule of hours, it must be subject to the provisions of Ministerial Agreement No. 169 - 2012)</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(Nota explicativa: En el caso de que el empleador necesite horarios especiales, deberá sujetarse a lo establecido en el Acuerdo Ministerial Nro. 169 – 2012)</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTH - REMUNERATION:</b></p>
                    <p>The EMPLOYER, in accordance with articles 80, 81 and 83 of the Labor Code, will pay the amount of {{number_format($employeeGrossSalary) }} ( {{ strtoupper($formatter->format($employeeGrossSalary)) }}), as remuneration in favor of the worker by means of accreditation to the worker's bank account.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CUARTA - REMUNERACIÓN:</b>El EMPLEADOR, de acuerdo a los artículos 80, 81 y 83 del Código de Trabajo, cancelará por concepto de remuneración a favor del trabajador la suma de {{number_format($employeeGrossSalary) }} gross/month ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }}) , mediante acreditación a la cuenta bancaria del trabajador.</p>
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
                    <p>In addition, the EMPLOYER will pay the other social benefits established in articles 111 and 113 of the Labor Code, considering the proportionality in relation to the remuneration that corresponds to the full day. Likewise, the EMPLOYER will recognize the surcharges corresponding to supplementary or extraordinary hours, by agreement of the parties, if they have been previously authorized and in writing, according to article 55 of the Labor Code.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Además, el EMPLEADOR cancelará los demás beneficios sociales establecidos en los artículos 111 y 113 del Código del Trabajo tomando en consideración la proporcionalidad en relación con la remuneración que corresponde a la jornada completa. Asimismo, el EMPLEADOR reconocerá los recargos correspondientes a las horas suplementarias o extraordinarias, mediante acuerdo de las partes, siempre que hayan sido autorizados previamente y por escrito, según el artículo 55 del Código del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTH - DURATION OF THE CONTRACT:</b></p>
                    <p>The worker will initially enter a trial period of 90 days if he passes the trial, the Contract will be Indefinite. </p>
                    <p>This contract may be terminated for the reasons established in Articles 169, 172 and 173 of the Labor Code as soon as they are applicable to this type of contract.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>QUINTA - DURACIÓN DEL CONTRATO:</b></p>
                    <p>El trabajador inicialmente ingresará a un periodo de prueba de 90 días si pasa la prueba, el Contrato será Indefinido. </p>
                    <p>Este contrato podrá terminar por las causales establecidas en el Art. 169, 172 y 173 del Código del Trabajo en cuanto sean aplicables para este tipo de contrato.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SIXTH - PLACE OF WORK:</b></p>
                    <p>The EMPLOYEE (a) will perform the functions for which he has been hired at the facilities located at {{ $employeeCountryWork }} , in the city of {{ $employeeCity }} for the full fulfillment of the tasks entrusted to him.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTA - LUGAR DE TRABAJO:</b></p>
                    <p>El TRABAJADOR (a) desempeñará las funciones para las cuales ha sido contratado en las instalaciones ubicadas en {{ $employeeCountry }}, en la ciudad de {{ $employeeCity }}, para el cumplimiento cabal de las funciones a él encomendadas.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTH - OBLIGATIONS OF WORKERS AND EMPLOYERS:</b></p>
                    <p>Regarding the obligations, rights and prohibitions of the employer and worker, these are strictly subject to the provisions of the Labor Code, in its Chapter IV of the obligations of the employer and the worker, in addition to those stipulated in this contract. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SÉPTIMA - OBLIGACIONES DE LOS TRABAJADORES Y EMPLEADORES:</b></p>
                    <p>En lo que respecta a las obligaciones, derecho y prohibiciones del empleador y trabajador, estos se sujetan estrictamente a lo dispuesto en el Código del Trabajo, en su Capítulo IV de las obligaciones del empleador y del trabajador, a más de las estipuladas en este contrato. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}" style='page-break-after: avoid'>
        <table style='margin-top: -5px'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTH - APPLICABLE LEGISLATION:</b></p>
                    <p>In all matters not provided for in this Contract, whose special modalities are recognized and accepted by the parties, they are subject to the Labor Code.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>OCTAVA - LEGISLACIÓN APLICABLE:</b></p>
                    <p>En todo lo no previsto en este Contrato, cuyas modalidades especiales las reconocen y aceptan las partes, éstas se sujetan al Código del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NINTH - JURISDICTION AND COMPETENCE:</b></p>
                    <p>In case of discrepancies in the interpretation, fulfillment, and execution of this Contract and when it is not possible to reach an amicable agreement between the parties, these will be submitted to the competent judges of the place where this contract has been entered into, as well as to the procedure orally determined by law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOVENA - JURISDICCIÓN Y COMPETENCIA:</b></p>
                    <p>En caso de suscitarse discrepancias en la interpretación, cumplimiento y ejecución del presente Contrato y cuando no fuere posible llegar a un acuerdo amistoso entre las partes, estas se someterán a los jueces competentes del lugar en que este contrato ha sido celebrado, así como al procedimiento oral determinados por la Ley.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TENTH - SUBSCRIPTION:</b></p>
                    <p>The parties ratify each one of the preceding clauses and for proof and full validity of the provisions they sign this contract in original and two copies of equal tenor and value, in the city of Quito the {{ $day }} day of the month of {{ $month }} of the year {{ $year }}.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA - SUSCRIPCIÓN:</b></p>
                    <p>Las partes se ratifican en todas y cada una de las cláusulas precedentes y para constancia y plena validez de lo estipulado firman este contrato en original y dos ejemplares de igual tenor y valor, en la ciudad de Quito el día {{ $day }} del mes de {{ $translatedMonth }} del año {{ $year }}.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <div style="text-align: center; position: relative; height: 120px;">

                        <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%; font-weight: bold;">INTERMECU SAS</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%; font-weight: bold;">R.U.C.: 0993273333001</p>
                    </div>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <div style="text-align: center; position: relative; height: 120px;">

                        <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%; font-weight: bold;">INTERMECU SAS</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%; font-weight: bold;">R.U.C.: 0993273333001</p>
                    </div>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        @if($signatureExists)
                        <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 60px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>

                        @endif
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">{{ $employeeTaxId }}</p>

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        @if($signatureExists)
                        <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>

                        @endif
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">{{ $employeeTaxId }}</p>

                    </div>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
