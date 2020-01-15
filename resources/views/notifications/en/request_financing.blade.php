<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px;">
	        <p>Dear Client,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Your request to <b class="font-600">financing</b> by an amount of <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b>. It was rejected</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Your request to <b class="font-600">financing</b> by an amount of <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b>. It was passed</p>
	        @else
	        	<p>Your request to <b class="font-600">financing</b> by an amount of <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b> has been received</p>
	        @endif
	        <p>Sincerely,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>