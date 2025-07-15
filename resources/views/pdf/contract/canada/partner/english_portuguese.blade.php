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

$signatureExists = Storage::disk('private')->exists($record->signature);
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
                    <p>This Payroll and HR Service Agreement (the “Agreement”) is made on {{ $contractCreatedDay }} of {{ $contractCreatedmonth }}, {{ $contractCreatedyear }} (the “Effective Date”), by and between <b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA</b> (the <b>“Provider”</b>), a Brazilian company, enrolled under the fiscal registration number 46.427.519/0001-51, located at Avenida das
                        Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, Brazil, duly represented by its legal representative;
                        AND <b>GATE INTERMEDIANO INC.</b> (the
                        <b>“Customer”</b>), a Canadian company, enrolled under the fiscal registration number 733087506RC0001, located at 4388 Rue SaintDenis Suite200 #763, Montreal, QC H2J 2L1, Canada, duly represented by its authorized representative, (each, a “Party” and together, the “Parties”).
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO DE PARCERIA</h4>
                    <p>Este Contrato de Serviços de Folha de Pagamento e Recursos Humanos (o "Contrato") é celebrado em {{ $contractCreatedDay }}, {{ $contractCreatedmonth }}, {{ $contractCreatedyear }} (a <b>"Data de Vigência"</b>), por e entre <b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA</b> (o <b>“Fornecedor”</b>), uma empresa brasileira, inscrita no número de registro empresarial 46.427.519/0001-51, localizada na Avenida das Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, Brasil, devidamente representada pelo seu representante legal; E <b>GATE INTERMEDIANO INC.</b> (o <b>“Cliente”</b>), uma empresa Canadense, inscrita sob o número de registro fiscal 733087506RC0001, localizada em 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada, devidamente representada por seu representante autorizado, (cada um, uma "Parte" e, em conjunto, as "Partes"). </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services globally either directly or indirectly through its local partners; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO QUE,</b> o Fornecedor fornece determinados serviços de folha de pagamento, impostos e recursos humanos globalmente, direta ou indiretamente por meio de seus parceiros locais; </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> Customer also provides certain payroll, tax, and human resource services globally for its clients (“Customer’s Clients”); and </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO que</b> o Cliente também fornece determinados serviços de folha de pagamento, impostos e recursos humanos em todo o mundo para seus clientes (“Clientes do
                        Cliente”); e
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS</b> the Parties wish to enter into this Partnership Agreement to enable Provider to provide its services to Customer for the benefit of Customer’s Clients on the terms and conditions set forth herein. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO QUE,</b> as Partes desejam celebrar este Contrato de Parceria para permitir que o Fornecedor forneça seus serviços ao Cliente em benefício dos Clientes do Cliente sob os termos e condições aqui estabelecidos. </p>
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
                    <p><b>WHEREAS</b> the Parties wish to enter into this Partnership Agreement to enable Provider to provide its services to Customer for the benefit of Customer’s Clients on the terms and conditions set forth herein. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONSIDERANDO QUE,</b> as Partes desejam celebrar este Contrato de Parceria para permitir que o Fornecedor forneça seus serviços ao Cliente em benefício dos Clientes do Cliente sob os termos e condições aqui estabelecidos. </p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOW, THEREFORE,</b> in consideration of the premises and the mutual covenants set forth herein, the Parties hereby agree as follows: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>AGORA, PORTANTO</b>, em consideração às premissas e acordos mútuos estabelecidos neste documento, as Partes acordam o seguinte:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">I. PURPOSE</b>
                    <p><b>Service Offerings.</b> Provider shall provide to Customer the services of staffing, outsourcing payroll, consulting, and HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein (collectively, the “Services”), during the Term (defined in Section VI) subject to the terms and conditions of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">I.- OBJETO</b>
                    <p><b>Ofertas de Serviços.</b> O Fornecedor deverá fornecer ao Cliente os serviços de pessoal, terceirização de folha de pagamento, consultoria e RH anexados a este como Anexo A (o "Anexo A") e aqui incorporados (coletivamente, os "Serviços"), durante o Prazo (definido na Seção VI) sujeito aos termos e condições deste Contrato.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">II. – PROVIDER RESPONSIBILITIES</b>
                    <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby undertakes to:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">II. – RESPONSABILIDADES DO FORNECEDOR</b>
                    <p>Não obstante as outras obrigações sob este Contrato, o Provedor; comprometese a:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> to meet the requirements and quality standards required by Customer, which may periodically review the Services performed by the Provider;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> atender aos requisitos e padrões de qualidade exigidos pelo Cliente, que poderá revisar periodicamente os Serviços executados pelo Prestador;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> to collect all taxes related to its activities, considering local applicable law where the services are being rendered;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> arrecadar todos os tributos relativos às suas atividades, considerando a legislação local aplicável onde os serviços estão sendo prestados;</p>
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
                    <p><b>(c)</b> to provide, whenever customer requests it, all reports, spreadsheets, and other information relating to the Services and the country’s requirements; </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> fornecer, sempre que o cliente o solicite, todos os relatórios, planilhas e outras informações relativas aos Serviços e às exigências do país;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters, in particular, but not limited to, those related to the protection of the environment, exempting Customer and Customer’s Client from any responsibility resulting therefrom. Therefore, the Provider declares in this Agreement that its activities and Services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment; and</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> cumprir todas as leis globais e locais, decretos, regulamentos, resoluções, decisões, normas e demais disposições consideradas por lei relativas à prestação do serviço e questões trabalhistas, em particular, mas não limitado a aquelas relacionadas a proteção do ambiente, isentando o Cliente e o Cliente do Cliente de qualquer responsabilidade daí resultante. Portanto, a Prestadora declara neste Contrato que suas atividades e Serviços, utilizados agora e no futuro, atendem à legislação e às normas de proteção e segurança relativas a saneamento e meio ambiente; e</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e)</b> to have and maintain any needed licenses, registrations, or the like to provide the Services outlined herein. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e)</b> ter e manter quaisquer licenças, registros ou similares necessários para fornecer os Serviços descritos neste documento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">III – CUSTOMER RESPONSABILITIES:</b>
                    <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby undertakes to:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">III – RESPONSABILIDADES DO CLIENTE:</b>
                    <p>Não obstante as outras obrigações decorrentes deste Contrato, o Cliente, por meio deste, comprometese a:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> to process the monthly payment to the Provider set forth in Schedule B (the “Schedule B”);</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> processar o pagamento mensal ao Provedor estabelecido no Anexo B (o "Anexo B");</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> to abide by and require Customer’s Clients to abide by Provider’s instructions concerning the local labor legislation, considering where the service is being provided; and</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> cumprir e exigir que os Clientes do Cliente cumpram as instruções do Prestador relativas à legislação trabalhista local, considerando onde o serviço está sendo prestado; e</p>
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
                    <p><b>(c)</b> to supply the technical information required for the Services to be performed.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> fornecer as informações técnicas necessárias para que os Serviços sejam executados.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IV – PAYMENT AND FEES:</b>
                    <p><b>(a)</b> For the Services agreed herein, Customer shall pay to the Provider the amount the Parties agreed upon in writing in the format outlined in Schedule B or substantially similar thereto for each Worker or Service. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IV – PAGAMENTO E TAXAS:</b>
                    <p><b>(a)</b> Para os Serviços aqui acordados, o Cliente deverá pagar ao Prestador o valor acordado pelas Partes por escrito no formato descrito no Anexo B ou substancialmente semelhante para cada Trabalhador ou Serviço.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b) INVOICE:</b> Provider will issue a monthly invoice to the Customer up to the 10th day of the month and Customer shall pay to Provider within 10 (ten) days of receipt of the invoice of the same month the invoice was issued. The invoice will include the Worker’s gross renumeration (e.g., salary, bonuses, commissions, allowances, etc.), any mandatory employer costs (e.g., social security contributions, other taxes etc.), and Provider’s fee.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b) FATURA:</b> A Prestadora emitirá uma fatura mensal ao Cliente até o 10º dia do mês e o Cliente deverá pagar à Prestadora no prazo de 10 (dez) dias do recebimento da fatura do mesmo mês em que a fatura foi emitida. A fatura incluirá a renumeração bruta do Trabalhador (por exemplo, salário, bônus, comissões, subsídios, etc.), quaisquer custos obrigatórios do empregador (por exemplo, contribuições para a previdência social, outros impostos etc.) e a taxa do Provedor.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) DUE DATE:</b> Customer shall pay Provider within 10 (ten) days of receipt of the invoice by Provider. Undisputed invoices that remain unpaid past the due date will be subject to a penalty fee equal to 3%.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) DATA DE VENCIMENTO:</b> O Cliente deverá pagar ao Provedor no prazo de 10 (dez) dias após o recebimento da fatura pelo Provedor. As faturas não contestadas que permanecerem não pagas após a data de vencimento estarão sujeitas a uma multa de 3%.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) EXCHANGE RATE:</b> Invoices will be issued in USD based on the exchange rate of the date of the issuance of the invoice, considering the 3.5% margin of risk in favor of Provider. For clarity, this means that all exchange rates used to convert to USD will be increased by 3.5%. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) TAXA DE CÂMBIO:</b> As faturas serão emitidas em USD com base na taxa de câmbio da data de emissão da fatura, considerando a margem de risco de 3,5% a favor da Prestadora. Para maior clareza, isso significa que todas as taxas de câmbio usadas para converter para USD aumentarão em 3,5%.</p>
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
                    <b style="text-decoration: underline;">V. - CONFIDENCIALIDADE</b>
                    <p><b>(a)</b> Tanto o Cliente quanto o Provedor reconhecem que em razão de seu relacionamento com a outra parte sob este Contrato, ele terá acesso e adquirirá conhecimento, material, dados, sistemas e outras informações relativas à operação, negócios, assuntos financeiros e propriedade intelectual da outra Parte ou Cliente do Cliente, que pode não ser acessível ou conhecida do público em geral, incluindo, mas não se limitando aos termos deste Contrato (referido como "Informações Confidenciais").</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> NonDisclosure/Use. Each of Customer and Provider agrees that it will: (i) maintain and preserve the confidentiality of all Confidential Information received from the other party (the "Disclosing Party''), both orally and in writing, including taking such steps to protect the confidentiality of the Disclosing Party's Confidential Information as the party receiving such Confidential Information (the "Receiving Party") takes to protect the confidentiality of its own confidential or proprietary information; provided, however, that in no instance shall the Receiving Party use less than a reasonable standard of care to protect the Disclosing Party's Confidential Information; (ii) disclose such Confidential Information only to its own employees on a "need to know" basis, and only to those employees who have agreed to maintain the confidentiality thereof pursuant to a written agreement containing terms at least as stringent as those set forth in this Agreement; (iii) not disassemble, "reverse engineer" or "reverse compile" such software for any purpose in the event that software is involved;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(b)</b> Não Divulgação/Uso. O Cliente e o Provedor concordam que: (i) manterá e preservará a confidencialidade de todas as Informações Confidenciais recebidas da outra parte (a "Parte Divulgadora''), tanto oralmente quanto por escrito, inclusive tomando as medidas necessárias para proteger a confidencialidade das Informações Confidenciais da Parte Divulgadora, conforme a parte que recebe tais Informações Confidenciais (a "Parte Receptora") para proteger a confidencialidade de suas próprias informações confidenciais ou proprietárias; desde que, no entanto, em nenhuma instância a Parte Receptora use menos do que um padrão razoável de cuidado para proteger as Informações Confidenciais da Parte Divulgadora; (ii) divulgar tais Informações Confidenciais apenas para seus próprios funcionários em uma base de "necessidade de conhecimento", e apenas para os funcionários que concordaram em manter a confidencialidade de acordo com um contrato escrito contendo termos pelo menos tão rigorosos quanto os estabelecidos neste Contrato; (iii) não desmontar, "inverter e engenharia" ou "compilação reversa" de tal software para qualquer finalidade, caso o software esteja envolvido; </p>
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
                    <p>e (iv) não divulgar tais Informações Confidenciais a terceiros sem o consentimento prévio por escrito da Parte Divulgadora; desde que, no entanto, cada parte possa divulgar os termos financeiros deste Contrato a seus consultores jurídicos e comerciais e a potenciais investidores, desde que tais terceiros concordem em manter a confidencialidade de tais Informações Confidenciais. Cada Parte Receptora concorda ainda em usar as Informações Confidenciais da Parte Divulgadora apenas com a finalidade de cumprir suas obrigações sob este Contrato. A obrigação de confidencialidade da Parte Receptora sobreviverá a este Contrato por um período de 5 (cinco) anos a partir da data de sua rescisão ou expiração e, posteriormente, será rescindida e não terá mais força ou efeito; desde que, no entanto, com relação às Informações Confidenciais que constituam um segredo comercial, tais informações permaneçam confidenciais enquanto tais informações continuarem sendo um segredo comercial. As partes também concordam mutuamente em (1) não alterar ou remover qualquer identificação ou aviso de qualquer direito autoral, marca registrada ou outros direitos de propriedade que indiquem a propriedade de qualquer parte das Informações Confidenciais da Parte Divulgadora; e (2) notificar a Parte Divulgadora das circunstâncias em torno de qualquer posse ou uso das Informações Confidenciais por qualquer pessoa ou entidade que não aquelas autorizadas sob este Contrato.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) Exclusions.</b> Each of Customer’s and Provider’s obligations in the preceding paragraph above shall not apply to Confidential Information which the Receiving Party can prove: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) Exclusões.</b> Cada uma das obrigações do Cliente e do Provedor no parágrafo anterior acima não se aplicará às Informações Confidenciais que a Parte Receptora possa provar: </p>
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
                    <p style='line-height: 1.5'><b>(i)</b> tornouse uma questão de conhecimento público sem culpa, ação ou omissão de ou pelo Receptor Festa; (ii) estava legitimamente na posse da Parte Receptora antes da divulgação pela Parte Divulgadora; (iii) após a divulgação pela Parte Divulgadora, foi legitimamente obtida pela Parte Receptora de um terceiro que estava legalmente na posse de tais Informações Confidenciais sem restrição; (iv) foi desenvolvido de forma independente pela Parte Receptora sem recorrer às Informações Confidenciais da Parte Divulgadora; ou (v) deve ser divulgado pela Parte Receptora de acordo com a lei, ordem judicial ou qualquer regulamento aplicável (incluindo quaisquer regras e regulamentos aplicáveis da bolsa de valores); desde que, no entanto, no caso de divulgações feitas de acordo com a cláusula (vi) anterior, a Parte Receptora deve fornecer notificação prévia por escrito à Parte Divulgadora de qualquer divulgação legalmente exigida das Informações Confidenciais da Parte Divulgadora o mais rápido possível em para dar à Parte Divulgadora a oportunidade de buscar uma ordem de proteção, ou, no caso de tal ordem não poder ser obtida, a divulgação pode ser feita de forma a minimizar ou eliminar qualquer responsabilidade potencial.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> Provider agrees that it will require every Worker to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d)</b> O Provedor concorda que exigirá que cada Trabalhador concorde com os termos de confidencialidade substancialmente semelhantes aos descritos neste documento para proteger as Informações Confidenciais do Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e)</b> Should Provider engage vendors, it will require every such vendor to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(e)</b> Se o Provedor contratar fornecedores, ele exigirá que cada um desses fornecedores concorde com termos de confidencialidade substancialmente semelhantes aos descritos neste documento para proteger as Informações Confidenciais do Cliente e do Cliente do Cliente.</p>
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
                    <b style="text-decoration: underline;">VI. - PROTEÇÃO DE DADOS GDPR</b>
                    <p>Qualquer informação que contenha dados pessoais deve ser tratada por ambas as Partes de acordo com todas as leis e regulamentos de privacidade aplicáveis, incluindo, sem limitação, o GDPR e leis e regulamentos equivalentes. Se para a execução dos Serviços for necessário trocar dados pessoais, as Partes relevantes determinarão suas respectivas posições em relação umas às outras (como controlador, controlador conjunto ou processador) e as consequências e responsabilidades subsequentes. de acordo com o GDPR o mais rápido possível. Para evitar dúvidas, a posição de cada Parte pode mudar dependendo das circunstâncias de cada situação.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VII. INTELLECTUAL AND INDUSTRIAL PROPERTY </b>
                    <p><b>(a)</b> Every document, report, data, know how, method, operation, design, trademarks confidential information, patents and any other information provided by Customer to the Provider shall be and remain exclusive property of the Customer that disclosed the information.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VII - PROPRIEDADE INTELECTUAL E INDUSTRIAL</b>
                    <p><b>(a)</b> Todo documento, relatório, dados, know how, método, operação, design, informações confidenciais de marcas registradas, patentes e qualquer outra informação fornecida pelo Cliente ao Provedor será e permanecerá propriedade exclusiva do Cliente que divulgou as informações.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> Após a rescisão ou expiração deste instrumento, nenhuma das Partes deverá usar marcas ou nomes que possam ser semelhantes aos da outra Parte e/ou que possam ser de alguma forma confundidos por clientes e empresas. Cada Parte comprometese a envidar seus melhores esforços para evitar erros ou divulgação indevida das marcas e nomes das outras Partes por pessoas não autorizadas.</p>
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
                    <p><b>(c) </b> O Prestador concorda que tudo o que for fornecido a ele ou aos Trabalhadores pelo Cliente do Cliente permanece propriedade do Cliente do Cliente e que nenhum direito, título ou interesse é transferido para o Prestador ou Trabalhadores, incluindo a recuperação de tal propriedade; isso inclui laptops da empresa, telefones, cartões de crédito etc. O Provedor também concorda que todos os direitos de propriedade e interesse no produto de trabalho (incluindo, entre outros, propriedade intelectual, software, trabalhos de autoria, segredos comerciais, designs, dados ou outras informações proprietárias) produzidas pelo Prestador ou Trabalhadores sob este Contrato são de propriedade exclusiva do Cliente do Cliente. O Provedor concorda ainda em ceder, ou fazer com que seja atribuído de tempos em tempos, ao Cliente do Cliente em uma base exclusiva todos os direitos, títulos e interesses e para o produto de trabalho produzido pelo Provedor ou Trabalhadores sob este Contrato, incluindo quaisquer direitos autorais, patentes, direitos de trabalho de máscara ou outros direitos de propriedade intelectual a eles relacionados, em perpetuidade ou pelo período mais longo permitido pela lei aplicável. O Provedor concorda que não deve usar o produto de trabalho em benefício de qualquer parte que não seja o Cliente do Cliente. Nada nesta Subseção se aplicará a qualquer material protegido por direitos autorais, notas, registros, desenhos, projetos, Inovações, melhorias, desenvolvimentos, descobertas e segredos comerciais concebidos, feitos ou descobertos pelo Provedor antes da Data de Vigência deste Contrato.</p>
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
                    <p><b>(d)</b> O Prestador exigirá que cada Trabalhador atribuído ao Cliente do Cliente concorde que, na extensão máxima permitida por lei, todas as invenções, desenvolvimentos ou melhorias concebidas ou criadas por tal Trabalhador enquanto estiver prestando serviços sob este Contrato, que relacionados ao trabalho ou projetos para o Cliente do Cliente, serão de propriedade exclusiva do Cliente do Cliente, e atribuir e transferir ao Cliente do Cliente (ou ao Provedor para posterior atribuição ao Cliente e, em última análise, ao Cliente do Cliente) todos os direitos do Trabalhador direito, título e interesse em e para tais invenções, desenvolvimentos ou melhorias e para quaisquer Patentes de Carta, Direitos Autorais e pedidos relativos a eles. O Provedor concorda que qualquer propriedade intelectual criada durante o envolvimento de um Trabalhador com o Cliente do Cliente permanece propriedade do Cliente do Cliente conforme descrito neste documento, mesmo que a lei local considere tal trabalho propriedade do empregador. A pedido e orientação do Cliente, o Prestador concorda em tomar todas as medidas necessárias, incluindo as descritas neste documento, conforme aplicável, para efetivar os direitos do Cliente do Cliente sobre a propriedade intelectual produzida durante o contrato de um Trabalhador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VIII. – MUTUAL INDEMNIFICATION</b>
                    <p><b>1)</b> Each Party shall indemnify, defend, and hold the other harmless against any loss, liability, cost, or expense (including reasonable legal fees) related to any third party claim or action that: </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">VIII. – INDENIZAÇÃO MÚTUA</b>
                    <p><b>1)</b> Cada Parte deverá indenizar, defender e isentar a outra de qualquer perda, responsabilidade, custo ou despesa (incluindo honorários advocatícios razoáveis) relacionados a qualquer reclamação ou ação de terceiros que: </p>
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
                    <p>(i) se verdadeira, seria uma violação de qualquer condição, garantia ou representação feita pela parte indenizadora de acordo com este Contrato; ou (ii) resulte de um ato ilegal (incluindo, mas não limitado a discriminação, retaliação e/ou assédio), ato negligente ou omissão de agir por parte da parte indenizadora ou seus funcionários ou agentes sob este Contrato . Essas obrigações de indenização estarão condicionadas à Parte que busca ser indenizada: (i) notificar imediatamente por escrito a parte indenizadora de qualquer reclamação, demanda ou ação para a qual a indenização seja solicitada; (ii) cooperar razoavelmente na defesa ou resolução de qualquer reclamação, demanda ou ação; e (iii) obter o prévio acordo por escrito da parte indenizadora para qualquer acordo ou proposta de acordo, o qual não poderá ser retido injustificadamente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>2)</b> During the Term, and for a period of two years following the effective date of termination, the Customer will, at its own expense, ensure that it maintains adequate insurance (including cover for, without limitation, public liability, labor liabilities and business interruption) in respect of its potential liability for loss or damage arising under or in connection with this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>2)</b> Durante o Prazo, e por um período de dois anos após a data efetiva de rescisão, o Cliente irá, às suas próprias custas, assegurar que mantém um seguro adequado (incluindo cobertura para, sem limitação, responsabilidade pública, responsabilidades trabalhistas e interrupção de negócios) em relação à seu potencial responsabilidade por perdas ou danos decorrentes ou relacionados a este Contrato;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IX. – TERM AND TERMINATION </b>
                    <p>This Agreement shall be in force and remain valid for undetermined period. Each of the Parties is free to terminate this Agreement at any time without cause by previous written notice of 60 (sixty) days. Exception is made if the Worker resigns at his/her own discretion, in which the period of 30 (thirty) days shall prevail. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">IX. – PRAZO E RESCISÃO</b>
                    <p>Este Contrato entrará em vigor e permanecerá válido por período indeterminado. Cada uma das Partes é livre para rescindir este Contrato a qualquer momento, sem justa causa, mediante aviso prévio por escrito de 60 (sessenta) dias. Exceção é feita se o Trabalhador pedir demissão a seu critério, prevalecendo o prazo de 30 (trinta) dias.</p>
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
                    <p>O Contrato poderá ser rescindido por justa causa independentemente de qualquer aviso prévio, na ocorrência dos seguintes eventos pelas Partes:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> consecutives delays or failure to comply by Customer with the payments due to the Provider remuneration or repeated nondelivery or late delivery of the Services by the Provider, only after Provider has given Customer a 2 (two)months previous notice of the potential of termination and provided Customer at least 30 (thirty) days’ notice to cure it. Exception to the previous notice period will apply in case the Worker resigns at his/her own discretion, as beyond the will of the Parties. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(a)</b> atrasos consecutivos ou incumprimento por parte do Cliente dos pagamentos devidos à remuneração do Prestador ou não entrega repetida ou entrega tardia dos Serviços pelo Prestador, apenas após o Prestador ter dado ao Cliente um prazo de 2 (dois) meses aviso prévio do potencial de rescisão e aviso prévio de pelo menos 30 (trinta) dias ao Cliente para sanálo. Exceção ao período de aviso prévio se aplicará caso o Trabalhador renuncie a seu próprio critério, como além da vontade das Partes.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> if any Party breaches any term or condition of this Agreement and fails to remedy to such failure within fifteen (15) days from the date of receipt of written notification from the other Party;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(b)</b> se qualquer Parte violar qualquer termo ou condição deste Contrato e não sanar tal descumprimento no prazo de quinze (15) dias a partir da data de recebimento da notificação por escrito da outra Parte;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> If either Party becomes or is declared insolvent or bankrupt, is the subject of any proceedings relating to its liquidation or insolvency or for the appointment of a receiver, conservator, or similar officer, or makes an assignment for the benefit of all or substantially all of its creditors or enters into any agreement for the composition, extension, or readjustment of all or substantially all of its obligations, then the other party may, by giving prior written notice thereof to the nonterminating Party, terminate this Agreement as of a date specified in such notice.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c)</b> Se qualquer uma das Partes se tornar ou for declarada insolvente ou falida, for objeto de qualquer processo relacionado à sua liquidação ou insolvência ou à nomeação de um administrador judicial, conservador ou funcionário similar, ou fizer uma cessão em benefício de todos ou substancialmente todos os seus credores ou celebra qualquer acordo para a composição, extensão ou reajuste de todas ou substancialmente todas as suas obrigações, então a outra parte poderá, mediante prévio escrito dez avisos para a Parte não rescindível, rescindir este Contrato a partir da data especificada em tal aviso.</p>
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
                    <p>Após a rescisão deste Contrato ou em sua rescisão, o Provedor se compromete a;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> return to Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by Customer in relation to the Services agreed upon in this Agreement;</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a)</b> devolver ao Cliente, no dia da rescisão deste Contrato, todo e qualquer equipamento, material promocional e outros documentos que tenham sido fornecidos pelo Cliente em relação aos Serviços acordados neste Contrato;</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respect and comply with Agreement before the effective termination date; and</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>b)</b> respeitar e cumprir o Contrato antes da data de rescisão efetiva; e</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> If required by Customer, Provider shall deliver to Customer the legal offboarding documentation referred to the worker.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c)</b> Se exigido pelo Cliente, o Prestador deverá entregar ao Cliente a documentação legal de desligamento referente ao trabalhador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">X – ACT OF GOD OR FORCE MAJEURE</b>
                    <p>In the event either Party is unable to perform its obligations under the terms of this Agreement because of acts of God or force majeure, such party shall not be liable for damages to the other for any damages resulting from such failure to perform or otherwise from such causes.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">X - ATO DE FORÇA OU FORÇA MAIOR</b>
                    <p>No caso de qualquer uma das Partes não poder cumprir suas obrigações sob os termos deste Contrato por causa de caso fortuito ou força maior, tal parte não será responsável por danos à outra por quaisquer danos resultantes de tal falha no cumprimento ou de outra forma de tal causas.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XI – MISCELLANEOUS PROVISIONS</b>
                    <p><b>PROVIDER´S LOCAL PARTNER:</b> In the event Provider indicates any local Partner in a Statement of Work (“SOW”), the Customer will not communicate directly to the local partner (i.e., emails, any correspondence, phone call, and so on) at any time without Provider’s written permission. Provider will be the primary and only point of contact for the entire negotiation and after its expiration in order to avoid damages and losses to the Provider. This provision is valid up to a period of 5 (five) years after the expiration of the Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XI – MISCELLANEOUS PROVISIONS</b>
                    <p><b>PROVIDER´S LOCAL PARTNER:</b> In the event Provider indicates any local Partner in a Statement of Work (“SOW”), the Customer will not communicate directly to the local partner (i.e., emails, any correspondence, phone call, and so on) at any time without Provider’s written permission. Provider will be the primary and only point of contact for the entire negotiation and after its expiration to avoid damages and losses to the Provider. This provision is valid up to a period of 5 (five) years after the expiration of the Agreement.</p>
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
                    <p><b>BENEFÍCIOS:</b> Cliente, Prestador e Trabalhadores não têm quaisquer direitos ou interesses nos benefícios de funcionários do Cliente do Cliente, planos de pensão, planos de ações, participação nos lucros, 401k ou outros benefícios adicionais que são fornecidos aos funcionários do Cliente pelo Cliente do Cliente. Todos os Trabalhadores contratados pelo Provedor para o Cliente devem seguir a legislação local e os custos serão inteiramente cobertos pelo Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>INDEPENDENT CONTRACTOR:</b> Parties hereby agree that Provider is not employed by Customer, and nothing in this Agreement shall be construed as creating any partnership, joint venture or other relationship between Provider and Customer or Customer’s Client. This is not a contract of employment. Provider’s relationship with respect to Customer is that of an independent contractor. At no time during the term of this Agreement will Provider be Customer’s agent or have any right, authority or power to enter into any commitments on behalf of Customer unless specifically authorized by an officer of Customer in writing. Nothing in this Agreement shall be deemed to create any employeremployee relationship between Customer and Provider and the parties expressly agree that no joint employer relationship shall exist with respect to the Workers who at all times shall remain employees of Provider.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>CONTRATADA INDEPENDENTE:</b> As partes concordam que o Prestador não é empregado pelo Cliente, e nada neste Contrato deve ser interpretado como a criação de qualquer parceria, joint venture ou outro relacionamento entre o Prestador e o Cliente ou o Cliente do Cliente. Este não é um contrato de trabalho. A relação do Provedor com relação ao Cliente é a de um contratado independente. Em nenhum momento durante a vigência deste Contrato o Prestador será o agente do Cliente ou terá qualquer direito, autoridade ou poder para firmar quaisquer compromissos em nome do Cliente, a menos que especificamente autorizado por um funcionário do Cliente por escrito. Nada neste Contrato deve ser considerado para criar qualquer relação empregadorempregado entre o Cliente e o Prestador e as partes concordam expressamente que não existirá nenhuma relação empregadora conjunta com relação aos Trabalhadores que em todos os momentos permanecerão funcionários do Prestador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NON-COMPETE:</b> Provider hereby agrees that throughout this Agreement and for one year thereafter, it will not engage directly with any of Customer’s Clients to whom it has been introduced to by Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NÃO CONCORRENCIA:</b> O Provedor concorda que, ao longo deste Contrato e por um ano depois, não se envolverá diretamente com nenhum dos Clientes do Cliente a quem foi apresentado pelo Cliente.</p>
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
                    <p>As Partes entendem e concordam que isso não se estende a nenhuma organização com a qual o Provedor já esteja contratado para executar serviços ou tenha conhecimento de uma fonte que não seja o Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>WARRANTY:</b> Each Party hereby represents, certifies, and warrants that: (i) it is authorized to enter into this Agreement including having any necessary licenses, registrations, or the like to perform as required herein; (ii) it has no conflicts that would prevent it from meeting its obligations under this Agreement; (iii) there are no pending or anticipated material lawsuits or claims against it, its directors, or officers that would prevent it from proceeding with this Agreement; (iv) neither it, nor its directors, or officers have within the last three (3) years been convicted of or had a civil judgment rendered against them for commission of fraud, criminal offense, breach of confidentiality, or indictment; and (v) it will use its best effort to maintain and keep Worker personal information and Confidential Information secure from unauthorized access or use.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>GARANTIA:</b> Cada Parte declara, certifica e garante que: (i) está autorizada a celebrar este Contrato, inclusive tendo quaisquer licenças, registros ou similares necessários para executar conforme exigido neste instrumento; (ii) não possui conflitos que a impeçam de cumprir suas obrigações sob este Contrato; (iii) não há processos judiciais ou reclamações relevantes pendentes ou antecipados contra ela, seus diretores ou executivos que a impeçam de prosseguir com este Contrato; (iv) nem ele, nem seus conselheiros ou diretores foram condenados nos últimos 3 (três) anos ou tiveram uma sentença civil proferida contra eles por prática de fraude, infração penal, quebra de sigilo ou acusação; e (v) envidará seus melhores esforços para manter e manter as informações pessoais do Trabalhador e as Informações Confidenciais protegidas contra acesso ou uso não autorizado.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XII - GENERAL PROVISIONS</b>
                    <p><b>(a) Changes –</b> Any changes or inclusions to this Agreement shall be made with the mutual consent of the Parties and in writing and consider any local mandatory local rule.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XII - DISPOSIÇÕES GERAIS</b>
                    <p><b>(a) Alterações -</b> Quaisquer alterações ou inclusões a este Contrato devem ser feitas com o consentimento mútuo das Partes e por escrito e considerar qualquer regra local obrigatória local.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(b) Independence –</b> In case any provision in this Agreement shall be invalid, illegal or unenforceable, the validity, legality and enforceability of the remaining provisions shall not in any way be affected or impaired thereby and such provision shall be ineffective only to the extent of such invalidity, illegality or unenforceability.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(b) Independência -</b> Caso qualquer disposição deste Contrato seja inválida, ilegal ou inexequível, a validade, legalidade e exequibilidade das demais disposições não serão de forma alguma afetadas ou prejudicadas e tal disposição será ineficaz apenas para a extensão de tal invalidade, ilegalidade ou inexequibilidade.</p>
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
                    <p><b>(c) Transfer –</b> this Agreement may not be transferred or assigned in whole or in part by either Party without the prior written consent of the other Party.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(c) Transferência -</b> este Contrato não pode ser transferido ou cedido no todo ou em parte por qualquer uma das Partes sem o consentimento prévio por escrito da outra Parte.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) Entire Agreement –</b> This Agreement contains the entire agreement and understanding among the parties hereto with respect to the subject matter hereof, and supersedes all prior and contemporaneous agreements, understandings, inducements, and conditions, express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express terms hereof control and supersede any course of performance and/or usage of the trade inconsistent with any of the terms hereof.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(d) Acordo Completo -</b> Este Acordo contém todo o acordo e entendimento entre as partes com relação ao assunto aqui tratado, e substitui todos os acordos, entendimentos, incentivos e condições anteriores e contemporâneos, expressos ou implícita, oral ou escrita, de qualquer natureza com relação ao assunto aqui tratado. Os termos expressos deste documento controlam e substituem qualquer curso de desempenho e/ou uso do comércio em conformidade com qualquer um dos termos deste documento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e) Tolerance and Absence of Waiver and Novation -</b> The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(e) Tolerância e Ausência de Renúncia e Novação -</b> A tolerância de qualquer descumprimento, ainda que repetido, por qualquer das Partes, das disposições deste Contrato não constitui ou não deve ser interpretado como renúncia da outra Parte ou como novação. Se qualquer tribunal considerar que qualquer disposição ou artigo deste Acordo é nulo, sem efeito ou sem qualquer efeito vinculativo, o restante deste Contrato permanecerá em pleno vigor e efeito como se tal disposição ou parte não tivesse integrado este acordo.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(f) Succession -</b> This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(f) Sucessão -</b> Este Contrato vincula as Partes e seus respectivos sucessores, particulares e universais, cessionários autorizados e representantes legais.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(g) Communication between the Parties -</b> All warnings, communications, notifications, and mailing resulting from the performance of this Agreement shall be done in writing, </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'><b>(g) Comunicação entre as Partes -</b> Todas as advertências, comunicações, notificações e correspondências decorrentes da execução deste Contrato serão feitas por escrito,</p>
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
                    <p>with receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by registry at the Registry of Deeds and Documents and will only be valid when directed and delivered to the Parties at the addresses indicated below in accordance with the applicable law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>com confirmação de recebimento, por correio com aviso de recebimento, por e-mail com aviso prévio de recebimento ou por registro no Cartório de Títulos e Documentos, e somente serão válidos quando encaminhados e entregues às Partes nos endereços abaixo indicados de acordo com a legislação aplicável.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">If to Partner:</b>
                    <p>A/C: Fernando Gutierrez</p>
                    <p>Address: Avenida das Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, Brazil</p>
                    <p>Phone/Fax: +55 21 98218-2575</p>
                    <p>E-mail: <a href="#">sac@intermediano.com</a> </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">Se ao Fornecedor:</b>
                    <p>A/C: Fernando Gutierrez</p>
                    <p>Endereço: Avenida das Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, Brasil</p>
                    <p>Telefone/Fax: +55 21 98218-257</p>
                    <p>E-mail: <a href="#">sac@intermediano.com</a> </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">If to Customer:</b>
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
                    <p>Any disputes between Customer and Provider that arise under this Agreement will be resolved through binding arbitration administered by the Cámara de Comercio Brasil - Canada, in accordance with the Arbitration Rules then in affect at that time. Partner agrees that sole venue and jurisdiction for disputes arising from this Agreement shall be conducted in Brazil – São Paulo city. Procedures and judgment upon the award rendered by the arbitrator may be entered in any court having jurisdiction thereof.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">XIII. – ARBITRAGEM/ LEI GOVERNAMENTAL</b>
                    <p>Quaisquer disputas entre Cliente e Provedor que surjam sob este Contrato serão resolvidas por meio de arbitragem vinculante administrada pela Câmara de Comércio Brasil - Canadá, de acordo com as Regras de Arbitragem então em vigor. O Parceiro concorda que o único foro e jurisdição para disputas decorrentes deste Contrato será realizado no Brasil - cidade de São Paulo. Os procedimentos e julgamento sobre a sentença proferida pelo árbitro podem ser apresentados em qualquer tribunal com jurisdição sobre o assunto.</p>
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
                    <p>Em fé do que, as Partes assinam este Contrato em 2 (duas) vias de igual forma e conteúdo, para um único fim. As Partes garantem e declaram que seu respectivo signatário está, a partir da Data de Vigência, devidamente autorizado por todas as ações corporativas necessárias e apropriadas para executar este Contrato. Aditivos subsequentes podem ser incorporados posteriormente se assinados e acordados por todas as Partes.</p>
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
                    <div style="text-align: center; margin-top: -20px">
                        <p style="text-align: center">{{ $adminSignedBy }}</p>
                        <p style="margin-top: -20px; text-align: center">{{ $adminSignedByPosition }}</p>
                    </div>
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
                    <div style="text-align: center; margin-top: -20px">
                        <p style="text-align: center">{{ $adminSignedBy }}</p>
                        <p style="margin-top: -20px; text-align: center">{{ $adminSignedByPosition }}</p>
                    </div>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>{{ $partnerName }}</b>

                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/private/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 30px">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <div style="text-align: center; margin-top: -20px">
                        <p style='text-align: center'>{{ $partnerContactName }}</p>
                        <p style="margin-top: -20px; text-align: center">Legal Representative</p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center">
                        <b>{{ $partnerName }}</b>

                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/private/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 30px">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <div style="text-align: center; margin-top: -20px">
                        <p style='text-align: center'>{{ $partnerContactName }}</p>
                        <p style="margin-top: -20px; text-align: center">Legal Representative</p>
                    </div>
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
                    <p style="text-align: center; font-weight: bold">Escopo de serviços</p>
                    <p style="text-align: center; font-weight: bold">Escopo Geral</p>
                    <p>O Cliente (a) apresentará indivíduos ao Provedor que os Clientes do Cliente gostariam de contratar, ou (b) solicitará suporte de pessoal do Provedor com base nos requisitos do Cliente do Cliente. Quando o Cliente solicitar suporte de pessoal, o Provedor apresentará candidatos ao Cliente sujeitos à aprovação final do Cliente.</p>
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
                    <p style='font-weight: bold'>Serviço de terceirização de folha de pagamento</p>
                    <p style='line-height: 1.5'>A pedido do Cliente, o Provedor tomará todas as medidas necessárias de acordo com a lei local para se tornar o empregador registrado para candidatos aprovados pelo Cliente do Cliente. Por lei, esses indivíduos serão funcionários do Provedor (“Trabalhadores”) por tempo indeterminado ou definitivo período. O Provedor colocará os Trabalhadores em contato com o Cliente do Cliente de acordo com as instruções do Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be charged separately by Provider, and payment shall be equally made as stated in clause. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>O Provedor gerenciará todas as obrigações legais, fiscais, administrativas e semelhantes do empregador de acordo com a lei local. Isso inclui, mas não se limita a, assinar um contrato de trabalho adequado com o Trabalhador, verificar a identidade e o direito legal do Trabalhador ao trabalho, emitir salários apropriados, cobrar/remessar encargos sociais e impostos ou similares, conforme exigido pela lei local, e - embarque em um Trabalhador em conformidade. Custos extras de contratação, que não fazem parte do processo regular de contratação, como verificações de antecedentes, serão cobrados separadamente pelo Provedor, e o pagamento será feito igualmente conforme estabelecido na cláusula.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Durante todo o envolvimento do Trabalhador, o Cliente atuará como um elo entre o Cliente/Trabalhador do Cliente e o Provedor no que se refere a quaisquer alterações na taxa de pagamento, necessidades de reembolso, férias anuais, consultas de rescisão e similares. O Provedor concorda em fornecer prontamente ao Cliente todas as informações necessárias para garantir que o Cliente e o Trabalhador do Cliente sejam informados sobre quaisquer nuances legais locais.</p>
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
                    <p>A taxa da Prestadora pelo seu Serviço de Terceirização da Folha de Pagamento será de 12% sobre a receita bruta total dos Trabalhadores para os países relacionados: Chile, Colômbia, Costa Rica, Peru e Uruguai, considerada uma taxa mínima de USD 350,00. Para outros Países não listados aqui, deverá ser verificado caso a caso. O Provedor deverá faturar as taxas de serviço EOR como um item de linha separado em cada fatura.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='font-weight: bold'>Staffing Service</p>
                    <p style='line-height: 1.5'>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='font-weight: bold'>Serviço de Pessoal</p>
                    <p style='line-height: 1.5'>A pedido do Cliente, o Provedor recrutará, examinará e entrevistará candidatos de acordo com os requisitos do Cliente do Cliente, conforme comunicado pelo Cliente e seguindo a legislação local. O Provedor apresentará tais candidatos ao Cliente sujeitos à aprovação final do Cliente do Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In the event that Provider presents the same candidate to Customer as another vendor, the search firm that presented the candidate to Customer first shall be deemed to have made the placement. Timing will be determined based on the time of receipt by Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>No caso de o Provedor apresentar o mesmo candidato ao Cliente como outro fornecedor, a empresa de pesquisa que apresentou o candidato ao Cliente primeiro será considerada como tendo feito a colocação. O tempo será determinado com base no tempo de recebimento pelo Cliente.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Once a candidate is approved by Customer’s Client, Provider may either be asked to provide its EOR service for that individual (“Contract Staffing”) or Customer’s Client will elect to employ the individual themselves or through another vendor (“Direct Hire”). </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5'>Uma vez que um candidato seja aprovado pelo Cliente do Cliente, o Provedor pode ser solicitado a fornecer seu serviço de EOR para aquele indivíduo (“Equipe Contratual”) ou o Cliente do Cliente optará por empregar o indivíduo por conta própria ou por meio de outro fornecedor (“Contrato Direto”).</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Fees for Contract Staffing will be agreed upon in writing on a case by case basis.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>As taxas para Contratação de Pessoal serão acordadas por escrito caso a caso.</p>
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
                    <p style='line-height: 1.5'>Em todos os casos de Contratação Direta, o Cliente pagará ao Provedor uma taxa de colocação de 18% do salário anual bruto dessa Contratação Direta. Tal taxa está sujeita ao Cliente do Cliente (ou fornecedor) emitir uma oferta formal de trabalho e o candidato aceitar a mesma. Se o candidato se demitir ou o Cliente do Cliente rescindir o contrato por qualquer motivo nos primeiros 90 (noventa) dias, o Provedor substituirá o Contratado Direto sem custo, o Provedor substituirá o contratado direto, sem custo de recrutamento, na medida em que o recrutamento foi feito pelo Provedor. Nesse caso, o Cliente deverá pagar por todos os custos de rescisão relacionados ao Trabalhador.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>Purchase Order: {{ $poNumber }}</p>
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>SCHEDULE</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>Ordem de compra: {{ $poNumber }}</p>
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
                    <b style="text-decoration: underline;">A) DETALHES DO TRABALHADOR:</b>

                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>NOME DO TRABALHADOR:</b> {{ $employeeName }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>PAÍS DE TRABALHO:</b> {{ $employeeCountryWork }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>CARGO:</b> {{ $employeeJobTitle }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>DATA DE INÍCIO:</b> {{ $employeeStartDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>DATA DE TÉRMINO:</b> {{ $employeeEndDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>SALÁRIO BRUTO:</b> {{ number_format($employeeGrossSalary, 2) }} como salário bruto mensal.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">DATE OF PAYMENT (every month): </b>
                    <p>Payment will be processed by the last day of the worked month. For efficiency, Provider will issue payment on the last day of every month.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">DATA DE PAGAMENTO (todos os meses): </b>
                    <p>O pagamento será processado até o último dia do mês trabalhado. Para maior eficiência, o Provedor emitirá o pagamento no último dia de cada mês.</p>
                </td>
            </tr>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">LOCAL PAYMENT CONDITIONS:</b>
                    <p>Salaries and/or any other remuneration is set at the local currency of the Country where services is provided.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">CONDIÇÕES LOCAIS DE PAGAMENTO: </b>
                    <p>Os salários e/ou qualquer outra remuneração são fixados na moeda local do País onde os serviços são prestados.</p>
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
                    <b style="text-decoration: underline;">B) TAXAS E TERMOS DE PAGAMENTO</b>
                    <p style='font-weight: bold'>TERMOS DE PAGAMENTO</p>
                    <p><b>TAXAS:</b> O Cliente deverá pagar ao Provedor mensalmente, com base no cálculo abaixo: O Cliente paga ao Provedor uma taxa mensal com base nos cálculos abaixo:</p>
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
                    <p>Os valores em Dólar Americano (USD) são usados apenas como referência, pois o valor efetivo é em Reais (BRL). O valor em dólares (USD) variará mensalmente considerando a taxa de câmbio.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>In addition to the monthly fee, there may be additional costs required by law in the Country where the Services are being rendered. Additional costs may apply in the following cases that Provider cannot anticipate or predict, as following:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Além da mensalidade, podem existir custos adicionais exigidos por lei no País onde os Serviços estão sendo prestados. Custos adicionais podem ser aplicados nos seguintes casos que o Provedor não pode antecipar ou prever, como segue:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i) </b>Bônus adicionais concedidos pelo cliente do Cliente; OU</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Any eventual local Government measures will be charged just in case there is any changing in the local legislation. Considering the Worker is an independent contractor there should be no additional fee.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Eventuais medidas do Governo local serão cobradas caso haja alguma alteração na legislação local. Considerando que o Trabalhador é um contratado independente, não deve haver taxa adicional.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LOCAL LEGISLATION - PREVAILS</b>
                    <p>The law that will govern the Worker’s engagement including their rights as an employee will be the law of the country where the Worker is providing the services., The Parties agree that all applicable law including but not limited to, labour and tax, and must be fully complied with the purposes of the local and global compliance guidelines.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LEGISLAÇÃO LOCAL - PREVALECE</b>
                    <p>A lei que regerá a contratação do Trabalhador, incluindo seus direitos como funcionário, será a lei do país onde o Trabalhador estiver prestando os serviços., As Partes concordam que todas as leis aplicáveis, incluindo, entre outras, trabalhistas e fiscais, e deve ser integralmente cumprido com os propósitos das diretrizes de conformidade locais e globais.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

</body>

</html>
