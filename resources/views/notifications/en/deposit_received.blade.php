<style>   
    ol {
        counter-reset: item;
    }
    ol li {
        display: block;
        position: relative;
    }
    ol li:before {
        content: counters(item, ".")".";
        counter-increment: item;
        position: absolute;
        margin-right: 100%;
        right: 10px; /* space between number and text */
    }
</style>
<div class="container">
    <div class="block_notifications">
        <h4>Estimado {{ isset($data['NOMBRE_DEL_CLIENTE']) ? $data['NOMBRE_DEL_CLIENTE'] : 'CLIENTE' }}</h4>
        <h5>Número de Cuenta {{ isset($data['ACCOUNT_NUMBER']) ? $data['ACCOUNT_NUMBER'] : 'N/A' }}</h5>
        <p>Le informamos que hemos recibido un depósito a su cuenta como a continuación se detalla</p>
        <table class="table table-bordered">
            <tr>
                <td>Acreditación:</td>
                <td>{{ isset($data['DATE']) ? $data['DATE'] : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Depósito</td>
                <td>{{ isset($data['MONTO']) ? $data['MONTO'] : 'N/A' }}</td>
            </tr>
        </table>
        <p>El o los saldo(s) aquí presentados no incluyen los pagos parciales realizados durante el período.</p>
        <p>Para mayor información te invitamos a revisar tu cuenta en <strong><u>Servicios Online</u></strong> Gracias por formar parte de la comunidad de Servicios Online.</p>
        <p>Nota: La fecha y hora de este mensaje ("Enviado el") podrá variar respecto a la fecha/hora real de operación de su transacción ("Operado el"). Esto dependerá de la configuración de sus servicios de correo y/o computadora en cuanto a su zona horaria.</p>
        <p>Atentamente,</p>
        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
        <br>
        <p>Consideraciones al depósito recibido:</p>
        <ol class="foo">
            <li>El CLIENTE ha transferido o transferirá un capital a las cuentas designadas por EL BROKER, bien fuera propias, de una empresa de compensación electrónica o de terceras personas o compañías para ser usado como garantía, de conformidad a las transacciones, apalancamientos y garantías antes descritas. Los beneficios obtenidos en las negociaciones serán depositados en la cuenta del CLIENTE como colateral adicional. Las pérdidas en las transacciones serán deducidas de la cuenta del CLIENTE. EL BROKER tendrá el derecho de incrementar o variar los montos requeridos para ser considerados colateral.</li>
            <li>Costo por recepción y procesamiento de transferencias entrantes: $15 dólares del monto efectivo compensado</li>
            <li>El CLIENTE podrá en cualquier momento que lo desee transferir por medio de una transferencia bancaria a la(s) cuenta(s) designadas por EL BROKER para ser tenedoras de los fondos, colateral en forma adicional destinado a realizar operaciones, pero sabiendo que EL BROKER se reserva el derecho de modificar el monto de los incrementos mínimos. </li>
            <li>Tanto EL BROKER como Empresa de Compensación se deslindan responsabilidad alguna por el resultado de las transacciones ordenadas por el Cliente y ejecutadas por EL BROKER.</li>
            <li>Ni EL BROKER ni la Empresa de Compensación, serán responsables por pagar intereses sobre el balance del CLIENTE.</li>
            <li>El CLIENTE no podrá depositar dinero a la cuenta de EL BROKER para ser retirado de forma inmediata. En caso de que el CLIENTE decida realizar este tipo de operaciones, EL BROKER se reserva el derecho de iniciar un proceso de investigación sobre el origen de los fondos y propósito del depósito y retiro de conformidad con las Políticas de Prevención de Lavado de Activos, Combate de Financiamiento al terrorismo y evasión fiscal El CLIENTE declara que no ha hecho y no efectuará depósitos a la(s) cuenta(s) de EL BROKER que sean producto de un crédito o préstamo, y que no son urgentemente necesitados y que en caso de pérdida del capital transferido, el estilo de vida del CLIENTE no se verá seriamente afectado.</li>
            <li>Políticas de Prevención de Lavado de Activos, Combate de Financiamiento de Terrorismo (AML/CFT) y evasión fiscal.
                <ol class="foo">
                    <li>El CLIENTE entiende que EL BROKER cumple con los estándares internacionales de Prevención de Lavado de Activos, Combate de Financiamiento de Terrorismo (AML/CFT). El CLIENTE está obligado a seguir las políticas internacionales, gubernamentales, internas, de la Empresa de compensación y del país de la cuenta custodia en materia de combate de lavado de dinero, financiamiento al terrorismo evasión fiscal y otras actividades ilegales.</li>
                    <li>Por la presente declaración El CLIENTE confirma que los fondos depositados en la(s) cuenta(s) designada(s) por EL BROKER y de las empresas de Compensación Electrónica, son de origen lícito y que la actividad ejecutada con EL BROKER no tiene ningún propósito ilícito. El CLIENTE expresamente declara que los fondos provistos o que planean ser depositados por él en la(s) cuenta(s) de EL BROKER, no provienen directa o indirectamente, y no tienen conexión alguna con actividades ilegales, ilícitas o que puedan tener conexión directa o indirectamente con actividades que puedan ser consideradas ilegales, entre las que se encuentran de forma enunciativa pero no limitativa: Tráfico de Drogas, terrorismo, contrabando, Tráfico ilegal de armas, explosivos, municiones y materiales destinados a la producción de los mismos, Tráfico de órganos y tejidos humanos, así como suministros médicos; Tráfico de humanos (hombres, mujeres y/o niños); Extorsión; Secuestro; Tráfico de material o desechos radioactivos; Tráfico de obras de arte, animales exóticos y sustancias tóxicas; Genocidio; Crímenes de Guerra; Crímenes en contra de la humanidad; Enriquecimiento ilícito; Erario Público; Cualquier otra actividad ilícita</li>
                    <li>El CLIENTE reconoce y acepta que es el Legítimo Propietario-Beneficiario de los Fondos transferidos y/o que pueda transferir a EL BROKER, El CLIENTE entiende y toma la responsabilidad de informar a EL BROKER inmediatamente en caso de  ocurrir cambios en el Propietario-Beneficiario por medio de los formatos establecidos por EL BROKER y proporcionando los datos de identificación del Propietario-Beneficiario de los fondos de la cuenta y acepta que dicha información puede ser compartida por EL BROKER con los participantes que la ley pueda requerir y el CLIENTE asume responsabilidad por el origen y propósito de los fondos y los datos del propietario, copropietario y/o beneficiario de los activos depositados en EL BROKER. El CLIENTE acepta y reconoce que EL BROKER no asume ninguna responsabilidad por la no recepción de dicha información a tiempo. El CLIENTE está siendo advertido de que la información concerniente a la propiedad de los fondos puede ser compartida con las empresas de Compensación Electrónica y los bancos designados por EL BROKER.</li>
                    <li>El CLIENTE no aceptará que terceras personas o compañías efectúen pagos o depósitos a su cuenta abierta con EL BROKER. EL BROKER se reserva el derecho de solicitar informaciones adicionales sobre los depósitos efectuados a las cuentas designadas para tal efecto, y podrá rehusarse, sin perjuicio ni responsabilidad para EL BROKER, a recibir bajo su propio criterio, los depósitos que bajo su criterio, no cumplan con los estándares y políticas de EL BROKER.</li>
                    <li>El CLIENTE reconoce que la cuenta abierta y los fondos depositados a EL BROKER son cuentas con fines de operación  de Contratos por Diferencia, por lo que el CLIENTE deberá ejecutar transacciones de Contratos por Diferencia con el dinero depositado a las cuentas designadas por EL BROKER bien fuera propias o de Compensadoras Electrónicas. EL BROKER se reserva el derecho de iniciar investigaciones sobre el origen, situación fiscal y jurídica de los fondos, así como inmovilizar y bloquear la cuenta del CLIENTE en el caso de que bajo el criterio de EL BROKER, el CLIENTE esté utilizando los servicios de EL BROKER inadecuadamente, la cantidad de operaciones y los fondos involucrados resulten discrepantes con el balance de la cuenta del CLIENTE o si el CLIENTE solicita utilizar los recursos para cualquier fin diferente de efectuar transacciones de Contratos por Diferencia.</li>
                    <li>En caso de sospecha por parte de EL BROKER de que el CLIENTE está ejerciendo cualquier actividad contra sus políticas internas, y/o de la empresa de Compensación y/o del país donde se encuentre la cuenta custodia, en materia de depósitos, retiros, de AML/CFT y/o cualquier otra actividad fuera de lineamiento o que pudiese resultar ilegal, EL BROKER se reserva el derecho de iniciar una investigación y en caso de considerarlo necesario, a su sola discreción, solicitar al CLIENTE documentaciones adicionales que pueden ser -pero no se limitan a- su identidad, actividades, origen de fondos, recursos, información laboral, financiera, fiscal, lazos comerciales, personales y/o cualquier otra información que pudiera considerar apropiada para probar la licitud de los fondos y cumplimiento de las normativas ya fuese del Propietario-Beneficiario de los fondos, del CLIENTE mismo, del emisor de las transferencias recibidas en la(s) cuenta(s) designada(s) por EL BROKER o de cualquier otro participante que tenga relación con la cuenta que el CLIENTE ha abierto con EL BROKER y/o que tenga relación con los fondos que EL CLIENTE ha transferido o pretende transferir en un futuro, y en caso de considerarlo necesario, podrá solicitar una entrevista personal. La CUENTA del CLIENTE estará bloqueada y el CLIENTE no podrá realizar transacciones de Contratos por Diferencias, de la misma forma, no podrá solicitar retiros ni efectuar depósitos a su cuenta con EL BROKER, durante el tiempo en que su cuenta permanezca en investigación.</li>
                    <li>La requisición de documentación al CLIENTE podrá ser efectuada de manera verbal o escrita por parte de EL BROKER y el CLIENTE se compromete a enviar los documentos probatorios del origen de los fondos antes de la fecha límite que EL BROKER establezca al CLIENTE en la solicitud de información.</li>
                    <li>De la misma forma en caso de sospecha por parte de EL BROKER de que el CLIENTE está ejerciendo cualquier actividad contra sus políticas de depósitos, retiros, de AML/CFT y/o cualquier otra actividad ilegal, EL BROKER tiene el derecho de solicitar al cliente el cumplimiento de la ejecución de un determinado número de transacciones para proceder al desbloquea de la cuenta o bien terminar unilateralmente el presente acuerdo, parar de proporcionar servicios al CLIENTE y/o bloquear la CUENTA del mismo.</li>
                </ol>
            </li>
        </ol>                
    </div>
</div>