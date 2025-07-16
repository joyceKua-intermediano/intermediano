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

$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('es_CR', \NumberFormatter::SPELLOUT);
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;

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
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">EMPLOYEMENT CONTRACT</h4>
                    <p>PERSONAL QUALITIES:</p>
                    <p>We, <b>INTERMEDIANO SRL.</b>, Company registered under number 3-102-728410, represented on this act by Mr. JUAN CARLOS UMAÑA, adult, Costa Rican, married, Identity Card number 1 522 385, public accountant, neighbor of Escazú center, in his status as Legal Representative, hereinafter referred to as the "<b>EMPLOYER</b>" </p>
                    <p>and </p>
                    <p>{{ $employeeName }}, with ID {{ $employeeTaxId }}, Nationality {{ $employeeNationality }}, with address at {{ $employeeAddress }}, {{ $employeeCity }} {{ $employeeCountry }}, hereinafter referred to as "the <b>EMPLOYEE</b>," in accordance with the following individual employment contract:</p>
                    <p><b>DECLARATIONS:</b></p>
                    <p>For the purposes of this contract: it will be understood:</p>
                    <p><b>THE EMPLOYER:</b></p>
                    <p>a. That <b>INTERMEDIANO S.R.L.</b> is a Costa Rican company duly constituted under national laws, registered under number three – one hundred two - seven hundred twenty-eight thousand and four hundred and ten.</p>
                    <p>b. That within the activities that constitute its corporate purpose, it is foreseen the provision of personnel services to various clients under subcontracting terms. This is why it is necessary to contract services from external workers, so as is required for the kind of work to be rendered to the clients as well as for being special and extraordinary.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE TRABAJO</h4>
                    <p>CALIDADES PERSONALES:</p>
                    <p>Nosotros, <b>INTERMEDIANO S.R.L.</b>, Cédula jurídica número 3-102-728410, representada para este acto por el señor JUAN CARLOS UMAÑA, mayor, costarricense, casado, cédula de identidad número 1 522 385, contador público, vecino de Escazú centro, en su condición de Representante Legal, en adelante denominado como el “<b>PATRONO</b>” </p>
                    <p>y</p>
                    <p>{{ $employeeName }}, con ID {{ $employeeTaxId }}, Nacionalidad {{ $employeeNationality }}, con domicilio en {{ $employeeAddress }}, {{ $employeeCity }} {{ $employeeCountry }}, en adelante "el <b>TRABAJADOR</b>" de acuerdo al siguiente contrato individual de trabajo:</p>
                    <p><b>DECLARACIONES:</b></p>
                    <p>Para los efectos del presente contrato se en-tenderá por:</p>
                    <p><b>EL PATRONO:</b></p>
                    <p>a. Que <b>INTERMEDIANO S.R.L.</b> es una empresa costarricense debidamente constituida bajo las leyes nacionales, con cédula de persona jurídica número tres -ciento dos - setecientos veintiocho mil cuatrocientos diez.</p>
                    <p>b. Que dentro de las actividades que constituyen su objeto social, se encuentra prevista la prestación de servicios de personal a diversos clientes en forma subcontratada. Razón por la cual tiene la necesidad de contratar los servicios de trabajadores externos, por así exigirlo la naturaleza del trabajo que se va a prestar a los clientes y ser éste de carácter especial y extraordinario.</p>
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
                    <p><b>THE WORKER:</b></p>
                    <p>a. Declares to know the <b>EMPLOYER</b> corporate purpose and accepts that the provision of the services, duties and obligations will always be under <b>INTERMEDIANO S.R.L.</b>’s name, at the indicated work address and accept the conditions of the services for a certain period.</p>
                    <p>b. That THE WORKER expressly agrees that the EMPLOYER will be the one who determines the place where the contracted services will be rendered, and expressly accepts that, in case this contract concludes, it shall be terminated in accordance with the provisions of the Labor Code of the Republic of Costa Rica.</p>
                    <p>c. That the parties acknowledge and accept that this Agreement may be amended only expressly by the parties, through an addendum signed by a representative of each party.</p>
                    <p>Therefore, we agree on the following </p>
                    <p><b>CLAUSES:</b></p>
                    <p><b>FIRST. WORK RELATIONSHIP.</b></p>
                    <p>The work relationship will consist in personal services provision of the WORKER who will perform the functions {{ $employeeJobTitle }} for the EMPLOYER (INTERMEDIANO S.R.L.)</p>
                    <p><b>SECOND. CONTRACT LENGHT.</b></p>
                    <p>The length will be for a time starting on {{ $employeeStartDateFormated }} and ending on {{ $employeeEndDateFormated }}. At the convenience of both parties, this contract may be renewed by agreement of the parties, for which an annex will be signed. In case the EMPLOYER unilaterally wants to end this contract, he will have the power to do it by adjusting to all existing labor regulations at the ending time.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EL TRABAJADOR:</b></p>
                    <p>a. Manifiesta conocer el objeto social del <b>PATRONO</b> y acepta que la prestación de sus servicios, deberes y obligaciones será siempre a nombre de <b>INTERMEDIANO S.R.L.</b>, en el domicilio laboral que se indique y acepta las condiciones de sus servicios por tiempo determinado.</p>
                    <p>b. Que EL TRABAJADOR acepta expresamente que su PATRONO será quien determine el lugar donde se ejecutarán las funciones contratadas, y expresamente acepta que, en caso de que el presente contrato concluya, éste se finiquitará de acuerdo con lo establecido en el Código de Trabajo de la República de Costa Rica.</p>
                    <p>c. Que las partes reconocen y aceptan que el presente Contrato podrá ser enmendado úni-camente de forma expresa por las partes, mediante adenda suscrito por un representante de cada parte.</p>
                    <p>Por tanto, acuerdan las siguientes </p>
                    <p><b>CLÁUSULAS:</b></p>
                    <p><b>PRIMERA. RELACIÓN LABORAL.</b></p>
                    <p>La relación laboral consistirá en la prestación de servicios personales del TRABAJADOR quien realizará las funciones de {{ $employeeJobTitle }} para el PATRONO (INTERMEDIANO S.R.L.)</p>
                    <p><b>SEGUNDA. PLAZO DE CONTRATO.</b></p>
                    <p>El plazo será por tiempo a partir del {{ $employeeStartDateLocal }} y terminará el {{ $employeeEndDateLocal }}. A conveniencia de ambas partes este contrato podrá ser renovado por acuerdo de partes, para lo cual se suscribirá un anexo. En caso de que el PATRONO de manera unilateral quiera rescindir del presente contrato, tendrá la facultad de hacerlo ajustándose a toda la normativa laboral existente al momento del finiquito.</p>
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
                    <p><b>THIRD. WORKING DAY.</b></p>
                    <p>The working schedule will be from <b>MONDAY TO FRIDAY: 9 AM/5PM, fulfilling 40 hours a week</b>. However, it is accepted that it can be varied at the moment that the EMPLOYER considers it necessary, within the corresponding legal framework. In case that the WORKER is required to perform an extraordinary day, this day has an administrative approval process, which will be only approved (if applicable) by the Human Resources supervisor in written form, notifying the WORKER, for the approval or the refusal for this specific case.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TERCERA. JORNADA.</b></p>
                    <p>La jornada de trabajo será de <b>LUNES A VIER-NES: 9AM/5PM, cumpliendo así 40 horas semanales</b>. Sin embargo, se acepta que el mismo puede ser variado en el momento que el PATRONO lo considere necesario, dentro del marco legal correspondiente. En caso de que se requiera que el TRABAJADOR realice jornada extraordinaria, dicha jornada tiene un trámite de aprobación administrativa, la cuales serán únicamente aprobadas (en caso de que proceda) por el supervisor de Recursos Humanos de manera escrita, notificando con ello al TRABAJADOR, de su aprobación o de su negativa para el caso concreto.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTH. SALARY.</b></p>
                    <p>The WORKER will receive a monthly salary of {{ number_format($employeeGrossSalary,2) }} gross/month ({{ strtoupper($formatter->format($employeeGrossSalary)) }}) . The payment will be monthly, by deposit in his/her savings account or checking account or by any other way under the EMPLOYER´s judgment that guarantees the greatest security to the WORKER.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CUARTA. SALARIO.</b></p>
                    <p>El TRABAJADOR percibirá un salario mensual de {{ number_format($employeeGrossSalary,2) }} ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }}). El pago será mensual, mediante depósito en su cuenta de ahorros o cuenta corriente o mediante cualquier otro medio que a juicio del PATRONO garantice la mayor seguridad al TRABAJADOR. </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTH. PLACE.</b></p>
                    <p>The WORKER commit to provide the services in the place or places determined by THE EMPLOYER, according to the needs and provisions required. For this, THE WORKER expressly agrees that the workplace may be changed by THE EMPLOYER, in accordance with the technical and productive requirements. THE EMPLOYER shall inform THE WORKER of any change in this sense, one day in advance, when applicable by the guidelines of the articles 38 and 39 of the Labor Code.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>QUINTA. LUGAR.</b></p>
                    <p>El TRABAJADOR se compromete a prestar el servicio en el lugar o lugares determinados por EL PATRONO, de acuerdo con las necesidades y disposiciones propias de éste. Para ello, EL TRABAJADOR acepta expresamente que el lugar de trabajo puede ser variado por EL PATRONO, de acuerdo con los requerimientos técnicos y productivos de éste. EL PATRONO procurará informar a EL TRABAJADOR de cualquier cambio en este sentido, con un día de antelación, siempre y cuando se apliquen los lineamientos del artículo 38 y 39 del Código de Trabajo.</p>
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
                    <p><b>SIXTH. GENERAL OBLIGATIONS OF THE WORKER.</b></p>
                    <p>a) THE WORKER has as main obligation to perform duties as {{ $employeeJobTitle }}, since these functions are not exhaustive, they may be changed according to the requirements of the EMPLOYER. Before any production need, time compliance delivery or any other business requirement, and in accordance with the EMPLOYER´s discretion, </p>
                    <p>THE WORKER may be exceptionally required to perform other tasks other than those normally performed, b) THE WORKER is obliged to do his/her best and act in good faith, according to his/her capacity and abilities, to achieve the purpose that is sought by signing this Agreement, for which it will be subject to the payment systems and will carry out the labor matters consultations only with the EMPLOYER and will be subject to the work systems, guidelines, security measures and the coexistence of the place of work, of the EMPLOYER or the work places where his/her services are rendered, as well as giving the best use to the work elements that are given to him for the performance of the function entrusted to him, c) the WORKER also will be subject to the client's guidelines on a) Order and Discipline, b) workers obligations and respect to the check-in and check-out time of their functions c) Uniforms and work clothes have to be formal, like dress pants and long or three quarters sleeved shirt, c.1) In working hours, special events, seminars of the employer and/or the client, should not use any type of piercing. d) Safety and hygiene standards of the workplace and e) Licensing obtaining and Permission guidelines established by the client, </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTA. OBLIGACIONES GENERALES DEL TRABAJADOR.</b></p>
                    <p>a) EL TRABAJADOR tiene como obligación principal realizar labores de {{ $employeeJobTitle }} siendo que dichas funciones no son taxativas, por lo que podrán variarse según requerimiento del PATRONO. Ante cualquier necesidad de producción, de cumplimiento de tiempos de entrega o de cualquier otro requerimiento empresarial, y de acuerdo con el criterio discrecional del PATRONO, </p>
                    <p>EL TRABAJADOR podrá ser requerido en forma excepcional a realizar otras labores distintas a las que desarrolla habitualmente, b) EL TRABAJADOR se obliga a hacer su mejor esfuerzo y actuar de buena fe, de acuerdo con su capacidad y aptitudes, para lograr el fin que se busca con la firma del presente Contrato, para lo cual se sujetará a los sistemas de pago y realizará las consultas en materia laboral solamente al PATRONO y se sujetará a los sistemas de trabajo, directrices, medidas de seguridad y convivencia del lugar donde le corresponde ejecutar su trabajo, del PATRONO o de los centros de trabajo en que se preste sus servicios, así como dar el mejor uso a los elementos de trabajo que se le otorguen para el desarrollo de la función que le encomienden los jefes o superiores que le asignen para el cumplimiento de los servicios contratados, c) Asimismo se sujetará el TRABAJADOR a los lineamientos del cliente sobre a) Orden y Disciplina, b) Obligaciones de los trabajadores y respeto de los horarios de entrada y salida de sus funciones, c) Uniformes y ropa de trabajo siendo formal, tipo pantalón de vestir y camisa manga larga o tres cuartos, c.1) En horas laborales, eventos especiales, seminarios del patrono y/o el cliente no deberá utilizar ningún tipo de piercing. d) Normas de Seguridad e higiene del centro de trabajo y e) Lineamientos de obtención de Licencias y Permisos establecidos por el cliente, </p>
                </td>
            </tr>



        </table>
        @include('pdf.contract.layout.footer')
    </main>



    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>f) The worker agrees to carry out his/her work with the highest efficiency and performance on execution, according to the guidelines given by the EMPLOYER, being his/her responsibility to avoid errors in the production, g) THE WORKER is bound to keep full confidentiality in relation to the technical and professional information, that comes to his/her knowledge by virtue of the execution of the contracted functions, attempting to the protection of the technical and professional secrets of which he / she is aware by work reasons he / she performs, as well as any confidential administrative information of THE EMPLOYER or its representatives, clients or employees. The breach of this confidentiality duty and regulations will give THE EMPLOYER the right to terminate this CONTRACT without any employer liability, without prejudice to the application of the national protecting information regulations Not Disclosed and any other applicable legal measure.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p>f) El trabajador se compromete a realizar sus labores con la mayor eficiencia y rendimiento que está ejecutando, conforme a los lineamientos dados por el PATRONO, siendo su responsabilidad evitar errores en la producción, g) EL TRABAJADOR se obliga a guardar total confidencialidad en relación con la información técnica y profesional, que llegue a su conocimiento en virtud de la ejecución de las funciones contratadas, procurando el resguardo de los secretos técnicos y profesionales de los cuales tenga conocimiento por razón del trabajo que ejecute, así como también de cualquier información administrativa confidencial de EL PATRONO o sus representantes, clientes o empleados. La violación a este deber de confidencialidad y normativas dará pie a EL PATRONO a dar por finalizado el presente CONTRATO sin responsabilidad patronal, sin perjuicio de la aplicación de la normativa nacional protectora de la información No Divulgada y de cualquier otra medida legal aplicable.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTH. ADDRESS AND NOTICES.</b></p>
                    <p>The parties designate as their addresses for all communications, notices and notifications (judicial and extrajudicial), the following:</p>
                    <p><b>INTERMEDIANO S.R.L</b> Avenidas 2 y 4, Calle 5,
                        Oficinas LCU & Asociados, Escazú Centro, San José,
                    </p>
                    <p><b>BY THE WORKER:</b> {{ $employeeName }}.</p>
                    <p> THE WORKER shall have all the benefits indicated in the Labor Code.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEPTIMA. DOMICILIO Y AVISOS.</b></p>
                    <p>Las partes designan como sus domicilios para todo tipo de comunicaciones, avisos y notificaciones (judiciales y extrajudiciales), las siguientes:</p>
                    <p><b>INTERMEDIANO S.R.L</b> Avenidas 2 y 4, Calle 5,
                        Oficinas LCU & Asociados, Escazú Centro, San José,
                    </p>
                    <p><b>DEL TRABAJADOR:</b> {{ $employeeName }}.</p>
                    <p> EL TRABAJADOR tendrá todos los beneficios que indique el Código de Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NINTH. BREACH OF CONTRACT.</b></p>
                    <p>In case of failure of the WORKER’s obligations with his/her labor to the EMPLOYER that violates morality, good manners or do not fully exercise the tasks entrusted by both the EMPLOYER and the CLIENT,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOVENA. INCULPLIMIENTO.</b></p>
                    <p>En caso de incumplimiento del TRABAJADOR con sus obligaciones laborales para con el PATRONO que atenten contra la moral, las buenas costumbres o no ejerzan a cabalidad con las tareas encomendadas tanto por el PATRONO como por EL CLIENTE,</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p> as well as those indicated by the Labor Code, this contract will be terminated without responsibility from the EMPLOYER. THE WORKER shall also indemnify the EMPLOYER for any expenses he has incurred due to the difficulty of replacing him with another worker of his/her own attitudes as well as for the training costs for his/her replacement, all in accordance with the provisions of the Republic Costa Rica’s Labor Code.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> así como de las indicadas por el Código de Trabajo, éste contrato se dará por terminado sin responsabilidad patronal. Asimismo, EL TRABAJADOR indemnizará al PATRONO cualquier gasto que haya realizado debido a la dificultad del mismo para reemplazarlo con otro funcionario de sus mismas actitudes y así como de los costos de capacitación para su reemplazo, todo a tenor de lo dispuesto en el Código de Trabajo de la República de Costa Rica.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TENTH. CONFIDENTIALITY.</b></p>
                    <p>OF CONFIDENTIALITY. All information obtained by the WORKER in his/her place of work or by being an employee of the EMPLOYER under business activities and under the development of the same work as well as the result of the services carried out as a WORKER, is considered as confidential, except for information previously known by the WORKER or that is in the public domain before or after the WORKER receives such information. Without limiting the generality of the foregoing, THE WORKER shall keep all such information in confidential and shall not use it for its own benefit or to provide it to third parties to perform the same functions. In case of non-compliance with this resolutely condition, he / she must pay unconditionally in favor of the EMPLOYER or, if applicable, to the affected client, the damages and losses caused by his/her actions as indicated in the Law. Likewise, the worker recognizes the confidentiality respect to this contract, especially with regards to the salary earned. THE WORKER agrees with the acknowledgement about the prohibition to use in favor of natural or legal persons other than THE CLIENT, the equipment, tools, knowledge and information that he acquires during the provision of services to the CLIENT,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DECIMA. CONFIDENCIALIDAD.</b></p>
                    <p>DE LA CONFIDENCIALIDAD. Se considera confidencial toda la información obtenida por el TRABAJADOR en su lugar de trabajo o por ser empleado del PATRONO, en actividades del negocio y del desarrollo del mismo trabajo como también del resultado de los servicios llevados a cabo como TRABAJADOR, excepto aquella información previamente conocida por el TRABAJADOR o que sea del dominio público antes o después de que el TRABAJADOR reciba dicha información. Sin limitar la generalidad de lo anterior, EL TRABAJADOR deberá mantener toda esa información en confidencialidad y no hará uso de la misma para beneficio propio o para brindarla a terceros para desarrollar las mismas funciones. En caso de incumplimiento de esta condición resolutoria deberá pagar incondicionalmente a favor del PATRONO o en su caso al cliente afectado los daños y perjuicios ocasionados por su accionar conforme a lo que indica la Ley. Asimismo, se reconoce por parte del trabajador la confidencialidad con respecto a este contrato, sobre todo en lo que se refiere al salario devengado. EL TRABAJADOR da por entendido la prohibición de utilizar a favor de personas físicas o jurídicas distintas a EL CLIENTE, los equipos, herramientas, conocimiento e información que adquiere durante la prestación de servicios al CLIENTE,</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p> likewise THE WORKER understands the prohibition to supply or provide information, documentation, production processes, policies, inventions, machinery, equipment, patents, trademarks and other resources to which he/her has access or are classified as confidential information in connection with the provision of services. Shall be considered confidential information any administrative, technical, trade secrets, know-how, industrial information, data and any other methods, techniques or information supplied by THE CLIENT directly or indirectly and that under no circumstances shall be disclosed after the end of the employment relationship. The worker also recognizes the confidentiality with respect to the main contract with regards the salary earned. As well, THE WORKER aware of the legal consequences, declare that he/she will not disclose the confidential information, or the knowledge acquired or derived from dealing with it, being reserved the right of THE CLIENT, to exercise the corresponding legal actions.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> así mismo EL TRABAJADOR da por entendido la prohibición de suministrar o facilitar a personas ajenas a EL CLIENTE información, documentación, procesos de producción, políticas, inventos, maquinaria, equipo, patentes, marcas y demás recursos a los que tenga acceso o se cataloguen como información confidencial con motivo de la prestación de servicios. Será considerada información confidencial toda información administrativa, técnica, secretos de comercio, know-how, información industrial, datos y cualesquiera otros métodos, técnicas o información suplida por EL CLIENTE directa o indirectamente y que bajo ninguna circunstancia podrá ser revelada luego de la terminación de la relación laboral. Asimismo, se reconoce por parte del trabajador la confidencialidad con respecto al contrato principal en lo que se refiere al salario devengado. Por su parte, EL TRABAJADOR advertido de las consecuencias lega-les, declara que no revelará la información Confidencial, o el conocimiento adquirido o derivado del manejo de aquella, quedando a salvo el derecho de EL CLIENTE, de ejercer las acciones legales que correspondan.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>ELEVENTH. MATERIALS, EQUIPMENT AND TOOLS.</b></p>
                    <p>THE EMPLOYER at the request of the CLIENT, will supply all kinds of tools and work materials for the good performance of the tasks entrusted to the WORKER. THE WORKER, for his/her part, undertakes to make good use of them and to return them at the moment they are requested in the same condition in which they were delivered, except for normal deterioration due to their use. Within which a badge will be given to the WORKER so that he/she can carry out his/her work, being that once the contract is ended for any of the reasons established by the Costa Rican’s Labor Code,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DECIMA PRIMERA. MATERIALES, EQUIPO Y HE-RRAMIENTAS.</b></p>
                    <p>EL PATRONO a solicitud del CLIENTE, suminis-trará todo tipo de herramientas y utensilios de trabajo para el buen desarrollo de las labores encomendadas al TRABAJADOR. EL TRABAJADOR por su parte se compromete a hacer buen uso de las mismas y a devolverlas en el momento en que se le soliciten en el mismo estado en que le fueron entregadas, salvo el deterioro normal por su uso. Dentro de los cuales se entregará un gafete al TRABAJADOR para que pueda desempeñar sus labores siendo que una vez terminado el contrato por cualquiera de las razones establecidas por el Código de Trabajo de Costa Rica,</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p> he/she is responsible towards the EMPLOYER to deliver it in good conditions; otherwise he/her must cancel the value of one hundred US dollars ($ 100.00 US) for the replacement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> se hace responsable ante el PATRONO de entregar el mismo en buen estado de lo contrario deberá cancelar la suma de cien dólares estadouni-dense ($100.00 U.S.) para su reposición.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWELVETH.</b></p>
                    <p>It is understood by both parties that all administrative procedures such as but not limited to rebates, salary records, work environment, economic compensation, overtime approvals, administrative complaints, among others HAVE to be channeled only by employees from INTERMEDIANO S.R.L.’s company; otherwise, it is considered a serious fault and that can be considered as dismissals cause without the employer's responsibility.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DECIMA SEGUNDA.</b></p>
                    <p>Se entiende por ambas partes que todo trámite administrativo tales como pero no limitativo a rebajas, constancias salariales, ambiente laboral, remuneración económica, aprobación de horas extras, quejas administrativas, entre otras TIENEN que ser canalizadas únicamente por personeros de la empresa de INTERMEDIANO S.R.L., caso contrario se considera una falta grave y que puede constituirse como causal de despidos sin responsabilidad patronal.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRTEENTH. SPECIFIC OBLIGATIONS OF THE WORKER: </b></p>
                    <p>In accordance with the requirements of the job, which is the <b>Global Process Owner</b>, and according to the purpose of the position that will work with multiple teams across the organization to streamline Support's processes with those of other teams. This would also require collaboration with the Product Team and Operations Team to implement changes. of THE CLIENT procedures in relation to the company’s policies, the following specific functions are decreed, without the ones mentioned here being exhaustive and exclusive, it is understood that if any other is necessary for the accomplishment of the proper operation, it must be carried out as long as it adheres to the good customs and business practices.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DECIMA TERCERA. OBLIGACIONES ESPECÍFICAS DEL TRABAJADOR: </b></p>
                    <p>De conformidad con los requerimientos del puesto de trabajo, el cual es el de <b>Global Process Owner</b> y de acuerdo con el objetivo del puesto que será trabajar con múltiples equipos de toda la organización para racionalizar los procesos de Soporte con los de otros equipos. Esto también requerirá la colaboración con el equipo de productos y el equipo de operaciones para aplicar los cambios de EL CLIENTE en relación a las políticas de la empresa, se decretan las siguientes funciones específicas sin que las que aquí se mencionan sean taxativas y exclusivas enten-diéndose que si se requiere alguna otra necesaria para la realización de su buen funcionamiento, se deberá realizar siempre y cuando se apegue a las buenas costumbres y prácticas empresariales.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <div style="border: 1px solid rgb(188, 188, 188); margin: 0px 10px 0 10px; padding: 20px; page-break-after: always;">
        <p style="text-align: center; font-weight: bold; text-decoration: underline">Main tasks</p>
        <p><b>JOB TITLE: {{$employeeJobTitle}}</b></p>
        {!! $jobDescription !!}

    </div>
    @include('pdf.contract.layout.header')
    <div style="border: 1px solid rgb(188, 188, 188); margin: 20px 10px 0 10px; padding: 20px; page-break-after: always;">
        <p style="text-align: center; font-weight: bold; text-decoration: underline">Funciones Principales</p>
        <p><b>CARGO: {{$employeeJobTitle}}</b></p>
        {!! $translatedJobDescription !!}

    </div>
    @include('pdf.contract.layout.footer')




    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}" style='page-break-after: avoid'>
        <table style='margin-top: -5px'>


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTHEENTH. APPLICABLE LAW AND JURISDICTION. </b></p>
                    <p>For all matters relating to the interpretation, performance and execution of this Agreement, the parties submit to the applicable provisions of the Civil Code of Commerce and the Republic of Costa Rica’s Labor Code and to the Tribunals jurisdiction of the city San Jose, renouncing any other jurisdiction that by reason of their present or future addresses could correspond to them. Having read the present Contract, the parties sign it in two copies in the city of <b>San José, on </b> </p>
                    <p>{{ $formattedDate }} of {{ $month }} of {{ $year }}.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DECIMA CUARTA. LEY APLICABLE Y JURISDIC-CIÓN.</b></p>
                    <p>Para todo lo relativo a la interpretación, cumplimiento y ejecución del presente Contrato, las partes se someten a las disposiciones aplicables del Código Civil de Comercio y el Código del Trabajo de la República de Costa Rica y a la jurisdicción de los Tribunales de la Ciudad de San José, renunciando a cualquier otro fuero que por razón de sus domicilios presentes o futuros pudiera corresponderles. Leído que fue el presente Contrato, lo firman las partes en dos tantos en la ciudad de <b>San José, el</b> </p>
                    <p> {{$day}} de {{ $translatedMonth }} de {{ $year }}.</p>

                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; position: relative; height: 200px;">
                        <div style="text-align: left;">
                            <p><b>Employer:</b> <span style="font-weight: bold; padding-left: 5px;">INTERMEDIANO SRL</span></p>
                        </div>
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                    </div>
                    @if (!empty($adminSignedBy))
                    <div style="margin-top: -25px;">
                        <p style="text-align: center; margin: 0;">C. J. 3-102-728410</p>
                        <p style="text-align: center; margin: 0;">{{ $adminSignedBy }}</p>
                        <p style="text-align: center; margin: 0;">{{ $adminSignedByPosition }}</p>
                    </div>
                    @endif

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; position: relative; height: 200px;">
                        <div style="text-align: left;">
                            <p><b>Employer:</b> <span style="font-weight: bold; padding-left: 5px;">INTERMEDIANO SRL</span></p>
                        </div>
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                    </div>
                    @if (!empty($adminSignedBy))
                    <div style="margin-top: -25px;">
                        <p style="text-align: center; margin: 0;">C. J. 3-102-728410</p>
                        <p style="text-align: center; margin: 0;">{{ $adminSignedBy }}</p>
                        <p style="text-align: center; margin: 0;">{{ $adminSignedByPosition }}</p>
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="display: inline-block; position: relative; height: 200px; width: 100%;">
                        <div style="text-align: left;">
                            <p><b>Worker:</b> <span style="font-weight: bold; padding-left: 5px;">{{ $employeeName }}</span></p>
                        </div>
                        @if($signatureExists)
                        <img src="{{ 
                                $is_pdf
                                    ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                    : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                                }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 60px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>
                        @endif
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">C.I {{ $employeeTaxId }}</p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="display: inline-block; position: relative; height: 200px; width: 100%;">
                        <div style="text-align: left;">
                            <p><b>Worker:</b> <span style="font-weight: bold; padding-left: 5px;">{{ $employeeName }}</span></p>
                        </div>
                        @if($signatureExists)
                        <img src="{{ 
                                $is_pdf
                                    ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                    : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                                }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>
                        @endif
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">C.I {{ $employeeTaxId }}</p>
                    </div>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
