<div class="container">
    <div class="block_notifications">
        <h4>Estimado {{ isset($data['NOMBRE_DEL_CLIENTE']) ? $data['NOMBRE_DEL_CLIENTE'] : 'CLIENTE' }}</h4>
        <h5>Número de Cuenta {{ isset($data['ACCOUNT_NUMBER']) ? $data['ACCOUNT_NUMBER'] : 'N/A' }}</h5>
        <p>El comprobante de su transferencia ha sido recibido pero está sujeto a confirmación de pago por parte de las entidades bancarias y centrales de compensación. <strong>ESPERE NUESTRO SEGUNDO EMAIL NOTIFICANDO LA RECEPCIÓN DE DE SU TRANSFERENCIA.</strong></p>
        <table class="table table-bordered">
            <tr>
                <td>Recepción del Comprobante:</td>
                <td>{{ isset($data['RECEIPT_DATE']) ? $data['RECEIPT_DATE'] : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Cantidad Transferida*</td>
                <td>{{ isset($data['MONTO']) ? $data['MONTO'] : '0.00' }}</td>
            </tr>
        </table>
        <i>* De acuerdo al comprobante enviado por usted.</i>
        <p>Le sugerimos validar con su banco que el monto transferido sea debitado de su cuenta bancaria y que las instrucciones de transferencia estén correctas. EL BROKER, no se responsabilizará por transferencias mal efectuadas, rechazadas o no ejecutadas por su banco, así como tampoco asumirá costes, cargos, reclamaciones ni responsabilidades por pagos mal efectuados o efectuados a destiempo. EL BROKER no se responsabilizará por comisiones bancarias o tipos de cambio aplicados. Por favor considere que la información mostrada en la página de Internet es actualizada una vez al día. Es posible que encuentre información diferente a la que se menciona en este mensaje hasta el momento de la siguiente actualización.</p>
        <p>Las transferencias se considerarán recibidos salvo buen cobro; en consecuencia, dichos pagos se acreditarán cuando sean efectivamente acreditados, reconocidos y asentados de acuerdo a los procedimientos de PLD/FT por parte de EL BROKER y las cámaras de compensación intervinientes.</p>
        <p>En caso de cualquier duda, por favor contacte a nuestro personal, quienes con gusto le atenderán.</p>
        <p>Gracias por su preferencia</p>
        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
        <p>Consideraciones al crédito otorgado:</p>
        <p>Le rogamos tener en consideración los tiempos de transferencia internacional para evitar la cancelación del anticipo colateral, transacciones relacionadas, cobro de comisiones, penalizaciones e intereses.</p>
        <p>Si necesita ayuda o tiene alguna duda, por favor <strong><u>contacte</u></strong> a uno de nuestros representantes</p>
    </div>
</div>