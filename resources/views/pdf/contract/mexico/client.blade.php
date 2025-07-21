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
$contractCreatedyear = $record->created_at->format('Y');
$contractDay = $record->created_at->format('j');

$translatedMonth = \Carbon\Carbon::parse($record->created_at)->locale('es')->translatedFormat('F');
$createdDate = (new DateTime($record->created_at))->format('[d/m/Y]');

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
$employeeName = $record->employee->name;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeCountryWork = $record->country_work ?? null;
$employeeEmail = $record->employee->email ?? null;
$employeeAddress = $record->personalInformation->address ?? null;
$employeeCity = $record->personalInformation->city ?? null;
$employeeDateBirth = $record->personalInformation->date_of_birth ?? null;
$employeeMobile = $record->personalInformation->mobile ?? null;
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

    .line-height-sm {
        line-height: 1.4
    }

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">SERVICE AGREEMENT</h4>
                    <p>This Payroll and HR Service Agreement (the “Agreement”) is made on {{ $createdDate }} (the “Effective Date”), by and between <b>INTERMEDIANO, S.A. DE C.V.</b> (the <b>“Provider”</b>), domiciliated at Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, Postal Code 11590, CDMX, México; AND {{ $companyName }} (the <b>“Customer”</b>), a company duly incorporated with {{ $customerTaxId }} under the laws of {{ $customerCountry }} and holding offices at {{ $customerAddress }}.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE SERVICIOS</h4>
                    <p>Este Contrato de Servicios de Nómina y Recursos Humanos (el "Acuerdo") se realiza el {{ $createdDate }} (la "Fecha de Vigencia"), por y entre <b>INTERMEDIANO, S.A. DE C.V.</b> (el <b>"Proveedor"</b> ) domiciliado Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, Código Postal 11590, CDMX, México, debidamente representado por su representante legal; Y {{ $companyName }} (el <b>"Cliente"</b>), una sociedad debidamente constituida con {{ $customerTaxId }} según las leyes de {{ $customerCountry }} y con domicilio en {{ $customerAddress }}.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> the Provider provides certain special services; and </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que el Proveedor proporciona ciertos servicios especiales; y</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Customer wishes to obtain the services and Provider wishes to provide the services on the terms and conditions set forth herein;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que el Cliente desea obtener los servicios y el Proveedor desea proporcionar los servicios en los términos y condiciones establecidos en este documento;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> services will be provided by Provider in México;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que los servicios serán proporcionados por el Proveedor, en México;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Provider will render directly;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que el Proveedor prestará servicios directos; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOW, THEREFORE,</b> in consideration of the premises and the mutual covenants set forth herein, the parties hereby agree as follows:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>AHORA, POR LO TANTO,</b> en consideración de las premisas y los pactos mutuos establecidos en este documento, las partes acuerdan lo siguiente:</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Provider and Customer hereinafter jointly referred to as "Parties" and individually a "Party";</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Proveedor y el Cliente en lo sucesivo denominados conjuntamente como "Partes" e individualmente una "Parte";</p>
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
                    <p>The Parties decide to enter into the present Services Agreement (“Agreement”), which shall be governed by the following terms and conditions:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Las Partes deciden celebrar el presente Acuerdo de Servicios ("Acuerdo"), que se regirá por los siguientes términos y condiciones:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I. PURPOSE</b></p>
                    <p><b>Service Offerings.</b> Provider shall provide to Customer the services of payroll, consulting and HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein (collectively, the “Services”), during the Term (defined in Section VII) subject to the terms and conditions of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I. FINALIDAD</b></p>
                    <p><b>Ofertas de servicios.</b> El Proveedor proporcionará al Cliente los servicios de nómina, consultoría y recursos humanos adjuntos al presente según Anexo A (el "Anexo A") e incorporados en este documento (colectivamente, los "Servicios"), durante el Plazo (definido en la Sección VII) sujeto a los términos y condiciones de este Acuerdo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. PROVIDER RESPONSIBILITIES</b></p>
                    <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby undertakes to:</p>
                    <p><b>a)</b> to meet the requirements and quality standards required by Customer, which may periodically review the Services performed by the Provider;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. RESPONSABILIDADES DEL PROVEEDOR</b></p>
                    <p>Sin perjuicio de las demás obligaciones en virtud de este Acuerdo, el Proveedor; se compromete a:</p>
                    <p><b>a)</b> cumplir con los requisitos y estándares de calidad requeridos por el Cliente, el cual podrá revisar periódicamente los Servicios realizados por el Proveedor;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> to collect all taxes related to its activities, considering each different local law, rules and compliance demand;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> recaudar todos los impuestos relacionados a sus actividades, teniendo en cuenta cada una de las diferentes leyes, normas y requisitos de cumplimiento locales;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> to provide, whenever customer requests it, all reports, spreadsheets and other information relating to the Services and its country local aspects;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> proporcionar, siempre que el cliente lo solicite, todos los informes, hojas de cálculo y otra información relacionada con los Servicios y los aspectos locales del país;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>d)</b> to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters, in particular, but not limited to, those related to the protection of the environment, exempting Customer from any responsibility resulting therefrom. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>d)</b> cumplir con todas las leyes, decretos, reglamentos, resoluciones, decisiones, normas y otras disposiciones globales y locales consideradas por la ley en relación a la prestación del servicio y los asuntos laborales, en particular, pero no limitados a los relacionados con la protección del medio ambiente, eximiendo al Cliente de cualquier responsabilidad que resulte de ello.</p>

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
                    <p>Therefore, the Provider declares in this Agreement that its activities and services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> Por lo tanto, el Proveedor declara en este Acuerdo que sus actividades y servicios, utilizados ahora y en el futuro, cumplen con la legislación y las normas de protección y seguridad en materia sanitaria y del medio ambiente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>III. CUSTOMER RESPONSABILITIES:</b></p>
                    <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby undertakes to:</p>
                    <p><b>a)</b> to process the monthly payment to the Provider set forth in Schedule B (the “Schedule B”), following strictly the local labor legislation, considering where the service is being provided;</p>
                    <p><b>b)</b> to supply the technical information required for the Services to be performed. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>III. RESPONSABILIDADES DEL CLIENTE:</b></p>
                    <p>Sin perjuicio de las demás obligaciones en virtud de este Acuerdo, el Cliente se compromete a:</p>
                    <p><b>a)</b> realizar el pago mensual al Proveedor establecido en el Anexo B (el "Anexo B"), siguiendo estrictamente la legislación laboral local, considerando dónde se está prestando el servicio;</p>
                    <p><b>b)</b> proporcionar la información técnica requerida para la realización de los Servicios. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV. PAYMENT AND FEES: </b></p>
                    <p><b>a)</b> For the Services agreed herein, Customer shall pay to the Provider the amount set forth and described in Schedule B. </p>
                    <p><b>b)</b> Each Party shall pay all taxes, charges, fees and social contributions due in terms of their activities and / or contractual obligations.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV. PAGO Y TASAS: </b></p>
                    <p><b>a)</b> Para los Servicios acordados en este documento, el Cliente deberá pagar al Proveedor la cantidad establecida y descrita en el Anexo B. </p>
                    <p><b>b)</b> Cada Parte pagará todos los impuestos, cargas, tasas y contribuciones sociales adeudadas en términos de sus actividades y / u obligaciones contractuales.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V. - CONFIDENTIALITY</b></p>
                    <p><b>a)</b> Both parties agree to Endeavor to take all reasonable measures to keep in confidence the execution, terms and conditions as well as performance of this Agreement, and the confidential data and information of any party that another party may know or access during performance of this Agreement (hereinafter referred to as “Confidential Information”), and shall not disclose, make available or assign such Confidential Information to any third party without the prior written consent of the party providing the information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V. CONFIDENCIALIDAD</b></p>
                    <p><b>a)</b> Ambas partes acuerdan esforzarse por tomar todas las medidas razonables para mantener en confidencialidad la ejecución, los términos y condiciones, así como el cumplimiento de este Acuerdo, y los datos e información confidenciales de cualquier parte que la otra parte pueda conocer o acceder durante el cumplimiento de este Acuerdo (en lo sucesivo, "Información confidencial"), y no divulgará, pondrá a disposición o cederá dicha Información Confidencial a ningún tercero sin el consentimiento previo por escrito de la parte que proporciona la información.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: 40px'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> Information received by a Party which: (i) is information of general or public knowledge; (ii) has been previously approved or consented to in writing, generally and without restriction, by the Party from which the information originates; and/or (iii) has been requested by a competent administrative or judicial authority, shall not be covered by the confidentiality obligation provided herein. In the latter case, the Party receiving such a request shall inform the other Party as promptly as possible and provided that the nature of the administrative or judicial proceedings so permits.</p>
                    <p><b>c)</b> During the term of this Agreement and for a period of five (5) years after its termination, both Parties undertake to maintain the most complete and absolute confidentiality on any information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> No quedan comprendidas dentro de la obligación de confidencialidad aquí prevista la información recibida por una de las Partes que:(i) sea información de general o público conocimiento; (ii) haya sido su transmisión a terceros aprobada o consentida previamente y por escrito, con carácter general y sin restricciones, por la Parte de la que procede la información; y/o (iii) haya sido solicitada por una autoridad administrativa o judicial competente. En este último caso, la Parte que reciba tal solicitud informará a la otra Parte con la mayor celeridad posible y siempre que la naturaleza de las actuaciones administrativas o judiciales lo permitan.</p>
                    <p><b>c)</b> Durante la vigencia del presente Acuerdo y durante un periodo de cinco (5) años desde su terminación, ambas Partes se comprometen a mantener la más completa y absoluta confidencialidad sobre cualquier información.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. - GDPR DATA PROTECTION</b></p>
                    <p>Any information containing personal data shall be handled in accordance with all applicable privacy laws and regulations, including without limitation the GDPR REGULATION (EU) 2016/679 OF THE EUROPEAN PARLIAMENT AND OF THE COUNCIL) of April 27th., 2016 and equivalent laws and regulations. If for the performance of the services it is necessary to exchange personal data, the relevant Parties shall determine their respective positions towards each other (either as controller, joint controllers or processor) and the subsequent consequences and responsibilities according to the GDPR as soon as possible after the Effective Date.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. PROTECCIÓN DE DATOS GDPR</b></p>
                    <p>Cualquier información que contenga datos personales se manejará de acuerdo con todas las leyes y reglamentaciones de privacidad aplicables, incluidas, entre otras, las leyes y regulamentos GDPR (REGLAMENTO (UE) 2016/679 DEL PARLAMENTO EUROPEO Y DEL CONSEJO de 27 de abril de 2016) y equivalentes. Si para la prestación de los servicios es necesario intercambiar datos personales, las Partes pertinentes determinarán sus respectivas posiciones entre sí (ya sea como responsables del tratamiento, corresponsables del tratamiento o encargados del tratamiento) y las consecuencias y responsabilidades posteriores de acuerdo con el GDPR tan pronto como sea posible después de la Fecha de entrada en vigencia. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: 65px !important">


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. INTELLECTUAL AND INDUSTRIAL PROPERTY </b></p>
                    <p><b>a)</b> Every document, report, data, know-how, method, operation, design, trademarks confidential information, patents and any other information provided by Customer to the Provider shall be and remain exclusive property of the Customer that have disclosed the information.</p>
                    <p><b>b)</b> After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. PROPIEDAD INTELECTUAL E INDUSTRIAL </b></p>
                    <p><b>a)</b> Cada documento, informe, datos, know-how, método, operación, diseño, marcas comerciales, información confidencial, patentes y cualquier otra información proporcionada por el Cliente al Proveedor será y seguirá siendo propiedad exclusiva del Cliente que haya divulgado la información.</p>
                    <p><b>b)</b> Después de la terminación o el vencimiento del presente, ninguna de las Partes utilizará marcas comerciales o nombres que puedan ser similares a los de la otra Parte y / o que puedan ser confundidos de alguna manera por clientes y compañías. Cada Parte se compromete a hacer todo lo posible para evitar errores o la divulgación indebida de las marcas y nombres de las otras Partes por personas no autorizadas.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. TERM AND TERMINATION</b></p>
                    <p> This Agreement shall be in force and remain valid from the date of signature for undetermined period. Each of the Parties is free to terminate this Agreement at any time without cause by previous written notice of 30 (thirty) days.</p>
                    <p> The Agreement may be terminated for justified cause regardless of any previous notice, in the occurrence of the following events by the Parties:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. PLAZO Y TERMINACIÓN</b></p>
                    <p> Este Contrato estará en vigor y seguirá siendo válido desde la fecha de su firma y por un período indeterminado. Cada una de las Partes es libre de rescindir este Acuerdo en cualquier momento sin causa mediante notificación previa por escrito de 30 (treinta) días.</p>
                    <p> El Contrato puede ser rescindido por causa justificada independientemente de cualquier aviso previo, en la ocurrencia de los siguientes eventos por las Partes:</p>
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
                    <p><b>a)</b> consecutives delays or failure to comply by Customer with the payments due to the Provider remuneration or repeated non-delivery or late delivery of the Services by the Provider; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> retrasos consecutivos o incumplimiento por parte del Cliente de los pagos debidos a la remuneración del Proveedor o la falta repetida o entrega tardía de los Servicios por parte del Proveedor; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> if any party breaches any term or condition of this Agreement and fails to remedy to such failure within five (5) days from the date of receipt of written notification from the other party, in this sense;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> si alguna de las partes incumple cualquier término o condición de este Acuerdo y no remedia dicho incumplimiento dentro de los cinco (5) días a partir de la fecha de recepción de la notificación por escrito de la otra parte, en este sentido;</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> If either party becomes or is declared insolvent or bankrupt, is the subject of any proceedings relating to its liquidation or insolvency or for the appointment of a receiver, conservator, or similar officer, or makes an assignment for the benefit of all or substantially all of its creditors or enters into any agreement for the composition, extension, or readjustment of all or substantially all of its obligations, then the other party may, by giving prior written notice thereof to the non-terminating party, terminate this Agreement as of a date specified in such notice;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> Si cualquiera de las partes se torna o se declara insolvente o en quiebra, es objeto de cualquier procedimiento relacionado con su liquidación o insolvencia o para el nombramiento de un síndico, curador o funcionario similar, o hace una cesión en beneficio de todos o sustancialmente todos sus acreedores o celebra cualquier acuerdo para el convenio, extensión, o reajuste de todas o sustancialmente todas sus obligaciones, entonces la otra parte podrá, mediante notificación previa por escrito de ello a la parte que no termina, rescindir este Acuerdo a partir de la fecha especificada en dicha notificación;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p> Upon termination of this Agreement or at its termination, Provider undertakes to: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> Tras la terminación de este Acuerdo o en su terminación, el Proveedor se compromete a: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> return to Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by Customer in relation to the Services agreed upon in this Agreement; as well as any compensation defined as cash advanced, among which is: deposit or guarantee, unsatisfied provisions, etc., deducted from the expenses actually incurred.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> devolver al Cliente el día de la terminación de este Acuerdo, todos y cada uno de los equipos, material promocional y otros documentos que hayan sido proporcionados por el Cliente en relación con los Servicios acordados en este Acuerdo; Así como cualquier compensación definida como cash advanced entre los que se encuentra: depósito o fianza, provisiones no satisfechas, etc., deducidas de los gastos realmente inccurridos.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>

        <table style='margin-top: 0px'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respect and comply with all Service requests forwarded by Customer before the date of expiration or early termination of this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respetar y cumplir con todas las solicitudes de Servicio enviadas por el Cliente antes de la fecha de vencimiento o terminación anticipada de este Acuerdo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IX. ACT OF GOD OR FORCE MAJEURE</b></p>
                    <p>In the event either Party is unable to perform its obligations under the terms of this Agreement because of acts of God or force majeure, such party shall not be liable for damages to the other for any damages resulting from such failure to perform or otherwise from such causes.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IX. CASO FORTUITO O FUERZA MAYOR</b></p>
                    <p>En el caso de que cualquiera de las Partes no pueda cumplir con sus obligaciones bajo los términos de este Acuerdo debido a actos de Dios o fuerza mayor, dicha parte no será responsable de los daños a la otra por cualquier daño resultante de dicho incumplimiento o de cualquier otra manera de tales causas.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <p><b>X. GENERAL PROVISIONS </b></p>
                    <p><b>(a)</b> Changes – Any changes or inclusions to this Agreement shall be made with the mutual consent of the Parties and in writing and consider any local mandatory local rule.</p>
                    <p><b>(b)</b> Independence – In case any provision in this Agreement shall be invalid, illegal or unenforceable, the validity, legality and enforceability of the remaining provisions shall not in any way be affected or impaired thereby and such provision shall be ineffective only to the extent of such invalidity, illegality or unenforceability.</p>
                    <p><b>(c)</b> Transfer –this Agreement may not be transferred or assigned in whole or in part by either Party without the prior written consent of the other Party.</p>
                    <p><b>(d)</b> Entire Agreement – This Agreement contains the entire agreement and understanding among the parties hereto with respect to the subject matter hereof, and supersedes all prior and contemporaneous agreements, understandings,</p>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p><b>X. DISPOSICIONES GENERALES </b></p>
                    <p><b>(a)</b> Cambios – Cualquier cambio o inclusión a este Acuerdo se hará con el consentimiento mutuo de las Partes y por escrito y considerará cualquier regla local local obligatoria.</p>
                    <p><b>(b)</b> Independencia – En caso de que cualquier disposición de este Acuerdo sea inválida, ilegal o inaplicable, la validez, legalidad y aplicabilidad de las disposiciones restantes no se verán afectadas o perjudicadas de ninguna manera por ello y dicha disposición será ineficaz solo en la medida de dicha invalidez, ilegalidad o inaplicabilidad.</p>
                    <p><b>(c)</b> Cesión: este Acuerdo no puede ser cedido o asignado en su totalidad o en parte por ninguna de las Partes sin el consentimiento previo por escrito de la otra Parte.</p>
                    <p><b>(d)</b> Acuerdo completo: este Acuerdo contiene el acuerdo completo y el entendimiento entre las partes con respecto al tema del presente, y reemplaza todos los acuerdos, entendimientos, incentivos y condiciones anteriores y</p>

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
                    <p> inducements and conditions, express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express terms hereof control and supersede any course of performance and/or usage of the trade inconsistent with any of the terms hereof.</p>
                    <p><b>(e)</b> Tolerance and Absence of Waiver and Novation. The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement.</p>
                    <p><b>(f)</b> Succession - This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives.</p>
                    <p><b>(g)</b> Communication between the Parties - All warnings, communications, notifications and mailing resulting from the performance of this Agreement shall be done in writing, with receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by registry at the Registry of Deeds and Documents, and will only be valid when directed and delivered to the Parties at the addresses indicated below in accordance with the applicable law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> contemporáneos, expresos o implícitos, orales o escritos, de cualquier naturaleza con respecto al objeto del presente. Los términos expresos del presente controlan y reemplazan cualquier curso de rendimiento y / o uso del comercio inconsistente con cualquiera de los términos del presente documento.</p>
                    <p><b>(e)</b> Tolerancia y ausencia de renuncia y novación. La tolerancia de cualquier incumplimiento, incluso si se repite, por cualquiera de las disposiciones de este Acuerdo no constituye o no se interpretará como una renuncia por la otra Parte o como novación. Si algún tribunal o corte determina que cualquier disposición o artículo de este Acuerdo es nulo, sin efecto o sin ningún efecto vinculante, el resto de este Contrato permanecerá en pleno vigor y efecto como si dicha disposición o parte no hubiera integrado este Acuerdo.</p>
                    <p><b>(f)</b> Sucesión - Este Acuerdo vincula a las Partes y sus respectivos sucesores, particulares y universales, cesionarios autorizados y representantes legales.</p>
                    <p><b>(g)</b> Comunicación entre las Partes - Todas las advertencias, comunicaciones, notificaciones y envíos por correo resultantes de la ejecución de este Acuerdo se harán por escrito, con confirmación de recibo, por correo con notificación de recibo, por correo electrónico con notificación de recibo o por registro en el Registro de Escrituras y Documentos, y sólo será válido cuando se dirija y entregue a las Partes en las direcciones que se indican a continuación de conformidad con la ley aplicable.</p>
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
                    <b style="text-decoration: underline;">If to Provider:</b>
                    <p>A/C: <b>Fernando Gutierrez</b></p>
                    <p><b>Address:</b> Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, Postal Code 11590, CDMX, México</p>
                    <p><b>Phone:</b> +55 21 98217 3082</p>
                    <p><b>E-mail:</b> <a href="#">sac@intermediano.com</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">Si al Proveedor:</b>
                    <p>A/C: <b>Fernando Gutierrez</b></p>
                    <p><b>Dirección:</b> Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, Postal Code 11590, CDMX, México</p>
                    <p><b>Teléfono:</b> +55 21 98217 3082</p>
                    <p><b>E-mail:</b> <a href="#">sac@intermediano.com</a> </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>If to Customer:</b>
                    <p>A/C: <b>{{ $contactName }} {{ $contactSurname }}</b></p>
                    <p><b>Address:</b> {{ $customerAddress }} </p>
                    <p><b>Phone/Fax:</b> {{ $customerPhone }}</p>
                    <p><b>E-mail:</b> <a href="#">{{ $customerEmail }}</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Si al Cliente:</b>
                    <p>A/C: <b>{{ $contactName }} {{ $contactSurname }}</b></p>
                    <p><b>Dirección:</b> {{ $customerAddress }} </p>
                    <p><b>Teléfono:</b> {{ $customerPhone }}</p>
                    <p><b>E-mail:</b> <a href="#">{{ $customerEmail }}</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>XI. JURISDICTION </b></p>
                    <p>The parties elect the courts of <b>[CITY/COUNTRY]</b> to settle any doubts and/or disputes arising out of this instrument, with the exclusion of any other jurisdiction, as privileged as it may be and the applicable law shall be of the <b>[COUNTRY]</b>.</p>
                    <p>The full text of this contract, as well as the documents derived from it, including the Annexes, have been drawn up in the English and Spanish languages, both versions being considered official, although the Spanish language version is considered as the priority for its interpretation.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>XI. JURISDICIÓN</b></p>
                    <p>Las partes eligen a los tribunales de la Ciudad de México, México, para resolver cualquier duda y / o disputa que surja de este instrumento, con la exclusión de cualquier otra jurisdicción, por privilegiada que sea y la ley aplicable será la de México. </p>
                    <p>El texto íntegro de este contrato, así como los documentos que se deriven del mismo, incluidos los Anexos, han sido redactados en los idiomas inglés y español, considerándose ambas versiones como oficiales, si bien se fija como prioritaria para su interpretación la versión en idioma español.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and content, for one sole purpose.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>En fe de lo cual, las Partes firman el presente Acuerdo en dos (2) copias de igual forma y contenido, con un único propósito.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>



    @include('pdf.contract.layout.header')
    <main>
        <div>
            <p style='text-align: center'>{{ $contractCreatedDay }} of {{ $contractCreatedmonth }} of {{ $contractCreatedyear }}.</p>

        </div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="margin-top: 20px;">
                        <p style='text-align: center'><b>INTERMEDIANO, S.A. DE C.V. </b></p>
                    </div>
                    <div style="text-align: center; position: relative; height: 120px;">


                        @if($adminSignatureExists)
                        <img src="{{ 
                            $is_pdf 
                                ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                : url('/signatures/' . $type. '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />
                        @endif
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        @if (!empty($adminSignedBy))
                        <p style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">{{ $adminSignedBy }}</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $adminSignedByPosition }}</p>
                        @endif

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="margin-top: 20px;">
                        <p style='text-align: center'><b>{{ $companyName }}</b></p>
                    </div>
                    <div style="text-align: center; position: relative; height: 120px;">

                        @if($signatureExists)
                        <img src="{{ 
                            $is_pdf
                                ? Storage::disk('private')->path($record->signature)
                                : url('/signatures/customer/' . $record->company_id . '/customer') . '?v=' . filemtime(storage_path('app/private/signatures/clients/customer_' . $record->company_id . '.webp')) 
                        }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);"/>

                        @endif
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style='position: absolute; bottom: 14x; left: 50%; transform: translateX(-50%);'>{{ $signedDate }}</p>
                        <p style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">{{ $customerName }} {{ $contactSurname }}</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);">{{ $customerPosition }}</p>


                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>SCHEDULE A</b></p>
                    <p style="text-align: center; font-weight: bold">Scope of Services</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>ANEXO A</b></p>
                    <p style="text-align: center; font-weight: bold">Alcance de los Servicios</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>1. Services of outsourcing, Payroll, consulting and HR for employees in {{$customerCountry}}.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>1. Servicios de outsourcing, nómina, consultoría y RRHH para empleados en {{$customerCountry}}.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>2. Payments to employees made through wire transfer, in local currency.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>2. Pagos a empleados hechos localmente a través de transferencias, en moneda local.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>3. Collection of taxes evidences as per local rules</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>3. Recolección de los comprobantes de pagos de impuestos según las normas locales.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center; font-weight: bold;">SCHEDULE B</p>
                    <p style="text-align: left; font-weight: bold">A) EMPLOYEE WORKING DETAIL:</p>
                    <p>Name of Employee: {{ $employeeName }}</p>
                    <p>Date of Birth: {{ $employeeDateBirth }}</p>
                    <p>Address: {{ $employeeAddress }}</p>
                    <p>Mobile: {{ $employeeMobile }}</p>
                    <p>E-mail: {{ $employeeEmail }}</p>
                    <p>Marital Status: {{ $employeeCivilStatus }}</p>
                    <p>Country of Work: {{ $employeeCountryWork }}</p>
                    <p>Job Title: {{ $employeeJobTitle }}</p>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p style="text-align: center; font-weight: bold;">ANEXO B</p>
                    <p style="text-align: left; font-weight: bold">A) DETALLE DE TRABAJO DEL EMPLEADO:</p>
                    <p>Nombre del Empleado: {{ $employeeName }}</p>
                    <p>Fecha de Nacimiento: {{ $employeeDateBirth }}</p>
                    <p>Dirección: {{ $employeeAddress }}</p>
                    <p>Teléfono Móvil: {{ $employeeMobile }}</p>
                    <p>Correo Electrónico: {{ $employeeEmail }}</p>
                    <p>Estado Civil: {{ $employeeCivilStatus }}</p>
                    <p>País de Trabajo: {{ $employeeCountryWork }}</p>
                    <p>Cargo: {{ $employeeJobTitle }}</p>

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
                    <p>Job Description: *Please find it at the end of the contract.</p>
                    <p>Start Date: {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>Contract Type: {{ $record->end_date ? 'Defined Contract Period': 'Undefined Contract Period' }}</p>
                    <p>Remuneration Value: {{ number_format($record->gross_salary, 2) }} Gross/Monthly </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Descripción del Trabajo: Ver al final del contrato.</p>
                    <p>Fecha de Inicio: {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>Tipo de Contrato: {{ $record->end_date ? 'Defined Contract Period': 'Undefined Contract Period' }}</p>
                    <p>Valor de la Remuneración: {{ number_format($record->gross_salary, 2) }} Gross/Monthly </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DATE OF PAYMENT (every month):</b> Last day of the working month.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FECHA DE PAGO (mensual):</b> Último día del mes trabajado.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>LOCAL PAYMENT CONDITIONS: </b></p>
                    <p>Salaries and/or any other remuneration is set in [{{ $currencyName }}/Amount/Terms].</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONDICIONES DE PAGO LOCALES:</b> </p>
                    <p>El salario y/o cualquier otra remuneración se realizan en [{{ $currencyName }}/Monto/Términos].</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>B) FEES AND PAYMENT TERMS:</b></p>
                    <p><b>PAYMENT TERMS</b></p>
                    <p><b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below: The Customer pays the Provider a monthly fee based on the calculations below: </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>B) TARIFAS Y CONDICIONES DE PAGO:</b></p>
                    <p><b>CONDICIONES DE PAGO</b></p>
                    <p><b>TARIFAS:</b> El Cliente deberá pagar al Proveedor mensualmente, según el cálculo a continuación: El Cliente paga al Proveedor una tarifa mensual en base a los cálculos a continuación: </p>
                </td>
            </tr>


        </table>
        <div style="margin-top: 50px !important">
            @include('pdf.mexico_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main style="page-break-after: avoid">

        <table style='margin-top: -5px'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>INVOICE:</b> Provider will issue a monthly invoice to the Customer every 1st day of the month and Customer shall pay to Provider until the 20th. day of the same month the invoice was issued. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FACTURA:</b> El Proveedor emitirá una factura mensual al Cliente el 1er día del mes y el Cliente pagará al Proveedor hasta el día 20. día del mismo mes en que se emitió la factura. </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DUEDATE:</b> Every month the payments shall be credited on Provider´s bank account up to the 20th of the same month the respective invoice was issued. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FECHA DE VENCIMIENTO:</b> Cada mes los pagos se acreditarán en la cuenta bancaria del Proveedor hasta el día 20 del mismo mes en que se emitió la factura respectiva. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PENALTY:</b> Payments credited after the 20th. due date mentioned above, shall have an interest of 3%.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PENALIZACIÓN:</b> Pagos acreditados después del día 20, la fecha de vencimiento mencionada anteriormente tendrá un interés del 3%.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>EXCHANGE RATE:</b> Invoices will be issued in USD based on the exchange rate of the date of the issuance of the invoice. This rate will change monthly according to the currency fluctuation.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>TASA DE CAMBIO:</b> Las facturas se emitirán en USD en base al tipo de cambio de la fecha de emisión de la factura. La tasa variará mensualmente según la fluctuación cambiaria.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: left; white-space: nowrap; margin-bottom: -15px'><b>GUARANTEE (1 MONTH SALARY/REMUNERATION):</b></p>
                    <p>Customer shall anticipate the monthly cost per each employee. This amount will be kept by Provider until the end of the Agreement and will be compensated on the last working month of the respective employee.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: left;  white-space: nowrap; margin-bottom: -15px;'><b>GARANTÍA (1 MES DE SALÁRIO/REMUNERACIÓN):</b> </p>
                    <p>El cliente deberá anticipar el costo mensual por cada empleado. Esta cantidad será retenida por el Proveedor hasta el final del Acuerdo y será compensada en el último mes hábil del empleado respectivo.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>B) LOCAL LEGISLATION - PREVAILS </b> </p>
                    <p>The law that will govern the entire Agreement and the relations related to Employee´s obligations and rights will be the law of Mexico, where the services are being provided, including but not limited to, labor and tax, and must be fully complied with the purposes of the local and global compliance guidelines.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>C) LEGISLACIÓN LOCAL - PREVALECE </b></p>
                    <p>La ley que regirá todo el Acuerdo y las relaciones relacionadas con las obligaciones y derechos del Empleado será la ley de México, donde se prestan los servicios, incluidos, entre otros, el trabajo y los impuestos, y debe cumplirse plenamente con los propósitos de las pautas de cumplimiento locales y globales .</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
