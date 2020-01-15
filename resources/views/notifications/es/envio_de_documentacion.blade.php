<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>

	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">envío de documentación</b> fue rechazada. Con la siguiente información</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">envío de documentación</b> fue aprobada. Con la siguiente información</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">envío de documentación</b> ha sido recibida. Con la siguiente información.</p>
	        @endif

			<div style="clear: both;"></div>

			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TIPO DE DOCUMENTO: </b> {{ isset($data['DOCUMENT_TYPE']) ? $data['DOCUMENT_TYPE'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>
			@if(isset($data['DOCUMENT_ARR']))
				<div style="width: 100%;">
					<p><b class="font-600">Archivos asociados a la documentación</b></p>
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
	        	<p><b class="font-600"><i>Respuesta del administrador:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
	</div>
</div>