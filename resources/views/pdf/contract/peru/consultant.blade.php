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
$contractCreatedDay = $record->created_at->format('jS');
$contractDay = $record->created_at->format('j');

$contractCreatedmonth = $record->created_at->format('F');
$translatedMonth = \Carbon\Carbon::parse($record->created_at)->locale('es')->translatedFormat('F');

$contractCreatedyear = $record->created_at->format('Y');
$createdDate = (new DateTime($record->created_at))->format('d/m/Y');



$customerTranslatedPosition = $record->translatedPosition;
$employeeName = $record->employee->name;
$employeeNationality = $record->personalInformation->nationality ?? null;
$employeeState = $record->personalInformation->state ?? null;
$employeeCivilStatus = $record->personalInformation->civil_status ?? null;
$employeeGender = $record->personalInformation->gender ?? null;
$employeeJobTitle = $record->job_title ?? null;
$employeeCountryWork = $record->country_work ?? null;
$employeeGrossSalary = $record->gross_salary;
$employeeTaxId = $record->document->tax_id ?? null;
$employeePersonalId = $record->document->personal_id ?? null;
$employeeEmail = $record->employee->email ?? null;
$employeeAddress = $record->personalInformation->address ?? null;
$employeeCity = $record->personalInformation->city ?? null;
$employeeDateBirth = $record->personalInformation->date_of_birth ?? null;
$employeePhone = $record->personalInformation->phone ?? null;
$employeeMobile = $record->personalInformation->mobile ?? null;
$employeeCountry = $record->personalInformation->country ?? null;
$employeeStartDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('d/m/Y'): 'N/A';
$employeeStartDateFFormated = $record->start_date
? \Carbon\Carbon::parse($record->start_date)->translatedFormat('j \\of F \\of Y')
: 'N/A';
$employeeEndDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d/m/Y'): 'N/A';
$employeeTaxId = $record->document->tax_id ?? null;

$formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
$formatterLocal = new \NumberFormatter('es_PE', \NumberFormatter::SPELLOUT);
$translatedJobDescription = $record->translated_job_description;
$jobDescription = $record->job_description;

$signaturePath = 'signatures/employee/employee_' . $record->employee_id . '.webp';
$signatureExists = Storage::disk('private')->exists($signaturePath);
$adminSignaturePath = 'signatures/admin/admin_' . $record->id . '.webp';
$adminSignatureExists = Storage::disk('private')->exists($adminSignaturePath);
$adminSignedBy = $record->user->name ?? '';
$adminSignedByPosition = $adminSignedBy === 'Fernando Guiterrez' ? 'CEO' : ($adminSignedBy === 'Paola Mac Eachen' ? 'VP' : 'Legal Representative');
$user = auth()->user();
$isAdmin = $user instanceof \App\Models\User;
$type = $isAdmin ? 'admin' : 'employee';

@endphp

<style>
    .main-container {
        text-align: justify;
    }

    p {
        line-height: 1.5 !important
    }

    .non-pdf p {
        line-height: 1.7 !important;
    }

    .non-pdf table {
        margin-top: 0px !important
    }

    .listItem {
        line-height: 1.5;
        margin: 5;
        padding: 0
    }

