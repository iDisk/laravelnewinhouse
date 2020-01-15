<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">Custodian change</b> was rejected.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for <b class="font-600">Custodian change</b> was approved.</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">Custodian change</b> have been received.</p>
	        @endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Admin reply:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif

	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    </div>
    </div>
</div>