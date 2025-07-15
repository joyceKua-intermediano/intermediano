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
$contractCreatedDate = (new DateTime($record->created_at))->format('[d/m/Y]');
$partnerName = $record->partner->partner_name;
$partnerContactName = $record->partner->contact_name;
$partnerAddress = $record->partner->address;

$partnerPhone = $record->partner->mobile_number;
$partnerEmail = $record->partner->email;
$partnerCountry = $record->partner->country->name;
$partnerTaxId = $record->partner->tax_id ?? 'NA';
$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->country ?? 'N/A';
$employeeState = $record->personalInformation->state ?? 'N/A';
$employeeCivilStatus = $record->personalInformation->civil_status ?? 'N/A';
$employeeJobTitle = $record->job_title ?? 'N/A';
$employeeCountryWork = $record->country_work ?? 'N/A';
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? 'N/A';
$employeeEmail = $record->employee->email ?? 'N/A';
$employeeAddress = $record->personalInformation->address ?? 'N/A';
$employeeCity = $record->personalInformation->city ?? 'N/A';
$employeeDateBirth = $record->personalInformation->date_of_birth ?? 'N/A';
$employeePhone = $record->personalInformation->phone ?? 'N/A';
$employeeMobile = $record->personalInformation->mobile ?? 'N/A';
$employeeCountry = $record->personalInformation->country ?? 'N/A';
$employeeEducation = $record->personalInformation->education_attainment ?? 'N/A';
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;
$contractType = $record->end_date == null ? 'Undefined Period' : 'Defined Period';
$exchangeRate = $record->quotation->exchange_rate;
$currencyName = $record->quotation->currency_name;
$signatureExists = Storage::disk('public')->exists($record->signature);
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name ?? '';
$adminSignedByPosition = $adminSignedBy === 'Fernando Guiterrez' ? 'CEO' : ($adminSignedBy === 'Paola Mac Eachen' ? 'VP' : 'Legal Representative');
$user = auth()->user();
$isAdmin = $user instanceof \App\Models\User;
$type = $isAdmin ? 'admin' : 'employee';
@endphp
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: 0px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">PARTNERSHIP AGREEMENT</h4>
                    <p>This Payroll and HR Service Agreement (the “Agreement”) is made on {{ $contractCreatedDay }} of {{ $contractCreatedmonth }}, {{ $contractCreatedyear }} (the <b>“Effective Date”</b>), by and between <b>{{ $partnerName }}</b> (the <b>“Provider”</b>), a {{ $partnerCountry }} company, enrolled under the fiscal registration number {{ $partnerTaxId }}, located at {{ $partnerAddress }}, {{ $partnerCountry }}, duly represented by its legal representative; AND <b>GATE INTERMEDIANO INC.</b> (the <b>“Customer”</b>), a Canadian company, enrolled under the fiscal registration number 733087506RC0001, located at 4388 Rue SaintDenis Suite200 #763, Montreal, QC H2J 2L1, Canada, duly represented by its authorized representative, (each, a “Party” and together, the “Parties”). </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE PARTNER</h4>
                    <p>El presente Contrato de servicios de nómina y recursos humanos (el <b>"Contrato"</b>) se celebra a partir del {{ $contractCreatedDay }}, {{ $contractCreatedmonth }}, {{ $contractCreatedyear }} (la <b>"Fecha de entrada en vigor"</b>), entre <b>{{ $partnerName }}</b> (el <b>"Proveedor"</b>), una empresa {{ $partnerCountry }}, registrada con el número de registro corporativo {{ $partnerTaxId }}, ubicada en {{ $partnerAddress }}, {{ $partnerCountry }}, debidamente representada por su representante legal; Y <b>GATE INTERMEDIANO INC.</b> (el <b>"Cliente"</b>), una empresa canadiense, inscrita bajo el número de registro fiscal 733087506RC0001, con domicilio en 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada, debidamente representada por su representante autorizado, (cada uno, una
                        "Parte" y juntos, las "Partes").
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services globally either directly or indirectly through its local partners; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que el Proveedor presta determinados servicios de nóminas, impuestos y recursos humanos a nivel mundial, directa o indirectamente a través de sus socios locales; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Customer also provides certain payroll, tax, and human resource services globally for its clients (“Customer’s Clients”); and </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que el Cliente también
                        presta determinados servicios de nóminas, fiscales y de recursos humanos en todo el mundo a sus clientes ("Clientes del Cliente"); y
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> the Parties wish to enter into this Partnership Agreement to enable Provider to provide its services to Customer for the benefit of Customer’s Clients on the terms and conditions set forth herein. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO</b> que las Partes desean suscribir el presente Acuerdo de Asociación para permitir al Proveedor prestar sus servicios al Cliente en beneficio de los Clientes del Cliente en los términos y condiciones establecidos en el presente documento. </p>
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
                    <p><b>NOW, THEREFORE,</b> in consideration of the premises and the mutual covenants set forth herein, the Parties hereby agree as follows: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>AHORA, POR CONSIGUIENTE,</b> en consideración de los supuestos y acuerdos mutuos aquí expuestos, las Partes acuerdan lo siguiente: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">I. PURPOSE</b>
                    <p><b>Service Offerings.</b> Provider shall provide to Customer the services of staffing, outsourcing payroll, consulting, and HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein (collectively, the “Services”), during the Term (defined in Section VI) subject to the terms and conditions of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">I.- OBJETO</b>
                    <p><b>Oferta de Servicios.</b> El Proveedor prestará al Cliente los servicios de dotación de personal, externalización de nóminas, consultoría y RRHH que se adjuntan como Anexo A (el "Anexo A") y que se incorporan al presente (colectivamente, los "Servicios"), durante la Vigencia (definida en la Sección VI) con sujeción a los términos y condiciones del presente Contrato. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">II. – PROVIDER RESPONSIBILITIES</b>
                    <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby undertakes to: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">II. – RESPONSABILIDADES DEL PROVEEDOR</b>
                    <p>Sin perjuicio de sus demás obligaciones en virtud del presente Contrato, el Proveedor se compromete a:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> to meet the requirements and quality standards required by Customer, which may periodically review the Services performed by the Provider; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> cumplir los requisitos y estándares de calidad exigidos por el Cliente, quien podrá revisar periódicamente los Servicios prestados por el Proveedor; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> to collect all taxes related to its activities, considering local applicable law where the services are being rendered; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> percibir todos los impuestos relacionados con sus actividades, teniendo en cuenta la legislación local aplicable en el lugar donde se prestan los servicios; </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> to provide, whenever customer requests it, all reports, spreadsheets, and other information relating to the Services and the country’s requirements; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> proporcionar, siempre que lo solicite el cliente, todos los informes, hojas de cálculo y demás información relacionada con los Servicios y los requisitos del país; </p>
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
                    <p><b>(d)</b> to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters, in particular, but not limited to, those related to the protection of the environment, exempting Customer and Customer’s Client from any responsibility resulting therefrom. Therefore, the Provider declares in this Agreement that its activities and Services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment; and </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> cumplir con todas las leyes globales y locales, decretos, reglamentos, resoluciones, decisiones, normas y otras disposiciones consideradas por la ley relativas a la prestación del servicio y cuestiones laborales, en particular, pero no exclusivamente, las relativas a la protección del medio ambiente, eximiendo al Cliente y al Cliente del Cliente de cualquier responsabilidad derivada de las mismas. Por lo tanto, el Proveedor declara en el presente Contrato que sus actividades y Servicios, utilizados ahora y en el futuro, cumplen con la legislación y las normas de protección y seguridad relativas al saneamiento y al medio ambiente; y </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e)</b> to have and maintain any needed licenses, registrations, or the like to provide the Services outlined herein.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e)</b> tener y mantener todas las licencias, registros o similares necesarios para prestar los Servicios descritos en este documento. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">III – CUSTOMER RESPONSABILITIES:</b>
                    <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby undertakes to:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">III – RESPONSABILIDADES DO CLIENTE:</b>
                    <p>Sin perjuicio de las demás obligaciones derivadas del presente Contrato, el Cliente se compromete a:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> to process the monthly payment to the Provider set forth in Schedule B (the “Schedule B”);</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> tramitar el pago mensual al Proveedor establecido en el Anexo B (el "Anexo B");</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> to abide by and require Customer’s Clients to abide by Provider’s instructions concerning the local labor legislation, considering where the service is being provided; and</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> cumplir y exigir a los Clientes del Cliente que cumplan las instrucciones del Proveedor relativas a la legislación laboral local, teniendo en cuenta dónde se presta el servicio; y</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> to supply the technical information required for the Services to be performed.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> facilitar la información técnica necesaria para la prestación de los Servicios.</p>
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
                    <b style="text-decoration: underline;">IV – PAYMENT AND FEES:</b>
                    <p><b>(a)</b> For the Services agreed herein, Customer shall pay to the Provider the amount the Parties agreed upon in writing in the format outlined in Schedule B or substantially similar thereto for each Worker or Service.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IV – PAGAMENTO E TAXAS:</b>
                    <p><b>(a)</b> Por los Servicios aquí acordados, el Cliente pagará al Proveedor la cantidad acordada por las Partes por escrito en el formato descrito en el Anexo B o sustancialmente similar por cada Trabajador o Servicio. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b) INVOICE:</b> Provider will issue a monthly invoice to the Customer up to the 10th day of the month and Customer shall pay to Provider within 10 (ten) days of receipt of the invoice of the same month the invoice was issued. The invoice will include the Worker’s gross renumeration (e.g., salary, bonuses, commissions, allowances, etc.), any mandatory employer costs (e.g., social security contributions, other taxes etc.), and Provider’s fee.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b) FACTURA:</b> El Proveedor emitirá una factura mensual al Cliente antes del día 10 del mes y el Cliente deberá pagar al Proveedor en un plazo de 10 (diez) días a partir de la recepción de la factura correspondiente al mismo mes en el que se emitió la factura. La factura incluirá la remuneración bruta del Trabajador (por ejemplo, salario, primas, comisiones, asignaciones, etc.), cualquier coste obligatorio del empleador (por ejemplo, cotizaciones a la seguridad social, otros impuestos, etc.) y los honorarios del Proveedor.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) DUE DATE:</b> Customer shall pay Provider within 10 (ten) days of receipt of the invoice by Provider. Undisputed invoices that remain unpaid past the due date will be subject to a penalty fee equal to 3%.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) FECHA DE VENCIMIENTO:</b> El Cliente deberá pagar al Proveedor en un plazo de 10 (diez) días a partir de la recepción de la factura por parte del Proveedor. Las facturas no comprobadas que permanezcan impagadas después de la fecha de vencimiento estarán sujetas a una multa del 3%.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) EXCHANGE RATE:</b> Invoices will be issued in USD based on the exchange rate of the date of the issuance of the invoice, considering the 3.5% margin of risk in favor of Provider. For clarity, this means that all exchange rates used to convert to USD will be increased by 3.5%.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) TIPO DE CAMBIO:</b> Las facturas se emitirán en USD sobre la base del tipo de cambio en la fecha de emisión de la factura, teniendo en cuenta el margen de riesgo del 3,5% a favor del Proveedor. Para mayor claridad, esto significa que todos los tipos de cambio utilizados para convertir a USD se incrementarán en un 3,5%.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">V. - CONFIDENTIALITY</b>
                    <p><b>(a)</b> Both Customer and Provider acknowledge that by reason of its relationship to the other party under this Agreement, it will have access to and acquire knowledge, material, data, systems and other information concerning the operation, business, financial affairs and intellectual property of the other Party or Customer’s Client, that may not be accessible or known to the general public, including but not limited to the terms of this Agreement (referred to as "Confidential Information").</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">V. - CONFIDENCIALIDAD</b>
                    <p><b>(a)</b> Tanto el Cliente como el Proveedor reconocen que, debido a su relación con la otra parte en virtud del presente Contrato, tendrán acceso y adquirirán conocimientos, material, datos, sistemas y otra información relativa al funcionamiento, la actividad empresarial, los asuntos financieros y la propiedad intelectual de la otra parte o del Cliente del Cliente, que pueden no ser accesibles o conocidos por el público en general, incluidos, entre otros, los términos del presente Contrato (denominada "Información confidencial").</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> NonDisclosure/Use. Each of Customer and Provider agrees that it will: (i) maintain and preserve the confidentiality of all Confidential Information received from the other party (the "Disclosing Party''), both orally and in writing, including taking such steps to protect the confidentiality of the Disclosing Party's Confidential Information as the party receiving such Confidential Information (the "Receiving Party") takes to protect the confidentiality of its own confidential or proprietary information; provided, however, that in no instance shall the Receiving Party use less than a reasonable standard of care to protect the Disclosing Party's Confidential Information; (ii) disclose such Confidential Information only to its own employees on a "need to know" basis, and only to those employees who have agreed to maintain the confidentiality thereof pursuant to a written agreement containing terms at least as stringent as those set forth in this Agreement; (iii) not disassemble, "reverse engineer" or "reverse compile" such software for any purpose in the event that software is involved;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>No divulgación/uso. El Cliente y el Proveedor acuerdan que: (i) mantendrán y preservarán la confidencialidad de toda la Información Confidencial recibida de la otra parte (la "Parte Reveladora"), tanto oralmente como por escrito, incluyendo la adopción de las medidas que sean necesarias para proteger la confidencialidad de la Información Confidencial de la Parte Reveladora tal y como la parte que recibe dicha Información Confidencial (la "Parte Receptora") trata de proteger la confidencialidad de su propia información confidencial o propietaria; No obstante, en ningún caso la Parte Receptora empleará un nivel de diligencia inferior al razonable para proteger la Información Confidencial de la Parte Divulgadora; (ii) revelar dicha Información Confidencial únicamente a sus propios empleados en función de la "necesidad de conocerla", y sólo a aquellos empleados que hayan aceptado mantener la confidencialidad en virtud de un acuerdo escrito que contenga términos al menos tan estrictos como los establecidos en el presente Acuerdo; </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p> and (iv) not disclose such Confidential Information to any third party without the prior written consent of the Disclosing Party; provided, however, that each party may disclose the financial terms of this Agreement to its legal and business advisors and to potential investors so long as such third parties agree to maintain the confidentiality of such Confidential Information. Each Receiving Party further agrees to use the Confidential Information of the Disclosing Party only for the purpose of performing its obligations under this Agreement. The Receiving Party's obligation of confidentiality shall survive this Agreement for a period of five (5) years from the date of its termination or expiration and thereafter shall terminate and be of no further force or effect; provided, however, that with respect to Confidential Information which constitutes a trade secret, such information shall remain confidential so long as such information continues to remain a trade secret. The parties also mutually agree to (1) not alter or remove any identification or notice of any copyright, trademark, or other proprietary rights which indicates the ownership of any part of the Disclosing Party's Confidential Information; and (2) notify the Disclosing Party of the circumstances surrounding any possession or use of the Confidential Information by any person or entity other than those authorized under this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(iv) no revelar dicha Información Confidencial a terceros sin el consentimiento previo por escrito de la Parte Reveladora; no obstante, cada una de las partes podrá revelar las condiciones financieras del presente Acuerdo a sus asesores jurídicos y comerciales y a la otra parte a inversores potenciales, siempre que dichos terceros acepten mantener la confidencialidad de dicha Información Confidencial. Asimismo, cada Parte Receptora se compromete a utilizar la Información Confidencial de la Parte Divulgadora únicamente con el fin de cumplir sus obligaciones en virtud del presente Acuerdo. La obligación de confidencialidad de la Parte Receptora subsistirá en virtud del presente Acuerdo durante un periodo de cinco (5) años a partir de la fecha de su rescisión o expiración y, a partir de entonces, quedará sin efecto; no obstante, en lo que respecta a la Información Confidencial que constituya un secreto comercial, dicha información seguirá siendo confidencial mientras siga siéndolo. Las partes también acuerdan mutuamente (1) no alterar ni eliminar ninguna identificación o aviso de derechos de autor, marca comercial u otros derechos de propiedad que indiquen la titularidad de cualquier parte de la Información Confidencial de la Parte Divulgadora; y (2) notificar a la Parte Divulgadora las circunstancias que rodean cualquier posesión o uso de la Información Confidencial por cualquier persona o entidad distinta de las autorizadas en virtud del presente Acuerdo. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) Exclusions.</b> Each of Customer’s and Provider’s obligations in the preceding paragraph above shall not apply to Confidential Information which the Receiving Party can prove: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) Exclusiones.</b> Las obligaciones del Cliente y del Proveedor establecidas en el párrafo anterior no se aplicarán a la Información Confidencial que la Parte Receptora pueda demostrar que:</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i)</b> has become a matter of public knowledge through no fault, action or omission of or by the Receiving Party; (ii) was rightfully in the Receiving Party's possession prior to disclosure by the Disclosing Party; (iii) subsequent to disclosure by the Disclosing Party, was rightfully obtained by the Receiving Party from a third party who was lawfully in possession of such Confidential Information without restriction; (iv) was independently developed by the Receiving Party without resort to the Disclosing Party's Confidential Information; or (v) must be disclosed by the Receiving Party pursuant to law, judicial order or any applicable regulation (including any applicable stock exchange rules and regulations); provided, however, that in the case of disclosures made in accordance with the foregoing clause (vi), the Receiving Party must provide prior written notice to the Disclosing Party of any such legally required disclosure of the Disclosing Party's Confidential Information as soon as practicable in order to afford the Disclosing Party an opportunity to seek a protective order, or, in the event that such order cannot be obtained, disclosure may be made in a manner intended to minimize or eliminate any potential liability.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'><b>(i)</b> ha pasado a ser de dominio público sin culpa, acción u omisión por parte de la Parte Receptora; (ii) estaba legítimamente en posesión de la Parte Receptora antes de su divulgación por parte de la Parte Divulgadora; (iii) tras su divulgación por parte de la Parte Divulgadora, fue legítimamente obtenida por la Parte Receptora de un tercero que estaba legítimamente en posesión de dicha Información Confidencial sin restricciones; (iv) fue desarrollada de forma independiente por la Parte Receptora sin que la Parte Divulgadora tuviera conocimiento de dicha Información Confidencial; (v) no fue divulgada por la Parte Divulgadora recurrir a la Información Confidencial de la Parte Divulgadora; o (vi) deba ser divulgada por la Parte Receptora en virtud de la ley, una orden judicial o cualquier normativa aplicable (incluidas las normas y reglamentos bursátiles aplicables); No obstante, en el caso de las divulgaciones realizadas en virtud de la cláusula (v) anterior, la Parte Receptora notificará previamente por escrito a la Parte Divulgadora cualquier divulgación de la Información Confidencial de la Parte Divulgadora exigida legalmente tan pronto como sea posible, con el fin de dar a la Parte Divulgadora la oportunidad de solicitar una orden de protección o, en caso de que no pueda obtenerse dicha orden, la divulgación podrá realizarse de forma que se minimice o elimine cualquier responsabilidad potencial.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(d)</b> Provider agrees that it will require every Worker to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(d)</b> El Proveedor acuerda que exigirá a cada Trabajador que acepte términos de confidencialidad sustancialmente similares a los aquí descritos para proteger la Información Confidencial del Cliente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e)</b> Should Provider engage vendors, it will require every such vendor to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e)</b> Si el Proveedor contrata proveedores, exigirá a cada uno de ellos que acepte unas condiciones de confidencialidad sustancialmente similares a las descritas en este documento para proteger al Cliente y la Información confidencial del Cliente. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VI. - GDPR DATA PROTECTION</b>
                    <p>Any information containing personal data shall be handled by both Parties in accordance with all applicable privacy laws and regulations, including without limitation the GDPR and equivalent laws and regulations. If for the performance of the Services it is necessary to exchange personal data, the relevant Parties shall determine their respective positions towards each other (either as controller, joint controllers or processor) and the subsequent consequences and responsibilities according to the GDPR as soon as possible. For the avoidance of doubt, each Party’s position may change depending upon the circumstances of each situation.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VI. - PROTECCIÓN DE DATOS GDPR</b>
                    <p>Cualquier información que contenga datos personales será tratada por ambas Partes de conformidad con todas las leyes y reglamentos aplicables en materia de privacidad, incluyendo, sin limitación, el GDPR y las leyes y reglamentos equivalentes. Si para la prestación de los Servicios es necesario intercambiar datos personales, las Partes pertinentes determinarán sus respectivas posiciones en relación con la otra (como controlador, controlador conjunto o procesador) y las consiguientes consecuencias y responsabilidades. de conformidad con el GDPR tan pronto como sea posible. Para evitar dudas, la posición de cada Parte podrá cambiar en función de las circunstancias de cada situación. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VII. INTELLECTUAL AND INDUSTRIAL PROPERTY </b>
                    <p><b>(a)</b> Every document, report, data, know how, method, operation, design, trademarks confidential information, patents and any other information provided by Customer to the Provider shall be and remain exclusive property of the Customer that disclosed the information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VII - PROPIEDAD INTELECTUAL E INDUSTRIAL</b>
                    <p><b>(a)</b> Cualquier documento, informe, dato, know-how, método, operación, diseño, información confidencial de marcas, patentes y cualquier otra información proporcionada por el Cliente al Proveedor será y seguirá siendo propiedad exclusiva del Cliente que divulgó la información. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> Tras la rescisión o expiración del presente instrumento, ninguna de las Partes utilizará marcas o nombres que puedan ser similares a los de la otra Parte y/o que puedan ser confundidos de alguna manera por clientes y empresas. Cada Parte se compromete a hacer todo lo posible para evitar errores o la divulgación indebida de las marcas y nombres de la otra Parte por parte de personas no autorizadas. </p>
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
                    <p><b>(c)</b> Provider agrees that everything provided to it or Workers by Client’s Customer remains the property of Client’s Customer, and that no right, title, or interest is transferred to Provider or Workers including recovery of said property; this includes company laptops, phones, credit cards, etc. Provider further agrees that all right title and interest in the work product (including but not limited to intellectual property, software, works of authorship, trade secrets, designs, data or other proprietary information) produced by Provider or Workers under this Agreement are the sole property of Customer’s Client. Provider further agrees to assign, or cause to be assigned from time to time, to Client’s Customer on an exclusive basis all rights, title and interest in and to the work product produced by Provider or Workers under this Agreement, including any copyrights, patents, mask work rights or other intellectual property rights relating thereto, in perpetuity or for the longest period otherwise permitted under applicable law. Provider agrees that it shall not use the work product for the benefit of any party other than Customer’s Client. Nothing in this Subsection shall apply to any copyrightable material, notes, records, drawings, designs, Innovations, improvements, developments, discoveries and trade secrets conceived, made or discovered by Provider prior to the Effective Date of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) </b> El Proveedor acepta que cualquier cosa que el Cliente del Cliente le proporcione a él o a los Trabajadores seguirá siendo propiedad del Cliente del Cliente y que no se transfiere ningún derecho, título o interés al Proveedor o a los Trabajadores, incluida la recuperación de dicha propiedad; esto incluye ordenadores portátiles de la empresa, teléfonos, tarjetas de crédito, etc. El Proveedor también acepta que todos los derechos de propiedad e intereses sobre el producto del trabajo (incluidos, entre otros, la propiedad intelectual, el software, las obras de autoría, los secretos comerciales, los diseños, los datos u otra información de propiedad) producidos por el Proveedor o los Trabajadores en virtud del presente Contrato son propiedad exclusiva del Cliente del Cliente. Asimismo, el Proveedor acepta ceder, o hacer que se cedan de vez en cuando, al Cliente del Cliente de forma exclusiva todos los derechos, títulos e intereses sobre el producto del trabajo producido por el Proveedor o los Trabajadores en virtud del presente Contrato, incluidos los derechos de autor, patentes, derechos de trabajo de máscaras u otros derechos de propiedad intelectual relacionados con el mismo, a perpetuidad o durante el periodo más largo permitido por la legislación aplicable. El Proveedor acuerda que no utilizará el Producto del Trabajo en beneficio de ninguna otra parte que no sea el Cliente del Cliente. Nada de lo dispuesto en esta Subsección se aplicará a cualquier material protegido por derechos de autor, notas, registros, dibujos, diseños, innovaciones, mejoras, desarrollos, descubrimientos y secretos comerciales concebidos, realizados o descubiertos por el Proveedor antes de la Fecha de Entrada en Vigor del presente Contrato. </p>
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
                    <p><b>(d)</b> Provider shall require each Worker assigned to Customer’s Client to agree that, to the maximum extent permitted by law, all inventions, developments or improvements conceived or created by such Worker while engaged in rendering services under this Agreement, that relate to work or projects for Customer’s Client, shall be the exclusive property of Customer’s Client, and to assign and transfer to Customer’s Client (or to Provider for further assignment to Customer and ultimately to Customer’s Client) all of Worker’s right, title and interest in and to such inventions, developments or improvements and to any Letter Patents, Copyrights and applications pertaining thereto. Provider agrees that any intellectual property created during a Worker’s engagement with Customer’s Client remains the property of Customer’s Client as outlined herein, even if local law deems such work the property of the employer. At Customer’s request and direction, Provider agrees to take whatever steps necessary including those outlined herein, as applicable, to effectuate Customer’s Client’s rights in the intellectual property produced during a Worker’s engagement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> El Proveedor exigirá a cada Trabajador asignado al Cliente del Cliente que acepte que, en la máxima medida permitida por la ley, todas las invenciones, desarrollos o mejoras concebidos o creados por dicho Trabajador durante la prestación de servicios en virtud del presente Contrato, que estén relacionados con trabajos o proyectos para el Cliente del Cliente, serán propiedad exclusiva del Cliente del Cliente, y cederá y transferirá al Cliente del Cliente (o al Proveedor para su posterior cesión al Cliente y, en última instancia, al Cliente del Cliente) todos los derechos, títulos e intereses del Trabajador sobre dichas invenciones, desarrollos o mejoras y sobre cualquier Carta Patente, Derecho de Autor y solicitudes relacionadas con los mismos. El Proveedor acepta que cualquier propiedad intelectual creada durante la implicación de un Trabajador con el Cliente del Cliente sigue siendo propiedad del Cliente del Cliente tal y como se describe en el presente documento, incluso si la legislación local considera que dicho trabajo es propiedad del empleador. A petición e indicación del Cliente, el Proveedor se compromete a tomar todas las medidas necesarias, incluidas las descritas en el presente documento, según proceda, para hacer efectivos los derechos del Cliente del Cliente sobre la propiedad intelectual producida durante la contratación de un Trabajador. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VIII. – MUTUAL INDEMNIFICATION</b>
                    <p><b>1)</b> Each Party shall indemnify, defend, and hold the other harmless against any loss, liability, cost, or expense (including reasonable legal fees) related to any third party claim or action that: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VIII. – INDEMNIZACIÓN MUTUA</b>
                    <p><b>1)</b> Cada una de las Partes indemnizará, defenderá y eximirá a la otra de cualquier pérdida, responsabilidad, coste o gasto (incluidos los honorarios razonables de abogados) relacionados con cualquier reclamación o acción de terceros que: </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(i) if true, would be a breach of any condition, warranty, or representations made by the indemnifying party pursuant to this Agreement; or (ii) arises out of an unlawful act (including but not limited to discrimination, retaliation, and/or harassment), negligent act, or omission to act by indemnifying party or, its employees, or agents under this Agreement. These indemnity obligations shall be contingent upon the Party seeking to be indemnified: (i) giving prompt written notice to the indemnifying party of any claim, demand, or action for which indemnity is sought; (ii) reasonably cooperating in the defense or settlement of any such claim, demand, or action; and (iii) obtaining the prior written agreement of the indemnifying party to any settlement or proposal of settlement, which agreement shall not be unreasonably withheld.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'>(i) de ser cierta, constituiría un incumplimiento de cualquier condición, garantía o declaración realizada por la parte indemnizadora en virtud del presente Acuerdo; o (ii) sea consecuencia de un acto ilícito (incluidos, entre otros, discriminación, represalias y/o acoso), acto negligente u omisión por parte de la parte indemnizadora o de sus empleados o agentes en virtud del presente Acuerdo. Dichas obligaciones de indemnización estarán condicionadas a que la Parte que solicita la indemnización: (i) notifique con prontitud y por escrito a la parte indemnizadora cualquier reclamación, demanda o acción por la que se solicita la indemnización; (ii) coopere razonablemente en la defensa o resolución de dicha reclamación, demanda o acción; y (iii) obtenga el acuerdo previo por escrito de la parte indemnizadora para cualquier acuerdo o propuesta de acuerdo, que no se denegará injustificadamente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>2)</b> During the Term, and for a period of two years following the effective date of termination, the Customer will, at its own expense, ensure that it maintains adequate insurance (including cover for, without limitation, public liability, labor liabilities and business interruption) in respect of its potential liability for loss or damage arising under or in connection with this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>2)</b> Durante el Periodo de vigencia, y por un periodo de dos años tras la fecha efectiva de rescisión, el Cliente se asegurará, a sus expensas, de que mantiene un seguro adecuado (que incluya cobertura para, sin limitación, responsabilidad pública, responsabilidades laborales e interrupción de la actividad empresarial) con respecto a su responsabilidad potencial por pérdidas o daños derivados de este
                        Contrato o relacionados con el mismo.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IX. – TERM AND TERMINATION </b>
                    <p>This Agreement shall be in force and remain valid for undetermined period. Each of the Parties is free to terminate this Agreement at any time without cause by previous written notice of 60 (sixty) days. Exception is made if the Worker resigns at his/her own discretion, in which the period of 30 (thirty) days shall prevail. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IX. – PLAZO Y ANULACIÓN</b>
                    <p style='line-height: 1.4'>El presente Acuerdo entrará en vigor y será válido por tiempo indefinido. Cada una de las Partes es libre de rescindir el presente Acuerdo en cualquier momento, sin causa justificada, notificándolo por escrito con 60 (sesenta) días de antelación. La excepción es si el Empleado dimite por decisión propia, en cuyo caso prevalecerá el plazo de preaviso de 30 (treinta) días. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Agreement may be terminated for justified cause regardless of any previous notice, in the occurrence of the following events by the Parties:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Contrato podrá rescindirse por causa justificada, con independencia de cualquier preaviso, cuando se produzcan los siguientes hechos por las Partes: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> consecutives delays or failure to comply by Customer with the payments due to the Provider remuneration or repeated nondelivery or late delivery of the Services by the Provider, only after Provider has given Customer a 2 (two)months previous notice of the potential of termination and provided Customer at least 30 (thirty) days’ notice to cure it. Exception to the previous notice period will apply in case the Worker resigns at his/her own discretion, as beyond the will of the Parties. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(a)</b> los retrasos consecutivos o el incumplimiento por parte del Cliente de los pagos debidos a la remuneración del Proveedor o la no entrega o entrega tardía repetida de los Servicios por parte del Proveedor, sólo después de que el Proveedor haya notificado al Cliente con un plazo de dos (2) meses de antelación la posibilidad de rescisión y con un preaviso de al menos treinta (30) días al Cliente para subsanarla. Se aplicará una excepción al plazo de preaviso en caso de que el Trabajador renuncie por voluntad propia, como ajena a la voluntad de las Partes. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> if any Party breaches any term or condition of this Agreement and fails to remedy to such failure within fifteen (15) days from the date of receipt of written notification from the other Party;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> si una de las Partes incumple cualquier término o condición del presente Acuerdo y no subsana dicho incumplimiento en el plazo de quince (15) días a partir de la fecha de recepción de la notificación por escrito de la otra Parte; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> If either Party becomes or is declared insolvent or bankrupt, is the subject of any proceedings relating to its liquidation or insolvency or for the appointment of a receiver, conservator, or similar officer, or makes an assignment for the benefit of all or substantially all of its creditors or enters into any agreement for the composition, extension, or readjustment of all or substantially all of its obligations, then the other party may, by giving prior written notice thereof to the nonterminating Party, terminate this Agreement as of a date specified in such notice.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Si alguna de las Partes deviene o es declarada insolvente o en quiebra, es objeto de cualquier procedimiento relativo a su liquidación o insolvencia o al nombramiento de un síndico, curador o funcionario similar, o realiza una cesión en beneficio de todos o sustancialmente todos sus acreedores o celebre cualquier acuerdo de convenio, prórroga o reajuste de todas o sustancialmente todas sus obligaciones, entonces la otra parte podrá, mediante diez notificaciones por escrito a la Parte no demandante, rescindir el presente Acuerdo a partir de la fecha
                        especificada en dicha notificación.
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Upon termination of this Agreement or at its termination, Provider undertakes to:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>A la terminación del presente Contrato o a su rescisión, el Proveedor se compromete a: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> return to Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by Customer in relation to the Services agreed upon in this Agreement;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>a)</b> devolver al Cliente, el día de la rescisión del presente Contrato, todos y cada uno de los equipos, material promocional y otros documentos que hayan sido proporcionados por el Cliente en relación con los Servicios acordados en el presente Contrato; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respect and comply with Agreement before the effective termination date; and</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respetar y cumplir el Contrato antes de la fecha efectiva de rescisión; y </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>c)</b> If required by Customer, Provider shall deliver to Customer the legal offboarding documentation referred to the worker.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>c)</b> Si así lo requiere el Cliente, el Contratista facilitará al Cliente la documentación legal de despido relativa al empleado. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">X – ACT OF GOD OR FORCE MAJEURE</b>
                    <p style='line-height: 1.5'>In the event either Party is unable to perform its obligations under the terms of this Agreement because of acts of God or force majeure, such party shall not be liable for damages to the other for any damages resulting from such failure to perform or otherwise from such causes.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">X - ACTO DE FUERZA O FUERZA MAYOR</b>
                    <p style='line-height: 1.5'>En caso de que una de las Partes no pueda cumplir sus obligaciones en virtud del presente Acuerdo debido a circunstancias imprevisibles o de fuerza mayor, dicha Parte no será responsable ante la otra de ningún daño resultante de dicho incumplimiento o de cualquier otra causa. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XI – MISCELLANEOUS PROVISIONS</b>
                    <p style='line-height: 1.5'><b>PROVIDER´S LOCAL PARTNER:</b> In the event Provider indicates any local Partner in a Statement of Work (“SOW”), the Customer will not communicate directly to the local partner (i.e., emails, any correspondence, phone call, and so on) at any time without Provider’s written permission. Provider will be the primary and only point of contact for the entire negotiation and after its expiration in order to avoid damages and losses to the Provider. This provision is valid up to a period of 5 (five) years after the expiration of the Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XI – DISPOSICIONES VARIAS</b>
                    <p style='line-height: 1.4'><b>SOCIO LOCAL DEL PROVEEDOR:</b> En caso de que el Proveedor indique algún Socio local en una Declaración de Trabajo ("SOW"), el Cliente no se comunicará directamente con el socio local (es decir, correos electrónicos, cualquier correspondencia, llamada telefónica, etc.) en ningún momento sin el permiso por escrito del Proveedor. El Proveedor será el principal y único punto de contacto durante toda la negociación y después de su vencimiento para evitar daños y perjuicios al Proveedor. Esta disposición es válida hasta un período de 5 (cinco) años después de la expiración del Acuerdo. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>BENEFITS:</b> Customer, Provider, and Workers do not have any rights or interest in Customer’s Client’s employee benefits, pension plans, stock plans, profit sharing, 401k, or other fringe benefits that are provided to Customer’s Client’s employees by Customer’s Client. All Workers engaged by Provider for Customer shall follow local legislation and the costs shall be covered by Customer entirely. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>BENEFICIOS:</b> El Cliente, el Proveedor y los Empleados no tienen ningún derecho o interés en los beneficios de los empleados del Cliente, planes de pensiones, planes de acciones, participación en beneficios, 401k u otros beneficios complementarios que sean proporcionados a los empleados del Cliente por el Cliente del Cliente. Todos los Trabajadores contratados por el Proveedor para el Cliente deberán cumplir la legislación local y los costes correrán íntegramente a cargo del Cliente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>INDEPENDENT CONTRACTOR:</b> Parties hereby agree that Provider is not employed by Customer, and nothing in this Agreement shall be construed as creating any partnership, joint venture or other relationship between Provider and Customer or Customer’s Client. This is not a contract of employment. Provider’s relationship with respect to Customer is that of an independent contractor. At no time during the term of this Agreement will Provider be Customer’s agent or have any right, authority or power to enter into any commitments on behalf of Customer unless specifically authorized by an officer of Customer in writing. Nothing in this Agreement shall be deemed to create any employeremployee relationship between Customer and Provider and the parties expressly agree that no joint employer relationship shall exist with respect to the Workers who at all times shall remain employees of Provider.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>CONTRATANTE INDEPENDIENTE:</b> Las partes acuerdan que el Proveedor no es empleado del Cliente, y nada de lo dispuesto en el presente Contrato se interpretará como la creación de una sociedad, empresa conjunta u otra relación entre el Proveedor y el Cliente o el Cliente del Cliente. No se trata de un contrato de trabajo. La relación del Proveedor con el Cliente es la de un contratista independiente. En ningún momento durante la vigencia del presente Contrato, el Proveedor será agente del Cliente ni tendrá derecho, autoridad o poder alguno para contraer compromisos en nombre del Cliente, a menos que un funcionario del Cliente lo autorice específicamente por escrito. Nada de lo dispuesto en el presente Contrato se considerará que crea una relación empleador-empleado entre el Cliente y el Contratista, y las partes acuerdan expresamente que no existirá ninguna relación conjunta de empleado con respecto a los Peones, que seguirán siendo en todo momento empleados del Contratista.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NON-COMPETE:</b> Provider hereby agrees that throughout this Agreement and for one year thereafter, it will not engage directly with any of Customer’s Clients to whom it has been introduced to by Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NO COMPETENCIA:</b> El Proveedor acuerda que, durante la vigencia del presente Contrato y un año después, no se involucrará directamente con ninguno de los Clientes del Cliente a los que haya sido presentado por éste. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Parties understand and agree that this does not extend to any organizations with whom Provider is already contracted to perform services or learns of from a source other than Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Las Partes entienden y acuerdan que esto no se extiende a ninguna organización con la que el Proveedor ya esté contratado para prestar servicios o de la que tenga conocimiento por una fuente distinta al Cliente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>WARRANTY:</b> Each Party hereby represents, certifies, and warrants that: (i) it is authorized to enter into this Agreement including having any necessary licenses, registrations, or the like to perform as required herein; (ii) it has no conflicts that would prevent it from meeting its obligations under this Agreement; (iii) there are no pending or anticipated material lawsuits or claims against it, its directors, or officers that would prevent it from proceeding with this Agreement; (iv) neither it, nor its directors, or officers have within the last three (3) years been convicted of or had a civil judgment rendered against them for commission of fraud, criminal offense, breach of confidentiality, or indictment; and (v) it will use its best effort to maintain and keep Worker personal information and Confidential Information secure from unauthorized access or use.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>GARANTÍA:</b> Cada una de las Partes declara, certifica y garantiza que: (i) está autorizada a suscribir el presente Contrato, lo que incluye disponer de todas las licencias, registros o similares necesarios para cumplir con lo aquí exigido; (ii) no tiene conflictos que le impidan cumplir con sus obligaciones en virtud del presente Contrato; (iii) no existen procedimientos o reclamaciones legales importantes pendientes o anticipadas contra ella, sus directores o funcionarios que le impidan proceder con el presente Contrato; (iv) ni ella ni sus directores o funcionarios han sido condenados en los últimos tres (3) años ni se ha dictado sentencia civil contra ellos por fraude, delito penal, violación de la confidencialidad o enjuiciamiento; y (v) hará todo lo posible por conservar y mantener la información personal del Trabajador y la Información Confidencial a salvo de accesos o usos no autorizados. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XII - GENERAL PROVISIONS</b>
                    <p><b>(a) Changes –</b> Any changes or inclusions to this Agreement shall be made with the mutual consent of the Parties and in writing and consider any local mandatory local rule.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XII - DISPOSICIONES GENERALES</b>
                    <p style='line-height: 1.4'><b>(a) Modificaciones -</b> Cualquier modificación o adición al presente Acuerdo deberá realizarse con el consentimiento mutuo de las Partes y por escrito, y tendrá en cuenta cualquier norma local de obligado cumplimiento. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'><b>(b) Independence –</b> In case any provision in this Agreement shall be invalid, illegal or unenforceable, the validity, legality and enforceability of the remaining provisions shall not in any way be affected or impaired thereby and such provision shall be ineffective only to the extent of such invalidity, illegality or unenforceability.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'><b>(b) Independencia -</b> Si alguna disposición de este Acuerdo es inválida, ilegal o inaplicable, la validez, legalidad y aplicabilidad de las disposiciones restantes no se verán afectadas o perjudicadas en modo alguno y dicha disposición será ineficaz sólo en la medida de dicha invalidez, ilegalidad o inaplicabilidad. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(c) Transfer –</b> this Agreement may not be transferred or assigned in whole or in part by either Party without the prior written consent of the other Party.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(c) Transferencia -</b> este Contrato não pode ser transferido ou cedido no todo ou em parte por qualquer uma das Partes sem o consentimento prévio por escrito da outra Parte.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(d) Entire Agreement –</b> This Agreement contains the entire agreement and understanding among the parties hereto with respect to the subject matter hereof, and supersedes all prior and contemporaneous agreements, understandings, inducements, and conditions, express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express terms hereof control and supersede any course of performance and/or usage of the trade inconsistent with any of the terms hereof.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(d) Acuerdo Completo -</b> este Acuerdo contiene el acuerdo completo y el entendimiento entre las partes con respecto al tema del mismo, y reemplaza todos los acuerdos, entendimientos, incentivos y condiciones anteriores y contemporáneos, expresos o implícitos, orales o escritos, de cualquier naturaleza con respecto al tema aquí tratado. Los términos expresos de este documento controlan y reemplazan cualquier curso de desempeño y/o uso comercial de acuerdo con cualquiera de los términos de este documento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e) Tolerance and Absence of Waiver and Novation -</b> The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e) Tolerancia y Ausencia de Renuncia y Novación -</b> La tolerancia de cualquier incumplimiento, incluso si es repetido, por cualquiera de las Partes, de las disposiciones de este Acuerdo no constituye ni debe interpretarse como una renuncia por parte de la otra Parte o como una novación. Si cualquier tribunal determina que alguna disposición o parte de este Acuerdo es nula, inválida o sin efecto vinculante, el resto de este Acuerdo permanecerá en pleno vigor y efecto como si dicha disposición o parte no hubiera formado parte de este acuerdo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(f) Succession -</b> This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(f) Sucesión -</b> Este Acuerdo vincula a las Partes y sus respectivos sucesores, privados y universales, cesionarios autorizados y representantes legales. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(g) Communication between the Parties -</b> All warnings, communications, notifications, and mailing resulting from the performance of this Agreement shall be done in writing, </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(g) Comunicación entre las Partes -</b> Todos los avisos, comunicaciones, notificaciones y correspondencia que surjan de la ejecución de este Acuerdo se realizarán por escrito,</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>with receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by registry at the Registry of Deeds and Documents and will only be valid when directed and delivered to the Parties at the addresses indicated below in accordance with the applicable law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>con acuse de recibo, por correo postal con acuse de recibo, por correo electrónico con acuse de recibo previo o mediante registro en el Registro de Títulos y Documentos, y sólo tendrá validez cuando sea remitido y entregado a las Partes en las direcciones que a continuación se indican de conformidad con la legislación aplicable. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">If to Provider:</b>
                    <p>A/C: {{ $partnerContactName }}</p>
                    <p>Address: {{ $partnerAddress }}</p>
                    <p>Phone/Fax{{ $partnerPhone }}</p>
                    <p>E-mail: <a href="#">{{ $partnerEmail }}</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">Se ao Proveedor:</b>
                    <p>A/C: {{ $partnerContactName }}</p>
                    <p>Endereço:{{ $partnerAddress }}</p>
                    <p>Telefone/Fax: {{ $partnerPhone }}</p>
                    <p>E-mail: <a href="#">{{ $partnerEmail }}</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">If to Client:</b>
                    <p>A/C: PAOLA MAC EACHEN</p>
                    <p>Address: 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada</p>
                    <p>Phone/Fax: +1 514 907 5393</p>
                    <p>E-mail: <a href="#">paolamceachen@yahoo.ca</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">Si al Cliente:</b>
                    <p>A/C: PAOLA MAC EACHEN</p>
                    <p>Endereço: 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada</p>
                    <p>Telefone/Fax: +1 514 907 5393</p>
                    <p>E-mail: <a href="#">paolamceachen@yahoo.ca</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XIII. – ARBITRATION/ GOVERNMENT LAW</b>
                    <p style='line-height: 1.5'>Any disputes between Customer and Provider that arise under this Agreement will be resolved through binding arbitration administered by the Cámara de Comercio Brasil - Canada, in accordance with the Arbitration Rules then in affect at that time. Partner agrees that sole venue and jurisdiction for disputes arising from this Agreement shall be conducted in Brazil – São Paulo city. Procedures and judgment upon the award rendered by the arbitrator may be entered in any court having jurisdiction thereof.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XIII. – ARBITRAJE/DERECHO GUBERNAMENTAL</b>
                    <p style='line-height: 1.5'>Cualquier disputa entre Cliente y Proveedor que surja bajo este Acuerdo se resolverá mediante arbitraje vinculante administrado por la Cámara de Comercio Brasil - Canadá, de acuerdo con las Reglas de Arbitraje vigentes en ese momento. El Socio acepta que el único foro y jurisdicción para las disputas que surjan de este Acuerdo se llevará a cabo en Brasil, la ciudad de São Paulo. Las actuaciones y sentencia sobre el laudo dictado por el árbitro podrán iniciarse en cualquier tribunal que tenga jurisdicción sobre el mismo. </p>
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
                    <p>In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and content, for one sole purpose. The Parties do each hereby warrant and represent that their respective signatory is, as of the Effective Date, duly authorized by all necessary and appropriate corporate action to execute this Agreement. Subsequent addendums may later be incorporated if signed and agreed to by all Parties. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>En fe de lo cual, las Partes firman el presente Acuerdo en 2 (dos) ejemplares de igual forma y contenido, para un solo propósito. Las Partes garantizan y declaran que su respectivo signatario está, a partir de la Fecha de Entrada en Vigor, debidamente autorizado para todas las acciones corporativas necesarias y apropiadas para ejecutar este Acuerdo. Las enmiendas posteriores podrán incorporarse más adelante si son firmadas y acordadas por todas las Partes. </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <p style="margin: 0;"> {{ $contractCreatedDate }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>GATE INTERMEDIANO INC.</b>
                    </div>
                    <br><br>
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
                    <p style="text-align: center; margin-top: -20px">{{ $adminSignedBy }}</p>
                    <p style="text-align: center;margin-top: -20px">{{ $adminSignedByPosition }}</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>GATE INTERMEDIANO INC.</b>
                    </div>
                    <br><br>
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
                    <p style="text-align: center; margin-top: -20px">{{ $adminSignedBy }}</p>
                    <p style="text-align: center;margin-top: -20px">{{ $adminSignedByPosition }}</p>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>{{ $partnerName }}</b>
                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 30px">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">{{ $partnerContactName }}</p>
                    <p style="text-align: center;margin-top: -20px">Legal Representative</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>{{ $partnerName }}</b>

                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 30px">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">{{ $partnerContactName }}</p>
                    <p style="text-align: center;margin-top: -20px">Legal Representative</p>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center; font-weight: bold">SCHEDULE A</p>
                    <p style="text-align: center; font-weight: bold">Scope of Services</p>
                    <p style="text-align: center; font-weight: bold">General Scope</p>
                    <p>Customer will either (a) present individuals to Provider that Customer’s Clients would like to engage, or (b) request staffing support from provider based on Customer’s Client’s requirements. When Customer requests staffing support, Provider will present candidates to Customer subject to final approval by Customer’s Client.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center; font-weight: bold">ANEXO A</p>
                    <p style="text-align: center; font-weight: bold">Alcance de los servicios </p>
                    <p style="text-align: center; font-weight: bold">Alcance general</p>
                    <p>El Cliente (a) presentará al Proveedor a las personas que a los Clientes del Cliente les gustaría contratar, o (b) solicitará apoyo de personal al Proveedor según los requisitos del Cliente. Cuando el Cliente solicita apoyo de personal, el Proveedor presentará candidatos al Cliente sujeto a la aprobación final del Cliente. </p>
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
                    <p style='font-weight: bold'>Payroll Outsourcing Service</p>
                    <p style='line-height: 1.5'>At Customer’s request, Provider will take whatever steps are necessary under local law to become the employer of record for candidates approved by Customer’s Client. By law, those individuals will be employees of Provider (“Workers”) for either an indefinite or definite period. Provider will place the Workers on engagement with Customer’s Client pursuant to Customer’s instructions.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='font-weight: bold'>Servicio de subcontratación de nómina </p>
                    <p style='line-height: 1.5'>A petición del Cliente, el Proveedor tomará todas las medidas necesarias de conformidad con la ley local para convertirse en el empleador registrado de los candidatos aprobados por el Cliente. Por ley, estas personas serán empleados del Proveedor (“Trabajadores”) por un período indefinido o definitivo. El Proveedor pondrá a los Trabajadores en contacto con el Cliente del Cliente de acuerdo con las instrucciones del Cliente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be charged separately by Provider, and payment shall be equally made as stated in clause. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>El Proveedor gestionará todas las obligaciones legales, fiscales, administrativas y similares del empleador de conformidad con la legislación local. Esto incluye, entre otros, firmar un contrato de trabajo apropiado con el Trabajador, verificar la identidad del Trabajador y su derecho legal a trabajar, emitir salarios apropiados, cobrar/remitir cargos e impuestos de seguridad social o similares según lo requiera la ley local, y - abordar a un Trabajador obediente. Los costos de contratación adicionales, que no forman parte del proceso de contratación regular, como la verificación de antecedentes, serán cobrados por separado por el Proveedor y el pago se realizará de la misma manera como se establece en la cláusula. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Durante toda la contratación del Trabajador, el Cliente actuará como enlace entre el Cliente/Trabajador del Cliente y el Proveedor con respecto a cualquier cambio en la tasa de pago, necesidades de reembolso, vacaciones anuales, consultas de rescisión y similares. El Proveedor se compromete a proporcionar de inmediato al Cliente toda la información necesaria para garantizar que el Cliente y el Trabajador del Cliente estén informados de cualquier matiz legal local. </p>
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
                    <p>Provider’s fee for its Payroll Outsourcing Service shall be 12% over the total gross earnings of the Worker´s for the related countries: Chile, Colombia, Costa Rica, Peru and Uruguay, considered a minimum fee of USD350,00. For other Countries not listed herein, shall be checked case by case. Provider shall invoice the EOR service fees as a separate line item on each invoice. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>La tarifa del Proveedor por su Servicio de Outsourcing de Nómina será del 12% de los ingresos brutos totales de los Trabajadores para los países relacionados: Chile, Colombia, Costa Rica, Perú y Uruguay, considerándose una tarifa mínima de USD 350,00. Para otros países no enumerados aquí, se debe verificar caso por caso. El proveedor facturará las tarifas del servicio EOR como una partida separada en cada factura. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='font-weight: bold'>Staffing Service</p>
                    <p style='line-height: 1.5'>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='font-weight: bold'>Servicio de personal</p>
                    <p style='line-height: 1.5'>A petición del Cliente, el Proveedor reclutará, seleccionará y entrevistará candidatos de acuerdo con los requisitos del Cliente, según lo comunicado por el Cliente y siguiendo la legislación local. El Proveedor presentará dichos candidatos al Cliente sujeto a la aprobación final del Cliente del Cliente. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In the event that Provider presents the same candidate to Customer as another vendor, the search firm that presented the candidate to Customer first shall be deemed to have made the placement. Timing will be determined based on the time of receipt by Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>En el caso de que el Proveedor presente al Cliente el mismo candidato que otro proveedor, se considerará que ha realizado la colocación la empresa buscadora que presentó en primer lugar el candidato al Cliente. El tiempo se determinará en función del momento de recepción por parte del
                        Cliente.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Once a candidate is approved by Customer’s Client, Provider may either be asked to provide its EOR service for that individual (“Contract Staffing”) or Customer’s Client will elect to employ the individual themselves or through another vendor (“Direct Hire”). </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Una vez que el Cliente del Cliente aprueba a un candidato, se le puede pedir al Proveedor que proporcione su servicio EOR a esa persona ("Equipo de contrato") o el Cliente del Cliente elegirá emplear a la persona por su cuenta o a través de otro proveedor ("Equipo de contrato directo").</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Fees for Contract Staffing will be agreed upon in writing on a case by case basis.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Los honorarios por Contratación de Personal se acordarán por escrito caso por caso. </p>
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
                    <p style='line-height: 1.5'>In all Direct Hire cases, Customer will pay Provider a placement fee of 18% of that Direct Hire’s gross annual salary. Such fee is subject to Customer’s Client (or a vendor) issuing a formal job offer and the candidate accepting the same. If the candidate resigns or Customer’s Client terminates the engagement for any reason within the first 90 (ninety) days, Provider will replace the Direct Hire individual at no cost, Provider will replace the direct hire, at no recruiting cost, as far the recruitment has been done by the Provider. In this case, Customer shall pay for all termination cost related the Worker.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.4'>En todos los casos de Contratación Directa, el Cliente pagará al Proveedor una tarifa de colocación del 18% del salario bruto anual de dicha Contratación Directa. Dicha tarifa está sujeta a que el Cliente (o proveedor) del Cliente emita una oferta de trabajo formal y el candidato acepte la misma. Si el candidato renuncia o el Cliente del Cliente rescinde el contrato por cualquier motivo dentro de los primeros noventa (90) días, el Proveedor reemplazará la Contratación Directa sin costo, el Proveedor reemplazará la contratación directa, sin costo de contratación, en la medida que el
                        Reclutamiento fue realizado por el Proveedor. En este caso, el Cliente deberá pagar todos los costos de terminación relacionados con el Trabajador.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>Purchase Order: {{ $poNumber }}</p>
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>SCHEDULE</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>Orden de compra: {{ $poNumber }}</p>
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>ANEX</p>
                </td>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">A) WORKER DETAILS:</b>

                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>NAME OF WORKER:</b> {{ $employeeName }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>START DATE:</b> {{ $employeeStartDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>END DATE:</b> {{ $employeeEndDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>GROSS WAGES:</b> {{ number_format($employeeGrossSalary, 2) }} as gross monthly salary.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">A) DETALLES DEL TRABAJADOR:</b>

                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>NOMBRE DEL TRABAJADOR:</b> {{ $employeeName }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>PAÍS DE TRABAJO:</b> {{ $employeeCountryWork }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>CARGO:</b> {{ $employeeJobTitle }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>FECHA DE INICIO:</b> {{ $employeeStartDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>FECHA DE TÉRMINO:</b> {{ $employeeEndDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>SALARIO BRUTO:</b> {{ number_format($employeeGrossSalary, 2) }} como salario bruto mensual.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">DATE OF PAYMENT (every month): </b>
                    <p style='line-height: 1.5'>Payment will be processed by the last day of the worked month. For efficiency, Provider will issue payment on the last day of every month.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">FECHA DE PAGO (todos los meses): </b>
                    <p style='line-height: 1.5'>El pago se procesará hasta el último día del mes trabajado. Para mayor eficiencia, el Proveedor emitirá el pago el último día de cada mes.</p>
                </td>
            </tr>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">LOCAL PAYMENT CONDITIONS:</b>
                    <p style='line-height: 1.5'>Salaries and/or any other remuneration is set at the local currency of the Country where services is provided.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">CONDICIONES DE PAGO LOCALES: </b>
                    <p style='line-height: 1.5'>Los salarios y/o cualquier otra remuneración se fijan en la moneda local del país donde se prestan los servicios. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style="margin-top: 25px !important">

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">B) FEES AND PAYMENT TERMS</b>
                    <p style='font-weight: bold'>PAYMENT TERMS</p>
                    <p><b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below: The Customer pays the Provider a monthly fee based on the calculations below: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">B) TARIFAS Y TÉRMINOS DE PAGO </b>
                    <p style='font-weight: bold'>CONDICIONES DE PAGO</p>
                    <p><b>TARIFAS:</b> El Cliente debe pagar al Proveedor mensualmente, según el cálculo a continuación: El Cliente paga al Proveedor una tarifa mensual según los cálculos a continuación:</p>
                </td>
            </tr>
        </table>
        <div style="margin-top: -20px !important">
            @include('pdf.uruguay_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main style="page-break-after: avoid">

        <table style="margin-top: 35px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The values in American Dollar (USD) are only used as reference as the effective value is in BRL. The amount in USD will monthly vary considering the exchange rate. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Los valores en dólares estadounidenses (USD) se utilizan únicamente como referencia, ya que el valor efectivo está en reales (BRL). El valor en dólares (USD) variará mensualmente considerando el tipo de cambio.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In addition to the monthly fee, there may be additional costs required by law in the Country where the Services are being rendered. Additional costs may apply in the following cases that Provider cannot anticipate or predict, as following:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Además de la tarifa mensual, es posible que existan costos adicionales exigidos por la ley en el país donde se brindan los Servicios. Se pueden aplicar costos adicionales en los siguientes casos que el Proveedor no puede anticipar o predecir, de la siguiente manera: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i) </b>Bonificaciones adicionales otorgadas por el cliente del Cliente; O </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Any eventual local Government measures will be charged just in case there is any changing in the local legislation. Considering the Worker is an independent contractor there should be no additional fee.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Cualquier medida tomada por el gobierno local se cobrará si hay algún cambio en la legislación local. Considerando que el Trabajador es un contratista independiente, no debería haber ningún cargo adicional. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LOCAL LEGISLATION - PREVAILS</b>
                    <p>The law that will govern the Worker’s engagement including their rights as an employee will be the law of the country where the Worker is providing the services., The Parties agree that all applicable law including but not limited to, labour and tax, and must be fully complied with the purposes of the local and global compliance guidelines.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LEGISLACIÓN LOCAL – PREVALECE</b>
                    <p>La ley que regirá el empleo del Trabajador, incluidos sus derechos como empleado, será la ley del país donde el Trabajador esté prestando los servicios. Las Partes acuerdan que todas las leyes aplicables, incluidas, entre otras, las laborales y fiscales. y deberá cumplir plenamente con los propósitos de las pautas de cumplimiento locales y globales. </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

</body>

</html>
