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
$formattedDate = now()->format('jS');
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
$employeeNationality = $record->personalInformation->nationality ?? null;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeReferringGrossSalary = $employeeGrossSalary / 1.4;
$employeePositionTrustSalary = $employeeGrossSalary - $employeeReferringGrossSalary;
$employeeAddress = $record->personalInformation->address ?? null;
$employeeCity = $record->personalInformation->city ?? null;
$employeeState = $record->personalInformation->state ?? null;
$employeePostal = $record->personalInformation->postal_code ?? null;
$employeeEducation = $record->personalInformation->education_attainment ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('pt_BR', \NumberFormatter::SPELLOUT);
$personalId = $record->document->personal_id ?? null;
$personalTaxId = $record->document->tax_id ?? null;
$countryWork = $record->country_work ?? null;
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;
$signaturePath = 'signatures/employee_' . $record->id . '.webp';
$signatureExists = Storage::disk('public')->exists($signaturePath);
@endphp
<body>


    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">INDIVIDUAL AGREEMENT OF EMPLOYMENT</h4>
                    <p>Through this instrument and in accordance with the law,</p>
                    <p><b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA, </b>a Brazilian company, enrolled under the fiscal registration number 46.427.519/0001-51, located at Avenida das Americas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, herein referred to simply as, represented hereby by its legal representative in accordance with his Articles of Association, herein referred to simply as EMPLOYER.</p>
                    <p>And</p>
                    <p>{{ $employeeName }}, {{ $employeeNationality }}, {{ $employeeCivilStatus }}, {{ $employeeEducation }}, holder of Identification Card no. {{ $personalId }}, registered with the CPF under no. {{ $personalTaxId }}, residing and domiciled at {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeState }}, {{ $employeePostal }}, hereinafter referred to simply as the EMPLOYEE</p>
                    <p>Sign this INDIVIDUAL AGREEMENT OF EMPLOYMENT, pursuant to Decree-Law no. 5452/1943 (Labour Code – CLT) and the following agreed clauses:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO INDIVIDUAL DE TRABALHO</h4>
                    <p>Pelo presente instrumento e na melhor forma de direito, </p>
                    <p><b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA, </b>uma empresa brasileira, inscrita sob o número de registro fiscal 46.427.519/0001-51, localizado na Avenida das Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, CEP: 22.631-002, doravante denominada simplesmente de EMPREGADORA;</p>
                    <br><br><b></b>
                    <p>e</p>
                    <p>{{ $employeeName }}, {{ $employeeNationality }}, {{ $employeeCivilStatus }}, {{ $employeeEducation }}, portador(a) da Carteira de Identidade nº {{ $personalId }}, inscrito(a) no CPF sob o nº {{ $personalTaxId }}, residente e domiciliado(a) à {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeState }}, {{ $employeePostal }}, doravante denominado(a) simplesmente EMPREGADO(A);</p>
                    <p>Firmam o presente CONTRATO INDIVIDUAL DE TRABALHO, nos termos do Decreto-Lei n° 5.452/1943 (Consolidação das Leis do Trabalho – CLT) e das seguintes cláusulas, assim pactuadas:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 1 – Post</b>
                    <p>The EMPLOYEE undertakes to provide her services to the EMPLOYER, in the capacity of EMPLOYEE in the post of {{ $record->translatedPosition }}, her/his duties being defined in the job description attached and integrating the staff of the EMPLOYER.</p>
                    <br>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 1ª – Da Função</b>
                    <p>O EMPREGADO obriga-se a prestar seus serviços para a EMPREGADORA, na qualidade de EMPREGADO e na função de {{ $employeeJobTitle }}, aquelas previstas na anexa descrição do cargo, desse modo integrando o quadro de colaboradores da EMPREGADORA.</p>
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
                    <p>First Paragraph: The EMPLOYEE shall provide her services to satisfactorily support and comply with the obligations and objectives of the EMPLOYER.</p>
                    <p>Second Paragraph: The aforementioned services are inherent to the EMPLOYEE and may not be transferred in respect of the responsibilities of its execution thereof to another person who has not been previously employed for such purpose.</p>
                    <p>Third Paragraph: The EMPLOYEE undertakes to provide her services in strict compliance with civil, criminal, taxation, employment, social security and environmental legislation. The EMPLOYEE shall be liable for acting or failing to act, in violation of such legislation.</p>
                    <p>Fourth Paragraph: The EMPLOYER reserves the right to transfer the EMPLOYEE to another post or job for which it considers that she/he is better suited, always provided that this is compatible with her/his personal situation and subject to the applicable adjustments to this Agreement and to the respective record at the CTPS.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Parágrafo Primeiro: O EMPREGADO prestará seus serviços visando o satisfatório atendimento e cumprimento das obrigações e fins da EMPREGADORA.</p>
                    <p>Parágrafo Segundo: Os serviços mencionados acima são inerentes ao EMPREGADO, não podendo transferir sua responsabilidade na execução para outrem que não esteja previamente contratado para esse fim.</p>
                    <p>Parágrafo Terceiro: O EMPREGADO se compromete a executar seus serviços em estrito atendimento à legislação cível, criminal, tributária, trabalhista, previdenciária e ambiental, sob pena de ser responsabilizada por atos ou omissões que venham a infringir tais normas.</p>
                    <p>Parágrafo Quarto: A EMPREGADORA reserva-se o direito de proceder à transferência do EMPREGADO para outro cargo ou função, sobre a qual entenda que esta demonstre melhor capacidade de adaptação, desde que compatível com sua condição pessoal e mediante os devidos ajustes no presente Contrato e respectiva anotação na CTPS.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 2 – Exclusivity</b>
                    <p>The EMPLOYEE shall work on a professional basis for the EMPLOYER with exclusivity. The exercise of any other remunerated professional activity on an occasional and ancillary basis, whether for its own benefit and/or that of third parties is therefore prohibited, except in cases whereas the EMPLOYER grants prior authorisation in writing.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 2ª – Da Exclusividade</b>
                    <p>O EMPREGADO atuará profissionalmente de forma exclusiva para a EMPREGADORA, de modo que o exercício de qualquer outra atividade profissional a título ocasional e acessório, de maneira remunerada, seja visando benefício próprio e/ou de terceiros é, por conseguinte,
                        vedada, exceto nos casos em que a EMPREGADORA conceda autorização prévia por escrito.
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
                    <p>First Paragraph: The non-compliance of the obligation of exclusivity herein provided shall be deemed to be a default as provided for in art. 482(c) of the CLT, giving rise to valid grounds for the termination of this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p>Parágrafo Primeiro: A não observância da obrigação de exclusividade será considerada como falta grave, nos termos da alínea “c” do art. 482 da CLT, ensejando a rescisão do presente Contrato por justa causa.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 3 – Confidentiality</b>
                    <p>The EMPLOYEE formally undertakes not to divulge to third parties not related with this Agreement any information and/or data to which she/he has access deriving from the his/her services, in particular any document regarding the methods, clients organisation and/or operation of the EMPLOYER, either directly or indirectly, provided in any physical, magnetic and/or virtual media (paper, disc, copy, original, drawing, study, design, photograph, sample, etc), even involuntarily, related or unrelated with her/his functions. The EMPLOYEE shall be liable for any action, omission, negligence, imprudence or incompetence on her/his part.</p>
                    <br>
                    <p>First Paragraph: The EMPLOYEE and the EMPLOYER declare and acknowledge that all documents, data and/or information in respect of drawings, studies, designs, projects, research and any other information related to the activities of the EMPLOYER and/or its clients, that are divulged in whole or in part to its clients or internally, constitute professional secrecy and are reserved and confidential. </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 3ª – Da Confidencialidade</b>
                    <p>O EMPREGADO se compromete formalmente a não divulgar a terceiros não relacionados ao presente Contrato de Trabalho quaisquer informações e/ou dados a que tiver acesso em decorrência da prestação dos seus serviços, em especial quaisquer documentos sobre os métodos, clientes, organização e/ou o funcionamento da EMPREGADORA, direta ou indiretamente, em qualquer meio físico, magnético e/ou virtual (papel, discos, cópias, originais, planos, estudos, concepção, fotos, amostras, etc.), mesmo que involuntariamente, estejam ou não relacionados com suas funções, respondendo por quaisquer atos de ação, omissão, negligência, imprudência ou imperícia que praticar.</p>
                    <p>Parágrafo Primeiro: O EMPREGADO e a EMPREGADORA declaram e reconhecem que quaisquer documentos, dados e/ou informações, relativos aos planos, estudos, concepção, projetos, pesquisas e quaisquer outros relacionados às atividades da EMPREGADORA e/ou de seus clientes, total ou parcialmente divulgados para seus clientes ou internamente, constituem segredos profissionais, possuindo caráter de sigilo e confidencialidade.</p>
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
                    <p>Second Paragraph: The obligation of professional secrecy of the EMPLOYEE shall remain in force regardless the termination of this Agreement.</p>
                    <p>Third Paragraph: The breach of any obligations of confidentiality herein provided shall constitute a serious offence as provided for in art. 482 (g) of the CLT, giving rise to valid grounds for terminating this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Parágrafo Segundo: A obrigatoriedade de sigilo profissional pelo EMPREGADO permanecerá vigente mesmo após o encerramento do presente Contrato.</p>
                    <p>Parágrafo Terceiro: A violação de quaisquer obrigações de confidencialidade ora dispostas constituirá falta grave, nos termos da alínea “g” do art. 482 da CLT, ensejando a rescisão do presente Contrato por justa causa.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 4 – Validity</b>
                    <p>This Agreement shall be for a period of 90 (ninety) days probation period, starting on {{ $employeeStartDate }}, being one period of 45 days that can be extended for more 45 days. </p>
                    <p>After the probation period, the EMPLOYER shall notify the EMPLOYEE of any possible extension for undetermined period, when the agreement can be terminated at any time, at the initiative of both or one of the parties.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 4ª – Da Vigência</b>
                    <p>O presente contrato será pelo prazo determinado de 90 dias de experiência, a começar em {{ $employeeStartDate }}, sendo um prazo de 45 dias e podendo ser prorrogável por mais 45 dias.</p>
                    <p>Após o prazo de período de experiência, deverá a EMPREGADORA comunicar expressamente o EMPREGADO se tem interesse na continuidade do contrato, que passará a viger por prazo indeterminado, quando também poderá ser rescindido a qualquer tempo, por iniciativa de ambas ou uma das partes.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 5 – Remuneration</b>
                    <p>For the provision of services, the EMPLOYEE shall be entitled to a gross salary of R$ {{ $employeeGrossSalary }} ({{ strtoupper($formatter->format($employeeGrossSalary)) }} Reais), to be paid monthly by the EMPLOYER, no later than the 5th business day of the month following the provision of services. This amount includes a 40% bonus for a position of trust, in the sum of R$ {{ $employeePositionTrustSalary }} ({{ strtoupper($formatter->format($employeePositionTrustSalary)) }} Reais), as well as R$ {{ $employeeReferringGrossSalary }} ({{ strtoupper($formatter->format($employeeReferringGrossSalary)) }} Reais) related to the gross monthly salary.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 5ª – Da Remuneração</b>
                    <p>Pela prestação de seus serviços, o EMPREGADO fará jus a um salário bruto de R$ {{ $employeeGrossSalary }} ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }} Reais), a ser pago mensalmente pela EMPREGADORA, até o 5º dia útil do mês subsequente à prestação dos serviços. Este valor inclui uma gratificação de 40% correspondente ao cargo de confiança, no montante de R$ {{ $employeePositionTrustSalary }} ({{ strtoupper($formatterLocal->format($employeePositionTrustSalary)) }} Reais), além de R$ {{ $employeeReferringGrossSalary }} ({{ strtoupper($formatterLocal->format($employeeReferringGrossSalary)) }} Reais) referente ao salário bruto mensal."</p>
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
                    <p>First Paragraph: The EMPLOYER shall pay the EMPLOYEE the sum corresponding to the 13th salary divided into two instalments to be paid in November and December of each year.</p>
                    <p>Second Paragraph: The gross salary of the EMPLOYEE may be adjusted from time to time under conditions to be negotiated by the parties.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Parágrafo Primeiro: A EMPREGADORA pagará anualmente ao EMPREGADO o valor correspondente ao 13° Salário, dividida em duas parcelas a serem pagas em novembro e dezembro de cada ano.</p>
                    <p>Parágrafo Segundo: O salário bruto do EMPREGADO poderá ser reajustado, em tempo e condições a serem negociados pelas partes.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 6– Place of Work</b>
                    <p>The EMPLOYEE acknowledges and agrees that the services shall be provided, in principle, at {{ $countryWork }}, and without hours control, or where the EMPLOYER designates but they may also be provided in any other city of the national territory in accordance with the requirements and convenience of the EMPLOYER, pursuant to the provisions of art. 469 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 6ª – Do Local do Trabalho</b>
                    <p>O EMPREGADO está ciente e concorda que a prestação de seus serviços se dará, em princípio, na {{ $countryWork }}, e sem controle de horas, ou onde a EMPREGADORA designar, podendo também ocorrer em qualquer outra cidade do território nacional, de acordo com a necessidade e conveniência da EMPREGADORA, nos termos do que dispõe o art. 469 e parágrafos, da CLT.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 7 – Working Day</b>
                    <p>The EMPLOYEE shall not have a fixed or predetermined working day and shall solely perform her/his services and obligations during the time required by the EMPLOYER, which shall not be subject to control.</p>
                    <br>
                    <p>First Paragraph: The EMPLOYEE shall be entitled to a paid weekly rest period of not less than 24 (twenty- four) consecutive hours, as provided for in art. 67 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 7ª – Da Jornada</b>
                    <p>O EMPREGADO não cumprirá uma jornada de trabalho fixa ou pré-determinada, devendo tão-somente despender o tempo necessário ao satisfatório exercício de seus serviços e obrigações, motivo pelo qual não ficará subordinada ao controle de jornada.</p>
                    <p>Parágrafo Primeiro: O EMPREGADO fará jus ao repouso semanal remunerado, de duração mínima de 24 (vinte e quatro) horas consecutivas, nos termos do art. 67 da CLT.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 8 – Vacation</b>
                    <p>Following each period of 12 (twelve) months of the term of the Agreement, the EMPLOYEE shall have the right to enjoy vacation in a length inversely proportional to her/his absences, as provided for in art. 130 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 8ª – Das Férias</b>
                    <p>O EMPREGADO fará jus ao gozo de férias após cada período de 12 (doze) meses de vigência do contrato de trabalho, por período inversamente proporcional às suas faltas, nos termos do art. 130 da CLT.</p>
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
                    <b>Clause 9 – Travel Expenses</b>
                    <p>The EMPLOYER shall bear the EMPLOYEE’s expenses with travels in connection with work activities and exclusively related to the execution of the services.</p>
                    <p>10.1 – Should the EMPLOYEE bear such expenses; they may be reimbursed by the EMPLOYER upon the presentation of corresponding receipts and/or proof of payment.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 9ª – Das Despesas com Viagens</b>
                    <p>A EMPREGADORA arcará com as despesas do EMPREGADO decorrentes de viagens a trabalho e que estejam unicamente relacionadas com a prestação dos serviços.</p>
                    <p>10.1 – Caso o EMPREGADO arque com tais despesas, poderá ser ressarcido pela EMPREGADORA mediante a apresentação de recibos e/ou comprovantes de pagamento.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 10 – Transfer Expenses </b>
                    <p>The EMPLOYER shall assist the EMPLOYEE with costs resulting from possible transfer of the place of execution of the services as compensation for expenses incurred. </p>
                    <br>
                    <p>11.1 – Assistance with such costs shall be paid upon proof of expenses incurred for such purposes, provided that such transfer requires change of residence of the EMPLOYEE, as provided for in art. 469 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 10ª – Das Despesas Decorrentes de Transferências</b>
                    <p>A EMPREGADORA fornecerá ao EMPREGADO ajuda de custo, em decorrência de eventual transferência do local da prestação de serviços, visando o ressarcimento de despesas efetuadas.</p>
                    <p>11.1 – A ajuda de custo será fornecida desde que a transferência implique na imprescindível mudança de domicílio do EMPREGADO, nos termos do art. 469 da CLT, mediante a comprovação das despesas efetuadas para tal fim.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 11 – Deductions </b>
                    <p>The EMPLOYEE authorises the deduction from her/his salary of amounts advanced to her/him by the EMPLOYER, jointly with the statutory deductions, in particular those for social security purposes.</p>
                    <p>First Paragraph: Should the EMPLOYEE cause any damages arising from fraudulent or culpable conduct, she/he shall be obliged to compensate the EMPLOYER for all damage caused.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 11ª – Dos Descontos</b>
                    <p>O EMPREGADO autoriza o desconto em seu salário das importâncias que lhe forem adiantadas pela EMPREGADORA, bem como os descontos legais, sobretudo os previdenciários.</p>
                    <p>Parágrafo Primeiro: Sempre que causar qualquer prejuízo, resultante de alguma conduta dolosa ou culposa, ficará o EMPREGADO obrigado a ressarcir a EMPREGADORA por todos os danos causados.</p>
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
                    <b>Clause 12 – Special Provisions</b>
                    <p>The EMPLOYEE undertakes to respect the regulations of the company, which she/he acknowledges to be aware of, and to adopt irreproachable conduct in the working environment and abide the administrative procedures appropriate to prevent the loss of any confidential document or information. The EMPLOYEE shall inform the EMPLOYER immediately of the occurrence of any event of this nature, which shall not exclude her/his liability in case of default or misconduct from any action, omission, negligence or imprudence on her/his part.</p>
                    <p>First Paragraph: The occurrence of the events provided in art. 482 of the CLT shall constitute cause for immediate and due and proper dismissal of the EMPLOYEE, especially blatant disrespect or physical aggression towards any Director or hierarchical superior belonging to the EMPLOYER’s staff, disrespect or physical aggression towards any employee, partner or third party associated with the EMPLOYER in the workplace, any act of indiscipline or insubordination and drunkenness at work.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 12ª – Das Disposições Especiais</b>
                    <br>
                    <p>O EMPREGADO compromete-se a respeitar o regulamento da empresa, o qual declara conhecer, mantendo conduta irrepreensível no ambiente de trabalho, assim como a manter os procedimentos administrativos adequados à prevenção de extravio ou perda de quaisquer documentos ou informações confidenciais, devendo comunicar à EMPREGADORA, imediatamente, a ocorrência de incidentes desta natureza, o que não excluirá sua responsabilidade, caso apuradas quaisquer falhas decorrentes ação, omissão, negligência ou imprudência.</p>
                    <p>Parágrafo Primeiro: Constituirão motivos para imediata e justa dispensa do EMPREGADO, aqueles previstos no art. 482 da CLT, dentre os quais deve-se destacar o desacato moral ou agressão física a qualquer Diretor ou superior hierárquico da EMPREGADORA, o desacato moral ou agressão física a qualquer empregado, parceiro ou terceiros que se relacionem com a EMPREGADORA, no local de trabalho, qualquer ato de indisciplina ou de insubordinação e a embriaguez no serviço.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 13 – Competent Court</b>
                    <p>Pursuant to art. 651, of the CLT, the court of the District of City of Rio de Janeiro shall be competent to resolve any dispute arising from the AGREEMENT.</p>
                    <p>In witness whereof, they sign this Agreement of Employment in 02 (two) copies of identical content and form in the presence of 02 (two) witnesses, as required by law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 13ª – Eleição do Foro</b>
                    <p>Para dirimir quaisquer controvérsias oriundas do CONTRATO, será competente o foro da Comarca do Rio de Janeiro, de acordo com o art. 651, da CLT.</p>
                    <p>E por estarem assim justos e contratados, nos termos de seus respectivos interesses, de tudo cientes, assinam o presente Contrato de Trabalho, em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas, para as finalidades de direito.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main>
        <table style="margin: 100px 0 !important">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Rio de Janeiro, {{ $currentDate }}</p>
                    <div style="text-align: center; position: relative;">
                        <div style="display: inline-block; position: relative;">
                            <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                        </div>

                        <div style="width: 70%; border-bottom: 1px solid black; margin: 10px auto 0; z-index:100"></div>

                        <b>INTERMEDIANO DO BRASIL</b> <br>
                        <b>APOIO ADMINISTRATIVO LTDA</b>
                    </div>

                    <div style="text-align: center; position: relative; margin-top: 40px">
                        <div style="display: inline-block; position: relative;">
                            @if($signatureExists)
                            <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->id . '.webp') : asset('storage/signatures/employee_' . $record->id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                            <p style="text-align: left">{{ $employeeCity }}, {{ $currentDate }}</p>

                            @endif
                        </div>

                        <div style="width: 70%; border-bottom: 1px solid black; margin: -10px auto 0; z-index:100"></div>

                        <b>{{ $employeeName }}</b>
                    </div>

                    <p style="margin-bottom: 30px">Witnesses:</p>
                    <div style="width: 90%; border-bottom: 1px solid black;"></div>
                    <p>Name:</p>
                    <p>CPF:</p>
                    <p>RG:</p>
                    <div style="width: 90%; border-bottom: 1px solid black; margin-top: 30px"></div>
                    <p>Name:</p>
                    <p>CPF:</p>
                    <p>RG:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Rio de Janeiro, {{ $currentDate }}</p>
                    <div style="text-align: center; position: relative;">
                        <div style="display: inline-block; position: relative;">
                            <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                        </div>
                        <div style="width: 70%; border-bottom: 1px solid black; margin: 10px auto 0; z-index:100"></div>

                        <b>INTERMEDIANO DO BRASIL</b> <br>
                        <b>APOIO ADMINISTRATIVO LTDA</b>
                    </div>
                    <div style="text-align: center; position: relative; margin-top: 40px">
                        <div style="display: inline-block; position: relative;">
                            @if($signatureExists)
                            <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->id . '.webp') : asset('storage/signatures/employee_' . $record->id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;">
                            <p style="text-align: left">{{ $employeeCity }}, {{ $currentDate }}</p>
                            @endif
                        </div>

                        <div style="width: 70%; border-bottom: 1px solid black; margin: -10px auto 0; z-index:100"></div>


                        <b>{{ $employeeName }}</b>
                    </div>
                    <p style="margin-bottom: 30px">Testemunhas:</p>
                    <div style="width: 90%; border-bottom: 1px solid black;"></div>
                    <p>Nome:</p>
                    <p>CPF:</p>
                    <p>RG:</p>

                    <div style="width: 90%; border-bottom: 1px solid black; margin-top: 30px"></div>
                    <p>Nome:</p>
                    <p>CPF:</p>
                    <p>RG:</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <div style="border: 1px solid rgb(188, 188, 188); margin: 0px 10px 0 10px; padding: 20px; page-break-after: always;">

        <b style="text-align: center">ANNEX I</b>
        <b>ANNEX TO THE INDIVIDUAL EMPLOYMENT CONTRACT FOR A FIXED TERM</b>
        <b>JOB DESCRIPTION</b>
        <p style="margin-top: 20px"></p>

        <p>The non-exhaustive list of key responsibilities includes:</p>
        {!! $jobDescription !!}
        {!! $jobDescription !!}

    </div>
    @include('pdf.contract.layout.header')
    <div style="border: 1px solid rgb(188, 188, 188); margin: 20px 10px 0 10px; padding: 20px;">
        <b style="text-align: center">ANEXO I</b>
        <b>ANEXO AO CONTRATO INDIVIDUAL DE TRABALHO POR PRAZO DETERMINADO</b>
        <b>DESCRIÇÃO DAS FUNÇÕES</b>
        <p style="margin-top: 20px"></p>

        <p>A lista não exaustiva de responsabilidades principais inclui:</p>
        {!! $translatedJobDescription !!}
        {!! $translatedJobDescription !!}

    </div>
    @include('pdf.contract.layout.footer')

</body>

</html>
