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
$formattedStartDate = now()->format('jS');
$monthStartDate = now()->format('F');
$yearStartDate = now()->format('Y');

$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->nationality ?? null;
$employeeState = $record->personalInformation->state ?? null;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeCountryWork = $record->country_work ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? null;
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
$formatterLocal = new \NumberFormatter('es_CL', \NumberFormatter::SPELLOUT);
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

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 80px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">EMPLOYMENT CONTRACT</h4>
                    <p style='line-height: 1.6'>In Santiago, Chile, <b>{{ $formattedStartDate }} of {{ $monthStartDate }}, {{ $yearStartDate }},</b> between <b>Intermediano Chile SPA,</b>
                        Unique Tax Identification Nº. 77.223.3612, domiciliated at Calle El Gobernador 20, Oficina 202, Providencia, Santiago,
                        Región Metropolitana, legally represented by Mr. Fabian Castro Sepúlveda, both with residing at Santiago, Chile, hereinafter <b>"the Employer"</b> or <b>"Intermediano Chile SPA",</b> by one side; and by the other, <b>{{ $employeeName }}</b>, with RUN {{ $employeeTaxId }}, Nationality {{ $employeeNationality }}, with address at {{ $employeeAddress }}, hereinafter referred to as <b>"the Employee,"</b> in accordance with the following individual employment contract:
                    </p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE TRABAJO </h4>
                    <p style='line-height: 1.6'>En Santiago de Chile, <b>{{ $formattedStartDate }} {{ $monthStartDate }}, {{ $yearStartDate }},</b> entre <b>Intermediano Chile
                            SPA,</b> Rol Único Tributario Nº.
                        77.223.361-2, con domicilio en Calle
                        El Gobernador 20, Oficina 202,
                        Providencia, Santiago, Región
                        Metropolitana, representada
                        legalmente por el Sr. Fabian Castro
                        Sepúlveda, ambos con domicilio en
                        Santiago, Chile, en adelante <b>"el Empleador"</b> o <b>"Intermediano Chile SPA",</b> por una parte; y por la otra,
                        <b>{{ $employeeName }},</b> con RUN {{ $employeeTaxId }}, Nacionalidad
                        {{ $employeeNationality }}, con domicilio en
                        {{ $employeeAddress }}, en
                        adelante <b>"el Trabajador"</b> de acuerdo
                        al siguiente contrato individual de
                        trabajo: </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.6'><b>FIRST:</b> The Employee agrees to work as a
                        <b>{{ $employeeJobTitle }},</b> this position is expected to
                        have responsibility for the following
                        roles/tasks. Initial roles shall be as below
                        (but not limited to) and </p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.6'><b>PRIMERO:</b> El Trabajador acepta
                        desempeñarse como <b>{{ $employeeJobTitle }}</b> y
                        tendrá la responsabilidad de llevar a
                        cabo las siguientes labores y tendrá
                        un contrato a término indefinido: </p>

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
                    <p><b>Job Description</b></p>

                    {!! $jobDescription !!}
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Descripción de tareas </b></p>

                    {!! $translatedJobDescription !!}
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
                    <p><b>SECOND:</b>The Employee will work from &nbsp; [XXXX] &nbsp; and agrees to follow the
                        guidelines given by the employer to
                        give orders as well as to be compliant
                        with the policies and standards of
                        conduct set by the Employer. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEGUNDO:</b> El Trabajador trabajará en &nbsp; [XXXX] &nbsp; se compromete a seguir las
                        directrices dadas por el empleador,
                        y a cumplir con las políticas y normas
                        de conducta establecidas por el
                        empleador para sus trabajadores. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRD:</b> It is established that given the
                        nature of the function performed by the
                        Employee it is excluded from the limitation of working hours in
                        accordance with the provisions of the
                        second paragraph of Article 22 of the
                        Labor Code.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TERCERO:</b> Se establece que dada la
                        naturaleza de la función realizada
                        por el Trabajador se excluye de la limitación de las horas de trabajo de
                        conformidad con lo dispuesto en el
                        párrafo segundo del artículo 22 del
                        Código del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTH:</b> The Employer shall pay the
                        Employee, for his services, the following
                        remuneration and allowances: </p>
                    <p>A gross basic monthly salary of <b>CLP</b>
                        {{ number_format($employeeGrossSalary, 2)}} <b>gross/month</b>
                        {{ strtoupper($formatter->format($employeeGrossSalary)) }} which will be
                        settled and paid in cash or check at the
                        Employer’s location or through deposit
                        or electronic transfer into the
                        Employee's bank account, <b>the last day
                            of the month.</b> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CUARTO:</b> El Empleador pagará al
                        Trabajador, por sus servicios lo
                        siguiente: </p>
                    <p>Un sueldo base mensual bruto de
                        <b>CLP CLP bruto/mes</b> {{ number_format($employeeGrossSalary, 2)}} ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }}) el
                        cual será pagado en efectivo o
                        cheque en las instalaciones del
                        empleador o mediante depósito o
                        transferencia electrónica a la cuenta
                        bancaria del Trabajador, <b>el último
                            día hábil del mes.</b> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Gratification:</b> The parties agree that the
                        employee will receive a legal
                        gratification of the 25%, with an annual
                        ceiling of 4,75 of the minimum monthly
                        income according to Article 50 of the
                        Working Code. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Gratificación:</b> Las partes acuerdan
                        que el trabajador percibirá
                        mensualmente una gratificación
                        legal del 25%, con tope anual de 4,75
                        de ingresos mínimos mensuales
                        según artículo 50 del Código del
                        Trabajo. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTH:</b> For all legal purposes of this
                        contract, it is expressly stated that the
                        Worker began to perform his duties on
                        {{ $employeeStartDateFFormated }}, and the
                        contract will last for 90 days until [End
                        Day]/[End Month]/[End Year], after
                        which it will become indefinite. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>QUINTO:</b> Para todos los efectos
                        legales de este contrato, se hace
                        constar expresamente que el
                        Trabajador comenzó a desarrollar sus
                        funciones el [Día] de [Mes] de [Año
                        de inicio] y el contrato tendrá
                        duración de 90 días hasta el {{ $employeeStartDateFFormated }},
                        fecha a partir de la cual se tornará
                        indefinido. </p>
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
                    <p><b>SIXTH:</b> For all the effects that may take
                        place, it is stated that the Employee did
                        not have to change his place of
                        residence by reason of this contract. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTO:</b> Para todos los efectos del
                        presente contrato, se establece que
                        el Trabajador no ha tenido que
                        cambiar su lugar de residencia en
                        virtud de este contrato. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTH:</b> The termination causes of this
                        employment contract are contained in
                        Articles 159, 160 and 161 of the Labor
                        Law Code and in the future be
                        established by law, all of which are
                        hereby expressly incorporated by
                        reference and deemed to form part of
                        this contract.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>
                        <b>SÉPTIMO:</b> Las causas de terminación
                        de este contrato de trabajo están
                        contenidas en los artículos 159, 160 y
                        161 del Código de Derecho del
                        Trabajo y en el futuro se establezcan
                        por ley, todos los cuales se
                        incorporan expresamente por
                        referencia y que se consideran
                        formar parte de este contrato.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTH:</b> For the purposes of this
                        contract, the Employee acknowledges
                        to have been trained by the Employer
                        for the role and functions to be
                        performed and it is stated that the
                        Employee received a copy of the Rules
                        of Order Health and Safety. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>OCTAVO:</b> Para los efectos de este
                        contrato, el Trabajador reconoce
                        haber sido entrenado por el
                        empleador para el papel y las
                        funciones a realizar y se establece
                        que el Trabajador recibió una copia
                        del Reglamento Interno de Orden
                        Higiene y Seguridad. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NINTH:</b> The Employee is expressly
                        prohibited from carrying out any
                        activity that is or may reasonably be
                        expected to be in actual or potential
                        conflict with the interests of the
                        Employer. The Employee is also
                        prohibited to develop or carry out,
                        directly or through third parties,
                        activities that are within the current or
                        future line of business. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOVENO:</b> El Trabajador tiene
                        expresamente prohibido realizar
                        cualquier actividad que puede ser
                        conflicto real o potencial con los
                        intereses del empleador. El
                        Trabajador también está prohibido
                        para desarrollar o llevar a cabo,
                        directamente a través de terceros,
                        actividades que están dentro de la
                        línea actual o futuro de los negocios.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TENTH:</b> In the performance of his duties,
                        the Employee, directly or indirectly,
                        orally or in written, will have access to
                        information related to the operation of
                        the Employer, and their respective
                        clients and/or providers, which the
                        Employee acknowledges is secret,
                        proprietary, private and confidential.
                        Therefore, unless express and prior
                        authorization of the Employer,
                        Employee is forbidden, during the term
                        of this agreement and after its
                        termination, to (i) use for his own benefit
                        or for the benefit of any other third party,
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMO:</b> En el ejercicio de sus
                        funciones, el trabajador, directa o
                        indirectamente, en forma oral o
                        escrita, tendrá acceso a la
                        información relacionada con el
                        funcionamiento del empleador, y sus
                        respectivos clientes y/o proveedores,
                        respecto de la cual el Trabajador
                        reconoce que se trata de
                        información secreta, privada y
                        confidencial. Por lo tanto, a menos
                        que cuente con la autorización
                        previa y expresa del Contratante, el
                        Trabajador tiene prohibido, durante a vigencia de este acuerdo y
                        después de su terminación</p>
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
                    <p> (ii) facilitate or (iii) allow the use in
                        a form or effect that could adversely
                        affect in any manner the name or
                        business interest of the Employer, any
                        confidential information of the
                        Employer or, and specially of any of
                        related companies and subsidiaries,
                        shareholders, directors, representatives,
                        employees, customers and suppliers, to
                        which the Employee may have access
                        during the performance of his duties. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(i) utilizar
                        para su propio beneficio o en
                        beneficio de cualquier tercero, (ii)
                        facilitar o (iii) permitir el uso en una
                        forma o efecto, que pueda afectar
                        negativamente, de cualquier
                        manera el nombre o los intereses del
                        negocio del empleador, cualquier
                        información confidencial del
                        empleador, y especialmente de
                        cualquiera de las empresas
                        vinculadas y sus subsidiarias,
                        accionistas, directores,
                        representantes, trabajadores,
                        clientes y proveedores, a la que el
                        Trabajador pudiera tener acceso en
                        el ejercicio de sus funciones.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Employee is obliged to maintain
                        absolute secrecy and confidentiality to
                        third parties, as well as not to disclose,
                        copy or transmit in any manner or form
                        whatsoever, any information related to
                        the activities of the Employer and their
                        related companies and subsidiaries,
                        shareholders, directors, representatives,
                        employees, customers and suppliers, to
                        which the Employee may had access
                        with occasion of this employment
                        contract, both before starting the
                        employment relationship and during
                        and after its termination, such as
                        projects, methods, secrets, services,
                        marketing strategies, plans, economic
                        evaluations, bids, research, software,
                        values and costs, know-how and
                        innovative techniques, price lists, etc. to
                        which the Employee may have access
                        during the provision of services. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Trabajador está obligado a
                        mantener el secreto y la
                        confidencialidad absoluta respecto
                        de terceros, así como a no divulgar,
                        copiar o transmitir de cualquier
                        manera o forma, cualquier
                        información relacionada con las
                        actividades de la Empresa y sus
                        empresas relacionadas y subsidiarias,
                        accionistas, directores,
                        representantes, trabajadores,
                        clientes y proveedores, a los que el
                        Trabajador pueda haber tenido
                        acceso con ocasión de este
                        contrato de trabajo, tanto antes de
                        comenzar la relación laboral, como
                        durante y después de su
                        terminación, tales como proyectos,
                        métodos, secretos, servicios de
                        marketing estrategias, planes,
                        evaluaciones económicas,
                        licitaciones, investigación, softwares,
                        valores y costos, know how y
                        técnicas innovadoras, listas de
                        precios, etc., a las cuales el
                        Trabajador pueda tener acceso
                        durante la prestación de los servicios.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>For this purpose, the Employer and
                        Employee hereby acknowledge and
                        agree that any document and
                        information directly or indirectly
                        provided by, or obtained by the
                        Employee from, the Employer, or any of
                        the entities or persons mentioned
                        above, is confidential and a secret
                        unless expressly states otherwise in
                        writing.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Para este propósito, el empleador y
                        el Trabajador reconocen y aceptan
                        que cualquier documento e
                        información directa o
                        indirectamente proporcionada por,
                        u obtenidos por el Trabajador del
                        Empleador o cualquiera de las
                        entidades o personas mencionadas
                        anteriormente, es confidencial y
                        secreta, a menos se manifiesta
                        expresamente lo contrario por
                        escrito. </p>

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

                    <p>As per the Employee’s duties, he shall
                        be required to ensure an adequate
                        control of all the Employer's and (and
                        the above-mentioned persons' and
                        entities’) information and data and
                        ensure that it will not be used
                        elsewhere, and also to prevent
                        duplication or reproduction of such
                        data, in whole or in part, by any other
                        employee or third person strange to the
                        Employer. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p>De acuerdo con los deberes del
                        trabajador, se le requerirá asegurar
                        el control de toda la información del
                        Empleador (y de las personas y
                        entidades antes mencionadas)
                        como la información y los datos y
                        asegurar que no va a ser utilizado en
                        otros lugares, y también para
                        prevenir la duplicación o
                        reproducción de estos datos, en su
                        totalidad o en parte, por cualquier
                        otro Trabajador o tercera persona
                        extraña al Empleador. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>ELEVENTH:</b> Due to the nature of the
                        Employee’s position, he shall not be
                        entitled to participate in any collective
                        bargaining or to integrate any
                        bargaining commission, pursuant to
                        Article 305 of the Labor Code.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>UNDÉCIMO:</b> Debido a la naturaleza
                        de la posición del trabajador, no
                        tendrá derecho a participar en
                        negociaciones colectivas o para
                        integrar las comisiones de
                        negociación, de conformidad con el
                        artículo 305 del Código del Trabajo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWELFTH:</b> Any modification to this
                        contract, addition or deletion of
                        paragraphs or part thereof, shall be
                        made in writing, and no matter the
                        signing of a new contract, as
                        amendments, deletions or additions do
                        not alter in form substantial provisions
                        hereof.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DUODÉCIMO:</b> Cualquier
                        modificación a este contrato,
                        adición o supresión de los párrafos o
                        parte del mismo, se hará por escrito,
                        y no requiere la firma de un nuevo
                        contrato. </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRTEENTH:</b> This contract is signed in two
                        copies of the same date, one of them
                        being held by the Employer and one
                        held by the Employee. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMO TERCERO:</b> El presente
                        contrato se firma en dos ejemplares
                        de la misma fecha, quedando uno
                        de ellos en poder del empleador y
                        uno en poder del trabajador. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top; text-align: center; padding: 0 10px;  margin-top: -20px">
                    <h4 style=''>Intermediano Chile SPA</h4>
                    <div style="text-align: center; position: relative; height: 40px;">
                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 40px; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);" />
                        @endif
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    @if (!empty($adminSignedBy))
                    <p style="margin: 0; text-align: center;">{{ $adminSignedBy }}</p>
                    <p style="margin: 0; text-align: center;">{{ $adminSignedByPosition }}</p>
                    <p style="margin: 0; text-align: center;">R.U.T.: 77.223.361-2</p>
                    @endif
                </td>
                <td style="width: 50%; vertical-align: top; text-align: center; padding: 0 10px;  margin-top: -20px">
                    <h4 style=''>Intermediano Chile SPA</h4>
                    <div style="text-align: center; position: relative; height: 40px;">
                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 40px; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);" />
                        @endif
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    @if (!empty($adminSignedBy))
                    <p style="margin: 0; text-align: center;">{{ $adminSignedBy }}</p>
                    <p style="margin: 0; text-align: center;">{{ $adminSignedByPosition }}</p>
                    <p style="margin: 0; text-align: center;">R.U.T.: 77.223.361-2</p>
                    @endif
                </td>


            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        <p style="text-align: center">RUT {{ $employeeTaxId }}</p>

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                        }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -15px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 1000; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        @endif
                        <p style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        <p style="text-align: center">RUT {{ $employeeTaxId }}</p>

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                        }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -15px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 1000; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        @endif
                        <p style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>

                    </div>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
