<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request for <b class="font-600">permission settings</b> was rejected. With following information</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request for <b class="font-600">permission settings</b> was approved. With following information</p>
	        @else
	        	<p>Your request for <b class="font-600">permission settings</b>, have been recived. With following information</p>
	        @endif
			
			@if(isset($data['PERMISSION_ACCOUNT_ACCESS']) || isset($data['PERMISSION_TRANSFR_BTW_ACCOUNT']) || isset($data['PERMISSION_TELEPHONE_ORDERS']) || isset($data['PERMISSION_INTERNATIONAL_TRANSFER']) || isset($data['PERMISSION_WIRITTEN_ORDERS']))
			<div style="width: 100%;">
				<p><b class="font-600">THE PERMITS TO BE GRANTED</b></p>
			</div>
			<div style="width: 100%;">
				
					@if(isset($data['PERMISSION_ACCOUNT_ACCESS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Account Access: </b> {{ $data['PERMISSION_ACCOUNT_ACCESS'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_TRANSFR_BTW_ACCOUNT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Transfer between accounts: </b> {{ $data['PERMISSION_TRANSFR_BTW_ACCOUNT'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_TELEPHONE_ORDERS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Telephone orders: </b> {{ $data['PERMISSION_TELEPHONE_ORDERS'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_INTERNATIONAL_TRANSFER']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">International transfers: </b> {{ $data['PERMISSION_INTERNATIONAL_TRANSFER'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_WIRITTEN_ORDERS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Written orders: </b> {{ $data['PERMISSION_WIRITTEN_ORDERS'] }}</p>
					</div>
	                @endif
			</div>
			@endif
			<div style="clear: both;"></div>
			
			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">FULL NAME: </b> {{ isset($data['FULL_NAME']) ? $data['FULL_NAME'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TYPE AND ID NUMBER: </b> {{ isset($data['TYPE_NUMBER']) ? $data['TYPE_NUMBER'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BIRTHDATE: </b> {{ isset($data['DATE_OF_BIRTH']) ? $data['DATE_OF_BIRTH'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PLACE OF BIRTH: </b> {{ isset($data['PLACE_OF_BIRTH']) ? $data['PLACE_OF_BIRTH'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ADDRESS: </b> {{ isset($data['ADDRESS']) ? $data['ADDRESS'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">COUNTRY: </b> {{ isset($data['COUNTRY']) ? $data['COUNTRY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">STATE: </b> {{ isset($data['STATE']) ? $data['STATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">COUNTY / LOCATION: </b> {{ isset($data['COUNTY']) ? $data['COUNTY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PHONE: </b> {{ isset($data['PHONE_1']) ? $data['PHONE_1'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PHONE 2: </b> {{ isset($data['PHONE_2']) ? $data['PHONE_2'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">EMAIL: </b> {{ isset($data['EMAIL']) ? $data['EMAIL'] : '-' }}</p>
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