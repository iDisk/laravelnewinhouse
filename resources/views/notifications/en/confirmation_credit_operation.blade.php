<div class="container">
    <div class="block_notifications">
        <img src="{{ asset('assets/images/confirmation_credito_operativo.png') }}" class="img-responsive" style="width: 100%;"/>
        <div class="clearfix"></div>        
        <br>
        <p>            
            <span>Señor</span>
            <br>
            {NOMBRE_DEL_CLIENTE}
            <br>
            Número de Cuenta: {ACCOUNT_NUMBER}
        </p>
        <p>Nos complace hacer de su conocimiento la aceptación del Crédito Operativo solicitado por usted para efectuar operaciones {{ isset($data['OPERATION_TYPE']) ? $data['OPERATION_TYPE'] : 'ETIM/CFDs' }} con las características que a continuación se presentan:</p>
        <table class="table table-bordered">
            <tr>
                <td>Monto del Crédito Solicitado</td>
                <td>{MONTO}</td>
            </tr>
            <tr>
                <td>Fecha de Autorización</td>
                <td>{FECHA_AUTORIZATION}</td>
            </tr>
            <tr>
                <td>Fecha de Pago</td>
                <td>{FECHA_PAGO}</td>
            </tr>
        </table>
        <p>
            <span>Agradecemos su preferencia.</span><br><span>Atentamente,</span>
        </p>
        <p>{FIRMA_DEL_BROKER}</p>
        <p>Consideraciones al crédito otorgado:</p>
        <p>Le rogamos tener en consideración los tiempos de transferencia internacional para evitar la cancelación del anticipo colateral, transacciones relacionadas, cobro de comisiones, penalizaciones e intereses.</p>
        <p>Este crédito será únicamente utilizado durante el periodo de tiempo entre la aprobación y la fecha en que el depósito ejecutado por el CLIENTE para cruzar las operaciones con las contrapartes en mercado, sea completado, reconocido y asentado en la(s) cuenta(s) asignada(s) para tal propósito por EL BROKER.</p>
        <p>El CLIENTE declara estar actuando en su propio nombre y representación, de forma voluntaria y dando fe que lo declarado en la presente solicitud es cierto, especialmente aquello que tiene relación con el origen de los fondos y la información de los mismos. De la misma manera, el cliente declara que los fondos y recursos que utilizará para cubrir este anticipo de colateral no provienen de actividades que puedan ser consideradas ilegales. Declara también que no aceptará que terceras partes depositen fondos derivados de actividades ilegales en su nombre, para cubrir el presente Anticipo de Colateral, y Autoriza a EL BROKER o a cualquier entidad designada por este, pública o privada para la verificación de la identidad, origen y procedencia de los fondos. </p>
        <p>El presente ANTICIPO DE COLATERAL está siendo otorgado de acuerdo a las condiciones estipuladas en el Acuerdo para la prestación de servicios firmado entre las partes. El CLIENTE deberá considerar especialmente las siguientes condiciones sobre del ANTICIPO DE COLATERAL:</p>
        <ol type="a">
            <li>El cliente ha leído y entendido las declaraciones relativas a créditos operativos y anticipos de colateral del contrato entre las partes.</li>
            <li>Este ANTICIPO DE COLATERAL será utilizado únicamente por EL CLIENTE para realizar operaciones de CONTRATOS POR DIFERENCIA.</li>
            <li>El CLIENTE no podrá hacer retiros de su(s) CUENTA(s) mientras el ANTICIPO DE DEPÓSITO permanezca abierto.</li>
            <li>El resultado de las operaciones no estará disponible para EL CLIENTE hasta que la transferencia de fondos sea completado, reconocido y asentado en la(s) cuenta(s) asignada(s) para tal propósito por EL BROKER, siendo el CLIENTE completamente responsable de que el depósito llegue a su destino.</li>
            <li>El presente ANTICIPO DE COLATERAL será considerado como Capital de Riesgo. En caso de beneficios en las operaciones ejecutadas por el CLIENTE, éstas serán depositadas a la cuenta del mismo, y no serán consideradas como pago el presente ANTICIPO DE COLATERAL, en el caso de existir una pérdida, esto tampoco exime al CLIENTE del pago del mismo.</li>
            <li>EL CLIENTE entiende que EL BROKER se reserve el derecho de cancelar las operaciones garantizadas con el ANTICIPO DE COLATERAL otorgado, si después de 72 horas de la fecha indicada en el presente documento como fecha de transferencia de fondos, los mismos no estuvieran completado, reconocido y asentado en la(s) cuenta(s) asignada(s) para tal propósito por EL BROKER.</li>
            <li>El CLIENTE libera a EL BROKER de cualquier gasto, costo, reclamación, pasivo o responsabilidad (incluyendo pagos, comisiones y cuotas por el intercambio –swap-) si no cumple con los tiempos y condiciones de la transferencia estipulada en la solicitud efectuada por EL CLIENTE y las condiciones estipuladas en el presente documento. </li>
            <li>Todos los gastos y costos derivados del presente ANTICIPO DE COLATERAL serán deducidos de la cuenta del cliente.</li>
            <li>EL BROKER designará en cada ocasión la(s) cuenta(s) a las que el cliente deberá depositar, bien fuera propias o de empresas de corretaje, compensación o intermediación, de conformidad con las características de cada cliente y depósito y en cumplimiento con las normas de compensación electrónica, AML/CFT, y otros factores a considerar a manera enunciativa más no limitativa, tipo de cliente, nacionalidad, antigüedad de la cuenta, monto de depósito, residencia legal, cuenta remitente, actividad de la cuenta del cliente. EL BROKER se reserva el derecho de modificar los datos bancarios para el depósito y de rechazar depósitos que pudieran ser hechos por el cliente sin el consentimiento de EL BROKER.</li>
            <li>Las empresas de Corretaje, compensación o intermediación designadas por EL BROKER para recibir los fondos del CLIENTE, custodiarán los mismos y podrán (pero no están obligadas a) actuar como como contraparte en las transacciones que ejecute el cliente. EL BROKER se reserva el derecho de contratar los servicios de varias empresas de compensación a fin de salvaguardar los intereses de los clientes y el CLIENTE acepta que EL BROKER puede cambiar la empresa custodia de los fondos del mismo, no afectando el balance que el CLIENTE tuviera con EL BROKER.</li>
        </ol>
        <p>Si necesita ayuda o tiene alguna duda, por favor <strong><u>contacte</u></strong> a uno de nuestros representantes</p>
    </div>
</div>