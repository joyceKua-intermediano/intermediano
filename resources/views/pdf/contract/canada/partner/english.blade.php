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
$year = now()->format('Y');
$currentDate = now()->format('[d/m/Y]');
$partnerName = $record->partner->partner_name;
$partnerTaxId = $record->partner->tax_id;
$partnerCountry = $record->partner->country->name;
$partnerAddress = $record->partner->address;


$partnerPhone = $record->partner->mobile_number;
$partnerEmail = $record->partner->email;
$partnerContactName = $record->partner->contact_name;
$customerTranslatedPosition = $record->translatedPosition;

$employeeName = $record->employee->name;
$employeeCountryWork = $record->country_work;
$employeeJobTitle = $record->job_title;
$employeeStartDate = $record->start_date;
$employeeEndDate = $record->end_date;
$employeeGrossSalary = $record->gross_salary;
$signatureExists = Storage::disk('public')->exists($record->signature);

@endphp

<style>
    .main-container {
        text-align: justify;
        padding-left: 50px;
        padding-right: 50px;
    }

    .clause-header {
        margin-top: 20px
    }

    .clause-header span {
        text-decoration: underline
    }

    p {
        line-height: 1.5 !important
    }

</style>
<body>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <h4 style='text-align:center; text-decoration: underline; margin: 20px 0px'> PARTNERSHIP AGREEMENT</h4>

        <p>This Payroll and HR Service Agreement (the “Agreement”) is made on November 06th., 2024 (the
            “Effective Date”), by and between <b>GATE INTERMEDIANO INC.</b> (the <b>“Customer”</b> ), a Canadian
            company, enrolled under the fiscal registration number 733087506RC0001, lo cated at 4388 Rue
            Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada, duly repre sented by its legal
            representative; AND <b>{{ $partnerName }}</b> (the <b>“Provider”</b>), a {{ $partnerCountry }} company, enrolled
            under the fiscal registration number {{ $partnerTaxId }}, located at {{ $partnerAddress }}, duly rep resented by its
            authorized representative, (each, a “Party “and together, the “Parties”)
        </p>

        <p><b>WHEREAS</b> Provider provides certain payroll, tax, and human resource services globally either directly or indirectly through its local partners; </p>
        <p><b>WHEREAS</b> Customer also provides certain payroll, tax, and human resource services globally for its clients (“Customer’s Clients”); and </p>
        <p><b>WHEREAS</b> the Parties wish to enter into this Partnership Agreement to enable Provider to provide its services to Customer for the benefit of Customer’s Clients on the terms and conditions set forth herein. </p>
        <p><b>NOW, THEREFORE,</b> in consideration of the premises and the mutual covenants set forth herein, the Parties hereby agree as follows: </p>
        <p class='clause-header'><b> I - <span>PURPOSE </span></b></p>
        <p><b>Service Offerings.</b> Provider shall provide to Customer the services of staffing, outsourcing payroll, consulting, and HR attached hereto as Schedule A (the “Schedule A”) and incorporated herein (collectively, the “Services”), during the Term (defined in Section VI) subject to the terms and conditions of this Agreement. </p>
        <p class='clause-header'><b> II - <span>PROVIDER RESPONSIBILITIES </span></b></p>
        <p>Notwithstanding the other obligations under this Agreement, the Provider; hereby undertakes to: </p>
        <p><b>a)</b> to meet the requirements and quality standards required by Customer, which may periodically review the Services performed by the Provider; </p>
        <p><b>(b) </b>to collect all taxes related to its activities, considering local applicable law where the services are being rendered; </p>
        <p><b>(c)</b> to provide, whenever customer requests it, all reports, spreadsheets, and other information relating to the Services and the country’s requirements; </p>

        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(d)</b> to comply with all global and local laws, decrees, regulations, resolutions, decisions, norms and other provisions considered by law concerning the provision of the service and labor matters, in particular, but not limited to, those related to the protection of the environment, exempting Customer and Customer’s Client from any responsibility resulting therefrom. Therefore, the Provider declares in this Agreement that its activities and Services, used now and in the future, comply with the legislation and protection and safety standards concerning sanitation and environment; and </p>
        <p><b>(e)</b> to have and maintain any needed licenses, registrations, or the like to provide the Services outlined herein. </p>
        <p class='clause-header'><b> III - <span>CUSTOMER RESPONSABILITIES </span></b></p>
        <p>Notwithstanding the other obligations under this Agreement, the Customer, hereby undertakes to: </p>
        <p><b>(a)</b> to process the monthly payment to the Provider set forth in Schedule B (the “Schedule B”); </p>
        <p><b>(b)</b> to abide by and require Customer’s Clients to abide by Provider’s instructions concerning the local labor legislation, considering where the service is being provided; and </p>
        <p><b>(c)</b> to supply the technical information required for the Services to be performed. </p>
        <p class='clause-header'><b> IV - <span>PAYMENT AND FEES </span></b></p>
        <p><b>(a)</b> For the Services agreed herein, Customer shall pay to the Provider the amount the Parties agreed upon in writing in the format outlined in Schedule B or substantially similar thereto for each Worker or Service. </p>
        <p style='line-height: 1.4 !important'><b>(b) INVOICE:</b> Provider will issue a monthly invoice to the Customer up to the 10th day of the month and Customer shall pay to Provider within 10 (ten) days of receipt of the invoice of the same month the invoice was issued. The invoice will include the Worker’s gross renumeration (e.g., salary, bonuses, commissions, allowances, etc.), any mandatory employer costs (e.g., social security contributions, other taxes etc.), and Provider’s fee. </p>
        <p style='line-height: 1.4 !important'><b>(c) DUE DATE:</b> Customer shall pay Provider within 10 (ten) days of receipt of the invoice by Provider. Undisputed invoices that remain unpaid past the due date will be subject to a penalty fee equal to 3%. </p>
        <p style='line-height: 1.4 !important'><b>(d) EXCHANGE RATE:</b> Invoices will be issued in USD based on the exchange rate of the date of the issuance of the invoice, considering the 3.5% margin of risk in favor of Provider. For clarity, this means that all exchange rates used to convert to USD will be increased by 3.5%. </p>
        <p class='clause-header'><b> V - <span>CONFIDENTIALITY </span></b></p>
        <p style='line-height: 1.4 !important'><b>(a)</b> Both Customer and Provider acknowledge that by reason of its relationship to the other party under this Agreement, it will have access to and acquire knowledge, material, data, systems and other information concerning the operation, business, financial affairs and intellectual property of the other Party or Customer’s Client, that may not be accessible or known to the general public, including but not limited to the terms of this Agreement (referred to as "Confidential Information"). </p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(b)</b> Non-Disclosure/Use. Each of Customer and Provider agrees that it will: <b>(i)</b> maintain and preserve the confidentiality of all Confidential Information received from the other party (the "Disclosing Party''), both orally and in writing, including taking such steps to protect the confidentiality of the Disclosing Party's Confidential Information as the party receiving such Confidential Information (the "Receiving Party") takes to protect the confidentiality of its own confidential or proprietary information; provided, however, that in no instance shall the Receiving Party use less than a reasonable standard of care to protect the Disclosing Party's Confidential Information; <b>(ii)</b> disclose such Confidential Information only to its own employees on a "need-toknow" basis, and only to those employees who have agreed to maintain the confidentiality thereof pursuant to a written agreement containing terms at least as stringent as those set forth in this Agreement; <b>(iii)</b> not disassemble, "reverse engineer" or "reverse compile" such software for any purpose in the event that software is involved; and <b>(iv)</b> not disclose such Confidential Information to any third party without the prior written consent of the Disclosing Party; provided, however, that each party may disclose the financial terms of this Agreement to its legal and business advisors and to potential investors so long as such third parties agree to maintain the confidentiality of such Confidential Information. Each Receiving Party further agrees to use the Confidential Information of the Disclosing Party only for the purpose of performing its obligations under this Agreement. The Receiving Party's obligation of confidentiality shall survive this Agreement for a period of five (5) years from the date of its termination or expiration and thereafter shall terminate and be of no further force or effect; provided, however, that with respect to Confidential Information which constitutes a trade secret, such information shall remain confidential so long as such information continues to remain a trade secret. The parties also mutually agree to <b>(1)</b> not alter or remove any identification or notice of any copyright, trademark, or other proprietary rights which indicates the ownership of any part of the Disclosing Party's Confidential Information; and <b>(2)</b> notify the Disclosing Party of the circumstances surrounding any possession or use of the Confidential Information by any-person or entity other than those authorized under this Agreement. </p>
        <p><b>(c) Exclusions.</b> Each of Customer’s and Provider’s obligations in the preceding paragraph above shall not apply to Confidential Information which the Receiving Party can prove: <b>(i)</b> has become a matter of public knowledge through no fault, action or omission of or by the Receiving Party; <b>(ii)</b> was rightfully in the Receiving Party's possession prior to disclosure by the Disclosing Party; <b>(iii)</b> subsequent to disclosure by the Disclosing Party, was rightfully obtained by the Receiving Party from a third party who was lawfully in possession of such Confidential Information without restriction; <b>(iv)</b> was independently developed by the Receiving Party without resort to the Disclosing Party's Confidential Information; or <b>(v)</b> must be disclosed by the Receiving Party pursuant to law, judicial order or any applicable regulation (including any applicable stock exchange rules and regulations); provided, however, that in the case of disclosures made in accordance with the foregoing clause <b>(vi)</b>, the Receiving Party must provide prior written notice to the Disclosing Party of any such legally required disclosure of the Disclosing Party's Confidential Information as soon as practicable in order to afford the Disclosing Party an opportunity to seek a protective order, or, in the event that such order cannot be obtained, disclosure may be made in a manner intended to minimize or eliminate any potential liability.</p>




        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(d)</b> Provider agrees that it will require every Worker to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information. </p>
        <p><b>(e)</b> Should Provider engage vendors, it will require every such vendor to agree to confidentiality terms substantially similar to those outlined herein to protect Customer’s and Customer’s Client’s Confidential Information. </p>
        <p class='clause-header'> <b>VI -<span> GDPR DATA PROTECTION </span></b></p>
        <p>Any information containing personal data shall be handled by both Parties in accordance with all applicable privacy laws and regulations, including without limitation the GDPR and equivalent laws and regulations. If for the performance of the Services it is necessary to exchange personal data, the relevant Parties shall determine their respective positions towards each other (either as controller, joint controllers or processor) and the subsequent consequences and responsibilities according to the GDPR as soon as possible. For the avoidance of doubt, each Party’s position may change depending upon the circumstances of each situation. </p>
        <p class='clause-header'> <b>VII -<span> INTELLECTUAL AND INDUSTRIAL PROPERTY </span></b></p>
        <p style='line-height: 1.4 !important;'><b>(a)</b> Every document, report, data, know-how, method, operation, design, trademarks confidential information, patents and any other information provided by Customer to the Provider shall be and remain exclusive property of the Customer that disclosed the information.</p>
        <p style='line-height: 1.4 !important;'><b>(b)</b> After the termination or the expiry hereof, neither Party shall use trademarks or names that may be similar to those of the other Party and/or may somewhat be confused by customers and companies. Each Party undertakes to use its best efforts to avoid mistakes or improper disclosure of the trademarks and names of the other Parties by unauthorized people. </p>
        <p style='line-height: 1.4 !important;'><b>(c)</b> Provider agrees that everything provided to it or Workers by Client’s Customer remains the property of Client’s Customer, and that no right, title, or interest is transferred to Provider or Workers including recovery of said property; this includes company laptops, phones, credit cards, etc. Provider further agrees that all right title and interest in the work product (including but not limited to intellectual property, software, works of authorship, trade secrets, designs, data or other proprietary information) produced by Provider or Workers under this Agreement are the sole property of Customer’s Client. Provider further agrees to assign, or cause to be assigned from time to time, to Client’s Customer on an exclusive basis all rights, title and interest in and to the work product produced by Provider or Workers under this Agreement, including any copyrights, patents, mask work rights or other intellectual property rights relating thereto, in perpetuity or for the longest period otherwise permitted under applicable law. Provider agrees that it shall not use the work product for the benefit of any party other than Customer’s Client. Nothing in this Subsection shall apply to any copyrightable material, notes, records, drawings, designs, Innovations, improvements, developments, discoveries and trade secrets conceived, made or discovered by Provider prior to the Effective Date of this Agreement. </p>
        <p><b>(d)</b> Provider shall require each Worker assigned to Customer’s Client to agree that, to the maximum extent permitted by law, all inventions, developments or improvements conceived or </p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p style='line-height: 1.4 !important'>created by such Worker while engaged in rendering services under this Agreement, that relate to work or projects for Customer’s Client, shall be the exclusive property of Customer’s Client, and to assign and transfer to Customer’s Client (or to Provider for further assignment to Customer and ultimately to Customer’s Client) all of Worker’s right, title and interest in and to such inventions, developments or improvements and to any Letter Patents, Copyrights and applications pertaining thereto. Provider agrees that any intellectual property created during a Worker’s engagement with Customer’s Client remains the property of Customer’s Client as outlined herein, even if local law deems such work the property of the employer. At Customer’s request and direction, Provider agrees to take whatever steps necessary including those outlined herein, as applicable, to effectuate Customer’s Client’s rights in the intellectual property produced during a Worker’s engagement. </p>
        <p class='clause-header'> <b>VIII -<span> MUTUAL INDEMNIFICATION </span></b></p>
        <p style='line-height: 1.4 !important'><b>1)</b> Each Party shall indemnify, defend, and hold the other harmless against any loss, liability, cost, or expense (including reasonable legal fees) related to any third party claim or action that: (i) if true, would be a breach of any condition, warranty, or representations made by the indemnifying party pursuant to this Agreement; or (ii) arises out of an unlawful act (including but not limited to discrimination, retaliation, and/or harassment), negligent act, or omission to act by indemnifying party or, its employees, or agents under this Agreement. These indemnity obligations shall be contingent upon the Party seeking to be indemnified: (i) giving prompt written notice to the indemnifying party of any claim, demand, or action for which indemnity is sought; (ii) reasonably cooperating in the defense or settlement of any such claim, demand, or action; and (iii) obtaining the prior written agreement of the indemnifying party to any settlement or proposal of settlement, which agreement shall not be unreasonably withheld. </p>
        <p><b>2)</b> During the Term, and for a period of two years following the effective date of termination, the Customer will, at its own expense, ensure that it maintains adequate insurance (including cover for, without limitation, public liability, labor liabilities and business interruption) in respect of its potential liability for loss or damage arising under or in connection with this Agreement. </p>
        <p class='clause-header'> <b>IX -<span> TERM AND TERMINATION </span></b></p>
        <p>This Agreement shall be in force and remain valid for undetermined period. Each of the Parties is free to terminate this Agreement at any time without cause by previous written notice of 60 (sixty) days. Exception is made if the Worker resigns at his/her own discretion, in which the period of 30 (thirty) days shall prevail. </p>
        <p>The Agreement may be terminated for justified cause regardless of any previous notice, in the occurrence of the following events by the Parties: </p>
        <p><b>(a)</b> consecutives delays or failure to comply by Customer with the payments due to the Provider remuneration or repeated non-delivery or late delivery of the Services by the Provider, only after Provider has given Customer a 2 (two)months previous notice of the potential of termination and provided Customer at least 30 (thirty) days’ notice to cure it. Exception to the previous notice period will apply in case the Worker resigns at his/her own discretion, as beyond the will of the Parties. </p>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(b)</b> if any Party breaches any term or condition of this Agreement and fails to remedy to such failure within fifteen (15) days from the date of receipt of written notification from the other Party; </p>
        <p style='line-height: 1.4 !important'><b>(c)</b> If either Party becomes or is declared insolvent or bankrupt, is the subject of any proceedings relating to its liquidation or insolvency or for the appointment of a receiver, conservator, or similar officer, or makes an assignment for the benefit of all or substantially all of its creditors or enters into any agreement for the composition, extension, or readjustment of all or substantially all of its obligations, then the other party may, by giving prior written notice thereof to the non-terminating Party, terminate this Agreement as of a date specified in such notice. </p>
        <p>Upon termination of this Agreement or at its termination, Provider undertakes to: </p>
        <p><b>a)</b> return to Customer the day of termination of this Agreement, any and all equipment, promotional material, and other documents which have been provided by Customer in relation to the Services agreed upon in this Agreement; </p>
        <p><b>b)</b> respect and comply with Agreement before the effective termination date; and </p>
        <p><b>c)</b> If required by Customer, Provider shall deliver to Customer the legal offboarding documentation referred to the worker. </p>
        <p class='clause-header'> <b>X -<span> ACT OF GOD OR FORCE MAJEURE </span></b></p>
        <p>In the event either Party is unable to perform its obligations under the terms of this Agreement because of acts of God or force majeure, such party shall not be liable for damages to the other for any damages resulting from such failure to perform or otherwise from such causes. </p>
        <p class='clause-header'> <b>XI -<span> MISCELLANEOUS PROVISIONS </span></b></p>
        <p style='line-height: 1.4 !important'><b>PROVIDER´S LOCAL PARTNER:</b> In the event Provider indicates any local Partner in a Statement of Work (“SOW”), the Customer will not communicate directly to the local partner (i.e., emails, any correspondence, phone call, and so on) at any time without Provider’s written permission. Provider will be the primary and only point of contact for the entire negotiation and after its expiration in order to avoid damages and losses to the Provider. This provision is valid up to a period of 5 (five) years after the expiration of the Agreement. </p>
        <p style='line-height: 1.4 !important'><b>BENEFITS:</b> Customer, Provider, and Workers do not have any rights or interest in Customer’s Client’s employee benefits, pension plans, stock plans, profit sharing, 401k, or other fringe benefits that are provided to Customer’s Client’s employees by Customer’s Client. All Workers engaged by Provider for Customer shall follow local legislation and the costs shall be covered by Customer entirely</p>
        <p style='line-height: 1.4 !important'><b>INDEPENDENT CONTRACTOR:</b> Parties hereby agree that Provider is not employed by Customer, and nothing in this Agreement shall be construed as creating any partnership, joint venture or other relationship between Provider and Customer or Customer’s Client. This is not a contract of employment. Provider’s relationship with respect to Customer is that of an independent contractor. At no time during the term of this Agreement will Provider be Customer’s agent or have any right, authority or power to enter into any commitments on behalf of Customer unless specifically </p>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p>authorized by an officer of Customer in writing. Nothing in this Agreement shall be deemed to create any employer-employee relationship between Customer and Provider and the parties expressly agree that no joint employer relationship shall exist with respect to the Workers who at all times shall remain employees of Provider. </p>
        <p style='line-height: 1.4 !important'><b>NON-COMPETE:</b> Provider hereby agrees that throughout this Agreement and for one year thereafter, it will not engage directly with any of Customer’s Clients to whom it has been introduced to by Customer. The Parties understand and agree that this does not extend to any organizations with whom Provider is already contracted to perform services or learns of from a source other than Customer. </p>
        <p style='line-height: 1.4 !important'><b>WARRANTY:</b> Each Party hereby represents, certifies, and warrants that: (i) it is authorized to enter into this Agreement including having any necessary licenses, registrations, or the like to perform as required herein; (ii) it has no conflicts that would prevent it from meeting its obligations under this Agreement; (iii) there are no pending or anticipated material lawsuits or claims against it, its directors, or officers that would prevent it from proceeding with this Agreement; (iv) neither it, nor its directors, or officers have within the last three (3) years been convicted of or had a civil judgment rendered against them for commission of fraud, criminal offense, breach of confidentiality, or indictment; and (v) it will use its best effort to maintain and keep Worker personal information and Confidential Information secure from unauthorized access or use. </p>
        <p class='clause-header'> <b>XII -<span> GENERAL PROVISIONS </span></b></p>
        <p><b>(a)</b> Changes – Any changes or inclusions to this Agreement shall be made with the mutual consent of the Parties and in writing and consider any local mandatory local rule. </p>
        <p><b>(b) Independence –</b> In case any provision in this Agreement shall be invalid, illegal or unenforceable, the validity, legality and enforceability of the remaining provisions shall not in any way be affected or impaired thereby and such provision shall be ineffective only to the extent of such invalidity, illegality or unenforceability. </p>
        <p><b>(c) Transfer –</b> this Agreement may not be transferred or assigned in whole or in part by either Party without the prior written consent of the other Party. </p>
        <p style='line-height: 1.4 !important'><b>(d) Entire Agreement –</b> This Agreement contains the entire agreement and understanding among the parties hereto with respect to the subject matter hereof, and supersedes all prior and contemporaneous agreements, understandings, inducements, and conditions, express or implied, oral or written, of any nature whatsoever with respect to the subject matter hereof. The express terms hereof control and supersede any course of performance and/or usage of the trade inconsistent with any of the terms hereof. </p>
        <p style='line-height: 1.4 !important'><b>(e) Tolerance and Absence of Waiver and Novation -</b> The tolerance of any failure to fulfill, even if repeated, by any Party, the provisions of this Agreement does not constitute or shall not be interpreted as a waiver by the other Party or as novation. If any court or tribunal finds that any provision or article of this Agreement is null, void, or without any binding effect, the rest of this Contract will remain in full force and effect as if such provision or part had not integrated this Agreement. </p>

        @include('pdf.contract.layout.footer')
    </main>




    @include('pdf.contract.layout.header')
    <main class="main-container">
        <p><b>(f) Succession -</b> This Agreement binds the Parties and their respective successors, particulars and universals, authorized assignees and legal representatives. </p>
        <p><b>(g) Communication between the Parties -</b> All warnings, communications, notifications, and mailing resulting from the performance of this Agreement shall be done in writing, with receipt confirmation, by mail with notice of receipt, by e-mail with notice of receipt or by registry at the Registry of Deeds and Documents and will only be valid when directed and delivered to the Parties at the addresses indicated below in accordance with the applicable law. </p>


        <b style='margin-top:30px'>If to Provider:</b>
        <p>
            <b> A/C:</b>
            {{ $partnerName }}
        </p>
        <p>
            <b> Address:</b> {{ $partnerAddress }}
        </p>
        <p> <b> Phone/Fax:</b> {{ $partnerPhone }}</p>
        <p> <b> E-mail:</b> {{ $partnerEmail }}</p>
        <br>
        <b>If to Customer:</b>
        <p>
            <b> A/C:</b>
            A/C: Fernando Gutierrez
        </p>
        <p><b>Address: </b>4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada </p>
        <p><b>Phone:</b> +1 514 907 5393</p>
        <p><b> E-mail:</b> sac@intermediano.com</p>
        <p class='clause-header'> <b>XIII.<span> ARBITRATION/ GOVERNMENT LAW </span></b></p>
        <p>Any disputes between Customer and Provider that arise under this Agreement will be resolved through binding arbitration administered by the Cámara de Comercio Brasil - Canada, in accordance with the Arbitration Rules then in affect at that time. Partner agrees that sole venue and jurisdiction for disputes arising from this Agreement shall be conducted in Brazil – São Paulo city. Procedures and judgment upon the award rendered by the arbitrator may be entered in any court having jurisdiction thereof. </p>
        <p>In witness whereof, the Parties sign this Agreement in two (2) copies of equal form and content, for one sole purpose. The Parties do each hereby warrant and represent that their respective signatory is, as of the Effective Date, duly authorized by all necessary and appropriate corporate action to execute this Agreement. Subsequent addendums may later be incorporated if signed and agreed to by all Parties.</p>

        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container'>


        <p style="margin-top: -6px !important;"> {{ $currentDate }}</p>

        <table style="width: 100%; text-align: center; border-collapse: collapse; border: none; margin-top: -35px !important;">
            <tr style="border: none;">

                <td style="width: 50%; vertical-align: top; border: none; text-align: center; padding: 10px; padding-top: -20px">
                    <h4>{{ $partnerName }}</h4>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="Signature" style="height: 50px; margin: 10px 0;">
                    <p style="margin: 5px 0; text-align: center;">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Blank Signature" style="height: 50px; margin: 10px 0;">
                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>

                    <p style="margin: 10px 0; text-align: center;">{{ $partnerContactName }}</p>
                    <p style="margin: 5px 0; text-align: center;">Representative</p>
                </td>
                <td style="width: 50%; vertical-align: top; border: none; text-align: center; padding: 10px;  padding-top: -20px">
                    <h4>GATE INTERMEDIANO INC.</h4>
                    <div style="margin-top: 65px">
                        <img src="{{ public_path('images/fernando_signature.png') }}" alt="Signature" style="height: 50px;">
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="margin: 10px 0; text-align: center;">Fernando Gutierrez</p>
                    <p style="margin: 5px 0; text-align: center;">CEO</p>
                </td>

            </tr>
        </table>

        <h4 style='text-align:center; margin: 20px 0px'> SCHEDULE A</h4>
        <h4 style='text-align:center;'> Scope of Services</h4>
        <h4 style='text-align:center;'> General Scope</h4>
        <p style='line-height: 1.4 !important'>Customer will either (a) present individuals to Provider that Customer’s Clients would like to engage, or (b) request staffing support from provider based on Customer’s Client’s requirements. When Customer requests staffing support, Provider will present candidates to Customer subject to final approval by Customer’s Client. </p>
        <p style='line-height: 1.4 !important'><b> Payroll Outsourcing Service</b></p>
        <p style='line-height: 1.4 !important'>At Customer’s request, Provider will take whatever steps are necessary under local law to become the employer of record for candidates approved by Customer’s Client. By law, those individuals will be employees of Provider (“Workers”) for either an indefinite or definite period. Provider will place the Workers on engagement with Customer’s Client pursuant to Customer’s instructions. </p>
        <p style='line-height: 1.4 !important'>Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be charged separately by Provider, and payment shall be equally made as stated in clause. </p>
        <p style='line-height: 1.4 !important'>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances. </p>
        <p>Provider’s fee for its Payroll Outsourcing Service shall be 12% over the total gross earnings of the Worker´s for the related countries: Chile, Colombia, Costa Rica, Peru and Uruguay, considered a minimum fee of USD350,00. For other Countries not listed herein, shall be checked case by case. Provider shall invoice the EOR service fees as a separate line item on each invoice. </p>
        @include('pdf.contract.layout.footer')

    </main>


    @include('pdf.contract.layout.header')

    <main class='main-container'>
        <p><b> Staffing Service</b></p>
        <p>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. </p>
        <p>In the event that Provider presents the same candidate to Customer as another vendor, the search firm that presented the candidate to Customer first shall be deemed to have made the placement. Timing will be determined based on the time of receipt by Customer. </p>
        <p>Once a candidate is approved by Customer’s Client, Provider may either be asked to provide its EOR service for that individual (“Contract Staffing”) or Customer’s Client will elect to employ the individual themselves or through another vendor (“Direct Hire”). </p>
        <p>Fees for Contract Staffing will be agreed upon in writing on a case-by-case basis. </p>
        <p>In all Direct Hire cases, Customer will pay Provider a placement fee of 18% of that Direct Hire’s gross annual salary. Such fee is subject to Customer’s Client (or a vendor) issuing a formal job offer and the candidate accepting the same. If the candidate resigns or Customer’s Client terminates the engagement for any reason within the first 90 (ninety) days, Provider will replace the Direct Hire individual at no cost, Provider will replace the direct hire, at no recruiting cost, as far the recruitment has been done by the Provider. In this case, Customer shall pay for all termination cost related the Worker. </p>
        <br>
        <p style='line-height: 1.5; text-align: center; font-weight: bold'>Purchase Order: {{ $poNumber }}</p>
        <h4 style='text-align: center'> SCHEDULE B</h4>
        <div>
            <p><b>A) WORKER DETAILS:</b></p>
            <p><b>NAME OF WORKER:</b> {{ $employeeName }}</p>
            <p><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
            <p><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
            <p><b>START DATE:</b> {{ $employeeStartDate }}</p>
            <p><b>END DATE:</b> {{ $employeeEndDate }}</p>
            <p><b>GROSS WAGES:</b> {{ number_format($employeeGrossSalary, 2) }}</p>
            <p><b>DATE OF PAYMENT (every month):</b> Payment will be processed by the last day of the worked month. For efficiency, Provider will issue payment on the last day of every month. </p>
        </div>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container'>
        <p><b>LOCAL PAYMENT CONDITIONS:</b> Salaries and/or any other remuneration is set at the local currency of the Country where services is provided. </p>

        <p class='clause-header'> <b>B)<span> FEES AND PAYMENT TERMS </span></b></p>

        <h4 style=''> PAYMENT TERMS</h4>
        <p> <b>FEES:</b> Customer shall pay the Provider in a monthly basis, based on the calculation below: The Customer pays the Provider a monthly fee based on the calculations below: </p>
        <div style="margin-top: -35px !important">
            @include('pdf.hong_kong_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')

    </main>

    @include('pdf.contract.layout.header')

    <main class='main-container' style='page-break-after: avoid'>
        <p>The values in American Dollar (USD) are only used as reference as the effective value is in BRL. The amount in USD will monthly vary considering the exchange rate. </p>
        <p>In addition to the monthly fee, there may be additional costs required by law in the Country where the Services are being rendered. Additional costs may apply in the following cases that Provider cannot anticipate or predict, as following: </p>
        <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR </p>
        <p><b>(ii)</b> Any eventual local Government measures will be charged just in case there is any changing in the local legislation.
        </p>
        <p>Considering the Worker is an independent contractor there should be no additional fee. </p>
        <p>C) <b style='text-decoration: underline'>LOCAL LEGISLATION - PREVAILS</b></p>
        <p>The law that will govern the Worker’s engagement including their rights as an employee will be the law of the country where the Worker is providing the services., The Parties agree that all applicable law including but not limited to, labour and tax, and must be fully complied with the purposes of the local and global compliance guidelines. </p>

        @include('pdf.contract.layout.footer')

    </main>
</body>
</html>
