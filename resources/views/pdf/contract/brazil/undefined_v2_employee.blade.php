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
$contractCreatedDate = (new DateTime($record->created_at))->format('[d/m/Y]');
$companyName = $record->company->name;
$customerAddress = $record->company->address;
$customerPhone = $record->companyContact->phone;
$customerEmail = $record->companyContact->email;
$customerName = $record->companyContact->contact_name;
$customerPosition = $record->companyContact->position;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->nationality ?? 'N/A';
$employeeCivilStatus = $record->personalInformation->civil_status ?? 'N/A';
$employeeJobTitle = $record->job_title ?? 'N/A';
$employeeGrossSalary = $record->gross_salary;
$employeeReferringGrossSalary = number_format($employeeGrossSalary / 1.4, 2);
$employeePositionTrustSalary = number_format($employeeGrossSalary - $employeeReferringGrossSalary, 2);
$employeeAddress = $record->personalInformation->address ?? 'N/A';
$employeeCity = $record->personalInformation->city ?? 'N/A';
$employeeState = $record->personalInformation->state ?? 'N/A';
$employeePostal = $record->personalInformation->postal_code ?? 'N/A';
$employeeEducation = $record->personalInformation->education_attainment ?? 'N/A';
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('pt_BR', \NumberFormatter::SPELLOUT);
$personalId = $record->document->personal_id ?? 'N/A';
$personalTaxId = $record->document->tax_id ?? 'N/A';
$countryWork = $record->country_work ?? 'N/A';
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;
$signaturePath = 'signatures/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('public')->exists($signaturePath);
$signedDate = $record->signed_contract ? new DateTime($record->signed_contract) : null;
$cutoffDate = new DateTime('2025-07-11');
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name ?? '';

$user = auth()->user();
$isAdmin = $user instanceof \App\Models\User;
$type = $isAdmin ? 'admin' : 'employee';
@endphp
<style>
    .non-pdf h4 {
        font-weight: bold;
    }

    .non-pdf p {
        line-height: 1.7 !important;
    }

    .short-lineheight {
        line-height: 1.5
    }

