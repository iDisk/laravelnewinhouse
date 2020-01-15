<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">international transfer</b> was rejected. With following information</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for <b class="font-600">international transfer</b> was approved. With following information</p>
	        @else
	        	<p>Your request for <b class="font-600">international transfer</b>, have been recived. With following information</p>
	        @endif
			
			<div style="clear: both;"></div>
			
			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ACCOUNT: </b> {{ isset($data['ACCOUNT']) ? $data['ACCOUNT'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">COVER ANY ACCOUNT SCALE FUND: </b> {{ isset($data['SHORT_FUND_ACCOUNT']) ? $data['SHORT_FUND_ACCOUNT'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">SEND RECEIPT: </b> {{ isset($data['SEND_RECEIPT']) ? $data['SEND_RECEIPT'] : 'No' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BENEFICIARY DETAIL: </b> {{ isset($data['BENEFICIARY']) ? $data['BENEFICIARY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">AMOUNT: </b> {{ isset($data['AMOUNT']) ? $data['AMOUNT'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CHARGES: </b> {{ isset($data['CARGO']) ? $data['CARGO'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">VALUE DATE: </b> {{ isset($data['VALUE_DATE']) ? $data['VALUE_DATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">EXECUTION DATE: </b> {{ isset($data['EXECUTION_DATE']) ? $data['EXECUTION_DATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TRANSFER DETAIL: </b> {{ isset($data['TRANSFER_DETAIL1']) ? $data['TRANSFER_DETAIL1'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TRANSFER DETAIL: </b> {{ isset($data['TRANSFER_DETAIL2']) ? $data['TRANSFER_DETAIL2'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>
			@if(isset($data['DOCUMENT_ARR']))

				<div style="width: 100%;">
					<p><b class="font-600">Files associated with the documentation</b></p>
				</div>
				@php 
					$i = 0;
				@endphp
				@foreach($data['DOCUMENT_ARR'] as $document_arr)
					@php $i++ @endphp
					{{ $i }}) <a href="{{ asset($document_arr['PATH']) }}" target="_blank">{{ $document_arr['NAME'] }}</a><br>
				@endforeach
				<br>
			@endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Admin reply:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
    </div>
</div>