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
$month = now()->format('F');
$day = now()->format('j');
$year = now()->format('Y');
$translatedMonth = \Carbon\Carbon::now()->locale('es')->translatedFormat('F');

$currentDate = now()->format('[d/m/Y]');
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
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$employeeStartDateFFormated = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\of F \\of Y')
: 'N/A';$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';

$currencyName = $record->quotation->currency_name;

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
        <table style='margin-top: 35px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">PARTNERSHIP AGREEMENT</h4>
                    <p>This Payroll and HR Service Agreement (the “Agreement”) is made on {{ $currentDate }} (the “Effective Date”), by and between <b>INTERMEDIANO S.R.L.</b> (the <b>“Provider”</b>), a Costa Rican company with mercantil registry No. 3-102-728410, resident at Avenidas 2 y 4, calle 5, Escazú, San Jose, Costa Rica , duly represented by its legal representative; AND <b>{{ $customerName }}</b> (the <b>“Customer”</b>), with its principal place {{ $customerCity }}, {{ $customerAddress }} duly represented by its authorized representative, (each, a “Party “and together, the “Parties”).</p>
                    <p><b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services globally either directly or indirectly through its local partners; </p>
                    <p><b>WHEREAS</b> Customer also provides certain payroll, tax, and human resource services globally for its clients (“Customer’s Clients”); and</p>
                    <p><b>WHEREAS</b> the Parties wish to enter into this Partnership Agreement to enable Provider to provide its services to Customer for the benefit of Customer’s Clients on the terms and conditions set forth herein.</p>
                    <p><b>NOW, THEREFORE,</b> in consideration of the premises and the mutual covenants set forth herein, the Parties hereby agree as follows:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE PARTNERSHIP</h4>
                    <p>Este Contrato de servicios de nómina y recursos humanos (el "Contrato") se celebra el {{ $currentDate }} (la "Fecha de entrada en vigencia"), por y entre <b>INTERMEDIANO S.R.L.</b> (el <b>“Proveedor”</b>), empresa de Costa Rica con cédula Jurídica <br> No. 3-102-728410, Ubicada en la Avenidas 2 y 4, calle 5, Escazú San Jose, Costa Rica, en adelante denominado simplemente como; Y <b>{{ $customerName }}</b> (el <b>“Cliente”</b>) con sede principal en la Ciudad de {{ $customerCity }}, {{ $customerAddress }} debidamente representados por su representante autorizado, (cada uno, un “Parte” y en conjunto, las “Partes”).</p>
                    <p><b>CONSIDERANDO</b> que el Proveedor brinda ciertos servicios de nómina, impuestos y recursos humanos a nivel mundial, ya sea directa o indirectamente a través de sus socios locales;</p>
                    <p><b>CONSIDERANDO</b> que el Cliente también brinda ciertos servicios de nómina, impuestos y recursos humanos a nivel mundial para sus clientes ("Clientes del Cliente"); y</p>
                    <p><b>CONSIDERANDO</b> que las Partes desean celebrar este Contrato de asociación para permitir que el Proveedor brinde sus servicios al Cliente en beneficio de los Clientes del Cliente en los términos y condiciones establecidos en este documento.</p>
                    <p><b>AHORA, POR LO TANTO,</b> en consideración de las premisas y los convenios mutuos establecidos en este documento, las Partes acuerdan lo siguiente:</p>
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
                    <p><b>I. - PURPOSE</b></p>
                    <p class='line-height-sm'><b>Service Offerings.</b> Provider shall provide to Customer the services of staffing, payroll, consulting and HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein (collectively, the “Services”), during the Term (defined in Section VI) subject to the terms and conditions of this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>I - OBJETO</b></p>
                    <p><b>Ofertas de servicios.</b> El Proveedor proporcionará al Cliente los servicios de dotación de personal, nómina, consultoría y RR. los términos y condiciones de este Contrato.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. – PROVIDER RESPONSIBILITIES</b></p>
                    <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby undertakes to:</p>
                    <p>(a) to meet the requirements and quality standards required by Customer, which may periodically review the Services performed by the Provider;</p>
                    <p>(b) to collect all taxes related to its activities, considering local applicable law where the services are being rendered;</p>
                    <p>(c) to provide, whenever customer requests it, all reports, spreadsheets and other information relating to the Services and the country’s requirements; </p>
                    <p>(d) to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters, in particular, but not limited to, those related to the protection of the environment, exempting Customer and Customer’s Client from any responsibility resulting therefrom. Therefore, the Provider declares in this Agreement that its activities and Services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment; and</p>
                    <p>(e) to have and maintain any needed licenses, registrations, or the like to provide the Services outlined herein. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>II. – RESPONSABILIDADES DEL PROVEEDOR</b></p>
                    <p>Sin perjuicio de las demás obligaciones en virtud de este Contrato, el Proveedor; se compromete a:</p>
                    <p>(a) para cumplir con los requisitos y estándares de calidad exigidos por el Cliente, el cual podrá revisar periódicamente los Servicios prestados por el Proveedor;</p>
                    <p>(b) recaudar todos los impuestos relacionados con sus actividades, considerando la ley local aplicable donde se están prestando los servicios;</p>
                    <p>(c) proporcionar, siempre que el cliente lo solicite, todos los informes, hojas de cálculo y otra información relacionada con los Servicios y los requisitos del país;</p>
                    <p class='line-height-sm'>(d) cumplir con todas las leyes, decretos, reglamentos, resoluciones, decisiones, normas y demás disposiciones globales y locales que considere la ley relativas a la prestación del servicio y en materia laboral, en particular, pero sin limitarse a, las relacionadas con la protección del medio ambiente, eximiendo al Cliente y al Cliente del Cliente de cualquier responsabilidad que de ello se derive. Por lo tanto, el Prestador declara en este Contrato que sus actividades y Servicios, utilizados ahora y en el futuro, cumplen con la legislación y las normas de protección y seguridad en materia de saneamiento y medio ambiente; y</p>
                    <p>(e) tener y mantener las licencias, registros o similares necesarios para proporcionar los Servicios descritos en este documento.</p>
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
                    <p><b>III – CUSTOMER RESPONSABILITIES:</b></p>
                    <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby undertakes to:</p>
                    <p>(a) to process the monthly payment to the Provider set forth in Schedule B (the “Schedule B”);</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>III – RESPONSABILIDADES DEL CLIENTE:</b></p>
                    <p>Sin perjuicio de las demás obligaciones en virtud del presente Contrato, el Cliente se compromete a:</p>
                    <p>(a) para procesar el pago mensual al Proveedor establecido en el Anexo B (el “Anexo B”);</p>

                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <p>(b) to abide by and require Customer’s Clients to abide by Provider’s instructions concerning the local labor legislation, considering where the service is being provided; and</p>
                    <p>(c) to supply the technical information required for the Services to be performed.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p>(b) cumplir y exigir a los Clientes del Cliente que cumplan las instrucciones del Proveedor con respecto a la legislación laboral local, considerando el lugar donde se presta el servicio; y</p>
                    <p>(c) suministrar la información técnica requerida para la prestación de los Servicios.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV – PAYMENT AND FEES:</b></p>
                    <p>(a) For the Services agreed herein, Customer shall pay to the Provider the amount the Parties agreed upon in writing in the format outlined in Schedule B or substantially similar thereto for each Worker or Service. </p>
                    <p>(b) INVOICE: Provider will issue a monthly invoice to the Customer up to the 10th day of the month and Customer shall pay to Provider within 10 (ten) days of receipt of the invoice of the same month the invoice was issued. The invoice will include the Worker’s gross renumeration (e.g., salary, bonuses, commissions, allowances, etc.), any mandatory employer costs (e.g., social security contributions, other taxes etc.), and Provider’s fee.</p>
                    <p>(c) DUE DATE: Customer shall pay Provider within 10 (ten) days of receipt of the invoice by Provider. Undisputed invoices that remain unpaid past the due date will be subject to a penalty fee equal to 3%.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IV – PAGO Y TASAS:</b></p>
                    <p>(a) Por los Servicios acordados en el presente, el Cliente pagará al Proveedor la cantidad que las Partes acordaron por escrito en el formato descrito en el Anexo B o sustancialmente similar al mismo para cada Trabajador o Servicio.</p>
                    <p>(b) FACTURA: El Proveedor emitirá una factura mensual al Cliente hasta el día 10 del mes y el Cliente deberá pagar al Proveedor dentro de los 10 (diez) días siguientes a la recepción de la factura del mismo mes en que se emitió la factura. La factura incluirá la remuneración bruta del Trabajador (p. ej., salario, bonos, comisiones, asignaciones, etc.), cualquier costo obligatorio del empleador (p. ej., contribuciones a la seguridad social, otros impuestos, etc.) y la tarifa del Proveedor.</p>
                    <p>(c) FECHA DE VENCIMIENTO: El Cliente deberá pagar al Proveedor dentro de los 10 (diez) días posteriores a la recepción de la factura por parte del Proveedor. Las facturas no disputadas que permanezcan sin pagar después de la fecha de vencimiento estarán sujetas a una multa equivalente al 3%.</p>
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
                    <p class='line-height-sm'>(d) EXCHANGE RATE: Invoices will be issued in USD based on the exchange rate of the date of the issuance of the invoice, considering the 3.5% margin of risk in favor of Provider. For clarity, this means that all exchange rates used to convert to USD will be increased by 3.5%. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class='line-height-sm'>(d) TIPO DE CAMBIO: Las facturas se emitirán en USD con base en el tipo de cambio de la fecha de emisión de la factura, considerando el 3,5% de margen de riesgo a favor del Proveedor. Para mayor claridad, esto significa que todos los tipos de cambio utilizados para convertir a USD aumentarán un 3,5 %.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V. - CONFIDENTIALITY</b></p>
                    <p class='line-height-sm'>(a) Both Customer and Provider acknowledge that by reason of its relationship to the other party under this Agreement, it will have access to and acquire knowledge, material, data, systems and other information concerning the operation, business, financial affairs and intellectual property of the other Party or Customer’s Client, that may not be accessible or known to the general public, including but not limited to the terms of this Agreement (referred to as "Confidential Information").</p>
                    <p class='line-height-sm'>(b) Non-Disclosure/Use. Each of Customer and Provider agrees that it will: (i) maintain and preserve the confidentiality of all Confidential Information received from the other party (the "Disclosing Party''), both orally and in writing, including taking such steps to protect the confidentiality of the Disclosing Party's Confidential Information as the party receiving such Confidential Information (the "Receiving Party") takes to protect the confidentiality of its own confidential or proprietary information; provided, however, that in no instance shall the Receiving Party use less than a reasonable standard of care to protect the Disclosing Party's Confidential Information; (ii) disclose such Confidential Information only to its own employees on a "need-to-know" basis, and only to those employees who have agreed to maintain the confidentiality thereof pursuant to a written agreement containing terms at least as stringent as those set forth in this Agreement;</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>V.- CONFIDENCIALIDAD</b></p>
                    <p class='line-height-sm'>(a) Tanto el Cliente como el Proveedor reconocen que, en virtud de su relación con la otra parte en virtud del presente Contrato, tendrá acceso y adquirirá conocimiento, material, datos, sistemas y otra información relacionada con la operación, negocios, asuntos financieros y propiedad intelectual. de la otra Parte o del Cliente del Cliente, que puede no ser accesible o conocido por el público en general, incluidos, entre otros, los términos de este Contrato (denominado "Información confidencial").</p>
                    <p class='line-height-sm'>(b) No divulgación/uso. Tanto el Cliente como el Proveedor acuerdan que: (i) mantendrán y preservarán la confidencialidad de toda la Información confidencial recibida de la otra parte (la "Parte reveladora"), tanto oralmente como por escrito, lo que incluye tomar las medidas necesarias para proteger la confidencialidad de la Información Confidencial de la Parte Reveladora como la parte que recibe dicha Información Confidencial (la "Parte Receptora") toma para proteger la confidencialidad de su propia información confidencial o de propiedad exclusiva, siempre que, sin embargo, en ningún caso la Parte Receptora utiliza menos de un estándar razonable de cuidado para proteger la Información Confidencial de la Parte Reveladora; (ii) divulgar dicha Información Confidencial solo a sus propios empleados en base a la "necesidad de saber",</p>
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
                    <p> (iii) not disassemble, "reverse engineer" or "reverse compile" such software for any purpose in the event that software is involved; and (iv) not disclose such Confidential Information to any third party without the prior written consent of the Disclosing Party; provided, however, that each party may disclose the financial terms of this Agreement to its legal and business advisors and to potential investors so long as such third parties agree to maintain the confidentiality of such Confidential Information. Each Receiving Party further agrees to use the Confidential Information of the Disclosing Party only for the purpose of performing its obligations under this Agreement. The Receiving Party's obligation of confidentiality shall survive this Agreement for a period of five (5) years from the date of its termination or expiration and thereafter shall terminate and be of no further force or effect; provided, however, that with respect to Confidential Information which constitutes a trade secret, such information shall remain confidential so long as such information continues to remain a trade secret. The parties also mutually agree to (1) not alter or remove any identification or notice of any copyright, trademark, or other proprietary rights which indicates the ownership of any part of the Disclosing Party's Confidential Information; and (2) notify the Disclosing Party of the circumstances surrounding any possession or use of the Confidential Information by anyperson or entity other than those authorized under this Agreement.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>y solo a aquellos empleados que han acordado mantener la confidencialidad de los mismos de conformidad con un Contrato escrito que contiene términos al menos tan estrictos como los establecidos en este Contrato; (iii) no desmontar, "re ingeniería inversa" o "compilación inversa" de dicho software para cualquier propósito en el caso de que el software esté involucrado; y (iv) no revelar dicha Información Confidencial a ningún tercero sin el consentimiento previo por escrito de la Parte Reveladora; siempre que, sin embargo, cada parte pueda divulgar los términos financieros de este Contrato a sus asesores legales y comerciales y a posibles inversores siempre que dichos terceros acuerden mantener la confidencialidad de dicha Información Confidencial. Cada Parte Receptora también acepta utilizar la Información Confidencial de la Parte Reveladora únicamente con el propósito de cumplir con sus obligaciones bajo este Contrato. La obligación de confidencialidad de la Parte Receptora sobrevivirá a este Contrato por un período de cinco (5) años a partir de la fecha de su rescisión o vencimiento y, posteriormente, se rescindirá y dejará de tener vigencia o efecto; siempre que, sin embargo, con respecto a la Información Confidencial que constituya un secreto comercial, dicha información permanecerá confidencial mientras dicha información continúe siendo un secreto comercial. Las partes también acuerdan mutuamente (1) no alterar ni eliminar ninguna identificación o aviso de derechos de autor, marca comercial u otros derechos de propiedad que indiquen la propiedad de cualquier parte de la Información confidencial de la Parte divulgadora; y (2) notificar a la Parte Reveladora de las circunstancias que rodean cualquier posesión o uso de la Información Confidencial por parte de cualquier persona o entidad distinta de las autorizadas en virtud de este Contrato.</p>

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
                    <p>(c) Exclusions. Each of Customer’s and Provider’s obligations in the preceding paragraph above shall not apply to Confidential Information which the Receiving Party can prove: (i) has become a matter of public knowledge through no fault, action or omission of or by the Receiving Party; (ii) was rightfully in the Receiving Party's possession prior to disclosure by the Disclosing Party; (iii) subsequent to disclosure by the Disclosing Party, was rightfully obtained by the Receiving Party from a third party who was lawfully in possession of such Confidential Information without restriction; (iv) was independently developed by the Receiving Party without resort to the Disclosing Party's Confidential Information; or (v) must be disclosed by the Receiving Party pursuant to law, judicial order or any applicable regulation (including any applicable stock exchange rules and regulations); provided, however, that in the case of disclosures made in accordance with the foregoing clause (v), the Receiving Party must provide prior written notice to the Disclosing Party of any such legally required disclosure of the Disclosing Party's Confidential Information as soon as practicable in order to afford the Disclosing Party an opportunity to seek a protective order, or, in the event that such order cannot be obtained, disclosure may be made in a manner intended to minimize or eliminate any potential liability.</p>

                    <p>(d) Provider agrees that it will require every Worker to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                    <p>(e) In the event Supplier contracts with suppliers, Supplier shall require such suppliers to agree to confidentiality terms substantially similar to those described herein to protect Customer's and Client's Confidential Information.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class="line-height-sm">(c) Exclusiones. Cada una de las obligaciones del Cliente y del Proveedor en el párrafo anterior no se aplicará a la Información Confidencial que la Parte Receptora pueda probar: (i) se ha convertido en un asunto de conocimiento público sin culpa, acción u omisión de o por parte del Receptor Fiesta; (ii) estaba legítimamente en posesión de la Parte Receptora antes de la divulgación por parte de la Parte Reveladora; (iii) después de la divulgación por parte de la Parte reveladora, la Parte receptora la obtuvo legítimamente de un tercero que estaba legalmente en posesión de dicha Información confidencial sin restricciones; (iv) fue desarrollado de forma independiente por la Parte Receptora sin recurrir a la Información Confidencial de la Parte Reveladora; o (v) debe ser divulgada por la Parte Receptora de conformidad con la ley, una orden judicial o cualquier regulación aplicable (incluidas las normas y reglamentos bursátiles aplicables); siempre que, sin embargo, en el caso de divulgaciones realizadas de conformidad con la cláusula (v) anterior, la Parte Receptora debe proporcionar un aviso previo por escrito a la Parte Reveladora de cualquier divulgación legalmente requerida de la Información Confidencial de la Parte Reveladora tan pronto como sea posible en para brindarle a la Parte divulgadora la oportunidad de solicitar una orden de protección o, en caso de que no se pueda obtener dicha orden, la divulgación puede realizarse de manera que se minimice o elimine cualquier responsabilidad potencial.</p>

                    <p class='line-height-sm'>(d) El Proveedor acepta que requerirá que cada Trabajador acepte términos de confidencialidad sustancialmente similares a los descritos en este documento para proteger la Información confidencial del Cliente y del Cliente.</p>
                    <p class='line-height-sm'>(e) En caso de que el Proveedor contrate a los proveedores, requerirá que dichos proveedores acepten términos de confidencialidad sustancialmente similares a los descritos en este documento para proteger la Información confidencial del Cliente y del Cliente.</p>
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
                    <p>(f) Should Provider engage vendors, it will require every such vendor to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(f) En caso de que el Proveedor contrate a vendedores, exigirá a cada uno de ellos que acepte unas condiciones de confidencialidad sustancialmente similares a las aquí descritas para proteger la información confidencial del Cliente y del Cliente del Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. - GDPR DATA PROTECTION</b></p>
                    <p>Any information containing personal data shall be handled by both Parties in accordance with all applicable privacy laws and regulations, including without limitation the GDPR and equivalent laws and regulations. If for the performance of the Services it is necessary to exchange personal data, the relevant Parties shall determine their respective positions towards each other (either as controller, joint controllers or processor) and the subsequent consequences and responsibilities according to the GDPR as soon as possible. For the avoidance of doubt, each Party’s position may change depending upon the circumstances of each situation.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VI. - PROTECCIÓN DE DATOS RGPD</b></p>
                    <p>Cualquier información que contenga datos personales será manejada por ambas Partes de Contrato con todas las leyes y reglamentos de privacidad aplicables, incluidos, entre otros, el RGPD y las leyes y reglamentos equivalentes. Si para la prestación de los Servicios es necesario intercambiar datos personales, las Partes correspondientes determinarán sus posiciones respectivas entre sí (ya sea como controlador, cocontroladores o procesador) y las consecuencias y responsabilidades subsiguientes de Contrato con el RGPD. tan pronto como sea posible. Para evitar dudas, la posición de cada Parte puede cambiar según las circunstancias de cada situación.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. INTELLECTUAL AND INDUSTRIAL PROPERTY</b></p>
                    <p>(a) Every document, report, data, know-how, method, operation, design, trademarks confidential information, patents and any other information provided by Customer to the Provider shall be and remain exclusive property of the Customer that disclosed the information.</p>
                    <p>(b) After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VII. PROPIEDAD INTELECTUAL E INDUSTRIAL</b></p>
                    <p>(a) Todo documento, informe, dato, know-how, método, operación, diseño, marcas, información confidencial, patentes y cualquier otra información proporcionada por el Cliente al Proveedor será y seguirá siendo propiedad exclusiva del Cliente que divulgó la información.</p>
                    <p>(b) Después de la rescisión o el vencimiento del presente, ninguna de las Partes utilizará marcas comerciales o nombres que puedan ser similares a los de la otra Parte y/o que puedan ser confundidos de alguna manera por los clientes y las empresas. Cada Parte se compromete a realizar sus mejores esfuerzos para evitar errores o divulgación indebida de las marcas y nombres de las otras Partes por parte de personas no autorizadas.</p>

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
                    <p>(c) Provider agrees that everything provided to it or Workers by Client’s Customer remains the property of Client’s Customer, and that no right, title, or interest is transferred to Provider or Workers including recovery of said property; this includes company laptops, phones, credit cards, etc. Provider further agrees that all right title and interest in the work product (including but not limited to intellectual property, software, works of authorship, trade secrets, designs, data or other proprietary information) produced by Provider or Workers under this Agreement are the sole property of Customer’s Client. Provider further agrees to assign, or cause to be assigned from time to time, to Client’s Customer on an exclusive basis all rights, title and interest in and to the work product produced by Provider or Workers under this Agreement, including any copyrights, patents, mask work rights or other intellectual property rights relating thereto, in perpetuity or for the longest period otherwise permitted under applicable law. Provider agrees that it shall not use the work product for the benefit of any party other than Customer’s Client. Nothing in this Subsection shall apply to any copyrightable material, notes, records, drawings, designs, Innovations, improvements, developments, discoveries and trade secrets conceived, made or discovered by Provider prior to the Effective Date of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(c) el Proveedor acepta que todo lo que el Cliente del Cliente le proporciona a él o a los Trabajadores sigue siendo propiedad del Cliente del Cliente, y que no se transfiere ningún derecho, título o interés al Proveedor o a los Trabajadores, incluida la recuperación de dicha propiedad; esto incluye computadoras portátiles, teléfonos, tarjetas de crédito, etc. de la compañía. El proveedor también acepta que todos los títulos de derechos e intereses en el producto del trabajo (incluidos, entre otros, propiedad intelectual, software, trabajos de autoría, secretos comerciales, diseños, datos u otra información patentada) producida por el Proveedor o los Trabajadores en virtud de este Contrato son propiedad exclusiva del Cliente del Cliente. El Proveedor también acepta ceder, o hacer que se asigne de vez en cuando, al Cliente del Cliente de forma exclusiva todos los derechos, títulos e intereses sobre el producto del trabajo producido por el Proveedor o los Trabajadores en virtud de este Contrato, incluidos los derechos de autor, patentes, enmascarar los derechos de trabajo u otros derechos de propiedad intelectual relacionados con los mismos, a perpetuidad o durante el período más largo permitido por la ley aplicable. El proveedor acepta que no utilizará el producto del trabajo en beneficio de ninguna otra parte que no sea el Cliente del Cliente. Nada en esta Subsección se aplicará a cualquier material, notas, registros, dibujos, diseños, innovaciones, mejoras, desarrollos, descubrimientos y secretos comerciales concebidos, hechos o descubiertos por el Proveedor antes de la Fecha de entrada en vigencia de este Contrato.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>(d) Provider shall require each Worker assigned to Customer’s Client to agree that, to the maximum extent permitted by law, all inventions, developments or improvements conceived or created by such Worker while engaged in rendering services under this Agreement,</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(d) El Proveedor requerirá que cada Trabajador asignado al Cliente del Cliente acepte que, en la medida máxima permitida por la ley, todos los inventos, desarrollos o mejoras concebidos o creados por dicho Trabajador mientras prestaba servicios en virtud de este Contrato, </p>
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
                    <p>that relate to work or projects for Customer’s Client, shall be the exclusive property of Customer’s Client, and to assign and transfer to Customer’s Client (or to Provider for further assignment to Customer and ultimately to Customer’s Client) all of Worker’s right, title and interest in and to such inventions, developments or improvements and to any Letter Patents, Copyrights and applications pertaining thereto. Provider agrees that any intellectual property created during a Worker’s engagement with Customer’s Client remains the property of Customer’s Client as outlined herein, even if local law deems such work the property of the employer. At Customer’s request and direction, Provider agrees to take whatever steps necessary including those outlined herein, as applicable, to effectuate Customer’s Client’s rights in the intellectual property produced during a Worker’s engagement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>que se relacionen con el trabajo o proyectos para el Cliente del Cliente, serán propiedad exclusiva del Cliente del Cliente, y para asignar y transferir al Cliente del Cliente (o al Proveedor para una asignación posterior al Cliente y, en última instancia, al Cliente del Cliente) todos los derechos, títulos e intereses del Trabajador en ya dichas invenciones, desarrollos o mejoras ya cualquier Carta de Patentes, Derechos de Autor y aplicaciones correspondientes. El Proveedor acepta que cualquier propiedad intelectual creada durante el compromiso de un Trabajador con el Cliente del Cliente sigue siendo propiedad del Cliente del Cliente como se describe en este documento, incluso si la ley local considera que dicho trabajo es propiedad del empleador. A pedido y dirección del Cliente, el Proveedor acepta tomar las medidas necesarias, incluidas las descritas en este documento, según corresponda, para hacer efectivos los derechos del Cliente del Cliente sobre la propiedad intelectual producida durante la contratación de un Trabajador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. – MUTUAL INDEMNIFICATION</b></p>
                    <p style='text-decoration: underline'>1) Each Party shall indemnify, defend, and hold the other harmless against any loss, liability, cost, or expense (including reasonable legal fees) related to any third party claim or action that: (i) if true, would be a breach of any condition, warranty, or representations made by the indemnifying party pursuant to this Agreement; or (ii) arises out of an unlawful act (including but not limited to discrimination, retaliation, and/or harassment), negligent act, or omission to act by indemnifying party or, its employees, or agents under this Agreement. These indemnity obligations shall be contingent upon the Party seeking to be indemnified: (i) giving prompt written notice to the indemnifying party of any claim, demand, or action for which indemnity is sought; </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>VIII. – INDEMNIZACIÓN MUTUA</b></p>

                    <p style='text-decoration: underline'>1) Cada Parte indemnizará, defenderá y eximirá a la otra de cualquier pérdida, responsabilidad, costo o gasto (incluidos los honorarios legales razonables) relacionados con cualquier reclamo o acción de un tercero que: (i) de ser cierto, sería un incumplimiento de cualquier condición, garantía o representación hecha por la parte que indemniza de conformidad con este Contrato; o (ii) surge de un acto ilegal (que incluye, entre otros, discriminación, represalias y/o acoso), acto negligente u omisión de actuar por parte de la parte que indemniza o sus empleados o agentes en virtud de este Contrato. Estas obligaciones de indemnización estarán supeditadas a que la Parte que busque ser indemnizada:</p>
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
                    <p style='text-decoration: underline'>(ii) reasonably cooperating in the defense or settlement of any such claim, demand, or action; and (iii) obtaining the prior written agreement of the indemnifying party to any settlement or proposal of settlement, which agreement shall not be unreasonably withheld.</p>
                    <p style='text-decoration: underline'>2) During the Term, and for a period of two years following the effective date of termination, the Customer will, at its own expense, ensure that it maintains adequate insurance (including cover for, without limitation, public liability, labor liabilities and business interruption) in respect of its potential liability for loss or damage arising under or in connection with this Agreement; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-decoration: underline'>(i) notifique por escrito y sin demora a la parte indemnizadora de cualquier reclamación, demanda o acción por la cual se solicite indemnización; (ii) cooperar razonablemente en la defensa o resolución de cualquier reclamo, demanda o acción; y (iii) obtener el Contrato previo por escrito de la parte indemnizadora para cualquier arreglo o propuesta de arreglo, dicho Contrato no se denegará injustificadamente.</p>
                    <p style='text-decoration: underline'>2) Durante el Plazo, y por un período de dos años a partir de la fecha de vigencia de la rescisión, el Cliente, a su cargo, se asegurará de mantener un seguro adecuado (incluida la cobertura, entre otros, de responsabilidad pública, responsabilidad laboral y la interrupción del negocio) con respecto a su posible responsabilidad por pérdidas o daños que surjan en virtud de este Contrato o en relación con él;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IX. – TERM AND TERMINATION</b></p>
                    <p>This Agreement shall be in force and remain valid for undetermined period. Each of the Parties is free to terminate this Agreement at any time without cause by previous written notice of 60 (sixty) days. Exception is made if the Worker resigns at his/her own discretion, in which the period of 30 (thirty) days shall prevail. </p>
                    <p>The Agreement may be terminated for justified cause regardless of any previous notice, in the occurrence of the following events by the Parties:</p>
                    <p>(a) consecutives delays or failure to comply by Customer with the payments due to the Provider remuneration or repeated nondelivery or late delivery of the Services by the Provider, only after Provider has given Customer a 2 (two)months previous notice of the potential of termination and provided Customer at least 30 (thirty) days’ notice to cure it.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>IX. - DURACIÓN Y TERMINACIÓN</b></p>
                    <p>Este Contrato estará en vigor y seguirá siendo válido por un período indeterminado. Cada una de las Partes es libre de rescindir este Contrato en cualquier momento sin causa previa notificación por escrito de 60 (sesenta) días. Se exceptúa la renuncia del Trabajador por voluntad propia, en la que prevalecerá el plazo de 30 (treinta) días.</p>
                    <p>El Contrato podrá ser rescindido por causa justificada independientemente de cualquier notificación previa, en caso de que ocurran los siguientes eventos por las Partes:</p>
                    <p>(a) retrasos consecutivos o incumplimiento por parte del Cliente de los pagos debidos a la remuneración del Proveedor o falta de entrega repetida o entrega tardía de los Servicios por parte del Proveedor, solo después de que el Proveedor haya dado al Cliente un plazo de 2 (dos) meses previo aviso de la posibilidad de rescisión y siempre que el Cliente tenga al menos 30 (treinta) días de antelación para subsanarla. </p>

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
                    <p> Exception to the previous notice period will apply in case the Worker resigns at his/her own discretion, as beyond the will of the Parties. </p>
                    <p>(b) if any Party breaches any term or condition of this Agreement and fails to remedy to such failure within fifteen (15) days from the date of receipt of written notification from the other Party;</p>
                    <p>(c) If either Party becomes or is declared insolvent or bankrupt, is the subject of any proceedings relating to its liquidation or insolvency or for the appointment of a receiver, conservator, or similar officer, or makes an assignment for the benefit of all or substantially all of its creditors or enters into any agreement for the composition, extension, or readjustment of all or substantially all of its obligations, then the other party may, by giving prior written notice thereof to the nonterminating Party, terminate this Agreement as of a date specified in such notice.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Se exceptuará el plazo de preaviso anterior en caso de que el Trabajador renuncie por su propia voluntad, más allá de la voluntad de las Partes.</p>
                    <p>(b) si alguna de las Partes incumple cualquier término o condición de este Contrato y no subsana dicho incumplimiento dentro de los quince (15) días a partir de la fecha de recepción de la notificación por escrito de la otra Parte;</p>
                    <p>(c) Si cualquiera de las Partes se declara o es declarada insolvente o en quiebra, es objeto de cualquier procedimiento relacionado con su liquidación o insolvencia o para el nombramiento de un síndico, curador o funcionario similar, o hace una cesión para el beneficio de todos o sustancialmente todos sus acreedores o celebre cualquier Contrato para la composición, extensión o reajuste de todas o sustancialmente todas sus obligaciones, entonces la otra parte podrá, mediante notificación previa por escrito a la parte que no rescinde Parte, rescindir este Contrato a partir de la fecha especificada en dicha notificación.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Upon termination of this Agreement or at its termination, Provider undertakes to:</p>
                    <p>a) return to Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by Customer in relation to the Services agreed upon in this Agreement;</p>
                    <p>b) respect and comply with Agreement before the effective termination date; and</p>
                    <p>c) If required by Customer, Provider shall deliver to Customer the legal offboarding documentation referred to the worker.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>A la terminación de este Contrato o a su terminación, el Proveedor se compromete a:</p>
                    <p>a) devolver al Cliente el día de la rescisión de este Contrato, todos y cada uno de los equipos, material promocional y otros documentos que haya proporcionado el Cliente en relación con los Servicios acordados en este Contrato;</p>
                    <p>b) respetar y cumplir el Contrato antes de la fecha efectiva de terminación; y</p>
                    <p>c) En caso de ser requerido por el Cliente, el Proveedor deberá entregar al Cliente la documentación legal de baja referida al trabajador.</p>

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

                    <p><b>X – ACT OF GOD OR FORCE MAJEURE</b></p>
                    <p>In the event either Party is unable to perform its obligations under the terms of this Agreement because of acts of God or force majeure, such party shall not be liable for damages to the other for any damages resulting from such failure to perform or otherwise from such causes.</p>
                    <p><b>XI – MISCELLANEOUS PROVISIONS</b></p>
                    <p><b>PROVIDER´S LOCAL PARTNER:</b> In the event Provider indicates any local Partner in a Statement of Work (“SOW”), the Customer will not communicate directly to the local partner (i.e., emails, any correspondence, phone call, and so on) at any time without Provider’s written permission. Provider will be the primary and only point of contact for the entire negotiation and after its expiration in order to avoid damages and losses to the Provider. This provision is valid up to a period of 5 (five) years after the expiration of the Agreement. </p>
                    <p><b>BENEFITS:</b> Customer, Provider, and Workers do not have any rights or interest in Customer’s Client’s employee benefits, pension plans, stock plans, profit sharing, 401k, or other fringe benefits that are provided to Customer’s Client’s employees by Customer’s Client All Workers engaged by Provider for Customer shall follow local legislation and the costs shall be covered by Customer entirely. </p>
                    <p><b>INDEPENDENT CONTRACTOR:</b> Parties hereby agree that Provider is not employed by Customer, and nothing in this Agreement shall be construed as creating any partnership, joint venture or other relationship between Provider and Customer or Customer’s Client.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p><b>X – CASO FORTUITO O FUERZA MAYOR</b></p>
                    <p>En caso de que cualquiera de las Partes no pueda cumplir con sus obligaciones en virtud de los términos de este Contrato debido a caso fortuito o fuerza mayor, dicha parte no será responsable de los daños a la otra por los daños que resulten de dicho incumplimiento. o de otro modo por tales causas.</p>
                    <p><b>XI - DISPOSICIONES VARIAS</b></p>
                    <p><b>SOCIO LOCAL DEL PROVEEDOR:</b> En el caso de que el Proveedor indique cualquier Socio local en una Declaración de trabajo ("SOW"), el Cliente no se comunicará directamente con el socio local (es decir, correos electrónicos, cualquier correspondencia, llamada telefónica, etc.) en cualquier momento sin el permiso por escrito del Proveedor. El Proveedor será el principal y único punto de contacto durante toda la negociación y después de su vencimiento a fin de evitar daños y perjuicios al Proveedor. Esta disposición es válida hasta un período de 5 (cinco) años después de la expiración del Contrato.</p>
                    <p><b>BENEFICIOS:</b> El Cliente, el Proveedor y los Trabajadores no tienen ningún derecho o interés en los beneficios para empleados, planes de pensión, planes de acciones, participación en las ganancias, 401k u otros beneficios complementarios que el Cliente del Cliente proporciona a los empleados del Cliente del Cliente. Todos los Trabajadores contratados por el Proveedor para el Cliente deberán cumplir con la legislación local y los costos serán cubiertos por el Cliente en su totalidad.</p>
                    <p><b>CONTRATISTA INDEPENDIENTE:</b> Por el presente, las partes acuerdan que el Proveedor no es empleado del Cliente, y nada en este Contrato se interpretará como la creación de una sociedad, empresa conjunta u otra relación entre el Proveedor y el Cliente o el Cliente del Cliente. </p>
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
                    <p>This is not a contract of employment. Provider’s relationship with respect to Customer is that of an independent contractor. At no time during the term of this Agreement will Provider be Customer’s agent or have any right, authority or power to enter into any commitments on behalf of Customer unless specifically authorized by an officer of Customer in writing. Nothing in this Agreement shall be deemed to create any employeremployee relationship between Customer and Provider and the parties expressly agree that no joint employer relationship shall exist with respect to the Workers who at all times shall remain employees of Provider.</p>
                    <p><b>NON-COMPETE:</b> Provider hereby agrees that throughout this Agreement and for one year thereafter, it will not engage directly with any of Customer’s Clients to whom it has been introduced to by Customer. The Parties understand and agree that this does not extend to any organizations with whom Provider is already contracted to perform services or learns of from a source other than Customer.</p>
                    <p><b>WARRANTY:</b> Each Party hereby represents, certifies, and warrants that: (i) it is authorized to enter into this Agreement including having any necessary licenses, registrations, or the like to perform as required herein; (ii) it has no conflicts that would prevent it from meeting its obligations under this Agreement; (iii) there are no pending or anticipated material lawsuits or claims against it, its directors, or officers that would prevent it from proceeding with this Agreement; (iv) neither it, nor its directors, or officers have within the last three (3) years been convicted of or had a civil judgment rendered against them for commission of fraud, criminal offense, breach of confidentiality, or indictment; and (v) it will use its best effort to maintain and keep Worker personal information and Confidential Information secure from unauthorized access or use.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p> Esto no es un contrato de trabajo. La relación del Proveedor con respecto al Cliente es la de un contratista independiente. En ningún momento durante la vigencia de este Contrato, el Proveedor será el agente del Cliente ni tendrá ningún derecho, autoridad o poder para contraer compromisos en nombre del Cliente, a menos que un funcionario del Cliente lo autorice específicamente por escrito. Nada en este Contrato se considerará que crea una relación de empleadorempleado entre el Cliente y el Proveedor y las partes acuerdan expresamente que no existirá una relación de empleador conjunto con respecto a los Trabajadores que en todo momento seguirán siendo empleados del Proveedor.</p>
                    <p><b>NO COMPETENCIA:</b> el Proveedor acepta que a lo largo de este Contrato y durante un año a partir de entonces, no se relacionará directamente con ninguno de los Clientes del Cliente a quienes el Cliente le haya presentado. Las Partes entienden y aceptan que esto no se extiende a ninguna organización con la que el Proveedor ya esté contratado para realizar servicios o se entere de una fuente que no sea el Cliente.</p>
                    <p><b>GARANTÍA:</b> Cada Parte declara, certifica y garantiza que: (i) está autorizada para celebrar este Contrato, lo que incluye tener las licencias, registros o similares necesarios para realizar lo requerido en este documento; (ii) no tiene conflictos que le impidan cumplir con sus obligaciones bajo este Contrato; (iii) no hay demandas o reclamos importantes pendientes o anticipados contra ella, sus directores o funcionarios que le impidan proceder con este Contrato; (iv) ni él, ni sus directores o funcionarios han sido condenados o se les ha dictado una sentencia civil en los últimos tres (3) años por comisión de fraude, delito penal, violación de la confidencialidad o en dictamen; y (v) hará su mejor esfuerzo para mantener y mantener la información personal del Trabajador y la Información Confidencial a salvo del acceso o uso no autorizado.</p>

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
                    <p><b>XII - GENERAL PROVISIONS</b></p>
                    <p>(a) Changes – Any changes or inclusions to this Agreement shall be made with the mutual consent of the Parties and in writing and consider any local mandatory local rule.</p>
                    <p>(b) Independence – In case any provision in this Agreement shall be invalid, illegal or unenforceable, the validity, legality and enforceability of the remaining provisions shall not in any way be affected or impaired thereby and such provision shall be ineffective only to the extent of such invalidity, illegality or unenforceability.</p>
                    <p>(c) Transfer –this Agreement may not be transferred or assigned in whole or in part by either Party without the prior written consent of the other Party.</p>
                    <p>(d) Entire Agreement – This Agreement contains the entire agreement and understanding among the parties hereto with respect to the subject matter hereof, and supersedes all prior and contemporaneous agreements, understandings, inducements and conditions, express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express terms hereof control and supersede any course of performance and/or usage of the trade inconsistent with any of the terms hereof.</p>
                    <p>(e) Tolerance and Absence of Waiver and Novation. The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>XII - DISPOSICIONES GENERALES</b></p>
                    <p>(a) Cambios: cualquier cambio o inclusión en este Contrato se realizará con el consentimiento mutuo de las Partes y por escrito y considerará cualquier regla local obligatoria local.</p>
                    <p>(b) Independencia: en caso de que alguna disposición de este Contrato sea inválida, ilegal o inaplicable, la validez, legalidad y aplicabilidad de las disposiciones restantes no se verán afectadas o perjudicadas de ninguna manera y dicha disposición será ineficaz solo en la medida de dicha invalidez, ilegalidad o inaplicabilidad.</p>
                    <p>(c) Transferencia: este Contrato no puede ser transferido o cedido en su totalidad o en parte por Parte sin el consentimiento previo por escrito de la otra Parte.</p>
                    <p>(d) Contrato completo: este Contrato contiene el Contrato completo y el entendimiento entre las partes con respecto al objeto del mismo, y reemplaza todos los Contratos, entendimientos, incentivos y condiciones anteriores y contemporáneos, expresos o implícitos, oral o escrita, de cualquier naturaleza con respecto al objeto del presente. Los términos expresos del presente controlan y reemplazan cualquier curso de ejecución y/o uso del comercio incompatible con cualquiera de los términos del presente.</p>
                    <p>(e) Tolerancia y Ausencia de Renuncia y Novación. La tolerancia de cualquier incumplimiento, incluso si se repite, por cualquiera de las Partes, de las disposiciones de este Acuerdo no constituye ni se interpretará como una renuncia de la otra Parte o como una novación. Si algún juzgado o tribunal determina que alguna disposición o artículo de este Acuerdo es nulo, inválido o sin ningún efecto vinculante, el resto de este Contrato permanecerá en pleno vigor y efecto como si dicha disposición o parte no hubiera integrado este Acuerdo.</p>
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
                    <p>(f) Succession - This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives.</p>
                    <p>(g) Communication between the Parties - All warnings, communications, notifications and mailing resulting from the performance of this Agreement shall be done in writing, with receipt confirmation, by mail with notice of receipt, by email with notice of receipt or by registry at the Registry of Deeds and Documents, and will only be valid when directed and delivered to the Parties at the addresses indicated below in accordance with the applicable law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>(f) Sucesión - Este Acuerdo vincula a las Partes y sus respectivos sucesores, particulares y universales, cesionarios autorizados y representantes legales.</p>
                    <p>(g) Comunicación entre las Partes - Todas las advertencias, comunicaciones, notificaciones y correos resultantes de la ejecución de este Acuerdo se realizarán por escrito, con acuse de recibo, por correo con aviso de recibo, por correo electrónico con aviso de re recepción o por inscripción en el Registro de Títulos y Documentos, y sólo tendrá validez cuando se dirija y entregue a las Partes en las direcciones que se indican a continuación de conformidad con la legislación aplicable.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>If to <b>Provider</b>:</p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: <b>FERNANDO JESUS SCHREINER GUTIERREZ</b></p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Address:</b> Avenidas 2 y 4, calle 5, Escazú, San Jose, Costa Rica</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Phone/Fax:</b> +55 21 98217 3082</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>E-mail:</b> <a href="#">sac@intermediano.com</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Si al <b>Proveedor:</b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: <b>FERNANDO JESUS SCHREINER GUTIERREZ</b></p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Dirección:</b> Avenidas 2 y 4, calle 5, Escazú, San Jose, Costa Rica</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Teléfono/Fax:</b> +55 21 98217 3082</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>E-mail:</b> <a href="#">sac@intermediano.com</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>If to <b>Customer: </b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: <b>{{ $contactName }} {{ $contactSurname }}</b></p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Address:</b> {{ $customerAddress }} </p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Phone/Fax:</b> {{ $customerPhone }}</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>E-mail:</b> <a href="#">{{ $customerEmail }}</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Si al <b>Cliente: </b></p>
                    <p style="line-height: 1.5; margin: 2px; margin-top: 10px;">A/C: <b>{{ $contactName }} {{ $contactSurname }}</b></p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Dirección:</b> {{ $customerAddress }} </p>
                    <p style="line-height: 1.5; margin: 2px;"><b>Telefone:</b> {{ $customerPhone }}</p>
                    <p style="line-height: 1.5; margin: 2px;"><b>E-mail:</b> <a href="#">{{ $customerEmail }}</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>XIII. – {{ strtoupper('Arbitration/ Government Law') }}</b></p>
                    <p>Any disputes between Customer and Provider that arise under this Agreement will be resolved through the Courts of Costa Rica. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>XIII. – {{ strtoupper('Arbitraje/ Leyes Gubernamentales') }}</b></p>
                    <p>Cualquier disputa entre el Cliente y el Proveedor que surja en virtud de este Acuerdo se resolverá mediante las Cortes de Costa Rica. </p>
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
                    <p>In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and content, for one sole purpose. The Parties do each hereby warrant and represent that their respective signatory is, as of the Effective Date, duly authorized by all necessary and appropriate corporate action to execute this Agreement. Subsequent addendums may later be incorporated if signed and agreed to by all Parties. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>En fe de lo cual, las Partes firman el presente Acuerdo en dos (2) ejemplares de igual forma y contenido, con un solo objeto. Cada una de las Partes garantiza y declara que su respectivo signatario está, a partir de la Fecha de entrada en vigencia, debidamente autorizado por todas las acciones corporativas necesarias y apropiadas para ejecutar este Acuerdo. Los apéndices subsiguientes pueden incorporarse posteriormente si todas las Partes los firman y acuerdan.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>{{ $employeeCity }}, {{ $formattedDate }} of {{ $month }} of {{ $year }}.</p>

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>INTERMEDIANO S.R.L. </b></p>

                        <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">Fernando Gutierrez</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">Legal Representative</p>
                    </div>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>{{ $employeeCity }}, {{$day}} de {{ $translatedMonth }} de {{ $year }}.</p>

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>INTERMEDIANO S.R.L. </b></p>

                        <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">Fernando Gutierrez</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">Legal Representative</p>
                    </div>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <div style="margin-top: 40px; margin-bottom: 75px">
                        <p style='text-align: center'><b>{{ $companyName }}</b></p>

                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>

                    <div style="text-align: center; margin-top: -20px">
                        <p style='text-align: center'>{{ $customerName }} {{ $contactSurname }}</p>
                        <p style="margin-top: -20px; text-align: center;">{{ $customerPosition }}</p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <div style="margin-top: 40px; margin-bottom: 75px">
                        <p style='text-align: center'><b>{{ $companyName }}</b></p>

                    </div>
                    <div style="width: 100%%; border-bottom: 1px solid black;"></div>

                    <div style="text-align: center; margin-top: -20px">
                        <p style='text-align: center'>{{ $customerName }} {{ $contactSurname }}</p>
                        <p style="margin-top: -20px; text-align: center;">{{ $customerTranslatedPosition }}</p>
                    </div>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top:-5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>SCHEDULE A</b></p>
                    <p style="text-align: center; font-weight: bold">Scope of Services</p>
                    <p><b>General Scope</b></p>
                    <p>Customer will either (a) present individuals to Provider that Customer’s Clients would like to engage, or (b) request staffing support from provider based on Customer’s Client’s requirements. When Customer requests staffing support, Provider will present candidates to Customer subject to final approval by Customer’s Client.</p>
                    <p><b>Employer of Record (“EOR”) Service</b></p>
                    <p>At Customer’s request, Provider will take whatever steps are necessary under local law to become the employer of record for candidates approved by Customer’s Client. By law, those individuals will be employees of Provider (“Workers”) for either an indefinite or definite period of time. Provider will place the Workers on engagement with Customer’s Client pursuant to Customer’s instructions.</p>
                    <p class='line-height-sm'>Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, , issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be charged separately by Provider, and payment shall be equally made as stated in clause. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>ANEXO A</b></p>
                    <p style="text-align: center; font-weight: bold">Alcance de los servicios</p>
                    <p><b>Alcance general</b></p>
                    <p class='line-height-sm'>El Cliente (a) presentará personas al Proveedor que a los Clientes del Cliente les gustaría contratar, o (b) solicitará apoyo de personal del proveedor según los requisitos del Cliente del Cliente. Cuando el Cliente solicite apoyo de personal, el Proveedor presentará candidatos al Cliente sujeto a la aprobación final por parte del Cliente del Cliente.</p>
                    <p><b>Servicio de empleador local ("EOR")</b></p>
                    <p class='line-height-sm'>A pedido del Cliente, el Proveedor tomará las medidas necesarias según la ley local para convertirse en el empleador registrado para los candidatos aprobados por el Cliente del Cliente. Por ley, esas personas serán empleados del Proveedor ("Trabajadores") por un período de tiempo indefinido o definido. El Proveedor pondrá a los Trabajadores en compromiso con el Cliente del Cliente de conformidad con las instrucciones del Cliente.</p>
                    <p class='line-height-sm'>El proveedor gestionará todas las obligaciones legales, fiscales, administrativas y similares del empleador en virtud de la legislación local. Eso incluye, pero no se limita a, ejecutar un contrato de trabajo adecuado con el Trabajador, verificar la identidad del Trabajador y su derecho legal a trabajar, emitir salarios apropiados, cobrar/remitir cargas sociales e impuestos o similares según lo exija la ley local, y desvincular a un trabajador de manera obediente. Los costos adicionales de participación, que no forman parte del proceso de contratación regular, como la verificación de antecedentes, serán cobrados por separado por el Proveedor, y el pago se realizará de manera equitativa según lo establecido en la cláusula.</p>
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
                    <p class='line-height-sm'>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class='line-height-sm'>A lo largo de la contratación del Trabajador, el Cliente actuará como enlace entre el Cliente/Trabajador del Cliente y el Proveedor en lo que se refiere a cualquier cambio en la tasa de pago, necesidades de reembolso, vacaciones anuales, consultas por despido y similares. El Proveedor acepta proporcionar al Cliente de inmediato cualquier información que necesite para garantizar que el Cliente y el Trabajador del Cliente estén informados de cualquier matiz legal local.</p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Provider’s fee for its EOR Service shall be 12% over the total gross earnings of the Worker´s for the related countries: Chile, Colombia, Costa Rica, Peru and Uruguay, considered a minimum fee of USD350,00. For other Countries not listed herein, shall be checked case by case. Provider shall invoice the EOR service fees as a separate line item on each invoice. </p>
                    <p><b>Staffing Service</b></p>
                    <p>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. </p>
                    <p>In the event that Provider presents the same candidate to Customer as another vendor, the search firm that presented the candidate to Customer first shall be deemed to have made the placement. Timing will be determined based on the time of receipt by Customer.</p>
                    <p>Once a candidate is approved by Customer’s Client, Provider may either be asked to provide its EOR service for that individual (“Contract Staffing”) or Customer’s Client will elect to employ the individual themselves or through another vendor (“Direct Hire”). </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>La tarifa del Proveedor por su Servicio EOR será del 12% sobre el total de los ingresos brutos del Trabajador para los países relacionados: Chile, Colombia, Costa Rica, Perú y Uruguay, considerando una tarifa mínima de USD 350,00. Para otros Países no enumerados aquí, se verificará caso por caso. El proveedor deberá facturar las tarifas del servicio EOR como una línea separada en cada factura.</p>
                    <p><b>Servicio de dotación de personal</b></p>
                    <p>A pedido del Cliente, el Proveedor reclutará, examinará y entrevistará a los candidatos de conformidad con los requisitos del Cliente del Cliente según lo comunicado por el Cliente y de Contrato con la legislación local. El Proveedor presentará dichos candidatos al Cliente sujeto a la aprobación final por parte del Cliente del Cliente.</p>
                    <p>En el caso de que el Proveedor presente el mismo candidato al Cliente que otro proveedor, se considerará que la empresa de búsqueda que presentó el candidato al Cliente en primer lugar realizó la colocación. El tiempo se determinará en función del momento de recepción por parte del Cliente.</p>
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
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Una vez que el Cliente del Cliente aprueba a un candidato, se le puede solicitar al Proveedor que brinde su servicio EOR para esa persona ("Contratación de personal") o el Cliente del Cliente elegirá emplear a la persona por sí mismo o a través de otro proveedor ("Contratación directa").</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Fees for Contract Staffing will be agreed upon in writing on a case-by-case basis.</p>
                    <p>In all Direct Hire cases, Customer will pay Provider a placement fee of 18% of that Direct Hire’s gross annual salary. Such fee is subject to Customer’s Client (or a vendor) issuing a formal job offer and the candidate accepting the same. If the candidate resigns or Customer’s Client terminates the engagement for any reason within the first 90 (ninety) days, Provider will replace the Direct Hire individual at no cost, Provider will replace the direct hire, at no recruiting cost, as far the recruitment has been done by the Provider. In this case, Customer shall pay for all termination cost related the Worker.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Los honorarios por contratación de personal se acordarán por escrito caso por caso.</p>
                    <p>En todos los casos de Contratación Directa, el Cliente pagará al Proveedor una tarifa de colocación del 18 % del salario bruto anual de esa Contratación Directa. Dicha tarifa está sujeta a que el Cliente del Cliente (o un proveedor) emita una oferta de trabajo formal y el candidato acepte la misma. Si el candidato renuncia o el Cliente del Cliente finaliza el compromiso por cualquier motivo dentro de los primeros 90 (noventa) días, el Proveedor reemplazará a la persona de Contratación Directa sin costo alguno, el Proveedor reemplazará a la contratación directa, sin costo de contratación, en la medida en que la contratación haya sido realizado por el Proveedor. En este caso, el Cliente deberá pagar todos los costos de terminación relacionados con el Trabajador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center; font-weight: bold;">SCHEDULE B</p>
                    <p style="text-align: left; font-weight: bold">A) WORKER DETAILS:</p>
                    <p>NAME OF WORKER: {{ $employeeName }}</p>
                    <p>COUNTRY OF WORK: {{ $employeeCountryWork }}</p>
                    <p>JOB TITLE: {{ $employeeJobTitle }}</p>
                    <p>START DATE: {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>End DATE: {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>GROSS WAGES: {{ number_format($record->gross_salary, 2) }} as gross monthly salary. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p style="text-align: center; font-weight: bold;">ANEXO B</p>
                    <p style="text-align: left; font-weight: bold">A) DATOS DEL TRABAJADOR:</p>
                    <p>Nombre del Trabajador: {{ $employeeName }}</p>
                    <p>País de Trabajo: {{ $employeeCountryWork }}</p>
                    <p>Título del Puesto: {{ $employeeJobTitle }}</p>
                    <p>Fecha de Inicio: {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>Fecha de Finalización: {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('F j, Y') : 'N/A' }}</p>
                    <p>Salario Bruto: {{ number_format($record->gross_salary, 2) }} as gross monthly salary. </p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main style='page-break-after: avoid'>
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>DATE OF PAYMENT (every month):</b> Local legislation requires payment by last day of the month. For efficiency, Provider will issue payment on the last day of every month.</p>
                    <p><b>LOCAL PAYMENT CONDITIONS:</b> Salaries and/or any other remuneration is set at the local currency of the Country where services is provided.</p>
                    <p><b>B) FEES AND PAYMENT TERMS</b></p>
                    <p><b>PAYMENT TERMS</b></p>
                    <p><b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below: The Customer pays the Provider a monthly fee based on the calculations below: </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>FECHA DE PAGO (todos los meses):</b> La legislación local exige el pago antes del último día del mes. Para mayor eficiencia, el Proveedor emitirá el pago el último día de cada mes.</p>
                    <p><b>CONDICIONES DE PAGO LOCALES:</b> Los salarios y/o cualquier otra remuneración se fijan en la moneda local del País donde se prestan los servicios.</p>
                    <p><b>B) HONORARIOS Y CONDICIONES DE PAGO</b></p>
                    <p><b>TÉRMINOS DE PAGO</b></p>
                    <p>TARIFAS: El Cliente pagará al Proveedor mensualmente, según el cálculo a continuación: El Cliente paga al Proveedor una tarifa mensual según los cálculos a continuación:</p>
                </td>
            </tr>
        </table>
        <div style="margin-top: 20px !important">
            @include('pdf.costa_rica_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        <table>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In addition to the monthly fee, there may be additional costs required by law in the Country where the Services are being rendered. Additional costs may apply in the following cases that Provider cannot anticipate or predict, as following:</p>
                    <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR</p>
                    <p><b>(ii)</b> Any eventual local Government measures will be charged just in case there is any changing in the local legislation.
                        Considering the Worker is an independent contractor there should be no additional fee.
                    </p>
                    <p><b>C) LOCAL LEGISLATION - PREVAILS</b></p>
                    <p>The law that will govern the Worker’s engagement including their rights as an employee will be the law of the country where the Worker is providing the services., The Parties agree that all applicable law including but not limited to, labor and tax, and must be fully complied with the purposes of the local and global compliance guidelines.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Además de la tarifa mensual, puede haber costos adicionales requeridos por la ley en el País donde se prestan los Servicios. Se pueden aplicar costos adicionales en los siguientes casos que el Proveedor no puede anticipar o predecir, de la siguiente manera:</p>
                    <p><b>(i)</b> Bonos adicionales otorgados por el cliente del Cliente; O</p>
                    <p><b>(ii)</b> Cualquier eventual medida del gobierno local se cobrará en caso de que haya algún cambio en la legislación local.
                        Teniendo en cuenta que el trabajador es un contratista independiente, no debería haber una tarifa adicional.
                    </p>
                    <p><b>C) LEGISLACIÓN LOCAL - PREVALECE</b></p>
                    <p>La ley que regirá la contratación del Trabajador, incluidos sus derechos como empleado, será la ley del país donde el Trabajador preste los servicios. Las Partes acuerdan que toda la ley aplicable, incluida, entre otras, la laboral e impuestos, y debe cumplirse a cabalidad con los propósitos de los lineamientos de cumplimiento locales y globales.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

</body>

</html>
