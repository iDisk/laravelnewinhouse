<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">Transfer between my accounts</b> was rejected. With following information</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for <b class="font-600">Transfer between my accounts</b> was approved. With following information</p>
	        @else
	        	<p>Your request for <b class="font-600">Transfer between my accounts</b> have been recived. With following information</p>
	        @endif
			<div style="clear: both;"></div>
			<div style="width: 100%;">
				<p><b class="font-600">CHARGE ACCOUNT: </b> {{ isset($data['FROM_ACCOUNT']) ? $data['FROM_ACCOUNT'] : '-' }}</p>
			</div>

			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CURRENCY: </b> {{ isset($data['CURRENCY']) ? $data['CURRENCY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">AMOUNT: </b> {{ isset($data['CURRENCY_SYMBOL']) ? $data['CURRENCY_SYMBOL'] : '' }}{{ isset($data['AMOUNT']) ? $data['AMOUNT'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">APPLICATION DATE: </b> {{ isset($data['APPLICATION_DATE']) ? $data['APPLICATION_DATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PAYMENT ACCOUNT: </b> {{ isset($data['PAYMENT_ACCOUNT']) ? $data['PAYMENT_ACCOUNT'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>
	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p>Admin reply : {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
    </div>
</div>