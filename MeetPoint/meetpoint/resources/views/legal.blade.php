@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')
    {{-- NAVBAR --}}
    <main class="container">
    {{-- Título y menú interno ---------------------------------------------------- --}}
    <h1 class="py-2">Información legal</h1>

    <ul class="indice">
        <li><a href="#privacidad">Política de privacidad</a></li>
        <li><a href="#aviso">Aviso legal – Condiciones de uso</a></li>
    </ul>

    {{-- 1. POLÍTICA DE PRIVACIDAD ------------------------------------------------ --}}
    <section id="privacidad" class="seccion">
        <h2 >Política de privacidad</h2>

        <h3 class="ps-4">1. ¿Para qué usamos sus datos?</h3>
        <p>En MeetPoint tratamos la información que usted nos facilita con estas finalidades:</p>
        <ul>
            <li><strong>Gestionar las reservas de salas y eventos</strong>, incluyendo recordatorios y cambios de última
                hora.</li>
            <li><strong>Contactar con usted</strong> por teléfono o mensajería en relación con la reserva.</li>
            <li><strong>Personalizar la experiencia</strong>: la geolocalización permite mostrarle espacios cercanos y
                mejorar tiempos de respuesta.</li>
            <li><strong>Enviarle comunicaciones internas</strong> sobre mejoras de la plataforma o cambios en las
                condiciones del servicio (nunca publicidad ajena).</li>
        </ul>

        <h3 class="ps-4">2. Base jurídica</h3>
        <p>La legitimación principal es la <strong>ejecución del contrato de reserva</strong>. El envío puntual de
            información sobre nuevas funcionalidades se basa en nuestro <strong>interés legítimo</strong> de mantenerle
            informado como cliente. En ningún caso cedemos sus datos a terceros ni hacemos perfiles con efectos jurídicos.
        </p>

        <h3 class="ps-4">3. Tiempo de conservación</h3>
        <p>Sus datos (nombre, teléfono y, en su caso, correo electrónico y ubicación) se conservan mientras mantenga activa
            su cuenta o exista alguna reserva pendiente. Una vez finalizada la relación, bloqueamos la información el tiempo
            estrictamente necesario para cumplir las obligaciones legales (por ejemplo, cinco años según la normativa
            contable española).</p>

        <h3 class="ps-4">4. Destinatarios</h3>
        <p><strong>No se realizan cesiones de datos a terceros.</strong> Solo accede el personal interno de MeetPoint que
            necesita la información para dar soporte y gestionar las reservas, bajo obligación de confidencialidad.</p>

        <h3 class="ps-4">5. Sus derechos</h3>
        <p>Puede ejercer los derechos de acceso, rectificación, supresión, oposición, portabilidad y limitación escribiendo
            a <a href="mailto:privacidad@meetpoint.es">privacidad@meetpoint.es</a> o a la dirección postal indicada en el
            aviso legal. Si considera que no hemos atendido correctamente su solicitud, puede reclamar ante la <a
                href="https://www.aepd.es">Agencia Española de Protección de Datos</a>.</p>
    </section>

    {{-- 2. AVISO LEGAL ----------------------------------------------------------- --}}
    <section id="aviso" class="seccion">
        <h2 >Aviso legal y condiciones de uso</h2>

        <p><strong>Objeto.</strong> El portal <em>meetpoint.es</em> facilita un directorio de salas y la posibilidad de
            reservarlas en línea. El acceso y uso del sitio implican la aceptación íntegra de estas condiciones.</p>

        <p><strong>Responsabilidad del usuario.</strong> Quien publica información (por ejemplo, descripciones de salas o
            imágenes) garantiza que es veraz y no vulnera derechos de terceros. Está prohibido difundir contenido ilícito,
            difamatorio, sexista, xenófobo o que contravenga la normativa vigente.</p>

        <p><strong>Propiedad intelectual.</strong> Todos los textos, códigos, logotipos, fotografías y diseños pertenecen a
            MeetPoint o a sus legítimos titulares. Se concede una licencia de uso estrictamente personal; cualquier
            explotación comercial requerirá autorización escrita.</p>

        <p><strong>Jurisdicción.</strong> Con carácter general, las partes se someten a los Juzgados y Tribunales de Madrid
            capital, salvo normativa imperativa que disponga otra cosa.</p>
    </section>
</main>

    


@endsection
