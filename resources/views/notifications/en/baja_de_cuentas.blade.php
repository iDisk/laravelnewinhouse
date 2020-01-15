<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>

	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">Account drop</b> was rejected. With the following information.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for<b class="font-600">Account drop</b> was approved. With the following information.</p>
	        @else
	        	<p>Your request for <b class="font-600">Account drop</b> have been received. With the following information.</p>
	        @endif

			<div style="clear: both;"></div>

			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ACCOUNT NUMBER: </b> {{ isset($data['NUM_DE_CUENTA']) ? $data['NUM_DE_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ACCOUNT TYPE: </b> {{ isset($data['TIPO_CUENTA']) ? $data['TIPO_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ACCOUNT DESCRIPTION: </b> {{ isset($data['DESCRIPTION_CUENTA']) ? $data['DESCRIPTION_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DESTINATION: </b> {{ isset($data['DESTINATION']) ? $data['DESTINATION'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BANK: </b> {{ isset($data['BANCO']) ? $data['BANCO'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CURRENCY: </b> {{ isset($data['DIVISA']) ? $data['DIVISA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">Action Required: </b> {{ isset($data['ACTION_ELIMINAR']) ? $data['ACTION_ELIMINAR'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Admin reply:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
	</div>
</div>