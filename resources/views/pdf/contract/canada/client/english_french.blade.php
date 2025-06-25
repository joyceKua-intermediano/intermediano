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
$companyName = $record->company->name;

$companyContactName = $record->companyContact->contact_name;
$companyContactSurname = $record->companyContact->surname;

$companyAddress = $record->company->address;

$companyPhone = $record->companyContact->phone;
$companyEmail = $record->companyContact->email;
$companyTaxId = $record->company->tax_id ?? 'NA';
$companyCountry = $record->company->country;


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
$employeeCountry = $record->personalInformation->country ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeEndDate = $record->start_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$signatureExists = Storage::disk('public')->exists($record->signature);

@endphp

<style>
    p {
        line-height: 1.5 !important
    }

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main>
        <table style='margin-top: 0px !important'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">SERVICES AGREEMENT</h4>
                    <p>This Services Agreement ("Agreement") signed and entered into on {{ $formattedDate }} of {{ $month }}, {{ $year }}, by and between: </p>
                    <p><b>GATE INTERMEDIANO INC.</b>, initially referred as
                        INTERMEDIANO INC. (the <b>“Provider”</b>) a
                        Canadian company with its principal place of
                        business at 4388 Rue Saint-Denis Suite200 #763,
                        Montreal, QC H2J 2L1, Canada, duly
                        represented by its legal representative; AND
                        <b>{{ $companyName }} </b> (the <b>“Customer”</b>), a
                        {{ $companyCountry }} company, enrolled
                        under the fiscal registration number
                        {{ $companyTaxId }}, located at
                        {{ $companyAddress }}, {{ $companyCountry }}, duly represented by its
                        authorized representative, (each, a “Party”
                        and together, the “Parties”). </p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">ENTENTE DE SERVICES</h4>

                    <p>Cette Entente de Services ("Entente") est signée
                        et entrée en vigueur le {{ $formattedDate }} of {{ $month }}, {{ $year }}, par et entre : </p>

                    <p><b>GATE INTERMEDIANO INC.</b>, désignée
                        INTERMEDIANO INC. (le <b>"Fournisseur"</b>), une
                        société canadienne ayant son siège social au
                        4388 Rue Saint-Denis, Suite 200 #763, Montréal,
                        QC H2J 2L1, Canada, dûment représentée par
                        son représentant légal; ET <b>{{ $companyName }}</b> (le
                        <b>"Client"</b>), une société {{ $companyCountry }}, inscrite
                        sous le numéro d'enregistrement fiscal {{ $companyTaxId }}, située à {{ $companyAddress }},
                        dûment représentée par son représentant
                        autorisé, (chacune, une “Partie” et ensemble,
                        les “Parties”). </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>WHEREAS,</b> in the event of any discrepancies
                        between the terms and conditions of the
                        Agreement and the Freelance Vendor T&C,
                        the terms and conditions of this Agreement
                        shall prevail and supersede; </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>ATTENDU QUE,</b> en cas de divergence entre les
                        termes et conditions du Contrat et les
                        Conditions Générales Freelance Vendor, les
                        termes et conditions du présent Contrat
                        prévaudront et remplaceront les autres;</p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>NOW, THEREFORE,</b> in consideration of the
                        mutual covenants and agreements contained
                        herein, the Parties hereby agree as follows: </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>PAR CONSÉQUENT,</b> en considération des
                        engagements mutuels et accords contenus
                        dans les présentes, les Parties conviennent de
                        ce qui suit: </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1) Introduction and Scope of Services:</b>
                    </p>
                    <p><b>1.1 Scope of Services:</b></p>
                    <p>The scope of services to be provided by the Provider to the Customer shall include staffing services support, with the specifics subject to variation based on the Customer's requirements. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1) Introduction et Portée des Services:</b></p>
                    <p><b>1.1 Portée des Services:</b></p>
                    <p>La portée des services à fournir par le Fournisseur au Client inclura le soutien en matière de services de dotation en personnel, les spécificités étant sujettes à variation en fonction des exigences du Client. </p>
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

                    <p><b>1.2 Service Details: </b></p>
                    <p>Detailed descriptions of the services to be
                        rendered shall be outlined in Appendices A
                        and B of this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p><b>1.2 Détails des Services:</b></p>
                    <p>Les descriptions détaillées des services à
                        rendre seront définies dans les Annexes A et B
                        du présent Accord.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.3 Indemnification Clause:</b></p>
                    <p>The Parties agree that any liability and/or
                        indemnification arising from the services and
                        activities performed under this Agreement
                        shall rest solely with the Subcontractor
                        engaged by the Provider. The Provider shall
                        bear no liability and is fully released from any
                        indemnification obligations to the Customer.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.3 Clause d'Indemnisation:</b></p>
                    <p>Les Parties conviennent que toute responsabilité et/ou indemnisation découlant des services et activités effectués dans le cadre du présent Accord incombera exclusivement au Sous-traitant engagé par le Fournisseur. Le Fournisseur ne portera aucune responsabilité et est entièrement libéré de toute obligation d'indemnisation envers le
                        Client.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.4 Subcontracting Authorization:</b></p>
                    <p>The Customer acknowledges and hereby formally and expressly grants the Provider authorization to subcontract the services described herein. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.4 Autorisation de Sous-traitance:</b></p>
                    <p>Le Client reconnaît et autorise par la présente formellement et expressément le Fournisseur à sous-traiter les services décrits dans les présentes. </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.5 Term:</b></p>
                    <p>This Agreement shall become effective as of the date of Customer´s registration as account holder with OneForma, and shall continue in effect until terminated by mutual agreement between both Parties or by either as per Section 1.6 below. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.5 Durée:</b></p>
                    <p>Le présent Accord prendra effet à la date de l'inscription du Client en tant que titulaire de compte auprès de OneForma et restera en vigueur jusqu'à sa résiliation par accord mutuel entre les deux Parties ou par l'une des Parties conformément à la Section 1.6 ci-dessous.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.6 Termination </b></p>
                    <p><b>1.6.1 Termination with Notice:</b></p>
                    <p>Either Party may terminate this Agreement by providing the other Party with no less than thirty (30) days' prior written notice of its intention to terminate. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.6 Résiliation:</b></p>
                    <p><b>1.6.1 Résiliation avec Préavis:</b></p>
                    <p>Chaque Partie peut résilier le présent Accord en fournissant à l'autre Partie un préavis écrit d'au moins trente (30) jours de son intention de résilier. </p>
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
                    <p><b>1.6.2 Termination for Default:</b></p>
                    <p>Either Party may terminate this Agreement immediately, without prior notice, in the event that the other Party is in default of any of its obligations under this Agreement. Such termination shall be effective upon the defaulting Party's receipt of written notice specifying the nature of the default. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>1.6.2 Résiliation pour Manquement:</b></p>
                    <p>Chaque Partie peut résilier le présent Accord immédiatement, sans préavis, dans le cas où l'autre Partie ne respecte pas l'une de ses obligations en vertu du présent Accord. Une telle résiliation prendra effet dès la réception par la Partie défaillante d'un avis écrit spécifiant la nature du manquement. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Upon termination of this Agreement, all rights and obligations of the Parties shall cease, except for any rights and obligations that have accrued prior to the effective date of termination, and any obligations that expressly survive the termination of this Agreement. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>En cas de résiliation du présent Accord, tous les droits et obligations des Parties cesseront, à l'exception des droits et obligations ayant pris naissance avant la date effective de la résiliation et de toutes obligations qui survivent expressément à la résiliation du présent Accord. </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>2) Entire Agreement:
                        </b></p>
                    <p>This Agreement, along with its Appendices, represents the entire understanding between the Parties regarding the subject matter herein and supersedes all prior discussions, agreements, and understandings, whether oral or written, including the aforementioned Freelance Vendor T&C. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>2) Accord Complet:
                        </b></p>
                    <p>Le présent Accord, avec ses Annexes, représente l'intégralité de l'entente entre les Parties concernant l'objet des présentes et remplace toutes les discussions, accords et ententes antérieurs, qu'ils soient oraux ou écrits, y compris les Conditions Générales Freelance Vendor susmentionnées. </p>
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
                    <p style=' text-align: center;'> <b style="text-decoration: underline;">SCHEDULE A</b></p>

                    <p>Scope of Services / General Scope</p>
                    <p>Customer will request staffing support from provider based on Customer’s Client’s requirements. When Customer requests staffing support, Provider will present candidates to Customer subject to final approval by
                        Customer’s Client.
                    </p>
                    <p>Payroll Outsourcing Service </p>
                    <p>At Customer’s request, Provider will take whatever steps are necessary under local law to become the employer of record for candidates approved by Customer’s Client or its subcontractor. By law, those individuals will be independent consultants (“freelancers”) or employees of Provider or from its subcontractor (“Workers”) for either an indefinite or definite period. In case of subcontracting a partner for the service, all indemnification responsibilities will be assumed by the subcontractor of the Provider. </p>
                    <p>Provider or subcontractor will place the Workers on engagement with Customer’s Client pursuant to Customer’s instructions. Provider will manage all legal, fiscal, administrative, and similar employer obligations under local law. That includes, but is not limited to, executing a proper employment contract with the Worker, verifying the Worker’s identity and legal right to work, issuing appropriate wages, collecting/remitting social charges and tax or the like as required by local law, and offboarding a Worker compliantly. Extra engagement costs, not part of the regular hiring process such as background checks shall be included in the costs. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style=' text-align: center;'> <b style="text-decoration: underline;">ANNEXE A</b></p>

                    <p>Portée des Services / Portée Générale
                    </p>
                    <p>Le Client demandera un soutien en personnel au Fournisseur en fonction des besoins de ses propres clients. Lorsque le Client demande ce soutien en personnel, le Fournisseur présentera des candidats au Client, sous réserve de l'approbation finale par le client du Client. </p>
                    <p>Service de Sous-Traitance de la Paie </p>
                    <p>À la demande du Client, le Fournisseur prendra toutes les mesures nécessaires en vertu de la loi locale pour devenir l'employeur des candidats approuvés par le contratant du Client ou pour sous-traiter ce service. Ces individus seront des travailleurs autonomes ou des employés du
                        Fournisseur ou de son sous-traitant (“Travailleurs”) pour une période indéterminée ou déterminée. En cas de sous-traitance à un partenaire pour le service, toutes les responsabilités d'indemnisation seront assumées par le sous-traitant, assumée par le sous-traitant du Fournisseur.
                    </p>
                    <p>Le Fournisseur ou le sous-traitant placera les Travailleurs en engagement avec le client du Client conformément aux instructions du Client. Le Fournisseur gérera toutes les obligations légales, fiscales, administratives et similaires en tant qu'employeur conformément à la loi locale. Cela comprend, sans s'y limiter, la conclusion d'un contrat de travail approprié avec le Travailleur, la vérification de l'identité et du droit de travail du Travailleur, l'émission des salaires appropriés, la collecte/remise des charges sociales et des impôts ou autres obligations légales locales, ainsi que la sortie du Travailleur en conformité avec la loi. Les coûts supplémentaires d'engagement, non inclus dans le processus d'embauche régulier comme les vérifications de sécurité, seront inclus dans les coûts. </p>
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
                    <p>Throughout the Worker’s engagement, Customer will act as a liaison between Customer’s Client/Worker and the Provider as it relates to any pay rate changes, reimbursement needs, annual leave, termination inquiries, and the like. Provider agrees to promptly provide Customer with any information it needs to ensure Customer’s Client and Worker are informed of any local legal nuances. </p>
                    <p>Provider’s fee for its Payroll Outsourcing Service shall be 4.5% over the total gross earnings of the Freelancer and 32% of the Worker´s hourly rates including all taxes for Canada. Once the Customer confirms the Project and Rates, the Provider will issue a SOW detailing the costs for each case and that SOW will be integral part of this agreement. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Pendant l'engagement du Travailleur, le Client agira en tant que liaison entre le contratant du Client/Travailleur et le Fournisseur en ce qui concerne tout changement de taux de rémunération, besoins de remboursement, congés annuels, demandes de résiliation, etc. Le Fournisseur s'engage à fournir promptement au Client toutes les informations nécessaires pour s'assurer que le client du Client et le Travailleur sont informés de toutes les subtilités légales locales. </p>
                    <p>Les frais du Fournisseur pour son Service de Sous-Traitance de la Paie seront de 4,5 % sur le total des gains bruts du Travailleur indépendant et de 32 % du taux horaire du Travailleur, taxes comprises, pour le Canada. Une fois que le
                        Client confirme le projet et les tarifs, le Fournisseur émettra une Déclaration de Travail détaillant les coûts pour chaque cas, et cette Déclaration de Travail fera partie intégrante de cette entente.
                    </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Staffing Service </b></p>
                    <p>At Customer’s request, Provider will recruit, vet, and interview candidates pursuant to Customer’s Client’s requirements as communicated by Customer and following the local legislation. Provider will present such candidates to Customer subject to final approval by Customer’s Client. Fees for Contract Staffing will be agreed upon in writing on a case-by-case basis. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>Service de Recrutement </b></p>
                    <p>À la demande du Client, le Fournisseur recrutera, vérifiera et interviewera des candidats selon les exigences du client du Client telles que communiquées par le Client et conformément à la législation locale. Le Fournisseur présentera ces candidats au Client sous réserve de l'approbation finale par le contratant du Client. Les frais pour le Personnel Contractuel seront convenus par écrit au cas par cas. </p>

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
                </td>
                <td style="width: 50%; vertical-align: top;">
                </td>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>SCHEDULE B</p>

                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>A) WORKER DETAILS:</b> {{ $employeeName }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>COUNTRY OF WORK:</b> {{ $employeeCountryWork }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>JOB TITLE:</b> {{ $employeeJobTitle }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>START DATE:</b> {{ $employeeStartDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>END DATE:</b> {{ $employeeEndDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>GROSS WAGES:</b> CAD {{ number_format($employeeGrossSalary, 2) }} as Gross Monthly Salary.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='line-height: 1.5; text-align: center; font-weight: bold'>ANNEXE B</p>

                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>A) DÉTAILS DU TRAVAILLEUR:</b> {{ $employeeName }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>PAYS DE TRAVAIL:</b> {{ $employeeCountryWork }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>INTITULÉ DU POSTE:</b> {{ $employeeJobTitle }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>DATE DE DÉBUT:</b> {{ $employeeStartDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>DATE DE FIN:</b> {{ $employeeEndDate }}</p>
                    <p style="margin: 5; padding: 0; line-height: 1.5;"><b>SALAIRE BRUT :</b> CAD {{ number_format($employeeGrossSalary, 2) }} comme Salaire Mensuel Brut.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">PAYMENT METHOD: </b>
                    <p>Every 25th the Provider will submit the worked hours in the month and the Customer shall approve on the same day. Provider will issue an invoice based on it and Customer shall pay on the 10th of the following month to the latest. If payment is not processed in time, there will be a fine of 2% per month. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">MODE DE PAIEMENT: </b>
                    <p>Chaque 25 du mois, le Fournisseur soumettra les heures travaillées dans le mois et le Client devra approuver le même jour. Le Fournisseur émettra une facture sur cette base et le Client devra payer au plus tard le 10 du mois suivant. En cas de retard de paiement, des pénalités de 2 % par mois seront appliquées. </p>

                </td>
            </tr>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">LOCAL PAYMENT CONDITIONS:</b>
                    <p>Salaries and/or any other remuneration is set at the local currency of the Country where services is provided. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">CONDITIONS DE PAIEMENT LOCALES:</b>
                    <p>Les salaires et/ou toute autre rémunération sont établis dans la monnaie locale du pays où les services sont fournis. </p>
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
                    <b style="text-decoration: underline;">B) FEES AND PAYMENT TERMS:</b>
                    <p style='font-weight: bold'>PAYMENT TERMS</p>
                    <p><b>FEES:</b> Customer shall pay the Provider in a
                        monthly basis, based on the calculation
                        below:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">B) FRAIS ET CONDITIONS DE PAIEMENT: </b>
                    <p style='font-weight: bold'>CONDITIONS DE PAIEMENT </p>
                    <p><b>FRAIS:</b> Le Client devra payer le Fournisseur
                        mensuellement, selon le calcul suivant:
                    </p>
                </td>
            </tr>
        </table>
        <div style="margin-top: -20px !important">
            @include('pdf.uruguay_quotation', ['record' => $record->quotation, 'hideHeader' => true])
        </div>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main>

        <table style="margin-top: 35px !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="text-align: center"><b>Worked Hours x Gross Hourly Rate </b></p>
                    <p>Payments can be made by a banking wire transfer or using platforms but regardless of the method, the funds should clear on Provider´s </p>
                    <p>Payments can be made by a banking wire
                        transfer or using platforms but regardless of
                        the method, the funds should clear on
                        Provider´s bank account on the 10th of the
                        following month when the services have been
                        provided.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style='text-align: center'><b>Heures Travaillées x Taux Horaire Brut</b></p>
                    <p>Les paiements peuvent être effectués par
                        virement bancaire ou en utilisant des
                        plateformes, mais quelle que soit la méthode,
                        les fonds doivent être crédités sur le compte
                        bancaire du Fournisseur le 10 du mois suivant
                        la prestation des services.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <p>In addition to the monthly fee, there may be
                        additional costs required by law in the
                        Country where the Services are being
                        rendered. Additional costs may apply in the
                        following cases that Provider cannot
                        anticipate or predict, as following:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>En plus des frais mensuels, il peut y avoir des
                        coûts supplémentaires exigés par la loi dans
                        le pays où les services sont rendus. Des coûts
                        supplémentaires peuvent s'appliquer dans les
                        cas suivants que le Fournisseur ne peut pas
                        anticiper ou prévoir, comme suit:
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i)</b> Additional bonuses awarded by the Customer´s client; OR</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(i) </b>Des bonus supplémentaires accordés par
                        le client du Client, OU</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Any eventual local Government measures.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>(ii)</b> Toutes mesures gouvernementales locales
                        éventuelles.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LOCAL LEGISLATION - PREVAILS</b>
                    <p>The law that will govern this Service Agreement as well as the Worker’s engagement including their rights as an employee will be the law of the Province of Quebec in Canada where the Worker is providing the services. The Parties agree that all applicable law including but not limited to, labor and tax, and must be fully complied with the purposes of the local and global compliance guidelines. This Service Agreement replaces any other agreement and shall prevail over all other jurisdictions. </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b style="text-decoration: underline;">C) LÉGISLATION LOCALE - PRÉÉMINENCE </b>
                    <p>La loi qui régira cette Entente de Services ainsi que l'engagement du Travailleur, y compris ses droits en tant qu'employé, sera la loi de la Province de Québec au Canada où le
                        Travailleur fournit les services. Les Parties conviennent que toutes les lois applicables, y compris mais sans s'y limiter, le droit du travail et fiscal, doivent être pleinement respectées conformément aux directives de conformité locales et mondiales. Cette Entente de Services remplace tout autre accord et prévaudra sur toutes les autres juridictions.
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main style="page-break-after: avoid">

        <table style="margin-top: 35px !important">

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; margin-top: 20px;">
                        <b>GATE INTERMEDIANO INC.</b>
                    </div>
                    <br><br>
                    <div style="text-align: center; margin-top: 0px">
                        <img src="{{ public_path('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">Fernando Gutierrez</p>
                    <p style="text-align: center;margin-top: -20px">CEO</p>
                    <p style="text-align: left;margin-top: 10px">Phone: +1 514 907 5393</p>
                    <p style="text-align: left;margin-top: -10px">Email: <a href="">sac@intermediano.com</a></p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; margin-top: 20px;">
                        <b>GATE INTERMEDIANO INC.</b>
                    </div>
                    <br><br>
                    <div style="text-align: center; margin-top: 0px">
                        <img src="{{ public_path('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                    </div>
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">Fernando Gutierrez</p>
                    <p style="text-align: center;margin-top: -20px">CEO</p>
                    <p style="text-align: left;margin-top: 10px">Phone: +1 514 907 5393</p>
                    <p style="text-align: left;margin-top: -10px">Email: <a href="">sac@intermediano.com</a></p>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; margin-top: 20px;">
                        <b>{{ $companyName }}</b>
                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px;">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">{{ $companyContactName }} {{ $companyContactSurname }}</p>
                    <p style="text-align: center; margin-top: -20px">Name of the legal representative</p>
                    <p style="text-align: left;margin-top: 10px">Phone: {{ $companyPhone }}</p>
                    <p style="text-align: left;margin-top: -10px">Email: <a href="">{{ $companyEmail }}</a></p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="text-align: center; margin-top: 20px;">
                        <b>{{ $companyName }}</b>
                    </div>
                    <br><br>
                    @if($signatureExists)
                    <img src="{{ $is_pdf ? storage_path('app/public/' . $record->signature) : asset('storage/' . $record->employee_id) }}" alt="" style="height: 50px; margin-bottom: -10px;">
                    <p style="text-align: center; margin-bottom: 0px">{{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

                    @else
                    <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="" style="height: 50px; margin-bottom: -10px; margin-top: 65px">

                    @endif
                    <div style="width: 100%; border-bottom: 1px solid black;"></div>
                    <p style="text-align: center; margin-top: -20px">Représentant Légal: {{ $companyContactName }} {{ $companyContactSurname }}</p>
                    <p style="text-align: center; margin-top: -20px">Représentant Légal</p>
                    <p style="text-align: left;margin-top: 10px">Téléphone: {{ $companyPhone }}</p>
                    <p style="text-align: left;margin-top: -10px">Email: <a href="">{{ $companyEmail }}</a> </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