</style>
<body>


    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">INDIVIDUAL AGREEMENT OF EMPLOYMENT</h4>
                    <p>Through this instrument and in accordance with the law,</p>
                    <p><b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA, </b>a Brazilian company, enrolled under the fiscal registration number 46.427.519/0001-51, located at Avenida das Americas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, Zip Code: 22.631-002, herein referred to simply as, represented hereby by its legal representative in accordance with his Articles of Association, herein referred to simply as EMPLOYER.</p>
                    <p>And</p>
                    <p>{{ $employeeName }}, {{ $employeeNationality }}, {{ $employeeCivilStatus }}, {{ $employeeEducation }}, holder of Identification Card no. {{ $personalId }}, registered with the CPF under no. {{ $personalTaxId }}, residing and domiciled at {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeState }}, {{ $employeePostal }}, hereinafter referred to simply as the EMPLOYEE;</p>
                    <p>Sign this INDIVIDUAL AGREEMENT OF EMPLOYMENT, pursuant to Decree-Law no. 5452/1943 (Labour Code – CLT) and the following agreed clauses:</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO INDIVIDUAL DE TRABALHO</h4>
                    <p>Pelo presente instrumento e na melhor forma de direito, </p>
                    <p><b>INTERMEDIANO DO BRASIL APOIO ADMINISTRATIVO LTDA, </b>uma empresa brasileira, inscrita sob o número de registro fiscal 46.427.519/0001-51, localizado na Avenida das Américas 02901, sala 516, Barra da Tijuca, Rio de Janeiro/RJ, CEP: 22.631-002, doravante denominada simplesmente de EMPREGADORA.</p>
                    <br><br><b></b>
                    <p>e</p>
                    <p>{{ $employeeName }}, {{ $employeeNationality }}, {{ $employeeCivilStatus }}, {{ $employeeEducation }}, portador(a) da Carteira de Identidade nº {{ $personalId }}, inscrito(a) no CPF sob o nº {{ $personalTaxId }}, residente e domiciliado(a) à {{ $employeeAddress }}, {{ $employeeCity }}, {{ $employeeState }}, {{ $employeePostal }}, doravante denominado(a) simplesmente EMPREGADO(A);</p>
                    <p>Firmam o presente CONTRATO INDIVIDUAL DE TRABALHO, nos termos do Decreto-Lei n° 5.452/1943 (Consolidação das Leis do Trabalho – CLT) e das seguintes cláusulas, assim pactuadas:</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 1 – About the Position</b>
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
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
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
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
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
                    <p>The EMPLOYEE hereby acknowledges that the employment constitutes a relationship of confidence and trust between the EMPLOYEE and the EMPLOYER with respect to certain information of a confidential or proprietary secret nature, which gives the EMPLOYER a competitive edge in its business (the “Confidential Information”).</p>
                    <p>The Confidential Information includes particularly without limitation: trademarks, patents, service marks, logos, designs of the EMPLOYER, decisions, plans and budgets, unpublished results, remunerations, sales predictions, sales marketing and sales plans, product development plans, competitive analysis, business and financial plans or forecast, non public financial information, contracts and customer and employee lists of the EMPLOYER, contract, engagement letters, all information or material which relates to the EMPLOYER’S know-how in production, marketing or licensing and all information which the EMPLOYER has a legal obligation to treat as confidential, or which the EMPLOYER treats as proprietary or designates as confidential, or for internal use only.</p>
                    <p>Confidential information does not include information that is publicly known or that becomes generally known (otherwise than due to error or breach of obligations by the EMPLOYEE) either during or after termination of employment, nor information commonly used in business by a large number of entities, as well as general knowledge learned during similar jobs elsewhere.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 3ª – Da Confidencialidade</b>
                    <p class="short-lineheight">O EMPREGADO reconhece que o emprego constitui uma relação de confiança entre o EMPREGADO e o EMPREGADOR com relação a determinadas informações de natureza confidencial ou proprietária, que conferem ao EMPREGADOR uma vantagem competitiva em seus negócios (as “Informações Confidenciais”).</p>
                    <p class="short-lineheight">As Informações Confidenciais incluem, sem limitação: marcas registradas, patentes, marcas de serviço, logotipos, designs do EMPREGADOR, decisões, planos e orçamentos, resultados não publicados, remunerações, previsões de vendas, estratégias e planos de marketing e vendas, planos de desenvolvimento de produtos, análises competitivas, planos ou previsões comerciais e financeiras, informações financeiras não públicas, contratos e listas de clientes e empregados do EMPREGADOR, cartas de compromisso, todas as informações ou materiais relacionados ao know-how do EMPREGADOR em produção, marketing ou licenciamento e todas as informações que o EMPREGADOR tenha obrigação legal de tratar como confidenciais, ou que o EMPREGADOR trate como proprietárias ou designe como confidenciais, ou para uso interno apenas.</p>
                    <p class="short-lineheight">Informações Confidenciais não incluem informações de conhecimento público ou que se tornem geralmente conhecidas (exceto em razão de erro ou violação de obrigações pelo EMPREGADO), seja durante ou após a rescisão do contrato de trabalho, nem informações comumente utilizadas nos negócios por um grande número de entidades, bem como conhecimentos gerais adquiridos em funções semelhantes em outras empresas.</p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')

    </main>
    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p class='short-lineheight'>The EMPLOYEE shall be released from the obligations defined in the above paragraphs of this Article only with the previously obtained written consent of the EMPLOYEE.</p>
                    <p class='short-lineheight'>Obligations under this Article shall not prevent the disclosure of information required by law or other mandatory regulations.</p>
                    <p class='short-lineheight'>Upon termination of this Agreement for whatsoever reason, the EMPLOYEE undertakes to return immediately to the EMPLOYER any confidential materials in its possession, whether in hard copy or electronic form. Furthermore, the EMPLOYEE undertakes not to keep any copies of such documents and materials. All such materials and documents shall remain the property of the EMPLOYER.</p>
                    <p class='short-lineheight'>The EMPLOYEE will not transmit, publish or disclose Confidential Information directly or indirectly to any third party, and undertakes to use the same level of care to prevent any access to any Confidential Information or similar documents used by the EMPLOYER, and in any case not less than objective expectation of attention; and that he/she will not use Confidential Information except for the purpose of performing the tasks and duties for which the EMPLOYER has hired him/her.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class='short-lineheight'>O EMPREGADO será liberado das obrigações definidas nos parágrafos acima deste Artigo somente mediante consentimento prévio e por escrito do EMPREGADOR.</p>
                    <p class='short-lineheight'>As obrigações deste Artigo não impedirão a divulgação de informações exigidas por lei ou regulamentos obrigatórios.</p>
                    <p class='short-lineheight'>Após a rescisão deste Contrato, por qualquer motivo, o EMPREGADO compromete-se a devolver imediatamente ao EMPREGADOR quaisquer materiais confidenciais em sua posse, seja em formato físico ou eletrônico. Além disso, o EMPREGADO compromete-se a não manter cópias desses documentos e materiais. Todos esses materiais e documentos permanecerão propriedade exclusiva do EMPREGADOR.</p>
                    <p class='short-lineheight'>O EMPREGADO não transmitirá, publicará ou divulgará Informações Confidenciais direta ou indiretamente a terceiros, e compromete-se a usar o mesmo nível de cuidado para evitar qualquer acesso às Informações Confidenciais ou documentos semelhantes utilizados pelo EMPREGADOR, e, em qualquer caso, a não empregar um nível de atenção inferior ao esperado objetivamente. Além disso, o EMPREGADO não utilizará as Informações Confidenciais, exceto para o propósito de desempenhar as funções para as quais foi contratado pelo EMPREGADOR.</p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p class='short-lineheight'>Second Paragraph: The obligation of professional secrecy of the EMPLOYEE shall remain in force regardless the termination of this Agreement.</p>
                    <p class='short-lineheight'>Third Paragraph: The breach of any obligations of confidentiality herein provided shall constitute a serious offence as provided for in art. 482 (g) of the CLT, giving rise to valid grounds for terminating this Agreement.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class='short-lineheight'>Parágrafo Segundo: A obrigatoriedade de sigilo profissional pelo EMPREGADO permanecerá vigente mesmo após o encerramento do presente Contrato.</p>
                    <p class='short-lineheight'>Parágrafo Terceiro: A violação de quaisquer obrigações de confidencialidade ora dispostas constituirá falta grave, nos termos da alínea “g” do art. 482 da CLT, ensejando a rescisão do presente Contrato por justa causa.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

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
                    <p>For the provision of services, the EMPLOYEE shall be entitled to a gross salary of R$ {{ number_format($employeeGrossSalary, 2) }} ({{ strtoupper($formatter->format($employeeGrossSalary)) }} Reais), to be paid monthly by the EMPLOYER, no later than the 5th business day of the month following the provision of services. This amount includes a 40% bonus for a position of trust, in the sum of R$ {{ number_format($employeePositionTrustSalary, 2) }} ({{ strtoupper($formatter->format($employeePositionTrustSalary)) }} Reais), as well as R$ {{ number_format($employeeReferringGrossSalary, 2) }} ({{ strtoupper($formatter->format($employeeReferringGrossSalary)) }} Reais) related to the gross monthly salary.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 5ª – Da Remuneração</b>
                    <p>Pela prestação de seus serviços, o EMPREGADO fará jus a um salário bruto de R$ {{ number_format($employeeGrossSalary, 2) }} ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }} Reais), a ser pago mensalmente pela EMPREGADORA, até o 5º dia útil do mês subsequente à prestação dos serviços. Este valor inclui uma gratificação de 40% correspondente ao cargo de confiança, no montante de R$ {{ number_format($employeePositionTrustSalary, 2) }} ({{ strtoupper($formatterLocal->format($employeePositionTrustSalary)) }} Reais), além de R$ {{ number_format($employeeReferringGrossSalary, 2) }} ({{ strtoupper($formatterLocal->format($employeeReferringGrossSalary)) }} Reais) referente ao salário bruto mensal.</p>
                </td>
            </tr>
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

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')

    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 6– Place of Work</b>
                    <p class='short-lineheight'>The EMPLOYEE acknowledges and agrees that the services shall be provided, in principle, at {{ $countryWork }}, and without hours control, or where the EMPLOYER designates but they may also be provided in any other city of the national territory in accordance with the requirements and convenience of the EMPLOYER, pursuant to the provisions of art. 469 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 6ª – Do Local do Trabalho</b>
                    <p class='short-lineheight'>O EMPREGADO está ciente e concorda que a prestação de seus serviços se dará, em princípio, na {{ $countryWork }}, e sem controle de horas, ou onde a EMPREGADORA designar, podendo também ocorrer em qualquer outra cidade do território nacional, de acordo com a necessidade e conveniência da EMPREGADORA, nos termos do que dispõe o art. 469 e parágrafos, da CLT.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 7 – Working Day</b>
                    <p class='short-lineheight'>The EMPLOYEE shall not have a fixed or predetermined working day and shall solely perform her/his services and obligations during the time required by the EMPLOYER, which shall not be subject to control.</p>
                    <br>
                    <p class='short-lineheight'>First Paragraph: The EMPLOYEE shall be entitled to a paid weekly rest period of not less than 24 (twenty- four) consecutive hours, as provided for in art. 67 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 7ª – Da Jornada</b>
                    <p class='short-lineheight'>O EMPREGADO não cumprirá uma jornada de trabalho fixa ou pré-determinada, devendo tão-somente despender o tempo necessário ao satisfatório exercício de seus serviços e obrigações, motivo pelo qual não ficará subordinada ao controle de jornada.</p>
                    <p class='short-lineheight'>Parágrafo Primeiro: O EMPREGADO fará jus ao repouso semanal remunerado, de duração mínima de 24 (vinte e quatro) horas consecutivas, nos termos do art. 67 da CLT.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 8 – Vacation</b>
                    <p class='short-lineheight'>Following each period of 12 (twelve) months of the term of the Agreement, the EMPLOYEE shall have the right to enjoy vacation in a length inversely proportional to her/his absences, as provided for in art. 130 of the CLT.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 8ª – Das Férias</b>
                    <p class='short-lineheight'>O EMPREGADO fará jus ao gozo de férias após cada período de 12 (doze) meses de vigência do contrato de trabalho, por período inversamente proporcional às suas faltas, nos termos do art. 130 da CLT.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 9 – Travel Expenses</b>
                    <p class='short-lineheight'>The EMPLOYER shall bear the EMPLOYEE’s expenses with travels in connection with work activities and exclusively related to the execution of the services.</p>
                    <p class='short-lineheight'>10.1 – Should the EMPLOYEE bear such expenses; they may be reimbursed by the EMPLOYER upon the presentation of corresponding receipts and/or proof of payment.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 9ª – Das Despesas com Viagens</b>
                    <p class='short-lineheight'>A EMPREGADORA arcará com as despesas do EMPREGADO decorrentes de viagens a trabalho e que estejam unicamente relacionadas com a prestação dos serviços.</p>
                    <p class='short-lineheight'>10.1 – Caso o EMPREGADO arque com tais despesas, poderá ser ressarcido pela EMPREGADORA mediante a apresentação de recibos e/ou comprovantes de pagamento.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

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
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 12 – Intellectual Property Rights</b>
                    <p>Nothing in this Agreement shall be deemed to be the granting or assignment of a license to an EMPLOYEE by the EMPLOYER, any existing or future intellectual property right in respect of which the EMPLOYER has a right of ownership or a right of use.</p>
                    <p>For the purposes of this Contract, the term “Intellectual Property” includes patents, rights to inventions, copyright and related rights, moral rights (to the extent permitted by law),</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 12ª – Direito de Propriedade Intelectual</b>
                    <p>Nada neste Contrato será interpretado como concessão ou atribuição de uma licença ao EMPREGADO pelo EMPREGADOR, referente a qualquer direito de propriedade intelectual existente ou futuro sobre o qual o EMPREGADOR detenha direito de propriedade ou de uso.</p>
                    <p>Para os fins deste Contrato, o termo “Propriedade Intelectual” inclui patentes, direitos sobre invenções, direitos autorais e direitos conexos, direitos morais (na medida permitida por lei), </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>trademarks and service marks, trade names and domain names, rights in get-up, rights to goodwill or to sue for passing off, rights in designs, rights in computer software, database rights, rights in confidential information (including know-how and trade secrets) and any other intellectual property rights, in each case whether registered or unregistered and including all applications (or rights to apply) for, and renewals or extensions of, such rights and all similar or equivalent rights or forms of protection which subsist now or will subsist in the future in any part of the world because of what was produced, invented or discovered by the EMPLOYEE, whether alone or with any other person, at any time during his employment with the EMPLOYER which relates directly or indirectly to the business of the EMPLOYER or which may, in the reasonable opinion of the EMPLOYER, be capable of being used or adapted for use therein.</p>

                    <p>All Intellectual Property to which this section applies shall, to the fullest extent permitted by law, belong to, vest in and be the absolute, sole, exclusive and unencumbered property of the EMPLOYER.</p>

                    <p style='text-align: center'>The EMPLOYEE hereby undertakes:</p>
                    <p>To notify and disclose to the EMPLOYER in writing full details of all Intellectual Property to which this section applies promptly upon the production, invention or discovery of same, and promptly, whenever requested by the EMPLOYER, and in any event upon the termination of employment with the EMPLOYER, to deliver up to the EMPLOYER all correspondence and other documents, papers and records and all copies thereof in the EMPLOYEE’S possession, custody or power relating to any Intellectual Property;</p>



                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>marcas registradas e marcas de serviço, nomes comerciais e nomes de domínio, direitos sobre embalagens e identidade visual, direitos sobre fundo de comércio ou para ações de concorrência desleal, direitos sobre designs, direitos sobre software, direitos sobre bancos de dados, direitos sobre informações confidenciais (incluindo know-how e segredos comerciais) e quaisquer outros direitos de propriedade intelectual, sejam registrados ou não, incluindo todas as aplicações (ou direitos de aplicação), renovações ou extensões desses direitos e todos os direitos semelhantes ou equivalentes que existam ou venham a existir no futuro em qualquer parte do mundo, em razão de criações, invenções ou descobertas feitas pelo Empregado, sozinho ou com qualquer outra pessoa, a qualquer momento durante seu emprego com o EMPREGADOR e que estejam direta ou indiretamente relacionadas aos negócios do EMPREGADOR ou que, na opinião razoável do EMPREGADOR, possam ser utilizados ou adaptados para uso nos negócios.</p>

                    <p>Toda a Propriedade Intelectual a que se aplica esta seção pertencerá, na máxima extensão permitida por lei, exclusivamente ao EMPREGADOR, sendo de sua propriedade absoluta, exclusiva e sem ônus.</p>
                    <p style='text-align: center'>O EMPREGADO compromete-se a:</p>
                    <p>Notificar e divulgar ao EMPREGADOR, por escrito, todos os detalhes da Propriedade Intelectual a que se aplica esta seção, imediatamente após sua criação, invenção ou descoberta, e sempre que solicitado pelo EMPREGADOR. Além disso, no momento da rescisão do emprego, entregar ao EMPREGADOR toda a correspondência, documentos, papéis e registros relacionados à Propriedade Intelectual em sua posse, custódia ou poder.</p>


                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>To hold on trust for the benefit of the EMPLOYER any Intellectual Property to the extent that the same may not be, and until the same is, vested absolutely in the EMPLOYER.</p>
                    <p>Assign, by way of present assignment of future copyright, all copyright in all Intellectual Property to which this section applies.</p>
                    <p class='short-lineheight'>Acknowledge that, save as provided in this Contract, no further remuneration or compensation is or may become due to the EMPLOYEE in respect of his performance of EMPLOYEE’S obligations under this section.</p>
                    <p class='short-lineheight'>Irrevocably appoint the EMPLOYER to be EMPLOYEE’S attorney in his name and on his behalf to execute and do any such instruments or things and generally to use EMPLOYEE’S name for the purpose of giving to the EMPLOYER (or its nominee) the full benefit of the provisions of this section. EMPLOYEE acknowledge in favour of third party a certificate in writing signed by any director or the secretary of the EMPLOYER that any instrument or act falls within the authority conferred shall be conclusive evidence that such is the case.</p>
                    <p class='short-lineheight'>Agree to give all necessary assistance to the EMPLOYER, at the EMPLOYER’S reasonable cost, to vest the Intellectual Property in the EMPLOYER or its nominees, to enable it to enforce its Intellectual Property rights against third parties, to defend claims for infringement of third party IP rights and to apply for registration of Intellectual Property, where appropriate throughout the world, and for the full term of those rights. Such documents may, at the EMPLOYER'S request, include waivers of all and any statutory moral rights relating to any copyright works which form part of the EMPLOYER’S Intellectual Property pursuant to this Agreement. This Clause shall survive termination of this contract.</p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Manter a Propriedade Intelectual em confiança para benefício do EMPREGADOR, na medida em que a mesma não seja imediatamente transferida ou esteja em processo de ser transferida integralmente para o EMPREGADOR.</p>
                    <p>Ceder, por meio deste contrato, todos os direitos autorais relacionados à Propriedade Intelectual abrangida por esta seção.</p>
                    <p class='short-lineheight'>Reconhecer que, salvo disposição em contrário neste Contrato, nenhuma remuneração adicional ou compensação será devida ao EMPREGADO pelo cumprimento de suas obrigações sob esta seção.</p>
                    <p class='short-lineheight'>Nomear irrevogavelmente o EMPREGADOR como seu procurador, autorizando-o a executar e tomar todas as medidas necessárias para garantir que os benefícios desta seção sejam conferidos integralmente ao EMPREGADOR (ou seus indicados). Um certificado por escrito, assinado por um diretor ou secretário do EMPREGADOR, confirmando que um ato ou documento está dentro da autoridade concedida, será prova conclusiva desse fato.</p>
                    <p class='short-lineheight'>Prestar toda a assistência necessária ao EMPREGADOR, a custos razoáveis deste, para garantir a propriedade da Propriedade Intelectual pelo EMPREGADOR ou seus indicados, bem como para proteger seus direitos contra terceiros, defender reivindicações de infração e solicitar registros de Propriedade Intelectual, conforme aplicável em qualquer parte do mundo e pelo período integral desses direitos. Se solicitado pelo EMPREGADOR, tal assistência incluirá a renúncia de quaisquer direitos morais estatutários relativos a obras protegidas por direitos autorais que façam parte da Propriedade Intelectual do EMPREGADOR, de acordo com este Contrato. Esta cláusula sobreviverá à rescisão deste Contrato.</p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <p>To the extent that, by law, any Intellectual Property or the rights therein do not, or are not permitted to or cannot, vest in or belong to the EMPLOYER, the EMPLOYEE hereby grants to the EMPLOYER an irrevocable, unlimited, royalty free, worldwide right and license to copy, publicly display, publicly perform, distribute, use, make, sell, offer to sell, import, modify and create derivative works of the Intellectual Property and to distribute same, directly or indirectly, through any number or manner of distribution channels.</p>
                    <p>EMPLOYEE shall not include any Intellectual Property Rights in which a third party has intellectual property rights, or which has been developed by the EMPLOYEE or on his behalf prior to commencing employment or in which the EMPLOYEE claims ownership rights, in any EMPLOYER software, documentation or materials without the prior express written consent of an authorized representative of the EMPLOYER. If the EMPLOYEE does so include such Intellectual Property Rights, the EMPLOYEE hereby expressly assigns the ownership of such Intellectual Property Rights to the EMPLOYER and such material shall be deemed to have been created during the employment for the purposes
                        of this Contract and the terms of this Contract shall apply as if the work had been created during EMPLOYEE’S
                        employment. EMPLOYEE shall not include any material covered by third party Intellectual Property Rights or material licensed under an “open source” or similar agreement without prior review by a member of the EMPLOYER’S management team.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">

                    <p>Na medida em que, por lei, qualquer Propriedade Intelectual ou direitos relacionados não possam ser transferidos ou atribuídos ao EMPREGADOR, o EMPREGADO concede ao EMPREGADOR um direito e licença irrevogável, ilimitado, livre de royalties e válido mundialmente para copiar, exibir publicamente, executar publicamente, distribuir, usar, fabricar, vender, oferecer para venda, importar, modificar e criar obras derivadas da Propriedade Intelectual, direta ou indiretamente, por meio de qualquer canal ou método de distribuição.</p>
                    <p>O EMPREGADO não incluirá qualquer Propriedade Intelectual que pertença a terceiros, tenha sido desenvolvida pelo Empregado antes do início do emprego, ou sobre a qual o EMPREGADO reivindique direitos de propriedade, em qualquer software, documentação ou material do EMPREGADOR, sem consentimento prévio e por escrito de um representante autorizado do EMPREGADOR. Caso o faça, o EMPREGADO expressamente cede ao EMPREGADOR a titularidade desses direitos, e tais materiais serão considerados criados durante o período de emprego, estando sujeitos a este Contrato. O EMPREGADO não poderá incluir materiais protegidos por direitos de propriedade intelectual de terceiros ou licenciados sob um contrato de “código aberto” ou similar sem prévia revisão da equipe de gestão do EMPREGADOR.</p>

                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="{{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <b>Clause 13 – Competent Court</b>
                    <p>Pursuant to art. 651, of the CLT, the court of the District of City of Rio de Janeiro shall be competent to resolve any dispute arising from the AGREEMENT.</p>
                    <p class='short-lineheight'>In witness whereof, they sign this Agreement of Employment in 02 (two) copies of identical content and form in the presence of 02 (two) witnesses, as required by law.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <b>Cláusula 13ª – Eleição do Foro</b>
                    <p class='short-lineheight'>Para dirimir quaisquer controvérsias oriundas do CONTRATO, será competente o foro da Comarca do Rio de Janeiro, de acordo com o art. 651, da CLT.</p>
                    <p class='short-lineheight'>E por estarem assim justos e contratados, nos termos de seus respectivos interesses, de tudo cientes, assinam o presente Contrato de Trabalho, em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas, para as finalidades de direito.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Rio de Janeiro, {{ $contractCreatedDate }}</p>
                    <div style="text-align: center; position: relative;">
                        <div style="display: inline-block; position: relative;">
                            @if ($signedDate
                            < $cutoffDate) <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />

                            @elseif ($adminSignatureExists)

                            <img src="{{ 
                                    $is_pdf 
                                        ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                        : url('/signatures/' . $type . '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                                }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />

                            @else
                            {{-- Use blank signature if none is available --}}
                            <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />
                            @endif
                        </div>


                        <div style="width: 70%; border-bottom: 1px solid black; margin: 10px auto 0; z-index:100"></div>

                        <b>INTERMEDIANO DO BRASIL</b> <br>
                        <b>APOIO ADMINISTRATIVO LTDA</b>
                    </div>

                    <div style="text-align: center; position: relative; margin-top: 40px">
                        <div style="display: inline-block; position: relative;">
                            @if($signatureExists && $signedDate)
                            <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px; margin: 0 auto;">
                            <p style="text-align: left">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>

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
                    <p>Rio de Janeiro, {{ $contractCreatedDate }}</p>
                    <div style="text-align: center; position: relative;">
                        <div style="display: inline-block; position: relative;">
                            @if ($signedDate
                            < $cutoffDate) <img src="{{ $is_pdf ? public_path('images/fernando_signature.png') : asset('images/fernando_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />

                            @elseif ($adminSignatureExists)

                            <img src="{{ 
                                    $is_pdf 
                                        ? storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp') 
                                        : url('/signatures/' . $type . '/' . $record->id . '/admin') . '?v=' . filemtime(storage_path('app/private/signatures/admin/admin_' . $record->id . '.webp')) 
                                }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />

                            @else
                            {{-- Use blank signature if none is available --}}
                            <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;" />
                            @endif
                        </div>

                        <div style="width: 70%; border-bottom: 1px solid black; margin: 10px auto 0; z-index:100"></div>

                        <b>INTERMEDIANO DO BRASIL</b> <br>
                        <b>APOIO ADMINISTRATIVO LTDA</b>
                    </div>
                    <div style="text-align: center; position: relative; margin-top: 40px">
                        <div style="display: inline-block; position: relative;">
                            @if($signatureExists && $signedDate)
                            <img src="{{ $is_pdf ? storage_path('app/public/signatures/employee_' . $record->employee_id . '.webp') : asset('storage/signatures/employee_' . $record->employee_id . '.webp') }}" alt="Signature" style="height: 50px; margin-bottom: -10px;margin: 0 auto;">
                            <p style="text-align: left">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
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
        <p style="text-align: center; font-weight: bold;">ANNEX I</p>
        <p style="font-weight: bold;">ANNEX TO THE INDIVIDUAL EMPLOYMENT CONTRACT</p>
        <p style="font-weight: bold;">JOB DESCRIPTION</p>
        <p>The non-exhaustive list of key responsibilities includes:</p>
        {!! $jobDescription !!}

    </div>
    @include('pdf.contract.layout.header')
    <div style="border: 1px solid rgb(188, 188, 188); margin: 20px 10px 0 10px; padding: 20px;">
        <p style="text-align: center; font-weight: bold;">ANEXO I</p>
        <p style="font-weight: bold;">ANEXO AO CONTRATO INDIVIDUAL DE TRABALHO</p>
        <p style="font-weight: bold;">DESCRIÇÃO DAS FUNÇÕES</p>
        <p>A lista não exaustiva de responsabilidades principais inclui:</p>
        {!! $translatedJobDescription !!}

    </div>
    @include('pdf.contract.layout.footer')

</body>

</html>
