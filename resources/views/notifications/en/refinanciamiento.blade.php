<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your <b class="font-600">refinancing</b> was rejected for the amount given.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your <b class="font-600">refinancing</b> was approved for the amount given.</p>
	        @else
	        	<p>Your <b class="font-600">refinancing</b> has been received for the amounts given.</p>
	        @endif

	        
	        @if(isset($data['REFINANCIAMIENTO_ARR']))
	        	@foreach($data['REFINANCIAMIENTO_ARR'] as $keyIndex => $refinanciamiento_data)
	        		<p><b class="font-600">{{ $keyIndex }}. PAYMENT AMOUNT:</b> ${{ isset($refinanciamiento_data['MONTO']) ? number_format($refinanciamiento_data['MONTO'], 2) : '-' }} - <b class="font-600">DATE OF PAYMENT:</b> {{ isset($refinanciamiento_data['FECHA']) ? $refinanciamiento_data['FECHA'] : '-' }}</p>
	        	@endforeach
	        @endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p>Admin reply : {{ $data['MESSAGE']  }}</p>
	        @endif
	        
	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>