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
$contractDay = $record->created_at->format('j');
$contractCreatedyear = $record->created_at->format('Y');
$translatedMonth = \Carbon\Carbon::parse($record->created_at)->locale('es')->translatedFormat('F');

$companyName = $record->company->name;
$contactName = $record->companyContact->contact_name;
$contactSurname = $record->companyContact->surname;

$customerAddress = $record->company->address;
$customerCity = $record->company->city;
$customerPhone = $record->companyContact->phone;
$customerEmail = $record->companyContact->email;
$customerName = $record->companyContact->contact_name;
$customerCountry = $record->company->country;
$customerPosition = $record->companyContact->position;
$customerTaxId = $record->company->tax_id ?? 'NA';
$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->country ?? null;
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
$employeePersonalId = $record->document->personal_id ?? null;
$employeeCountry = $record->personalInformation->country ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeStartDateFFormated = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\of F \\of Y')
: 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';

$currencyName = $record->quotation->currency_name;

$signedDate = $record->signed_contract ? \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y'): null;
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
    p {
        line-height: 1.5 !important
    }

    body {
        margin: 0px !important;

    }

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: 0px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">SERVICE AGREEMENT</h4>
                    <p>By this private instrument,</p>
                    <p><b>{{ $companyName }}</b> (the <b>“Customer”</b>), a company duly incorporated with {{ $customerTaxId }} under the laws of {{ $customerCountry }} holding offices at {{ $customerAddress }}; and</p>
                    <p><b>INTERMEDIANO PERÚ SAC,</b> a Peruvian company with mercantil registry No. 20606232960, addressed at Av. Paseo de Republica 3195 oficina 401, San Isidro, Lima, Perú, herein referred to simply as <b> “CONTRACTOR”</b>;</p>
                    <p><b>Customer</b> and <b>CONTRACTOR</b> hereinafter jointly referred to as "Parties" and individually a "Party";</p>
                    <p>CONSIDERING THAT, the contractor is specialized in business development.</p>
                    <p>CONSIDERING THAT the Customer is interested that the contractor performs these services;</p>
                    <p>The Parties DECIDE to enter into the present Services Agreement (“Agreement”), which shall be governed by the following terms and conditions:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE SERVICIO</h4>
                    <p>Por este instrumento en particular,</p>
                    <p><b>{{ $companyName }}</b> (el <b>"Cliente"</b>), una sociedad debidamente constituida con {{ $customerTaxId }} según las leyes de {{ $customerCountry }} y con domicilio en {{ $customerAddress }}; y</p>
                    <p><b>INTERMEDIANO PERÚ SAC,</b> empresa peruana con RUC No. 20606232960, con domicilio en Av. Paseo de Republica 3195 oficina 401, San Isidro, Lima, Perú, en adelante denominado simplemente como <b>“CONTRATISTA”</b>;</p>
                    <p><b>Cliente</b> y el <b>CONTRATISTA</b> de aquí en más juntos refiere simplemente como "Partes" e individualmente una "Parte";</p>
                    <p>CONSIDERANDO, que el contratista es un profesional especializado en el desarrollo de negocios.</p>
                    <p>CONSIDERANDO, que el Cliente tiene interés en que el Contratista realice estos servicios;</p>
                    <p>Las Partes deciden entrar en el presente Acuerdo de Servicios ("Acuerdo"), que se regirá por los términos y condiciones a seguir:</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I. - PURPOSE</b></p>
                    <p>1.1. - By the present Agreement the contractor commits to render to the Customer the services described in Annex I (“Services”), which integrates this instrument.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I - OBJETO</b></p>
                    <p>1.1. - Mediante el presente Acuerdo el contratista se compromete a prestar los servicios descritos en el Anexo I ("Servicios") que integra este instrumento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. – OBLIGATIONS OF THE PARTIES</b></p>
                    <p>2.1. - Notwithstanding the other obligations under this Agreement, the contractor; hereby undertakes to:</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. - OBLIGACIONES DE LAS PARTES</b></p>
                    <p>2.1. - Sin perjuicio de las demás obligaciones previstas en el presente Acuerdo, el contratista; por la presente se compromete a:</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: 0px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(a) meet the requirements and quality standards required by the Customer, which may periodically review the Services performed by the contractor;</p>
                    <p>(b) use best available techniques and make its best efforts in the performance of the Services;</p>
                    <p>(c) provide all the necessary safety material or the execution of the present Agreement;</p>
                    <p>(d) promptly collect all taxes related to its activities, as provided by “Annex I – Services Description” below</p>
                    <p>(e) provide, whenever the Customer requests it, all reports, spreadsheets and other information relating to the Services;</p>
                    <p>(f) comply with all laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters. Therefore, the contractor declares in this agreement that its activities and services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment;</p>
                    <p>(g) Within its realm of action, the contractor; undertakes to refrain from performing acts that may discredit the Customer before its Customer, suppliers, authorities and / or the public in general, taking all the necessary actions to preserve and safeguard the good and perfect reputation of the Customer;</p>
                    <p>(h) To meet the agreed services in the place and at the facilities where the service will be provided.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(a) cumplir con los requisitos y estándares de calidad requeridos por El Cliente, que puede revisar periódicamente los servicios prestados por el contratista;</p>
                    <p>(b) utilizar las mejores técnicas disponibles y realizará sus mejores esfuerzos en la prestación de los Servicios;</p>
                    <p>(c) proporcionar todo el equipo de seguridad necesario para la ejecución del presente Acuerdo;</p>
                    <p>(d) recoger con prontitud todos los impuestos relacionados con sus actividades, proporcionada por el “Anexo I – Descripción de Servicios</p>
                    <p>(e) proveer, cuando el Cliente lo solicite, todos los informes, hojas de cálculo y otras informaciones relacionadas con los servicios;</p>
                    <p>(f) cumplir con todas las leyes, decretos, reglamentos, resoluciones, decisiones, normas y demás disposiciones consideradas legales en materia laboral y del suministro del servicio, en particular, pero no limitado a, los relacionados con la. Por lo tanto, el contratista declara en este acuerdo que sus actividades y servicios, que se utilizan ahora, así como en el futuro, cumplen con la legislación y las normas de protección y seguridad con respecto a la sanidad y el medio ambiente;</p>
                    <p>(g) Dentro de su ámbito de acción, el contratista, se compromete a abstenerse de realizar actos que puedan desacreditar el Cliente ante sus clientes, proveedores, autoridades y / o el público en general, adoptando todas las medidas necesarias para preservar y salvaguardar el buen nombre y la perfecta reputación del Cliente;</p>
                    <p>(h) A cumplir con el servicio acordado en el lugar y en las instalaciones en que se convenga que el mismo será prestado.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(i) Without prejudice to the corresponding legal actions arising from the fulfillment of the contract, provision of services, inter-administrative agreement or administrative act, it undertakes with {{ $companyName }} to defray the costs of returning to the country of origin or to the place of residence of the foreigner hired or linked and of his family.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(i) Sin perjuicio de las acciones legales correspondientes que se desprendan del cumplimiento del contrato, prestación de servicios, acuerdo interadministrativo o acto administrativo, se compromete con {{ $companyName }} a sufragar los gastos de regreso al país de origen o al lugar de residencia del extranjero contratado o vinculado y de su familia.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>2.2. – For the performance of the Services set forth hereunder, the Customer undertakes to:</p>
                    <p>(a) process the monthly payment to the consultant within 30 days of the invoice and timesheet submittal by the consultant.</p>
                    <p>(b) supply the technical information required for the Services to be performed;</p>
                    <p>(c) to follow-up, if it deems necessary, directly or through third parties hired by it, the performance of the Services.</p>
                    <p>(d) In case the Customer terminates the contract before Schedule, it must cover additional costs, if any, during the performance of services, particularly those that appears as legal obligations and are not covered under the original conditions here agreed.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>2.2. - Para la prestación de los Servicios aquí acordados el Cliente se compromete a:</p>
                    <p>(a) realizar el pago mensual al consultor en hasta 30 días de presentada la factura con el timesheet por parte del consultor.</p>
                    <p>(b) proporcionar la información técnica necesaria para los servicios a prestar;</p>
                    <p>(c) realizar el seguimiento, si lo considera necesario, directamente o a través de terceras partes por ella contratadas, por el desempeño de la prestación de los Servicios.</p>
                    <p>(d) Caso el Cliente termine el contrato antes de plazo, deberá cubrir costos adicionales, si los hubiera, con ocasión de los servicios, particularmente aquellas que aparezcan como obligaciones legales y que no están contempladas en las condiciones originales aquí pactadas.</p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>III. – CONSIDERATION AND CONDITIONS OF PAYMENT</b></p>
                    <p>3.1. – For the Services agreed herein, the Customer shall pay to the contractor the amount set forth and described in Annex II.</p>
                    <p>3.2. – The Customer, directly or through third parties, shall pay to the contractors the amounts provided for in article 3.1 above once the Services order has been placed, within thirty (30) days from the delivery of the service and its corresponding invoice.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>III. - EXAMEN Y CONDICIONES DE PAGO</b></p>
                    <p>3.1. - Por los presentes servicios acordados, el Cliente deberá pagar al contratista el monto fijado y descrito en el anexo II.</p>
                    <p>3.2. – El Cliente directamente o a través de terceros, deberá pagar al contratista las cantidades previstas en el artículo 3.1 anterior una vez que los servicios hayan sido realizados, dentro de treinta (30) días de realizado el servicio y del recibo de su correspondiente factura.</p>

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
                    <p>This amount shall be adjusted annually in accordance with the Consumer Price Index (CPI) established by the government on January 1st of each calendar year.</p>
                    <p>3.3. – Accordingly, the contractor shall be fully and exclusively liable for the payment of any and all contributions or taxes, insurance benefits, unemployment insurance, social security benefits, pensions, income taxes or any other amounts required by any competent authority in relation to himself, at any time, to perform this Agreement, and agrees to indemnify and hold the Customer harmless from and against any claims filed against it in this sense.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Este valor será reajustado anualmente de acuerdo al IPC (Índice de Precios al Consumidor) decretado por el gobierno el 01 de enero de cada año en curso.</p>
                    <p>3.3. - En consecuencia, el contratista será íntegra y exclusivamente responsable por el pago de cualquiera y todas las contribuciones o impuestos, seguro, seguro de desempleo, prestaciones de la seguridad social, de las pensiones, los impuestos sobre la renta o cualquier otro monto competente requeridas por cualquier autoridad en relación a sí mismo, en cualquier momento, para llevar a cabo este acuerdo, y se compromete a indemnizar y a mantener indemne al Cliente contra cualquier reclamación presentadas contra ellos en este sentido.</p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV. SECRECY AND CONFIDENTIALITY</b></p>
                    <p>4.1. – The Parties agree to maintain the most complete and absolute confidentiality on any data, materials, information, documents, technical specifications, commercial, innovations, improvements that may come to their knowledge or access, as a consequence of this Agreement, and shall keep such information well protected and make the necessary steps to ensure that such information will not be disclosed or duplicated for the use of third parties.</p>
                    <p>4.2. – The Parties may not, under any circumstances, even after the expiration or termination of this Agreement, disclose, reveal, reproduce, provide to third parties unrelated to this Agreement the data, formulas, methods, procedures, couriers and mailing and other documents which are subject matter of this Agreement and/or the Services.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV. SECRETO Y CONFIDENCIALIDAD</b></p>
                    <p>4.1. - Las Partes se comprometen a mantener la más completa y absoluta confidencialidad de todos los datos, materiales, información, documentos, especificaciones técnicas, comerciales, innovaciones, mejoras que incorpore a su conocimiento o que tenga acceso, como consecuencia de este acuerdo, y mantendrá al día la información y bien protegida, y tomará las medidas necesarias para garantizar que dicha información no sea compartida o duplicada para el uso de terceros.</p>
                    <p>4.2. - Las Partes no podrán, bajo ninguna circunstancia, incluso después de la expiración o terminación del presente Acuerdo, revelar, mostrar, reproducir, proporcionar a terceros no relacionados con el presente Acuerdo, datos, fórmulas, métodos, procedimientos, correos y correspondencia y otros documentos que son objeto de este Acuerdo y / o los Servicios.</p>
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
                    <p>4.3. – During the term of this Agreement and for a period of five (5) years after its termination, the contractor undertakes to maintain the most complete and absolute confidentiality on any technical marketing material, promotional material and advertisements developed by the Customer, to which CONTRACTOR had access / knowledge due to this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>4.3. - Durante la vigencia del presente Acuerdo y durante un período de cinco (5) años después de su terminación, el contratista se compromete a mantener la confidencialidad más completa y absoluta de cualquier material técnico de marketing, publicidad y material de promoción desarrollado por el Cliente al cual el CONTRATISTA tuvo acceso / conocimiento debido a este Acuerdo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V. INTELLECTUAL AND INDUSTRIAL PROPERTY</b></p>
                    <p>5.1. Every document, report, data, know-how, method, operation, design, trademarks confidential information, patents and any other information provided by the Customer or by its Customer to the contractor shall be and remain exclusive property of the Customer or of the Customer that have disclosed the information.</p>
                    <p>5.2. – After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V. PROPIEDAD INTELECTUAL E INDUSTRIAL</b></p>
                    <p>5.1. Cada documento, informe, datos, know-how, el método, la operación, el diseño, la información confidencial de la marca, patentes y cualquier otra información proporcionada por el Cliente o por sus clientes al contratista serán y seguirán siendo propiedad exclusiva del Cliente o de los clientes que hayan facilitado la información.</p>
                    <p>5.2. - Después de la terminación o la expiración del presente, ninguna Parte usará marcas o nombres que puedan ser similares a los de la otra Parte, y / o que puedan ser un poco confusos por los clientes y las empresas. Cada Parte se compromete a realizar sus mejores esfuerzos para evitar errores o la divulgación indebida de las marcas y los nombres de las otras Partes por parte de personas no autorizadas.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. – TERM AND TERMINATION</b></p>
                    <p>6.1. – The present Agreement shall be in force and remain valid as per schedule in Annex I. This Agreement may be terminated by any of the Parties at any time by written notice.</p>
                    <p>6.2. - This Agreement may be terminated for justified cause regardless of any notice, in the occurrence of the following events:</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. - DURACIÓN Y TERMINACIÓN</b></p>
                    <p>6.1. - El presente Acuerdo estará en vigor y permanecerá válido conforme el cronograma en el Anexo I. El presente Acuerdo podrá ser terminado de forma inmediata por cualquiera de las Partes en cualquier momento mediante notificación escrita.</p>
                    <p>6.2. - El presente Acuerdo podrá ser terminado por justa causa, independientemente de cualquier notificación, en la ocurrencia de los eventos siguientes:</p>

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
                    <p>(a) consecutives delays or failure to comply by the Customer with the payments due to the contractor remuneration or repeated non-delivery or late delivery of the Services by the contractor;</p>
                    <p>(b) if any party breaches any term or condition of this Agreement and fails to remedy to such failure within ten (10) days from the date of receipt of written notification from the other party, in this sense.</p>
                    <p>(c) if any Party enters into insolvency, bankruptcy, or recovery or judicial or extrajudicial liquidation or even, if for any reason there is evidence that one of the Parties – by means of an absence of to comply with its obligations towards third parties-, is putting in risk in any way the possession of its assets or the maintenance of its Customer.</p>
                    <p>6.3. – Upon termination of this Agreement or at its termination, CONTRATADA undertakes to:</p>
                    <p>a) return to the Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by the Contractor in relation to the Services agreed upon in this Agreement;</p>
                    <p>(b) respect and comply with all Service requests forwarded by the Customer before the date of expiration or early termination of this Agreement;</p>
                    <p>6.4. – Upon termination of this Agreement the obligations of confidentiality shall remain valid between the parties for a period of five (5) years, including the obligations relating to the exclusivity and non-competing.</p>
                    <p>6.5 The Customer may terminate the Agreement forthwith without notice or liability at any time in the event of the following;</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(a) consecutivos retrasos o incumplimiento por el Cliente con los pagos debidos a la remuneración del contratista o la repetida falta de entrega o entrega atrasada de los Servicios por parte del contratista;</p>
                    <p>(b) si alguna parte incumple cualquiera de los términos o condiciones de este Acuerdo y no subsana dicho incumplimiento en el plazo de diez (10) días desde la fecha de recepción de la notificación por escrito de la otra parte, en este sentido.</p>
                    <p>(c) si cualquiera de las Partes entra en insolvencia, quiebra o evento judicial o extrajudicial recuperación o liquidación o, si por alguna razón hay evidencia de que una de las Partes - por medio de un incumplimiento en sus obligaciones frente a terceros -, está poniendo en riesgo de alguna forma la posesión de sus bienes o el mantenimiento de sus clientes.</p>
                    <p>6.3. - A la terminación de este Acuerdo o en su recisión, el CONTRATISTA se compromete a:</p>
                    <p>(a) retornar al Cliente el día de la terminación del presente Acuerdo, cualquiera y todos los equipos, material promocional, y otros documentos que hayan sido proporcionados por el Contratista en relación a los Servicios pactados en este Acuerdo;</p>
                    <p>(b) respetar y cumplir con todas las solicitudes de servicio enviadas por el Cliente antes de la fecha de vencimiento o terminación anticipada del presente Acuerdo;</p>
                    <p>6.4. - A la terminación del presente Acuerdo, las obligaciones de confidencialidad permanecerán válidas entre las partes por un período de cinco (5) años, incluidas las obligaciones relativas a la exclusividad y no competencia.</p>
                    <p>6.5 El Cliente podrá dar por terminado el acuerdo de manera inmediata y sin previo aviso o responsabilidad en cualquier momento en el caso de los siguientes;</p>

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

                    <p>6.5.1 The End Customer requests the Service Provider to be removed from the Assignment;</p>
                    <p>6.5.2 The End Customer finds the Service Providing Company or the Service Provider to be negligent, inefficient, or technically unsuitable in the performance of the services;</p>
                    <p>6.5.3 The Customer advise the Contractor that the Service Providing Company or the Service Provider(s) has, in its reasonable view, committed an act of misconduct which makes it unacceptable for the Customer to continue to use the Services;</p>

                    <p>6.5.4 The Service provider’s unauthorized absence, lack of technical ability, lack of performance, or persistently commits minor breaches of these terms or the Customer rules and regulations;</p>
                    <p>6.5.5 The Service provider’s action is considered to be a material breach of any of the terms of this assignment;</p>
                    <p>6.5.6 The Service Providing Company breach any terms of the Agreement and fail to remedy any such breach within seven
                        (7) days of notice being given by the Customer to the Service Providing Company requiring remedy;
                    </p>
                    <p>6.5.7 The Agreement between the Customer and the Customer fail definitely to start for whatever reason;</p>
                    <p>6.5.8 The Service Providing Company and/or its Service Provider(s) are convicted of a serious criminal offence which, in the opinion of the Customer could affect the Customer's reputation;</p>
                    <p>6.5.9 The Service Providing Company is unable to fulfil the Agreement, as required for any reason;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>6.5.1 El cliente final solicita que el proveedor de servicios sea eliminado de la asignación;</p>
                    <p>6.5.2 El cliente final descubre que la empresa que presta el servicio o el proveedor de servicios es negligente, ineficiente o no es técnicamente apto en la realización de los servicios;</p>
                    <p>6.5.3 El Cliente notifica el Contractor de que la compañía que proporciona el servicio o el proveedor (s) del servicio ha cometido, según su razonable juicio, un acto de mala conducta que hace que sea inaceptable para el cliente de seguir utilizando los Servicios;</p>

                    <p>6.5.4 La ausencia no autorizada del proveedor de servicios, la falta de capacidad técnica, falta de rendimiento, o persistente comisión de infracciones leves de estos términos o de las reglas y reglamentos Clientes;</p>
                    <p>6.5.5 La acción del proveedor de servicio es considerado como una violación grave de alguno de los términos de esta asignación;</p>
                    <p>6.5.6 La Empresa Proveedora de Servicios incumple cualquiera de los términos del Acuerdo y no logra remediar dicho incumplimiento dentro de los siete (7) días de la notificación realizada por el Cliente a la compañía que proporciona el servicio y que debe subsanar;</p>
                    <p>6.5.7 El Acuerdo entre el Contratista y el cliente no se inicia en definitiva por cualquier motivo;</p>
                    <p>6.5.8 La compañía que proporciona servicio y / o su proveedor (s) de servicio son condenados por un delito grave que, en opinión del Cliente, podría afectar a la reputación del Cliente;</p>
                    <p>6.5.9 La Compañía Proveedora del Servicio es incapaz de cumplir el Acuerdo, como se requiere para alguna razón;</p>
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
                    <p>6.5.10 The Customer fails to make payment to the Contractor in accordance with any of its agreements with the Customer for the provision of Services. For the avoidance of doubt this Sub-Clause is not restricted to the Customer's failure to pay for the Service Providing Company’s services provided pursuant to the Agreement;</p>
                    <p>6.5.11 A receiver, administrative receiver, administrator or similar officer be appointed to the Service Providing Company or any part of its assets or undertaking, or the Service Providing Company go into liquidation;</p>
                    <p>6.5.12 A receiver, administrative receiver, administrator or someone of similar office be appointed to the Customer or any part of its assets or undertakings, or the Customer go into liquidation;</p>
                    <p>6.5.13 the agreement between the Customer and the Contractor is terminated forthwith by the Customer for any reason;</p>
                    <p>6.6 The Service Providing Company and /its Service Provider(s) accepts the termination under sub-clause’s 6.5.1– 6.5.3 shall arise as a direct result of the decision/action of the Customer, and it shall have no compliant or claim against the Customer as a result.</p>
                    <p>6.7 Termination of an Assignment will be effective from the date that a valid termination notice under this Clause 10 is provided to the other party either verbally or in writing. Where notice has been provided verbally, this must be confirmed in writing at the earliest opportunity.</p>
                    <p>6.8 Termination of an Assignment under any of the provisions hereof shall be without prejudice to the rights and obligations of the parties arising hereto prior to, or as a result of, such termination.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>6.5.10 El cliente no realiza el pago a el Contratista de acuerdo con cualquiera de sus acuerdos con el Contratista para la prestación de los Servicios. Para evitar dudas, esta Sub-cláusula no se limita a la incapacidad del cliente para pagar los servicios de la Prestación de Servicios de la compañía previstas en aplicación del Acuerdo;</p>
                    <p>6.5.11 Un receptor, receptor administrativo, administrador o funcionario similar sea nombrado en la empresa proveedora de Servicios o cualquier parte de sus activos o empresa, o la compañía que proporciona servicio entra en liquidación;</p>
                    <p>6.5.12 Un receptor, receptor administrativo, administrador o alguien similar de la oficina es nombrado para el Cliente o cualquier parte de sus activos o empresas, o el cliente entra en liquidación;</p>
                    <p>6.5.13 el acuerdo entre el Cliente y el Contratista es terminado con efecto inmediato por el Cliente por cualquier motivo;</p>
                    <p>6.6 La empresa prestadora de servicios y / su proveedor (s) de servicio acepta la terminación en virtud de las Sub-cláusulas 6.5.1- 6.5.3 caso ocurran como resultado directo de la decisión / acción del cliente, y sin nada a protestar o reclamar contra el Cliente como consecuencia.</p>
                    <p>6.7 La terminación del acuerdo será efectiva a partir de la fecha en que se proporciona el aviso de terminación válida bajo esta Cláusula 10 a la otra parte, ya sea verbalmente o por escrito. Cuando el aviso sea verbal, esto debe ser confirmado por escrito a la mayor brevedad.</p>
                    <p>6.8 La terminación de una asignación en cualquiera de las disposiciones de la misma se entenderá sin perjuicio de los derechos y obligaciones de las partes presentes, o como resultado de dicha terminación.</p>

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
                    <p>6.9 Termination of this Assignment by either The Service Providing Company and /its Service Provider (s) outside of the agreed notice periods or any terms of this Assignment, the Customer has the right to withhold any and all mobilization/demobilization costs from the final signed timesheet.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4 !important'>6.9 La terminación de la presente Asignación tanto por la empresa proveedora de servicio o por / su Proveedor de servicios (s) fuera de los plazos de preaviso convenidos o cualquier término de esta asignación, el Cliente tiene el derecho de retener cualquier y todos los costos de movilización / desmovilización de la última planilla de horas firmadas.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. – ACT OF GOD OR FORCE MAJEURE</b></p>
                    <p>7.1. - Any situation which is actually caused by an unexpected event, or even if possible, of being planned, an event that is impossible to avoid, and which prevents the compliance of all or part of this Agreement by either Party, shall be understood as an act of God or a situation of “force majeure”.</p>
                    <p>7.1.1. - The following events are defined as acts of God or force majeure, among others, without limitation: wars, whether or not declared, revolutions, public disorder, earthquakes, landslides, mudslides, floods, exceptional rains and restrictions of public policy or any other circumstance beyond the reasonable control of the parties.</p>
                    <p>7.1.2. – The Party invoking an Act of God or an event of force majeure shall promptly notify the other party by the quickest means possible, confirming such communication by written notice through any means set forth in this Agreement.</p>
                    <p>7.2. – In case of force majeure that prevents the parties from fulfilling their obligations, such fulfillment will be suspended until the end of the event giving rise to force majeure, accordingly to the provisions below.</p>
                    <p>7.3. – If the term of the force majeure event proves to be longer than three (3) months, either party may terminate this Agreement by prior written notice of one (1) month, and the Parties shall be required to liquidate their mutual obligations in effect until the time of termination.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. - FUERZA MAYOR</b></p>
                    <p style='line-height: 1.4 !important'>7.1. - Cualquier situación que sea causada por un evento inesperado, o incluso en el caso de ser planificado, un evento que es imposible de evitar, y que impide el cumplimiento de la totalidad o parte de este Acuerdo por cualquiera de las Partes, será un acto comprendido como de "fuerza mayor".</p>
                    <p style='line-height: 1.4 !important'>7.1.1. - Los eventos siguientes se definen como de fuerza mayor, entre otros, pero sin limitarse a: las guerras, declaradas o no, revoluciones, disturbios públicos, terremotos, deslizamientos, derrumbes, inundaciones, lluvias excepcionales y restricciones de orden público o cualquier otra circunstancia más allá del control razonable de las partes.</p>
                    <p style='line-height: 1.4 !important'>7.1.2. - La parte que invoque un caso de fuerza mayor, deberá notificar de inmediato a la otra parte por el medio más rápido posible, confirmando dicha comunicación mediante notificación por escrito a través de cualquier medio establecido en el presente Acuerdo.</p>
                    <p>7.2. - En caso de fuerza mayor que impida a las partes el cumplimiento de sus obligaciones, tal cumplimiento se suspenderá hasta el final del evento que dé lugar a fuerza mayor, de acuerdo a las siguientes disposiciones.</p>
                    <p>7.3. - Si el término del evento de fuerza mayor se demuestra ser de más de tres (3) meses, cualquiera de las partes podrá rescindir el presente Acuerdo mediante notificación previa por escrito de un (1) mes, y las Partes estarán obligadas a liquidar sus obligaciones mutuas en efecto hasta el momento de la terminación.</p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: 35px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. - GENERAL PROVISIONS</b></p>
                    <p>8.1. – <b>Changes</b> – Any changes or inclusions to this Agreement shall be made with the mutual consent of the parties and in writing.</p>
                    <p>8.2. – <b>Independence</b> – If any provision of this Agreement is deemed to be invalid, illegal or unenforceable before any law or public policy, all other provisions of this Agreement will remain independent and in full force and effect for as long as the economic and legal transactions contemplated herein are not impaired by either party. If it is determined that any provision is invalid, illegal or unenforceable, the Parties shall negotiate in good faith to amend this Agreement so as to make effective its original intent in the most acceptable way possible, and so that the transactions contemplated by this Agreement are performed.</p>
                    <p>8.3. – <b>Assignment</b> – Except for the assignment hereof to the Parties’ affiliate companies, this Agreement may not be transferred or assigned in whole or in part by either party without the prior written consent of the other Party.</p>
                    <p>8.4. – <b>Entire Agreement</b> – This Agreement contains the entire agreement between the Parties with respect to the subject matter hereof. Any documents, commitments and prior covenants, oral, written or otherwise agreed between the Parties related to the subject matter of this Agreement shall be considered canceled and will not affect or modify any of its provisions or obligations. Any changes to this Agreement must be made in writing, by agreement between the Parties.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. - DISPOSICIONES GENERALES</b></p>
                    <p>8.1. - Cambios - Cualquier cambio o inclusión a este Acuerdo se deberá hacer con el mutuo consentimiento de las partes y de manera escrita.</p>
                    <p>8.2. - <b>Independencia</b> - Si se considera que alguna disposición de este Acuerdo es inválida, ilegal o no ejecutable ante cualquier ley o política pública, todas las demás disposiciones del presente Acuerdo permanecerán en pleno vigor e independientes y vigentes siempre y cuando las transacciones económicas y legales que se contemplan en este documento no se vean afectadas por alguna de las partes. Si se determina que alguna disposición es inválida, ilegal o inaplicable, las partes deberán negociar de buena fe para modificar el presente Acuerdo a fin de hacer efectiva su intención original de la forma más aceptable posible, y para que las transacciones contempladas en el presente Acuerdo sean realizadas.</p>
                    <p>8.3. - <b>Asignación</b> - Con excepción de la asignación a empresas filiales de las Partes, el presente Acuerdo no podrá ser cedido o transferido en su totalidad o en parte, por cualquiera de las partes sin el consentimiento previo por escrito de la otra Parte.</p>
                    <p>8.4. - <b>Acuerdo completo</b> - Este Acuerdo contiene el acuerdo completo entre las partes con respecto al objeto del mismo. Todos los documentos y compromisos previos pactos, oral, escrita o acuerdo en contrario entre las Partes en relación con la materia objeto del presente Acuerdo se considerará cancelado y no afectará o modificará cualquiera de sus disposiciones u obligaciones. Cualquier cambio a este Acuerdo deberá hacerse por escrito, previo acuerdo entre las Partes.</p>

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
                    <p>8.5. – <b>Tolerance and Absence of Waiver and Novation.</b> The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4 !important'>8.5. - <b>Tolerancia y Ausencia de Renuncia y Novación</b>. La tolerancia en la falta de cumplimiento, incluso si se repite, por cualquiera de las Partes, las disposiciones del presente Acuerdo no constituyen o no se interpretará como una renuncia por parte de la otra Parte o como novación. Si cualquier corte o tribunal encuentra que cualquier disposición o artículo de este Acuerdo es nula, inválida o sin efecto vinculante, el resto de este Contrato permanecerá en pleno vigor y efecto como si dicha disposición o la parte no se habían integrado el presente Acuerdo.</p>

                </td>
            </tr>


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>8.6. – <b>Succession.</b> This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives.</p>
                    <p>8.7. – <b>Communication between the Parties.</b> All warnings, communications, notifications and mailing resulting from the performance of this Agreement shall be done in writing, with receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by registry at the Registry of Deeds and Documents and will only be valid when directed and delivered to the parties at the addresses indicated below in accordance with the applicable law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>8.6. - <b>Sucesión.</b> Este acuerdo obliga a las partes y sus respectivos sucesores, particulares y universales, cesionarios autorizados y representantes legales.</p>
                    <p>8.7. - <b>La comunicación entre las Partes.</b> Todos los avisos, comunicaciones, notificaciones y correo resultantes de la ejecución de este Contrato se harán por escrito, con acuse de recibo, por correo con acuse de recibo, por correo electrónico con acuse de recibo o por el registro en el Registro de Títulos y Documentos, y sólo será válida cuando dirigido y entregado a las partes en las direcciones abajo indicadas de acuerdo con la ley aplicable.</p>
                </td>
            </tr>


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>If to:<b> INTERMEDIANO PERÚ SAC</b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: Carlos Ricardo Argote Silva</p>
                    <p style="line-height: 1.5; margin: 2px;">Address: Av. Paseo de Republica 3195 oficina 401, San Isidro, Lima, Perú</p>
                    <p style="line-height: 1.5; margin: 2px;">Phone/Fax: +51 998 090 355</p>
                    <p style="line-height: 1.5; margin: 2px;">E-mail: <a href="#">carlos@alg.pe</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Si a: <b>INTERMEDIANO PERÚ SAC</b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: Carlos Ricardo Argote Silva</p>
                    <p style="line-height: 1.5; margin: 2px;">Dirección: Av. Paseo de Republica 3195 oficina 401, San Isidro, Lima, Perú</p>
                    <p style="line-height: 1.5; margin: 2px;">Teléfono / Fax: +51 998 090 355</p>
                    <p style="line-height: 1.5; margin: 2px;">E-mail: <a href="#">carlos@alg.pe</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>If to: <b>{{ $companyName }}</b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: {{ $contactName }} {{ $contactSurname }}</p>
                    <p style="line-height: 1.5; margin: 2px;">Address: {{ $customerAddress }} </p>
                    <p style="line-height: 1.5; margin: 2px;">Phone/Fax: {{ $customerPhone }}</p>
                    <p style="line-height: 1.5; margin: 2px;">E-mail: <a href="#">{{ $customerEmail }}</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Si a: <b>{{ $companyName }}</b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: {{ $contactName }} {{ $contactSurname }}</p>
                    <p style="line-height: 1.5; margin: 2px;">Dirección: {{ $customerAddress }} </p>
                    <p style="line-height: 1.5; margin: 2px;">Telefone: {{ $customerPhone }}</p>
                    <p style="line-height: 1.5; margin: 2px;">Correo Electrónico: <a href="#">{{ $customerEmail }}</a> </p>
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
                    <p><b>IX. – JURISDICTION</b></p>
                    <p>9.1. - The parties elect the courts of Panama City to settle any doubts and/or disputes arising out of this instrument, with the exclusion of any other jurisdiction, as privileged as it may be, and the applicable law shall be of the Republic of Panama.</p>
                    <p>In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and content, for one sole purpose.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IX. - JURISDICCIÓN</b></p>
                    <p>9.1. - Las partes eligen a los tribunales de la Ciudad de Panamá para resolver cualquier duda y/o las disputas que surjan de este instrumento, con la exclusión de cualquier otro fuero, por privilegiados que puedan ser y la ley aplicable será la de la República de Panamá.</p>
                    <p>En fe de lo cual, las partes firman el presente Contrato en dos (2) copias de igual tenor y a un solo efecto.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>{{ $employeeCity }}, {{ $contractCreatedDay }} of {{ $contractCreatedmonth }} of {{ $contractCreatedyear }}.</p>

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>Contractor</b></p>

                        <img src="{{ $is_pdf ? public_path('images/fabian_signature.png') : asset('images/fabian_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">INTERMEDIANO PERÚ SAC</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">RUC: 20606232960</p>
                    </div>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>{{ $employeeCity }}, {{$contractDay}} de {{ $translatedMonth }} de {{ $contractCreatedyear }}.</p>

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>Contratista</b></p>

                        <img src="{{ $is_pdf ? public_path('images/fabian_signature.png') : asset('images/fabian_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">INTERMEDIANO PERÚ SAC</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">RUC: 20606232960</p>
                    </div>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>Customer</b></p>

                    <div style="margin-top: 20px;">
                        <p style='text-align: center'><b>{{ $companyName }}</b></p>
                    </div>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? Storage::disk('private')->path($record->signature)
                                : url('/signatures/customer/' . $record->company_id . '/customer') . '?v=' . filemtime(storage_path('app/private/signatures/clients/customer_' . $record->company_id . '.webp')) 
                        }}" alt="Employee Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;" />
                        @else
                        <div style="text-align: center; position: relative; height: 100px;">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;">
                        </div>
                        @endif
                        <p style='position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%);'>{{ $signedDate }}</p>
                        <p style="position: absolute; bottom: 0px; left: 50%; transform: translateX(-50%);">{{ $customerName }} {{ $contactSurname }}</p>
                        <p style="position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%);">{{ $customerPosition }}</p>

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>Cliente</b></p>
                    <div style="margin-top: 20px;">
                        <p style='text-align: center'><b>{{ $companyName }}</b></p>
                    </div>
                    <div style="text-align: center; position: relative; height: 100px;">

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? Storage::disk('private')->path($record->signature)
                                : url('/signatures/customer/' . $record->company_id . '/customer') . '?v=' . filemtime(storage_path('app/private/signatures/clients/customer_' . $record->company_id . '.webp')) 
                        }}" alt="Employee Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;" />
                        @else
                        <div style="text-align: center; position: relative; height: 100px;">
                            <img src="{{ public_path('images/blank_signature.png') }}" alt="Signature" style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;">
                        </div>
                        @endif
                        <p style='position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%);'>{{ $signedDate }}</p>
                        <p style="position: absolute; bottom: 0px; left: 50%; transform: translateX(-50%);">{{ $customerName }} {{ $contactSurname }}</p>
                        <p style="position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%); width: 100%; text-align: center;">{{ $customerTranslatedPosition }}</p>

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                    </div>

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
                    <p style="text-align: center"><b>ANNEX I</b></p>
                    <p style="text-align: center; font-weight: bold">EMPLOYEE WORKING DETAIL:</p>
                    <p><b>Name of Employee:</b> {{ $record->employee->name }}</p>
                    <p><b>Date of Birth:</b> {{ $employeeDateBirth }}</p>
                    <p><b>ID Number:</b> {{ $employeePersonalId }}</p>
                    <p><b>Address:</b> {{ $employeeAddress }}</p>
                    <p><b>Mobile:</b> {{ $employeeMobile }}</p>
                    <p><b>E-mail:</b> {{ $employeeEmail }}</p>
                    <p><b>Marital Status:</b> {{ $employeeCivilStatus }}</p>
                    <p><b>Country of Work:</b> {{ $record->country_work }}</p>
                    <p><b>Job Title:</b> {{ $record->job_title }}</p>
                    <p><b>Start Date:</b> {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p><b>Contract Type: [Contract Type]</b></p>
                    <p><b>Remuneration Value:</b> {{ number_format($employeeGrossSalary, 2) }} Gross/Monthly</p>
                    <p><b>DATE OF PAYMENT (every month):</b> Last day of the working month</p>
                    <p><b>LOCAL PAYMENT CONDITIONS:</b> Salaries and/or any other remuneration is set in [{{ $currencyName }}/Amount/Terms]</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>ANEXO I</b></p>
                    <p style="text-align: center; font-weight: bold">DETALLE DE TRABAJO DEL EMPLEADO:</p>
                    <p><b>Nombre del Empleado: </b> {{ $record->employee->name }}</p>
                    <p><b>LOCAL PAYMENT CONDITIONS:</b> {{ $employeeDateBirth }}</p>
                    <p><b>Número de IDENTIFICACIÓN:</b> {{ $employeePersonalId }}</p>
                    <p><b>Dirección:</b> {{ $employeeAddress }}</p>
                    <p><b>Teléfono Móvil:</b> {{ $employeeMobile }}</p>
                    <p><b>Correo Electrónico:</b> {{ $employeeEmail }}</p>
                    <p><b>Estado Civil:</b> {{ $employeeCivilStatus }}</p>
                    <p><b>País de Trabajo: </b> {{ $record->country_work }}</p>
                    <p><b>Cargo:</b> {{ $record->job_title }}</p>
                    <p><b>Fecha de Inicio:</b> {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p><b>Contract Type: [Contract Type]</b></p>
                    <p><b>Valor de la Remuneración:</b> {{ number_format($employeeGrossSalary, 2) }} Bruto/Mensua</p>
                    <p><b>FECHA DE PAGO (mensual):</b> Ultimo día del mês trabajado</p>
                    <p><b>FECHA DE PAGO (mensual):</b> El salario y/o cualquier otra remuneración se realizan en [{{ $currencyName }}/Monto/Términos]</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; font-weight: bold;margin-bottom: 16px">
                        <p style='text-align: center'>ANNEX II</p>
                    </div>
                    <p><b>A) FEES AND PAYMENT TERMS:</b>
                        FEES: Customer shall pay the Contractor in a monthly basis, based on the calculation below:
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; font-weight: bold;margin-bottom: 16px">
                        <p style='text-align: center'>ANEXO II</p>
                    </div>
                    <p><b>A) TARIFAS Y CONDICIONES DE PAGO:
                            TARIFAS:</b> El Cliente deberá pagar al Contratista mensualmente, según el cálculo a continuación:
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>

        <div style="margin-top: -20px !important">
            @include('pdf.peru_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>INVOICE:</b> Contractor will issue a monthly invoice to the Customer every 1st day of the month and Customer shall pay to Contractor until the 20th. day of the same month the invoice was issued. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FACTURA:</b> El Contratista emitirá una factura mensual al Cliente el 1er día del mes y el Cliente pagará al Contratista hasta el día 20. día del mismo mes en que se emitió la factura. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main style='page-break-after: avoid'>

        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DUEDATE:</b> Every month the payments shall be credited on Provider´s bank account up to the 20th of the same month the respective invoice was issued. </p>
                    <p><b>PENALTY:</b> Payments credited after the 20th. due date mentioned above, shall have an interest of 3%.</p>
                    <p><b>EXCHANGE RATE:</b> Invoices will be issued in EUR based on the exchange rate of the date of the issuance of the invoice. The exchange rate utilized in the contract is of [ ] per EUR and it is as reference only. This rate will change monthly according to the currency fluctuation.</p>
                    <p style='text-align: left; white-space: nowrap; margin-bottom: -15px'><b>GUARANTEE (1 MONTH SALARY/REMUNERATION):</b></p>
                    <p>
                        Customer shall anticipate the monthly cost per each employee. This amount will be kept by Provider until the end of the Agreement and will be compensated on the last working month of the respective employee
                    </p>
                    <p><b>B) LOCAL LEGISLATION - PREVAILS</b>
                        The law that will govern the entire Agreement and the relations related to Employee´s obligations and rights will be the law of the country where the services are being provided, including but not limited to, labor and tax, and must be fully complied with the purposes of the local and global compliance guidelines
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FECHA DE VENCIMIENTO:</b> Cada mes los pagos se acreditarán en la cuenta bancaria del Proveedor hasta el día 20 del mismo mes en que se emitió la factura respectiva. </p>
                    <p><b>PENALIZACIÓN:</b> Pagos acreditados después del día 20, la fecha de vencimiento mencionada anteriormente tendrá un interés del 3%.</p>
                    <p><b>TASA DE CAMBIO:</b> Las facturas se emitirán en EUR en base al tipo de cambio de la fecha de emisión de la factura. La tasa de cambio utilizada en el contrato es de [ ] por EUR y sirve como referencia solamente. La tasa variará mensualmente según la fluctuación cambiaria.</p>
                    <p style='text-align: left;  white-space: nowrap; margin-bottom: -15px;'><b>GARANTÍA (1 MES DE SALÁRIO/REMUNERACIÓN):</b> </p>
                    <p>
                        El cliente deberá anticipar el costo mensual por cada empleado. Esta cantidad será retenida por el Proveedor hasta el final del Acuerdo y será compensada en el último mes hábil del empleado respectivo.
                    </p>
                    <p><b>B) LEGISLACIÓN LOCAL - PREVALECE</b>
                        La ley que regirá todo el Acuerdo y las relaciones relacionadas con las obligaciones y derechos del Empleado será la ley del país donde se prestan los servicios, incluidos, entre otros, el trabajo y los impuestos, y debe cumplirse plenamente con los propósitos de las pautas de cumplimiento locales y globales
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

</body>

</html>
