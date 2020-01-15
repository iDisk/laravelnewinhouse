<div class="container" style="margin-top: 45px;">
    <div class="block_notifications">
        <p>Apreciado Cliente,</p>
        <p class="text-danger">
            <b>¡BIENVENIDO A {{ isset($data['NOMBRE_DEL_BROKER']) ? $data['NOMBRE_DEL_BROKER'] : 'BROKER' }}</b>
        </p>
        <p>
            <u>Su cuenta ha sido activada y ahora está lista para ser fondeada y comenzar a operar.</u>
        </p>
        <p>
            Inicie sesión con el nombre de usuario y la contraseña de un solo uso (OTP.
        </p>
        <p>
            Elija su idioma preferido para que la comunicación futura, así como las opciones y funciones en el sistema bancario en línea estén en el idioma que elija.
        </p>
        <p class="text-danger">
            <b>DETALLES DE INGRESO A SU CUENTA:</b>
        </p>
        <table class="table table-bordered table-danger">
            <tr>
                <td>LOGIN URL:</td>
                <td>
                    @if(isset($data['LOGIN_URL']) && $data['LOGIN_URL'] != '')
                    <a href="{{ $data['LOGIN_URL'] }}">{{ $data['LOGIN_URL'] }}</a>
                    @else
                    LOGIN URL
                    @endif
                </td>
            </tr>
            <tr>
                <td>NOMBRE DE USUARIO</td>
                <td>{{ isset($data['NOMBRE_DE_USUARIO']) ? $data['NOMBRE_DE_USUARIO'] : 'NOMBRE DE USUARIO' }}</td>
            </tr>
            <tr>
                <td>CONTRASEÑA DE USUARIO</td>
                <td>{{ isset($data['USER_PASSWORD']) ? $data['USER_PASSWORD'] : 'USER PASSWORD' }}</td>
            </tr>
            <tr>
                <td>NÚMERO DE CUENTA</td>
                <td>{{ isset($data['NUMERO_DE_CUENTA']) ? $data['NUMERO_DE_CUENTA'] : 'NUMERO DE CUENTA' }}</td>
            </tr>
        </table>
        <p>
            Tenga en cuenta que la primera vez que ingrese a su cuenta debe cambiar la contraseña, debe tener al menos 8 caracteres alfanuméricos y al menos una letra mayúscula. Guarde esta información en un lugar seguro. 
        </p>
        <p>
            *** POR FAVOR REVISE: revise sus mensajes dentro del sistema bancario en línea y registre su clave de seguridad. Necesitará esto para iniciar cualquier solicitud. ***
        </p>
    </div>
</div>