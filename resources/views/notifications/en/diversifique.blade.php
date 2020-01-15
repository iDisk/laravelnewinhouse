<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your <b class="font-600">diversify</b> request was rejected. With the following information.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your <b class="font-600">diversify</b> request was approved. With the following information.</p>
	        @else
	        	<p>Your <b class="font-600">diversify</b> request received. With the following information</p>
	        @endif
	        <div style="clear: both;"></div>

	        <div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ORIGIN: </b> {{  $data['FROM_ACCOUNT']  }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PRODUCT TO CONTRACT: </b> {{  isset($data['PRODUCT_HIRE']) ? $data['PRODUCT_HIRE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DESIRED EXPIRATION: </b> {{  isset($data['EXPIRATION_DATE']) ? $data['EXPIRATION_DATE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">AMOUNT: </b> {{  isset($data['AMOUNT']) ? $data['AMOUNT'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">APPLICATION DATE: </b> {{  isset($data['APPLICATION_DATE']) ? $data['APPLICATION_DATE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">EXPIRATION INSTRUCTION: </b> {{  isset($data['INSTRUCTION']) ? $data['INSTRUCTION'] : '' }}</p>
				</div>
			</div>
	        
	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Admin reply:</i>i</b> {{ $data['MESSAGE']  }}</p>
	        @endif

	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>