<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">accounts administration</b> was rejected. With following information</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for <b class="font-600">accounts administration</b> was approved. With following information</p>
	        @else
	        	<p>Your request for <b class="font-600">accounts administration</b> have been recived. With following information</p>
	        @endif
			
			<p><b class="font-600">DAILY LIMITS</b></p>
			<div style="width: 100%;">
				@if(isset($data['TFAMODIFY_LIMIT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">TRANSFER BETWEEN ACCOUNTS: </b> ${{ isset($data['TFAMODIFY_LIMIT']) ? number_format($data['TFAMODIFY_LIMIT'], 2) : '-' }}</p>
					</div>
				@endif
				@if(isset($data['TTPMODIFY_LIMIT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">TRANSFER TO THIRD PARTIES: </b> ${{ isset($data['TTPMODIFY_LIMIT']) ? number_format($data['TTPMODIFY_LIMIT'], 2) : '-' }}</p>
					</div>
				@endif
				@if(isset($data['TIMODIFY_LIMIT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">INTERNATIONAL TRANSFERS: </b> ${{ isset($data['TIMODIFY_LIMIT']) ? number_format($data['TIMODIFY_LIMIT'], 2) : '-' }}</p>
					</div>
				@endif
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