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
$dayNumber = now()->format('d');
$month = now()->format('F');
$year = now()->format('Y');
$currentDate = now()->format('[d/m/Y]');
$companyName = $record->company->name;
$customerAddress = $record->company->address;
$customerPhone = $record->companyContact->phone;
$customerEmail = $record->companyContact->email;
$customerName = $record->companyContact->contact_name;
$customerPosition = $record->companyContact->position;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->country ?? null;
$employeeState = $record->personalInformation->state ?? null;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeEmail = $record->employee->email ?? null;
$employeeAddress = $record->personalInformation->address ?? null;
$employeeCity = $record->personalInformation->city ?? null;
$employeeDateBirth = $record->personalInformation->date_of_birth ?? null;
$employeePhone = $record->personalInformation->phone ?? null;
$employeeCountry = $record->personalInformation->country ?? null;
$employeeEducation = $record->personalInformation->education_attainment ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
$personalId = $record->document->personal_id ?? null;
$personalTaxId = $record->document->tax_id ?? null;
$countryWork = $record->country_work ?? null;
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;
$pensionFund = $record->socialSecurityInfos->pension_fund ?? 'N/A';
$signaturePath = 'signatures/employee_' . $record->id . '.webp';
$signatureExists = Storage::disk('public')->exists($signaturePath);
switch (true) {
case $employeeCountry == 'Colombia':
$employeeLocality = 'colombiana';
$employeeNationality = 'Colombian';
break;

default:
$employeeNationality = '';
$employeeLocality = '';

break;
}
@endphp

<style>
    .compact-table {
        border-collapse: collapse;
        width: 100%;
    }

    .compact-table td {
        padding: 10px;
        /* Reduced from typical 5px */
        vertical-align: top;
    }

    .compact-table p {
        margin: 1px 0;
        /* Reduced from typical 5px */
        font-size: 0.9em;
    }