</style>
<body>
    <!-- Content Section -->
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">INDIVIDUAL CONTRACT OF WORK</h4>
                    <p>For this document, which is duplicated, the <b>INDIVIDUAL EMPLOYMENT CONTRACT WITH UNDEFINED TERM, FOR A SPECIFIC SERVICE</b>, in accordance with article 63 of the TUO of Legislative Decree 728, Labor Productivity and Competitiveness Act, approved by D.S. No. 003-97-TR, originated by the reasons and the objective causes indicated, which celebrate <b>THE EMPLOYER</b> and <b>THE WORKER</b> identified in this document, according to the following conditions and clauses: </p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h4 style="text-align:center !important; text-decoration: underline;">CONTRATO INDIVIDUAL DE TRABAJO</h4>
                    <p>Conste por el presente documento que se extiende por duplicado, el <b>CONTRATO INDIVIDUAL DE TRABAJO A PLAZO INDETERMINADO, POR SERVICIO ESPECÍFICO,</b> conforme el artículo 63 del TUO del Decreto Legislativo 728, Ley de Productividad y Competitividad Laboral, originado por los motivos y las causas objetivas que se indican en este documento, que celebran <b>EL EMPLEADOR</b> y <b>EL TRABAJADOR</b> identificados en este documento, de acuerdo con
                        las condiciones y clausulas siguientes:
                    </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a. THE EMPLOYER INTERMEDIANO PERU S.A.C.</b> with RUC. N° 20606232960, with address at Av. Paseo de Republica 3195, oficina 401, San Isidro, Lima, Perú.
                        Economic activity: <b>Commercial Activities
                            of Human Resources Administration.</b> Its
                        Representative, Carlos Ricardo Argote Silva with DNI 06040946 domiciled at
                        Unidad Vecinal Block 62 Dpto. 120, Departamento de Lima, Provincia de Lima, Distrito de Lima, Province of Lima; The legal status is single.
                    </p>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>a. EL EMPLEADOR INTERMEDIANO PERU S.A.C.</b> con RUC. N° 20606232960, con domicilio en Av. Paseo de Republica 3195 oficina 401, San Isidro, Lima, Perú.
                        Actividad económica: <b>Actividades Comerciales de administración de
                            Recursos Humanos.</b> Su Apoderado,
                        Carlos Ricardo Argote Silva con DNI
                        06040946 con domicilio en Unidad Vecinal Block 62 Dpto. 120, Departamento de Lima, Provincia de Lima, Distrito de Lima; El estado legal es soltero.
                    </p>

                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p class='listItem'><b>b. THE WORKER:</b> {{ $employeeName }}</p>
                    <p class='listItem'><b>Nationality:</b> {{ $employeeNationality }}</p>
                    <p class='listItem'><b>Gender:</b> {{ ucfirst($employeeGender) }}</p>
                    <p class='listItem'><b>Identity Card:</b> {{ $employeePersonalId }}</p>
                    <p class='listItem'><b>Address:</b> {{ $employeeAddress }}</p>
                    <p class='listItem'><b>Email:</b> {{ $employeeEmail }}</p>
                    <p class='listItem'><b>Workplace:</b> {{ $employeeCountryWork }}</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p class='listItem'><b>b. EL TRABAJADOR:</b> {{ $employeeName }}</p>
                    <p class='listItem'><b>Nacionalidad:</b> {{ $employeeNationality }}</p>
                    <p class='listItem'><b>Sexo:</b> {{ ucfirst($employeeGender) }}</p>
                    <p class='listItem'><b>Doc. de Identidad:</b> {{ $employeePersonalId }}</p>
                    <p class='listItem'><b>Dirección:</b> {{ $employeeAddress }}</p>
                    <p class='listItem'><b>Correo:</b> {{ $employeeEmail }}</p>
                    <p class='listItem'><b>Lugar de trabajo:</b> {{ $employeeCountryWork }}</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c. CONDITIONS OF THE CONTRACT</b> <br>
                        The objective determining cause of the hiring is the contract that "THE EMPLOYER" has entered into with a <b>Client</b> in order to meet the requirement according to mutual agreement of the parties.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>c. CONDICIONES DEL CONTRATO</b> <br>
                        Es causa objetiva determinante de la contratación, el contrato que ha celebrado "EL EMPLEADOR" con un<b> Cliente</b> a fin de cubrir requerimiento según acuerdo mutuo de las partes.
                    </p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: 0px !important'>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>• Contract Duration:</b> Indetermined</p>
                    <p><b>• Position:</b> {{ $employeeJobTitle }}</p>
                    <p><b>• Start Date:</b> {{ $employeeStartDate }}</p>
                    <p><b>• Ordinary Compensation:</b> S/{{number_format($employeeGrossSalary) }} ( {{ strtoupper($formatter->format($employeeGrossSalary)) }})
                        </b>which will be paid in cash or check at the employer's premises or by deposit or electronic transfer to the Worker's
                        bank account, on the last day Business of the month.</p>
                    <p><b>• Working hours:</b> from Monday to Friday
                        minimum of 40 hours per week.
                        This contract is of a fixed duration, beginning on {{ $createdDate }}, subject to its termination to the provisions of the labor legislation and/or subject to termination.</p>


                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>• Duración del Contrato:</b> Indeterminado</p>
                    <p><b>• Cargo: </b>{{ $employeeJobTitle }}</p>
                    <p><b>• Fecha de inicio: </b>{{ $employeeStartDate }}</p>
                    <p><b>• Remuneración Ordinaria: </b>S/{{number_format($employeeGrossSalary) }} gross/month ({{ strtoupper($formatterLocal->format($employeeGrossSalary)) }}) el cual será pagado en efectivo o cheque en las instalaciones del empleador o mediante deposito o transferencia electrónica a la cuenta bancaria del Trabajador, el último día hábil del mes.</p>
                    <p><b>• Horario de trabajo:</b> De lunes a viernes
                        cumpliendo 40 horas semanales.
                        El presente contrato es de duración determinada, iniciándose el {{ $createdDate }}, sujetándose para su extinción a lo dispuesto en la legislación laboral y/o sujeto a terminación.</p>

                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>d. CONTRACT CLAUSES</b></p>
                    <p><b style='text-decoration: underline'>FIRST.</b> - By virtue of the present document, <b>THE EMPLOYER</b> contracts under the conditions previously indicated the services of <b>THE WORKER</b> to carry out the own and complementary work of the position also indicated and is obligated to:</p>
                    <p>A) Develop for the <b>EMPLOYER</b> all their capacity of work in the performance of the main, related and complementary work inherent to the position.

                    </p>
                    <p> B) Comply with the functions, orders and instructions of <b>THE EMPLOYER</b> or its representatives.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>d. CLAUSULAS DEL CONTRATO</b></p>
                    <p><b style='text-decoration: underline'>PRIMERA.</b> - En virtud del presente documento, <b>EL EMPLEADOR</b> contrata bajo las condiciones precedentemente señaladas los servicios de <b>EL TRABAJADOR</b> para que realice las labores propias y complementarias
                        del puesto también indicado y se obliga a:
                    </p>
                    <p>A) Desarrollar para <b>EL EMPLEADOR</b> toda su
                        capacidad de trabajo en el desempeño de las labores principales, conexas y
                        complementarias inherentes al puesto.
                    </p>
                    <p> B) Cumplir con las funciones, ordenes e
                        instrucciones de <b>EL EMPLEADOR</b> o sus representantes.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>SECOND. </b> <b>- THE WORKER</b> must comply with the Regulations of the Work Center, as well as the specifications contained in the Internal Work Regulations and/or the Industrial Safety and Hygiene Regulations and those that are dictated by the needs of the service.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>SEGUNDA. </b> <b>- EL TRABAJADOR</b> deberá cumplir con el Reglamento del Centro de Trabajo, así como las especificaciones contenidas en el Reglamento Interno del Trabajo y/o en el Reglamento de Seguridad e Higiene Industrial y las que se impartan por necesidades del servicio.</p>
                </td>
            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>THIRD.</b> <b> - THE WORKER</b> shall fulfill the following duties specific to the position: </p>
                    <p>
                        Hosted for the project: <b>"INTERMEDIANO PERU S.A.C."</b>
                        As the:

                        <ul>
                            <p><b>•</b> Product show. </p>
                            <p><b>•</b> Test the proof of concepts.</p>
                            <p><b>•</b> Make customer benefits.</p>
                            <p><b>•</b> Solve customer questions.</p>
                            <p><b>•</b> Validate the compatibility of the product with the client software
                                infrastructure.</p>
                        </ul>
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>TERCERA. </b> <b>- EL</b> TRABAJADOR deberá
                        cumplir con las siguientes funciones específicas al cargo:
                    </p>

                    <p>Asignado para el proyecto: <b>"INTERMEDIANO PERU S.A.C."</b>
                        Funciones de:
                        <ul>
                            <p><b>•</b> Demostración de Producto. </p>
                            <p><b>•</b> Probar la prueba de conceptos.</p>
                            <p><b>•</b> Hacer prestaciones de clientes.</p>
                            <p><b>•</b> Resolver preguntas de clientes.</p>
                            <p><b>•</b> Validar la compatibilidad del producto con la infraestructura de software del cliente.</p>
                        </ul>

                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>FOURTH.</b> - The remuneration of the <b>WORKER</b> for all concepts is the one indicated in the
                        conditions of this contract.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>CUARTA.</b> - La retribución del <b>TRABAJADOR</b> por todo concepto es Ia señalada en las condiciones de este contrato.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>FIFTH. </b> - If, during the term of the contract, there are circumstances or events not foreseen at the present moment that render impossible the reason that motivates the hiring and as a
                        consequence will be unnecessary the execution of the provision of contracted services, will resolve the employment relationship, for which the <b>WORKER</b> will be given the notice with due anticipation. In such case, <b>THE EMPLOYER</b> will only be obliged to pay social compensation and
                        benefits that could accrue until the expiration of the period indicated in the notice of termination.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b style='text-decoration: underline'>QUINTA. </b> - Si durante la vigencia del contrato, se produjeran circunstancias o hechos no previstos al momento presente que hicieran imposible Ia razón que motiva la contratación y como consecuencia resultara innecesaria Ia ejecución de la prestación de los servicios
                        contratados, se resolverá el vínculo laboral, para lo cual se cursara at <b>TRABAJADOR</b> el aviso con la anticipación debida. En tal caso, <b>EL EMPLEADOR</b> solo quedará obligado at pago de remuneraciones y beneficios sociales
                        que pudieran devengarse hasta el vencimiento del plazo señalado en el aviso de cese.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SIXTH. </b> - The worker shall be subject to the labor regime of private activity within the scope and effects determined by the TUO of Legislative Decree No. 728, Labor Productivity and Competitiveness Act approved by Supreme Decree No. 003-97-TR, for this modality of
                        contracting.
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>SEXTA. </b> <b>- El</b> trabajador estará sujeto al régimen laboral de Ia actividad privada dentro de los alcances y efectos que determina el TUO del Decreto Legislativo N° 728, Ley de Productividad y Competitividad Laboral aprobado por Decreto Supremo N° 003-97-TR, para esta modalidad de contratación.</p>
                </td>
            </tr>



        </table>
        @include('pdf.contract.layout.footer')
    </main>


    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>e. CONFIDENTIALITY</b></p>
                    <p>The Employee hereby acknowledges that the employment constitutes a relationship of confidence and trust between the Employee and the Employer with respect to certain information of a confidential or proprietary secret nature, which gives the Employer a competitive edge in its business (the “Confidential Information”).</p>
                    <p>The Confidential Information includes particularly without limitation: trademarks, patents, service marks, logos, designs of the Employer, decisions, plans and budgets, unpublished results, remunerations, sales predictions, sales marketing and sales plans, product development plans, competitive analysis, business and financial plans or forecast, non public financial information, contracts and customer and employee lists of the Employer, contract, engagement letters, all information or material which relates to the Employer’s know-how in production, marketing or licensing and all information which the Employer has a legal obligation to treat as confidential, or which the Employer treats as proprietary or designates as confidential, or for internal use only.</p>
                    <p>Confidential information does not include information that is publicly known or that becomes generally known (otherwise than due to error or breach of obligations by the Employee) either during or after termination of employment, nor information commonly used in business by a large number of entities, as well as general knowledge learned during similar jobs elsewhere.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>e. CONFIDENCIALIDAD</b></p>
                    <p>Por el presente, el Empleado reconoce que el empleo constituye una relación de confianza entre el Empleado y el Empleador con respecto a cierta información de naturaleza confidencial o secreta de propiedad, que le da al Empleador una ventaja competitiva en su negocio (la “Información Confidencial”).</p>
                    <p>La Información Confidencial incluye particularmente sin limitación: marcas, patentes, marcas de servicio, logotipos, diseños del Contratante, decisiones, planes y presupuestos, resultados inéditos, remuneraciones, predicciones de ventas, marketing de ventas y planes de ventas, planes de desarrollo de productos, análisis competitivos, negocios. y planes o pronósticos financieros, información financiera no pública, contratos y listas de clientes y empleados del Empleador, contratos, cartas de compromiso, toda la información o material que se relacione con los conocimientos técnicos del Empleador en producción, comercialización o concesión de licencias y toda la información que el Empleador tiene la obligación legal de tratar como confidencial, o que el Empleador trata como de propiedad exclusiva o designa como confidencial, o para uso interno únicamente.</p>
                    <p>La información confidencial no incluye información que sea de conocimiento público o que llegue a ser de conocimiento general (que no sea debido a un error o incumplimiento de obligaciones por parte del Empleado) ya sea durante o después de la terminación del empleo, ni información comúnmente utilizada en los negocios por una gran cantidad de entidades. así como conocimientos generales adquiridos durante trabajos similares en otros lugares.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>
    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}">
        <table style='margin-top: -5px'>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>The Employee will not transmit, publish or disclose Confidential Information directly or indirectly to any third party, and undertakes to use the same level of care to prevent any access to any Confidential Information or similar documents used by the Employer, and in any case not less than objective expectation of attention; and that he/she will not use Confidential Information except for the purpose of performing the tasks and duties for which the Employer has hired him/her.</p>
                    <p>Upon termination of this Agreement for whatsoever reason, the Employee undertakes to return immediately to the Employer any confidential materials in its possession, whether in hard copy or electronic form. Furthermore, the Employee undertakes not to keep any copies of such documents and materials. All such materials and documents shall remain the property of the Employer.</p>
                    <p>The Employee shall be released from the obligations defined in the above paragraphs of this Article only with the previously obtained written consent of the Employer.</p>
                    <p>Obligations under this Article shall not prevent the disclosure of information required by law or other mandatory regulations.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>El Empleado no transmitirá, publicará ni divulgará Información Confidencial directa o indirectamente a ningún tercero, y se compromete a utilizar el mismo nivel de cuidado para evitar cualquier acceso a cualquier Información Confidencial o documentos similares utilizados por el Empleador, y en cualquier caso no menos que la expectativa objetiva de atención; y que no utilizará Información Confidencial excepto con el propósito de realizar las tareas y deberes para los cuales el Contratante lo ha contratado.</p>
                    <p>Tras la terminación de este Acuerdo por cualquier motivo, el Empleado se compromete a devolver inmediatamente al Empleador cualquier material confidencial en su posesión, ya sea en forma impresa o electrónica. Además, el Empleado se compromete a no conservar copias de dichos documentos y materiales. Todos estos materiales y documentos seguirán siendo propiedad del Empleador.</p>
                    <p>El Empleado quedará liberado de las obligaciones definidas en los párrafos anteriores de este Artículo sólo con el consentimiento escrito previamente obtenido del Empleador.</p>
                    <p>Las obligaciones bajo este Artículo no impedirán la divulgación de información requerida por la ley u otras regulaciones obligatorias.</p>
                </td>
            </tr>

        </table>
        @include('pdf.contract.layout.footer')
    </main>

    @include('pdf.contract.layout.header')
    <main class="main-container {{  $is_pdf ? 'is-pdf' : 'non-pdf'  }}" style='page-break-after: avoid'>
        <table style='margin-top: -5px'>


            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>f. INTELLECTUAL PROPERTY</b></p>
                    <p>Nothing in this Agreement shall be deemed to be the granting or assignment of a license to an Employee by the Employer, any existing or future intellectual property right in respect of which the Employer has a right of ownership or a right of use.</p>
                    <p>Done in two copies of the same tenor and for a single effect that are signed in the city and date indicated.</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p><b>f. PROPIEDAD INTELECTUAL</b></p>
                    <p>Nada en este Acuerdo se considerará la concesión o cesión de una licencia a un Empleado por parte del Empleador, cualquier derecho de propiedad intelectual existente o futuro respecto del cual el Empleador tenga un derecho de propiedad o un derecho de uso.</p>
                    <p>Hecho en dos ejemplares de un mismo tenor y para un solo efecto que se firman en la dudad y fecha indicados.</p>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Lima, {{ $contractCreatedDay }} of {{ $contractCreatedmonth }} of {{ $contractCreatedyear }}.</p>
                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        <p style='text-align: center'><b>WORKER</b></p>
                        @if($signatureExists)
                        <img src="{{ 
                                $is_pdf
                                    ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                    : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                                }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 60px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>

                        @endif
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">RUT {{ $employeeTaxId }}</p>

                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>Lima, {{$contractDay}} de {{ $translatedMonth }} de {{ $contractCreatedyear }}.</p>
                    <div style="display: inline-block; position: relative; height: 140px; width: 100%;">
                        <p style='text-align: center'><b>TRABAJADOR</b></p>
                        @if($signatureExists)
                        <img src="{{ 
                                $is_pdf
                                    ? storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')
                                    : url('/signatures/'. $type. '/' . $record->employee_id . '/employee') . '?v=' . filemtime(storage_path('app/private/signatures/employee/employee_' . $record->employee_id . '.webp')) 
                                }}" alt="Employee Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);" />

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: -22px;width: 100%; left: 50%; transform: translateX(-50%); text-align: center;">{{ $employeeCity }}, {{ \Carbon\Carbon::parse($record->signed_contract)->format('d/m/Y h:i A') }}</p>
                        @else
                        <img src="{{ $is_pdf ? public_path('images/blank_signature.png') : asset('images/blank_signature.png') }}" alt="Signature" style="height: 10px; margin-top: 40px; z-index: 100; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">
                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>

                        @endif
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px;">{{ $employeeName }}</p>
                        <p style="position: absolute; bottom: -7px; left: 50%; transform: translateX(-50%);">RUT {{ $employeeTaxId }}</p>

                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>EMPLOYER</b></p>

                        <img src="{{ $is_pdf ? public_path('images/fabian_signature.png') : asset('images/fabian_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>
                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">Carlos Ricardo Argote Silva</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">INTERMEDIANO PERU S.A.C.</p>
                    </div>

                </td>
                <td style="width: 50%; vertical-align: top;">

                    <div style="text-align: center; position: relative; height: 120px;">
                        <p style='text-align: center'><b>EMPLEADOR</b></p>

                        <img src="{{ $is_pdf ? public_path('images/fabian_signature.png') : asset('images/fabian_signature.png') }}" alt="Signature" style="height: 50px; position: absolute; bottom: 25%; left: 50%; transform: translateX(-50%);">

                        <div style="width: 70%; border-bottom: 1px solid black; position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 100;"></div>

                        <p style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); margin-bottom: 20px; text-align: center !important; width: 100%;">Carlos Ricardo Argote Silva</p>
                        <p style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); text-align: center !important; width: 100%;">INTERMEDIANO PERU S.A.C.</p>
                    </div>
                </td>

            </tr>
        </table>
        @include('pdf.contract.layout.footer')
    </main>
</body>

</html>