</style>
<body>
    <!-- Content Section -->

    @include('pdf.contract.layout.header')
    <main>
        <table class="compact-table">
            <tr>
                <td style="width: 50%; vertical-align: top;" colspan="2">
                    <p><b>CONTRATO DE TRABAJO A TERMINO INDEFINIDO</b>(Salario Integral)</p>
                </td>
                <td style="width: 50%; vertical-align: top;" colspan="2">
                    <p><b>WORK CONTRACT - INDEFINITE TERM</b> <br> (Integral Salary)</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Empleador</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>INTERMEDIANO COLOMBIA S.A.S.</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Employer</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>INTERMEDIANO COLOMBIA S.A.S.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Identificación</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>NIT: 901.389.463-5</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Identification</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>NIT: 901.389.463-5</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Dirección</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Carrera 7B Bis #126-36, Bogotá – Colombia</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Address</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Carrera 7B Bis #126-36, Bogotá - Colombia</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Teléfono</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>+5 301 377 2115</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Phone number</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>+5 301 377 2115</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Trabajador</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeName }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Employee</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeName }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Identificación</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $personalId }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Personal ID</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $personalId }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Dirección</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeAddress }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Address</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeAddress }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Teléfono</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeePhone }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Phone Number</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeePhone }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Fecha de Nacimiento</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeDateBirth }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Date of Birth</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeDateBirth }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>E-mail</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeEmail }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>E-mail</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeEmail }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Cargo</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeJobTitle }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Position</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeJobTitle }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Salario</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>COP {{ number_format($employeeGrossSalary, 2) }} <span style='font-size: 10px; padding-bottom: 2px;'> {{ strtoupper($formatterLocal->format($employeeGrossSalary)) }} </span> </p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Salary</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>COP {{ number_format($employeeGrossSalary, 2) }} <span style='font-size: 10px'>{{ strtoupper($formatter->format($employeeGrossSalary)) }} </span> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Tipo de salario</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>lntegral</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Salary mode</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>lntegral</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Período de pago</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Mensual</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Payment period</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Monthly</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Duración</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Término indefinido</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Duration</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Indefinite Term</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Lugar celebración contrato</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Bogotá D.C.</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Place of contract</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Bogota D.C.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Lugar de ejecución contrato</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>A Nivel Nacional</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Labor placement</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Throughout and within Colombian national territory</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Fecha de inicio del contrato</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeStartDate }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Contract start date</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeStartDate }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <p>Fecha de finalización del contrato</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeEndDate }}</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>Contract end date</p>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <p>{{ $employeeEndDate }}</p>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Entre quienes suscriben a saber:
                        <b>JENNIFFER KATHERINE CASANOVA OSPINA,</b> quien obra en nombre y representación de la compañía <b>INTERMEDIANO COLOMBIA SAS.,</b> quien obra para los
                        efectos del presente contrato se
                        denominara el "<b>Empleador</b>" de una
                        parte, y de la otra {{ $employeeName }}, igualmente mayor de edad, de nacionalidad {{ $employeeLocality }}, identificado/a como aparece al pie de su firma quien obra en su propio
                        nombre y quien para los efectos del
                        presente contrato se denominara
                        "<b>Empleado</b>", hemos convenido en
                        suscribir el presente contrato individual de
                        trabajo, a término indefinido que se menciona a continuación,
                        contrato regulado de manera general por las normas laborales y contenido de manera especial en las siguientes clausulas:
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Among those who subscribe to: <b>JENNIFFER KATHERINE CASANOVA OSPINA,</b> who works in the name and representation of the company <b>INTERMEDIANO COLOMBIA SAS.,</b> who works for the purposes of this contract will be called the <br> "<b>Employer</b>" of one party, and the other, otra {{ $employeeName }}, also of legal age, of {{ $employeeNationality }} nationality, identified as it appears at the foot of his signature who works in his own name and who for the purposes of this contract will be called <br> "<b>Employee</b>", we have agreed to subscribe the present individual contract of work, to a indefinite term, mentioned below, a contract generally regulated by labor standards and contained in a special way in the following clauses:</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PRIMERA. - OBJETO, FECHA DE
                            INICIACION DE LABORES DURACION.</b> Las partes acuerdan que
                        la duración del presente contrato será a término indefinido y su fecha de inicio será a partir de {{ $employeeStartDate }} por tiempo indefinido.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST. - PURPOSE, DATE OF COMMENCEMENT AND DURATION.</b> The parties agree that the duration of this contract will be for a indefinite term and its starting date will be from {{ $employeeStartDate }}, undefined period.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEGUNDA. - SEDE DE TRABAJO.</b> El
                        Empleado tendrá sede principal de
                        trabajo en Colombia. Sin embargo, conforme a las funciones propias del cargo {{ $employeeJobTitle }}, el Empleado tendrá que viajar dentro y/o fuera del territorio colombiano.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SECOND. - PLACE OF WORK.</b> The Employee will have main headquarters of work in Colombia. However, according to the functions of the position of {{ $employeeJobTitle }}, the Employee will have to travel within and / or outside the Colombian territory.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TERCERA. - REMUNERACION. SALARIO INTEGRAL.</b>
                        El Empleador pagará al Empleado por Ia prestación de sus servicios personales, bajo Ia modalidad de
                        salario integral mensual, la suma de
                        {{ strtoupper($formatterLocal->format($employeeGrossSalary)) }} Moneda Colombiana (<b>COP</b> {{ number_format($employeeGrossSalary, 2) }} M/Cte.)
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>THIRD. - INTEGRAL REMUNERATION. SALARY.</b> The employer will pay the Employee for the provision of his personal services, under the modality of integral monthly salary the sum of {{ strtoupper($formatter->format($employeeGrossSalary)) }} Colombian Currency (<b>COP</b> {{ number_format($employeeGrossSalary, 2) }} M/Cte.)</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PARAGRAFO PRIMERO:</b> Este salario
                        además de retribuir el trabajo ordinario, comprende el pago de prestaciones, recargos y beneficios tales como los concernientes al trabajo nocturno, extraordinario o de horas extras, en días de descanso obligatorio, sobresueldos, descansos dominicales y festivos, primas legales, la cesantía y sus intereses, los suministros en especie, los subsidios y, en general toda clase de prestaciones legales.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST PARAGRAPH:</b> The above-mentioned salary comprises the payment of allowances, surcharges and benefits, such as those regarding night work, overtime, on mandatory rest days, premiums, work on Sundays and official and public holidays, legal allowances, severance and interests, incentives in kind, subsidies and, in general, all kinds of legal benefits. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PARAGRAFO SEGUNDO:</b> Cuando por
                        causa emanada directa indirectamente de la relación contractual existan obligaciones de tipo económico a cargo del Empleado y a favor del Empleador, este último procederá a efectuar las deducciones a que hubiere lugar en cualquier tiempo y, más concretamente, a la terminación del presente contrato,
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SECOND PARAGRAPH:</b> lf due to causes directly or indirectly originated in the contractual relationship there are economical obligations to be met by the Employee and in favor of the Employer, the latter will deduct the respective amounts at any time, and even specially, upon termination of the present contract,
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>así lo autoriza desde ahora el Empleado, entendiendo expresamente las partes que la presente autorización cumple las condiciones, de orden escrita previa, aplicable para cada caso. Las partes entienden expresamente que esta autorización cumple con las condiciones de una orden previa por escrito, aplicable a cada caso.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>so The Employee now authorizes, the parties expressly understanding that this authorization meets the conditions, of a prior written order, applicable in each case.
                        The parties expressly understood that this authorization meets the conditions prior written order, applicable to each case.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CUARTA. - PERIODO Y FORMA DE PAGO.</b> El salario acordado en la cláusula tercera será pagado en Colombia, mensualmente en pesos Colombianos (COP) mediante transferencia electrónica de la cual es titular el Empleado.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTH. - PERIOD & PAYMENT MODE.</b> The agreed salary in the third clause, will be paid in Colombia, monthly, in Colombian pesos (Cop$) through electronic transfer to the employee bank account. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>QUINTA. - BENEFICIOS EXTRALEGALES.</b> De conformidad con el artículo 128 del Código sustantivo del trabajo, la partes acuerdan que toda prestación, bonificación, subsidio, beneficio o auxilio, que no obstante lo estipulado anteriormente reciba llegue a recibir el Empleado, en dinero o en cualquier especie, habitual u ocasionalmente, que exceda en cualquier forma o por cualquier causa el salario arriba expresado en la cláusula tercera, no constituyen salario y, en consecuencia, no será tenido en cuenta para efectos de calcular el valor de vacaciones, indemnizaciones y, en general, para el pago de cualquier otra acreencia de carácter laboral y/o en materia de seguridad social y parafiscales.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTH. - EXTRALEGAL BENEFITS.</b> According to the article 128 of the Labour Code, the parties expressly agree that any occasional allowance, bonus, subsidy, relief or benefit granted by the Employer to the Employee, other than those entitled to by this Contract, will be understood to be granted by mere generosity and will not constitute a permanent benefit nor will it entitle the Employee to claim it, and the Employer may modify said allowance or benefit at its own discretion. Therefore, any such occasional allowance, etc., shall not be considered for calculating the value of vacations, severance payments and, in general, for the payment of any other labor and/or social security obligation.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PARÁGRAFO PRIMERO:</b> Todos Ios beneficios extralegales que reciba el empleado estarán sujetos a las políticas y condiciones fijadas por el Empleador.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST PARAGRAPH:</b> Any extralegal allowance given to the Employee will be subject to the policies and conditions established by the Employer.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTA. - OBLIGACIONES DEL EMPLEADO.</b> El Empleado se obliga especialmente, además de las obligaciones que establezca la ley, el reglamento de Trabajo o el Empleador, a:</p>
                    <p>1) Desempeñar con prontitud, eficiencia e imparcialidad las funciones de su cargo, así como ejecutar las órdenes que se le impartan; </p>
                    <p>2) Observar en sus relaciones con el público o con quienes solicitan sus servicios la consideración y cortesía debidas; </p>
                    <p>3) Guardar la reserva que requieren los asuntos relacionados con su trabajo, debido a su naturaleza o en virtud de instrucciones especiales, aún después de haber terminado el contrato, sin perjuicio de denunciar cualquier hecho delictuoso que perjudique al Empleador; </p>
                    <p>4) Dedicar la totalidad del tiempo reglamentario de su trabajo al desempeño de las funciones que le han sido encomendadas; </p>
                    <p>5) Resumir sus funciones al vencimiento de las licencias, permisos, vacaciones, etc.; </p>
                    <p>6) Tener decoro y corrección de su comportamiento, respeto a sus superiores, compañeros y subalternos; </p>
                    <p>7) Responder de la manera más rigurosa y darle un uso acorde con el trabajo a los documentos, útiles, equipos, materias primas, insumos, tarjetas de crédito, muebles y bienes asignados con ocasión a sus funciones, para el desempeño de su trabajo o confiados para su guardia o custodia, ninguno de los cuales podrá ser retirado o utilizado para un fin distinto al trabajo bajo ningún pretexto sin la autorización previa y expresa de la persona competente;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SIXTH. - EMPLOYEE’S OBLIGATIONS.</b> Notwithstanding the obligations established by law, internal Regulations or the Employer, the' Employee especially undertakes to: </p>
                    <p>1) Timely, efficiently and impartially perform all activities related to his position and to execute all instructions received by the Employer; </p>
                    <p>2) To observe and comply within his relationships whoever permitted to require his professional services the appropriate kindness and due courtesy; </p>
                    <p>3) To keep reserve about the matters related with its job, considering the nature of the matter or special instructions, even though the termination of this contract, without prejudice to report any criminal act that could harm the Employer; </p>
                    <p>4) To dedicate the entire work time to the good performance of the functions that have been entrusted to his position; </p>
                    <p>5) To fully reassume his duties at the expiration of licenses, permits, holidays, etc; </p>
                    <p>6) To have decorum and correctness of his behaviour, respect for his superiors, peers and subordinates; </p>
                    <p>7) To be responsible in the most rigorous way and give fair use to work documents, supplies, equipment, raw materials, inputs, credit cards, furniture and assets assigned during his functions, to perform work or entrusted to his guard or custody, none of which may be removed or used for a purpose other than to work for any purpose without the express prior authorization of the competent person; </p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: 0px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>8) Participar en las actividades programadas para la capacitación, desarrollo de personal, e instrucción que determine el Empleador; </p>
                    <p>9) Dar cumplimiento al horario de trabajo; </p>
                    <p>10) Abstenerse de poner en peligro, por actos u omisiones, la seguridad de las personas o de los bienes del Empleador o de los bienes de terceros confiados al mismo; </p>
                    <p>11) Dar cumplimiento oportunamente a las prescripciones que para seguridad de los locales, equipos, operaciones o los dineros y/o valores de Empleador; </p>
                    <p>12) No retener, distraer, apoderarse, o aprovecharse en forma indebida de dineros, valores o bienes que por razón o con ocasión de sus funciones le hayan confiado u asignado; </p>
                    <p>13) No permitir voluntariamente o por culpa, que otras personas lleguen a tener conocimiento de claves, datos o hechos de conocimiento privativo del Empleador o de determinados empleados del mismo; </p>
                    <p>14) No aprovecharse indebidamente de la relación comercial con clientes y proveedores del Empleador, a fin de obtener de estos préstamos, dadivas u otro tipo de beneficios que se otorguen en consideración de su condición de Empleado del Empleador, o con el fin de que se dé trato preferencial o especial a los asuntos cuyo o trámite o decisión del corresponda; </p>
                    <p>15) No dedicarse en sitio de trabajo al manejo de negocios particulares o realizar actividades de comercio o similares al del empleador, también de carácter particular, individual o con otros Empleados del Empleador o terceros, cualquiera que sea su finalidad; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>8) To participate in the programmed activities for training, personal development, and any other instruction program defined by the employer;</p>
                    <p>9) To comply with working hours; </p>
                    <p>10) To refrain from endangering, by act or omission, the safety of persons or property of the Employer or the property of its clients or others entrusted to it; </p>
                    <p>11) To comply promptly to the requirements for security of premises, equipment, operations or monies and/or securities of the Employer; </p>
                    <p>12) Do not hold, divert, take, or undue advantage in the form of money, securities or property by reason or occasion of its functions have appointed or assigned; </p>
                    <p>13) Do not allow either voluntarily or because, others acquire knowledge of key data or facts Employer proprietary knowledge or certain employees thereof; </p>
                    <br>
                    <p>14) Do not take unfair advantage of the business relationship with customers and suppliers of the Employer, to obtain from these loans, grants or other benefits that are granted, in consideration of his status as employed by the employer, or in order to achieve preferential or special treatment to issues or process or decisions which correspond to the Employer;</p>
                    <p>15) Do not engage in the management workplace to particular business or trade activities or similar to the employer's, also of particular character, individually or with other employees of the Employer or third parties, whatever their purpose; </p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: -15px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>16) No realizar operaciones o desempeñar funciones cuya ejecución esté atribuida expresa e inequívocamente a otro Empleado del Empleador, salvo en el caso de necesidad efectiva e inaplazable, y previa orden de un superior; </p>
                    <p>17) Abstenerse de cualquier actitud en los compromisos comerciales, personales o en las relaciones sociales, que pueda afectar en forma nociva la reputación del Empleador; </p>
                    <p>18) Cumplir con todas las leyes y reglamentos de Colombia, especialmente las relativas a moneda, mercado negro, y el uso y consumo de drogas o alcohol; </p>
                    <p>19) Usar adecuadamente y/o diligentemente la totalidad de los equipos, aplicativos, claves de acceso y elementos que hacen parte del puesto de trabajo y/o que le fueron encomendados al Empleado; </p>
                    <p>20) Asistencia y puntualidad a todas las jornadas de capacitación y entrenamiento que el Empleador considere necesarias para mantener y/o mejorar el nivel de conocimientos requerido para el adecuado desempeño de sus labores; </p>
                    <p>21) Abstenerse de usar, instalar o permitir que se use o se instale el cualquier computador del Empleador, o que este bajo la responsabilidad del Empleador, todo aquel software o hardware que no cumpla con los requisitos de licencia y/o respeto a los derechos de autor; </p>
                    <p style="line-height: 1.4 !important">22) Utilizar equipos, vehículos, ylo herramientas de propiedad o de uso de la empresa con la observancia de las normas de seguridad incluyendo la seguridad informática en sistemas, en especial, no dar a conocer la clave secreta de acceso o password ni manipular o alterar en cualquier forma la información que repose en la base de datos de la empresa. Tampoco destinar los equipos de cómputo de la empresa a un uso diferente del exclusivamente laboral; y,</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>16) Do not perform operations or perform functions whose execution is attributed expressly and unequivocally to another employee of the Employer, except in the case of effective and urgent need, and prior order from a superior; </p>
                    <p>17) To refrain from any attitude in commercial, personal or social relationships commitments that can deleteriously affect the reputation of the Employer; </p>
                    <p>18) To comply with all laws and regulations of Colombia, especially those relating to currency black market, and the use and consumption of drugs or alcohol; </p>
                    <p>19) To use properly and / or diligently all the equipment, applications, passwords and elements that are part of the job and / or that were entrusted to the employee; </p>
                    <p>20) To attend with punctuality to all training sessions that the Employer deems necessary to maintain and / or improve the level of knowledge required for the proper performance of his duties; </p>
                    <p>21) To refrain from using, install or permit the use or install in any Employer's computer, or which under the responsibility of the Employer, any software or hardware that does not meet licensing requirements and/or respect for the author rights; </p>
                    <p>22) To use equipment, vehicles, and/or tools that are property of the the Company, or for its use, with the observance of safety standards including computer security systems, especially, not to disclose the secret password or password or manipulate or in any way alter the information kept in the database of the company. Also, nor allocate computer equipment company to a different use of labor only; </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <p>23) Tener un alto estándar de conducta moral y ética. Al presente contrato se incorporan en lo que sean compatibles con el mismo las disposiciones del Reglamento lnterno de Trabajo, así como la Ley 789 de 2002.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>23) To have a high standard of moral and ethical conduct. This contract is incorporated which are compatible with the same provisions of the Working Rules and Law789 of 2002.</p>
                </td>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SÉPTIMA. - CONFIABILIDAD Y USO DE SISTEMAS.</b> El Empleado tratará en forma estrictamente confidencial toda información no pública que llegue a su conocimiento relacionada con los asuntos y negocios del Empleador y de sus clientes, contratistas y contratantes, incluyendo sin limitarse a la información corporativa de la empresa y sociedades relacionadas, informes financieros, planes y estrategias de mercadeo, bases de datos, listas de proveedores y clientes entre otras. El Empleado de forma expresa se compromete a guardar en el desempeño de sus funciones y fuera de ellas la discreción, reserva y sigilo que exige la lealtad que le debe al Empleador. Por lo dicho, se abstendrá de revelar, en detrimento de los interese del Empleador, información confidencial, secreta o no pública que llegue a sus conocimientos en el desempeño de sus funciones o por fuera de ellas. Se aclara que los documentos, datos e información de todo tipo que maneja el Empleador tales como, pero no limitados a, secretos industriales, patentes e inventos, Know-how (entendido como conocimiento no patentado) y software desarrollado o licenciado por el Empleador (todo lo anterior denominado en forma global como la "<b>lnformación</b>" para efectos de este contrato) es material clasificado, y en consecuencia el empleado tiene la obligación de guardar la confidencialidad a la que ha comprometido en todo momento aun después de terminado el contrato de trabajo.</p>
                </td>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTH. - CONFIDENTIALITY AND USE OF SYSTEMS.</b> The Employee agrees not to reveal, inform or divulge to third parties, during the duration of his employment and after termination thereof, the confidential information and any other information that he may have access to and/or that he may receive in fulfillment of his duties, undertaking to keep this information secret even after termination of the employment relationship, without considering the reasons for terminating the employment relationship between the parties. The aforementioned prohibition also covers any reproduction of the information that the Employee has access to regarding clients, contractors and contracting parties’ business strategies, procedures and organization methods, trade secrets, patents and inventions, know how (to be understood as non-patented knowledge), computer programs or any other kind of internal information that exclusively belongs to the Employer. The Employee will be released from the aforementioned prohibition, being able to reproduce or allowing third parties to have access to the Confidential or Corporate information, only with the prior express and specific written authorization from the Employer.</p>
                </td>
            </tr>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PARÁGRAFO PRIMERO:</b> El empleado autoriza al Empleador para que tenga acceso directamente o por intermedio de la persona y personas que este designe, en cualquier momento, a toda la información que contenga el o los computadores o redes de comunicación que tenga asignados como elementos de trabajo. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST PARAGRAPH:</b> The employee authorizes the Employer to have access, directly or through the person and persons designated by him, at any time, to all the information contained in the computer or communication networks assigned to him as work items.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>OCTAVA. - INVENCIONES Y DESCUBRIMIENTOS.</b> Las invenciones, desarrollos intelectuales o descubrimientos realizados por el Empleado durante la prestación de sus servicios al Empleador y todo relacionado con el trabajo, pertenecerán a este último, de conformidad con lo dispuesto por el artículo 539 del código de Comercio y 23 de la decisión 486 de la Comunidad Andina. En consecuencia, tendrá el Empleador el derecho de patentar o registrar ante las autoridades competentes, a su nombre o a nombre de terceros, tales inventos o descubrimientos, respetándose el derecho del empleado a ser mencionado como inventor en el caso de las patentes, si así lo desea, de conformidad con el artículo 24 de la decisión 486 de la Comunidad Andina. El Empleado acuerda facilitar el cumplimiento oportuno de las formalidades y trámites requeridos para los fines de la presente cláusula y acuerda dar su firma o extender, de manera oportuna, los poderes y documentos que sean necesarios para lograr el fin mencionado. Las partes expresamente convienen que el presente contrato constituye cesión de todos los derechos económicos sobre los desarrollos intelectuales e invenciones realizados por el Empleado y podrá ser utilizado para el registro o la obtención de la patente respectiva. Nada de lo estipulado en la presente cláusula obliga al Empleador al pago de compensación alguna al Empleado.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTH. - INVENTIONS AND DISCOVERIES.</b> <br> All inventions, intellectual developments or discoveries generated by the Employee during the rendering of his services to the Employer and everything related to his work, will be property of the Employer, as established in Article 539 of the Commercial Code and article 23 of decision 486 of the Andean Community. Therefore, the Employer will be entitled to submit any request for trademark or patent registration to its name or to the name of any third party before the competent authorities, said inventions or discoveries, whereas the Employer will respect the right of the Employee to be mentioned as the inventor, if the Employee so wishes, in the case of patents, according to article 24 of decision 486 of the Andean Community. The Employee agrees to cooperate with the Employer's legal advisors, or any other person designated by the Employer, facilitating the timely compliance of all required formalities and procedures and also agrees to sign all powers and documents that are necessary to this end. The parties expressly agree that this contract constitutes assignment of all economic rights on the intellectual developments and inventions created by the Employee and may be used for registrations or for obtaining the respective patents. No provision of this clause obliges the Employer to pay the Employee any kind of compensation.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: 0px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="line-height: 1.4 !important"><b>NOVENA. - DERECHOS DE AUTOR.</b> De conformidad con lo dispuesto en el artículo 28 de la LEY 1450 de 2011 los derechos patrimoniales sobre las obras creadas por el Empleado en cumplimiento del presente contrato de trabajo se considerarán transferidos al Empleador en la medida necesaria para el ejercicio de sus actividades habituales en el momento de creación de la obra. Dicha transferencia comprenderá todas las modalidades de explotación posibles y se extenderá a todos los territorios en que el Empleador tenga operaciones. La duración de la transferencia será por el máximo término determinado por la ley. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="line-height: 1.4 !important"><b>NINTH. - COPYRIGHT.</b> According to the provisions of article 28 of Law 1450 of the year 2011, the property rights on the works created by the Employee in fulfillment of this Employment Contract, are considered assigned to the Employer in the necessary extent for the exercise of its functions at the time of creation of the work. Said assignment will comprise all possible methods of exploitation and will extend to all territories in which the Employer operates. The duration of the assignment will be the maximum term established by law.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="line-height: 1.4 !important"><b>DÉCIMA. - TRATAMIENTO DE DATOS PERSONALES.</b> El Empleado autoriza de manera previa, expresa e informada al Empleador para que, directamente o a través de sus empleados, consultores, asesores y lo terceros encargados del tratamiento de Datos Personales, bien sea en Colombia o en el exterior, lleven a cabo cualquier operación o conjunto de operaciones tales como la recolección, almacenamiento, uso, circulación, supresión, transferencia y transmisión sobre sus datos personales, entendidos como cualquier información vinculada o que pueda asociarse al empleado para el cumplimiento de los fines de Empleador que incluyen pero no se limitan al cumplimiento de las obligaciones legales o contractuales del Empleador con terceros, la debida ejecución de este contrato, el cumplimiento de las políticas internas del Empleador, el cumplimiento de las obligaciones legales y reglamentarias del Empleado, la administración de sus sistemas de información y comunicaciones, la generación de copias de archivos de seguridad de la información de sus equipos proporcionados por el Empleador, el ofrecimiento de beneficios extralegales por el Empleador al Empleado, en el control y prevención por parte del Empleador de fraudes y lavado de activos, los mecanismos y protocolos de seguridad de la infraestructura y las instalaciones del Empleador, la elaboración de encuestas (comerciales, académicas, o de cualquier otra clase) y</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="line-height: 1.4 !important"><b>TENTH. - PROCESSING OF PERSONAL DATA.</b> The Employee hereby expressly authorizes the Employer to perform directly or via its employees, consultants and/or third parties responsible for processing personal data in Colombia or abroad, any operation or set of operations, such as storage, use, transmission and deletion of the Employee's personal data, whereas these are understood as any information related or that may be related to the Employee for the fulfillment of the Employer's ends, which include but are not limited to compliance with legal or contractual obligations of the Employer with third parties, duly execution of this contract, compliance with the internal policies of the Employer, compliance with legal or contractual obligations of the Employee, managing of information and communication systems, generation of backup files of the information of the equipment furnished by the Employer, offering of extralegal allowances to the Employee by the Employer, control and prevention by the Employer of any fraud and money laundering, safety mechanisms and protocols of the Employer's infrastructure and facilities, development of surveys (commercial, academic or of any other kind) and, in general, any other technical or field study directly or indirectly related to the Employer, creation of databases according to the characteristics and profiles of the Employee.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="line-height: 1.4 !important">en general cualquier estudio técnico o de campo relacionado directa o indirectamente con el Empleador, la creación de bases de datos de acuerdo a las características y perfiles del Empleado. El Empleado autoriza de manera previa, expresa e informada al Empleador para que, directamente o a través de sus empleados, consultores asesores y/o terceros en Colombia o en el Exterior realice Tratamiento de Datos Personales, incluido el dato biométrico, la videograbación de imagen obtenidos a través de procesos de video de vigilancia y registro de huella digital, y cualquier otro dato personal sensible. El Empleado conoce el carácter facultativo de entregar o no sus datos personales de carácter sensibles. El empleado autoriza de manera previa, expresa e informada para que el Empleador continúe sometiendo a tratamiento los Datos personales que hubieran recolectado o de cualquier forma sometido a tratamiento con anterioridad al presente contrato. Así mismo, el empleado autoriza de
                        manera previa, expresa e informada al Empleador para transferir y/o transmitir los datos personales del Empleado a permitir el acceso a estos, a terceros, tales como empresas promotoras de
                        salud EPS vigiladas por Ia superintendencia Nacional de Salud, Administradoras de Fondos de Pensiones, Administradora de Riesgos Laborales Entidades Bancarias y Aseguradoras vigiladas por la Superintendencia Financiera de Colombia y cajas de compensación Familiar vigiladas por la Superintendencia del Subsidio Familiar, ubicados en Colombia o en el exterior para el cumplimiento de los
                        mismos fines del Empleador, incluso a
                        países que no proporcionen niveles
                        adecuados de protección de Datos Personales. Previa solicitud de Empleado mediante el procedimiento apropiado, el Empleador le suministrara Ia información completa de los terceros que Ilevan a cabo el tratamiento de sus Datos Personales. El Empleado reconoce y acepta que el tratamiento de sus Datos Personales efectuados por fuera del territorio colombiano puede regirse por leyes extranjeras. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Employee expressly authorizes the Employer to directly or through its employees, consultants and/or third parties in Colombia or abroad, perform the processing of personal data, including biometric data, videotaping of images obtained through surveillance and fingerprint records as well as any other sensitive personal information. The Employee acknowledges the optional basis in providing or its sensitive personal data or not. The Employee expressly authorizes the Employer to continue treating the collected personal data or data that may have been submitted to treatment prior to his contract. The Employee also expressly authorizes the Employer to transfer and/or transmit the Employees personal data or to grant access to these data to third parties, such as Health Promotion Companies (EPS) monitored by the National Health Superintendence, Pension Fund Administrators, Administrator of Occupational Risks, banking and insurance entities monitored by the
                        Financial Superintendence of Colombia and Family Compensation Funds monitored by the Superintendence of Family Subsidy located in Colombia or
                        abroad, for the fulfillment of the
                        Employers functions even to countries
                        that do not provide adequate personal data protection. On appropriate request of the Employee, the Employer will provide the complete information about
                        the third parties that are treating its
                        personal data. The Employee agrees
                        that the treatment of its personal data
                        outside Colombian territory may be
                        subject to foreign laws. The Employee
                        acknowledges to be familiar with his/her rights as owner of these Personal Data, which are among others: i) know of,
                        update and rectify his/her personal data
                        in front of the Employer or whom treat
                        his/her personal data on behalf of the
                        Employer; ii) request proof of
                        authorization given to the Employer
                        except in cases when the law does not require this;
                    </p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Empleado reconoce que ha sido informado de los derechos que le asisten en su calidad de titular de Datos Personales, entre los que se
                        encuentran los siguientes: i) Conocer, actualizar y rectificar sus datos personales frente al Empleador o quienes por cuenta de este realicen el tratamiento de sus Datos Personales frente al empleador o quienes por cuenta de este realicen el tratamiento de sus Datos Personales; ii) Solicitar prueba de autorización otorgada al empleador salvo cuando la ley no lo requiera; iii) Previa solicitud, ser informado sobre el uso que se ha dado a sus datos personales, por el empleador o quienes por cuenta de este realicen el tratamiento de sus datos personales; iv)Presentar ante las autoridades competente quejas por violaciones al régimen legal colombiano de protección de datos personales cuando la autoridad competente determine que el Empleador incurrió en conductas contrarias a la ley a la constitución, y v) Acceder en forma gratuita a sus datos personales que hayan sido objeto de tratamiento.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>iii) upon request to be
                        informed about the use given to his/her
                        personal data by the Employer or by
                        third parties treating personal data on
                        the Employer's behalf; iv) submit to the
                        competent authorities any complaint
                        about violation of the Colombian data protection regulations when the competent Authority determines that
                        the Employer presented conducts that
                        are against the law or Constitution and
                        v) access free of charge the personal
                        data that have been subject to
                        treatment.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PARÁGRAFO PRIMERO:</b> Para la comprensión de la presente cláusula se deben tener en cuenta las siguientes definiciones: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIRST PARAGRAPH:</b> For a better understanding of this clause, bear in mind the following definitions: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Titular:</b> Persona Natural cuyos datos personales sean objeto de tratamiento.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Owner:</b> Natural person whose personal data are subject to treatment. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Dato Personal:</b> Cualquier información vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Personal Data:</b> Any information related to or that may be related to one or several certain or to be ascertained natural persons. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Tratamiento:</b> Cualquier operación o conjunto de operaciones sobre datos personales, tales como la recolección, almacenamiento uso, circulación o supresión. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Treatment:</b> Any operation or set of operations on personal data, such as collection, storage, use, circulation or deletion.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Base de Datos:</b> Conjunto organizado de Datos Personales que sea objeto de tratamiento. Rectificar información contenida en la base de Datos; y, v) Para garantizar la privacidad de la información. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Database:</b> Organized set of Personal Data subject to treatment. Rectify information contained in the Database; and v) To guarantee the privacy of the information.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA PRIMERA. - VACACIONES.</b> El Empleado tendrá derecho a quince (15) días hábiles de vacaciones remuneradas por cada año de servicios prestados al Empleador y proporcionalmente por fracción de año. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>ELEVENTH. - HOLIDAYS.</b> The Employee shall be entitled to fifteen (15) working days of paid vacation for each year of services rendered to the Employer and proportionally by fraction of the year.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA SEGUNDA. - TERMINACIÓN POR MUTUO ACUERDO.</b> El presente contrato se podrá dar por terminado por mutuo acuerdo por escrito entre las partes en cualquier instancia de su ejecución sin causar a favor del Empleado el pago de compensación alguna. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWELFTH. - TERMINATION BY MUTUAL AGREEMENT.</b> This contract may be terminated by mutual written agreement between the parties in any instance of its execution without causing in favor of the Employee the payment of any compensation.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA TERCERA. - TERMINACIÓN UNILATERAL - CAUSAS DE TERMINACIÓN.</b> <br> Son justas causas para que el Empleado de por terminado unilateral e inmediatamente el presente contrato: <br> a) el incumplimiento por parte del Empleador de las obligaciones contenidas en el presente contrato; y,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TIRTHEENTH. - UNILATERAL TERMINATION - GROUNDS FOR TERMINATION. </b><br> The following constitute just causes for the Employee to unilaterally and immediately terminate this contract: <br> a) the Employer's failure to comply with the obligations contained in this contract; and</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>b) las establecidas en el artículo 7 del Decreto 2351 de 1965, las cuales las partes declaran conocer y aceptar.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>b) those established in Article 7 of Decree 2351 of 1965, which the parties declare to know and accept.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Empleador podrá unilateralmente e inmediatamente dar por terminado el presente contrato:</p>
                    <p>(i) Si el Empleado incumple con las obligaciones contenidas en el presente contrato;</p>
                    <p>(ii) Las causas consagradas en el artículo 7 del Decreto 2351 de 1965, las cuales declara conocer;</p>
                    <p>(iii) El incumplimiento de sus obligaciones legales y reglamentarias;</p>
                    <p>(iv) El hecho de prestar el Empleado directa o indirectamente servicios a terceros, o trabajar por cuenta propia en forma independiente, a menos que exista permiso previo escrito del Empleador;</p>
                    <p>(v) La revelación de datos o informaciones ni públicas consideradas por el Empleador como secretas, reservadas y/o confidenciales;</p>
                    <p>(vi) El grave incumplimiento por parte del empleado, incluyendo pero sin limitarse a los actos de desobediencia, deshonestidad, incumplimiento persistente o serio de sus funciones o negligencias: </p>
                    <p>(vii) El que el Empleado use su posición laboral o el buen nombre de la compañía para afirmar o acreditar de cualquier manera una actividad o negocio personal o de un tercero;</p>
                    <p>(viii) El que el Empleado suministre al médico información inexacta al practicarse el examen de admisión o cualquier otro examen requerido;</p>
                    <p>(ix) El hecho de que el Empleado llegue embriagado o bajo los efectos de alcohol, drogas alucinógenas o narcóticas a su trabajo o los ingiera en el lugar de trabajo sea o durante el desempeño de sus funciones;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Employer may unilaterally and immediately terminate this contract:</p>
                    <p>(i) If the Employee fails to comply with the obligations contained in this contract;</p>
                    <p>(ii) The causes enshrined in Article 7 of Decree 2351 of 1965, which the Employer declares to know;</p>
                    <p>(iii) The Employee’s failure to comply with legal and regulatory obligations;</p>
                    <p>(iv) The Employee directly or indirectly providing services to third parties or working independently on their own account, unless prior written permission from the Employer has been obtained;</p>
                    <p>(v) The disclosure of non-public data or information deemed by the Employer to be secret, reserved, and/or confidential;</p>
                    <p>(vi) Serious breach by the Employee, including but not limited to acts of disobedience, dishonesty, persistent or serious failure to perform duties, or negligence;</p>
                    <p>(vii) The Employee using their job position or the company’s good name to affirm or accredit in any way a personal activity or business or that of a third party;</p>
                    <p>(viii) The Employee providing inaccurate information to the physician during the admission examination or any other required examination;</p>
                    <p>(ix) The Employee arriving at work intoxicated or under the influence of alcohol, hallucinogenic drugs, or narcotics, or consuming them at the workplace or during the performance of their duties; </p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(x) El hecho que el Empleado incurra como sujeto activo en conductas constitutivas de acoso laboral de acuerdo con la Ley 1010 de 2006, o promueva, tolere ylo sea permisivo con dicho tipo de conductas;</p>
                    <p>(xi) Que no cumpla con las responsabilidades y funciones asignadas a su cargo o su desempeño sea deficiente para su cargo de acuerdo con las políticas de evaluación del Empleador;</p>
                    <p>(xii) El incumplimiento del Empleado de las políticas y procedimientos de Empleador y/o los estándares de ética; </p>
                    <p>(xiii) El incumplimiento de las obligaciones y prohibiciones del Empleado previstas en el reglamento interno de trabajo del Empleador; </p>
                    <p>(xiv) La comisión por parte del empleado de cualquier acto deshonesto o fraudulento, o cualquier otro acto u omisión, que haya causado o pueda razonablemente esperarse que cause daño a los intereses o la reputación del negocio del Empleador; </p>
                    <p>(xv) La reitera no asistencia puntual a su trabajo o al incumplimiento de sus obligaciones, sea en la sede principal del mismo o en los lugares a donde deba desplazarse para cumplir con sus labores, sin justificación suficiente a juicio de la empresa; </p>
                    <p>(xvi) El hecho de que el Empleado obtenga o de dinero a título de préstamo, dádiva o prebenda a sus compañeros de trabajo, clientes y trabajadores de empresas clientes de la empresa, proveedores de la empresa o personas con las cuales se relacione por el desempeño de sus labores, o cuando se solicite de las mismas personas o les ofrezca dinero, préstamos, dádivas o prebendas; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(x) The Employee actively engaging in conduct constituting workplace harassment under Law 1010 of 2006, or promoting, tolerating, or being permissive of such conduct; </p>
                    <br>
                    <p>(xi) The Employee failing to fulfill the responsibilities and duties assigned to their position or performing deficiently in their role according to the Employer’s evaluation policies; </p>
                    <p>(xii) The Employee’s failure to comply with the Employer’s policies, procedures, and/or ethical standards; </p>
                    <p>(xiii) The Employee’s breach of the obligations and prohibitions set forth in the Employer’s internal work regulations; </p>
                    <p>(xiv) The Employee committing any dishonest or fraudulent act, or any other act or omission that has caused or could reasonably be expected to cause harm to the Employer’s business interests or reputation;</p>
                    <p>(xv) The Employee’s repeated failure to attend work punctually or fulfill their obligations, whether at the main workplace or at locations where they must travel to perform their duties, without sufficient justification in the Employer’s judgment; </p>
                    <p>(xvi) The Employee giving or obtaining money as a loan, gift, or benefit from coworkers, clients, employees of client companies, suppliers, or persons with whom they interact in the performance of their duties, or requesting or offering money, loans, gifts, or benefits from such persons; (xvii) Discrediting the Employer in any way through statements or acts aimed at such purpose; </p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(xvii) Desacreditar en alguna forma al Empleador, con manifestaciones o actos encaminados a tal fin; </p>
                    <p>(xviii) Que el Empleado en razón de sus funciones o vinculación laboral para cumplir o incumplir las labores asignadas, reciba, solicite o exija por cualquier medio dinero, regalo, dádiva o favor distinto de la remuneración salarial o de las prestaciones a las que tiene derecho en virtud del contrato de trabajo celebrado con el Empleador; </p>
                    <p>(xix) Desatender o negarse a cumplir con medidas de control establecidas por el Empleador para prevenir accidentes, hurtos, estafas, o cualquier otro ilícito que puedan atentar contra el patrimonio del Empleador;</p>
                    <p>(xx) Tener comportamiento irrespetuoso con sus superiores o desavenencias frecuentes con sus compañeros de trabajo; </p>
                    <p>(xxi) Cualquier falta u omisión grave en el manejo de dineros, efectos de comercio y valores, elementos de trabajo y herramientas; </p>
                    <p>(xxii) Negarse a cumplir sin justa causa órdenes que en el desempeño de su oficio le imparta el Empleador, siempre y cuando las mismas tengan una relación directa con las labores encomendadas y no afecten la dignidad del Empleado; </p>
                    <p>(xxiii) Que el Empleado comprometa las decisiones del Empleador para beneficiar intereses diversos a los del objeto que desarrolla el Empleador, en contradicción con las pautas o normas que este le señale, o en perjuicio de su patrimonio económico; </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(xvii) Discrediting the Employer in any way through statements or acts aimed at such purpose; </p>
                    <p>(xviii) The Employee, in connection with their duties or employment relationship, receiving, requesting, or demanding by any means money, gifts, benefits, or favors other than the salary or benefits to which they are entitled under this employment contract with the Employer; </p>
                    <br>
                    <p>(xix) Failing or refusing to comply with control measures established by the Employer to prevent accidents, theft, fraud, or any other illicit act that may jeopardize the Employer’s assets; </p>
                    <br>
                    <p>(xx) Exhibiting disrespectful behavior toward superiors or frequent disagreements with coworkers; </p>
                    <p>(xxi) Any serious fault or omission in handling money, commercial instruments, valuables, work equipment, or tools; </p>
                    <p>(xxii) Refusing without just cause to obey orders issued by the Employer in the performance of their duties, provided such orders are directly related to the assigned tasks and do not affect the Employee’s dignity; </p>
                    <p>(xxiii) The Employee compromising the Employer’s decisions to benefit interests contrary to the Employer’s objectives, in violation of the guidelines or rules provided by the Employer, or to the detriment of its economic assets; </p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top:-5px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(xxiv) La utilización para fines distintos a la labor para la cual fue contratado o Empleado o en general cualquier uso ilegal o inadecuado de la red de internet y de la cuenta de email dispuesta por la empresa para el cumplimiento a cabalidad de las funciones del Empleado. El Empleador autoriza expresamente al Empleador para que acceda a la cuenta de email que está bajo su administración, con el propósito de que constate el contenido de la misma cuando así lo considere e igualmente para que verifique con los medios que estime necesarios el uso que el empleado haga de la conexión a la red de internet dispuesta por el Empleador, incluida la verificación de visitas a los sitios de la red que desde dicha cuenta haga el Empleado, y de los archivos y documentos que almacene, conserve y disponga el Empleado en el equipo de cómputo suministrado por el Empleador, especialmente si los mismos no guardan relación de causalidad con las funciones desempeñadas por el Empleado; </p>
                    <p>(xxv) El uso o destinación de las herramientas de trabajo suministrado por el Empleador para labores ajenas ylo que no tengan relación con la causalidad con la ejecución del presente contrato de trabajo suscrito con el Empleado, al igual que la negligencia o inobservancia del deber de cuidado para con dichas herramientas: y </p>
                    <p>(xxvi) incumplir cualquiera de las obligaciones especiales previstas en las cláusulas sexta y séptima del presente contrato. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(xxiv) Using the internet network and email account provided by the company for purposes other than those for which the Employee was hired, or any illegal or improper use thereof. The Employer expressly authorizes the Employer to access the email account under its administration to verify its contents whenever deemed necessary, and to use any means it considers appropriate to monitor the Employee’s use of the internet connection provided by the Employer, including verifying visits to websites accessed through said account, as well as the files and documents stored, retained, or managed by the Employee on the computer equipment supplied by the Employer, particularly if they bear no causal relationship to the Employee’s duties; </p>
                    <br><br><br><br><br>
                    <p>(xxv) Using or allocating work tools provided by the Employer for purposes unrelated to the execution of this employment contract, as well as negligence or failure to exercise due care with respect to such tools; and </p>
                    <br>
                    <p>(xxvi) Breaching any of the special obligations set forth in clauses sixth and seventh of this contract. </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA CUARTA. - ACUERDO TOTAL.</b> El presente documento es el único acuerdo entre las partes, regula la única relación laboral que ha existido entre las partes, y sustituye y deja sin efecto cualquier otro contrato o acuerdo, verbal o escrito, que se haya suscrito o ejecutado con
                        anterioridad, en relación con cualquier tipo de vinculación de Empleado.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FOURTEENTH. - FULL AGREEMENT.</b> This document is the only agreement between the parties, it regulates the only labor relationship that has existed between the parties, and it replaces and nullifies any other contract or agreement, verbal or written, that has been previously subscribed or executed, in relation with any type of Employee relationship. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: -10px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA QUINTA. - MODIFICACIONES.</b> Este contrato podrá ser modificado en cualquier tiempo por el mutuo consentimiento de las partes. Las modificaciones que de este contrato se hagan, deberán constar por escrito y se integrarán a é1. Se entiende que cada una de las partes otorga su consentimiento con la firma del documento que modifica este contrato. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FIFTEENTH. - MODIFICATIONS.</b> This agreement may be modified at any time by the mutual consent of the parties. The modifications made to this contract must be written and integrated with it. lt is understood that each of the parties gives their consent with the signature of the document that modifies this contract.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA SEXTA. - MODIFICACIONES DE LAS CONDICIONES LABORALES. </b> El Empleado acepta desde ahora expresamente todas las modificaciones de sus condiciones laborales determinadas por el Empleador, en ejercicio de su poder subordinante, tales como jornadas de trabajo, el lugar de prestación del servicio, el cargo u oficio y/o funciones y la forma de remuneración, siempre que tales modificaciones no afecten su honor, dignidad o sus derechos mínimos ni impliquen desmejoras sustanciales o graves de perjuicios para é1, de conformidad con lo dispuesto por el artículo 23 del C.S.T. modificando por el artículo 1 de la ley 50 de 1990. Los gastos que se originen con el traslado de lugar de prestación de servicio serán cubiertos por el Empleador de
                        conformidad con el numeral 8 del artículo 57 del C.S.T. El cambio de lugar donde los servicios son prestados incluye lugares dentro o fuera de Colombia.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SIXTEENTH. - MODIFICATIONS OF THE LABOR CONDITIONS. </b> The Employee hereby expressly accepts all changes in his working conditions determined by the Employer, in the exercise of his subordinating power, such as working days, the place of service, the position or office and / or functions and the manner of Remuneration, provided that such modifications do not affect his honor, dignity or minimum rights nor imply any substantial or serious deterioration of damages for him, in accordance with the provisions of Article 23 of the C.S.T. Modified by article 1 of Law 50 of 1990. The expenses that originate with the transfer of place of provision of service will be covered by the Employer in accordance with number 8 of article
                        57 of the C.S.T. The change of place where the services are rendered includes places inside or outside Colombia.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA SÉPTIMA. - JORNADA LABORAL.</b> El Empleado se obliga a laborar la jornada máxima legal en los turnos y dentro de las horas señaladas por el Empleador, pudiendo hacer este ajuste o cambios de horario cuando lo estime conveniente. Por el acuerdo expreso o tácito de las partes, podrán repartirse las horas de la jornada ordinaria de forma prevista en la ley, teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada no se computan dentro de la misma, según el artículo 167 del código sustantivo del trabajo. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEVENTEENTH. - LABOR DAY.</b> The Employee undertakes to work the maximum legal day in the shifts and within the hours indicated by the Employer, being able to make this adjustment or changes of schedule when it deems convenient. By the express or tactical agreement of the parties, the hours of the ordinary day may be divided according to the law, taking into account that the rest times between the sections of the day are not counted within the same, according to the article 167 of the substantive code of the work.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: -5px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Así mismo el Empleador y el Empleado podrá acordar la implementación de una jornada diaria flexible o una jornada semanal de 36 horas de conformidad con el artículo 51 de la ley 789 de 2002. Las partes acuerdan que el día de descanso obligatorio podrá ser el día sábado o domingo PARÁGRAFO PRIMERO: EI Empleado acepta desde ahora todas las modificaciones que en ejercicio de su poder subordinadamente haga el empleador de sus condiciones laborales, en especial las que se refieren a la jornada y horarios de trabajo, el lugar de prestación de los servicios, el cargo, oficio y funciones de desempeñar, los periodos de pago, etc., Siempre y cuando tales modificaciones no afecten su honor , dignidad y derechos mínimos o impliquen desmejoras sustanciales o graves perjuicios para é1, de conformidad con lo establecido por el artículo 1 de las Ley 50 de 1990, que modificó al Artículo 23 del código sustantivo del trabajo. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Likewise, the Employer and Employee may agree to the implementation of a flexible daily working day or a 36-hour workweek in accordance with article 51 of Law 789 of 2002. The parties agree that the mandatory day of rest may be Saturday The Sunday. FIRST PARAGRAPH: The Employee accepts from now on all modifications that in the exercise of his power subordinately makes the employer of his working conditions, especially those that refer to the working day and hours, the place of provision of the services, the position , Duties and functions to perform, periods of payment, etc., provided that such modifications do not affect his honor, dignity and minimum rights or involve substantial deterioration or serious damages for him, in accordance with the provisions of Article 1 of the Law 50 of 1990, which amended Article 23 of the substantive code of work. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA OCTAVA. - INTERPRETACIÓN.</b> Este contrato ha sido redactado estrictamente de acuerdo a la Ley y a la jurisprudencia y será interpretado de buena fe, y en consonancia con el código sustantivo de Trabajo cuyo objeto definido en su artículo 1" es lograr la justicia en las relaciones entre Empleadores y trabajadores dentro de un espíritu de coordinación económica y equilibrio social. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EIGHTEENTH. - INTERPRETATION.</b> This contract has been drafted strictly according to the Law and jurisprudence and will be interpreted in good faith, and in line with the substantive Code of Work whose object defined in Article 1 is to achieve justice in relations between Employers and workers within of a spirit of economic coordination and social balance. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DÉCIMA NOVENA. - DESIGNACIÓN DE FONDO DE PENSIONES OBLIGATORIAS.</b> El Empleado manifiesta que se selecciona el fondo de pensiones obligatorias {{ $pensionFund }} para afiliarse y realizar los respectivos aportes obligatorios al sistema de pensiones. El Empleado declara que no se encuentra afiliado a otro fondo de pensiones y que en caso de traslado el mismo sería procedente toda vez el cumplimiento de los requisitos legales. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NINETEENTH. - DESIGNATION OF THE MANDATORY PENSION FUND.</b> The Employee states that the mandatory {{ $pensionFund }} pension fund is selected to join and make the respective mandatory contributions to the pension system. The Employee declares that he/she is not affiliated with another pension fund and that in case of transfer, the same would be due to comply with legal requirements. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main style="page-break-after: avoid">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGÉSIMA. - DESIGNACIÓN DE EPS.</b> El empleado igualmente manifiesta que, para los efectos de afiliación y cotización al sistema de salud, tanto suyo como de sus respectivos beneficiarios, selecciona a la empresa promotora de salud ASISTENCIA SALUD. El Empleador declara que no se encuentra afiliado a otra EPS. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTIETH. - DESIGNATION OF HEALTH PROMOTION COMPANY (EPS).</b> The Employee declares to choose affiliation and to pay contributions to the to the Health Promotion Company ASISTENCIA SALUD. The Employer states not to be affiliated to any other EPS. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIGÉSIMA PRIMERA. - LEY APLICABLE:</b> Este contrato estará sujeto a la ley colombiana y deberá ser interpretado de buena fe por las partes.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TWENTY FIRST. - APPLICABLE LAW:</b> This contract will be governed and construed by the laws of Colombia and shall be interpreted in good faith by the parties.</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center; padding: 60px 40px">En constancia se firma en Bogotá, el {{ $formattedDate }} día del mes de {{ $record->translatedMonth }} del {{ $year }}, en dos ejemplares de un mismo tenor, uno (1) para el empleador y uno (1) para el empleado.</div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center;">
                        <p style="margin-bottom: 20px"><b>EL EMPLEADOR</b></p>
                        <img src="{{ $is_pdf ? public_path('images/jenniffer_signature.png') : asset('images/jenniffer_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin-top: 65px">
                        <div style="width: 100%; border-bottom: 1px solid black; padding-top: -80px"></div>
                        <p style="margin-top: -50px">JENNIFFER K. CASANOVA OSPINA <br>MSC COLOMBIA S.A.S. <br>NIT: 901.389.463-5</p>

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center;">
                        <p style="margin-bottom: 20px"><b>EL EMPLEADO</b></p>
                        @if($signatureExists)
                        <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->id . '.webp') : asset('storage/signatures/employee_' . $record->id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin-top: 30px">
                        <p style="text-align: center; margin-bottom: 0px">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                        @endif
                        <div style="width: 100%; border-bottom: 1px solid black; padding-top: -80px"></div>
                        <p style="margin-top: -20px">{{ $employeeName }} <br> {{ $personalId }} de {{ $employeeState }}</p>
                    </div>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
