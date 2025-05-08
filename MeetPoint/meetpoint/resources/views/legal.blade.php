<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información legal</title>
</head>

<body>
    <nav>
        <p>MeetPoint
            <a href="{{ route('espacios.index') }}">Espacios</a>
            <a href="{{ route('resenas.index') }}">Reseñas</a>
            <a href="{{ route('contacto.create') }}">Contacto</a></p>
    </nav>
    {{-- Título y menú interno ---------------------------------------------------- --}}
    <h1>Información legal</h1>

    <ul class="indice">
        <li><a href="#privacidad">Política de privacidad</a></li>
        <li><a href="#aviso">Aviso legal - Condiciones de uso</a></li>
        <li><a href="#cookies">Política de cookies</a></li>
    </ul>

    {{-- 1. POLÍTICA DE PRIVACIDAD ------------------------------------------------ --}}
    <section id="privacidad" class="seccion">
        <h2>Política de privacidad</h2>

        <h3>¿Con qué finalidad tratamos sus datos?</h3>
        <p>Gestionar la relación comercial, prestar los servicios contratados,
            enviar comunicaciones sobre novedades de MeetPoint y mejorar la experiencia
            de usuario mediante elaboración de perfiles comerciales (sin decisiones
            automatizadas).</p>

        <h3>¿Cuál es la base jurídica?</h3>
        <p>La ejecución del contrato y el interés legítimo de MeetPoint; el
            envío de ofertas adicionales se basa en su consentimiento.</p>

        <h3>¿Durante cuánto tiempo conservaremos sus datos?</h3>
        <p>Mientras dure la relación contractual y, tras ella, los plazos
            exigidos por la normativa vigente.</p>

        <h3>Derechos</h3>
        <p>Puede ejercer los derechos de acceso, rectificación, supresión,
            oposición y limitación escribiendo a la dirección arriba indicada.
            Tiene derecho a reclamar ante la Agencia Española de Protección de Datos.</p>
    </section>

    {{-- 2. AVISO LEGAL ----------------------------------------------------------- --}}
    <section id="aviso" class="seccion">
        <h2>Aviso legal y condiciones de uso</h2>

        <p><strong>Objeto:</strong> el portal meetpoint.es ofrece un directorio de salas
            y espacios para reuniones y eventos. El acceso implica la aceptación de estas
            condiciones y el compromiso de uso lícito y diligente.</p>

        <p>El usuario garantiza la veracidad de la información publicada y exime a
            MeetPoint de cualquier responsabilidad derivada de contenidos aportados por
            terceros. Queda prohibida la difusión de contenidos xenófobos, difamatorios,
            sexistas o contrarios a la legalidad.</p>

        <p>MeetPoint es titular de todos los derechos de propiedad intelectual e
            industrial. Se concede al usuario una licencia limitada y revocable para uso
            personal; cualquier explotación comercial requiere autorización expresa.</p>

        <p>Estas condiciones se rigen por la legislación española; las partes se
            someten, cuando la norma lo permita, a los Juzgados de Madrid capital.</p>
    </section>

    {{-- 3. POLÍTICA DE COOKIES --------------------------------------------------- --}}
    <section id="cookies" class="seccion">
        <h2>Política de cookies</h2>

        <p>Este sitio utiliza cookies técnicas, de personalización y analíticas para
            mejorar la navegación. Al continuar navegando acepta su uso.
            Puede bloquearlas o eliminarlas en la configuración de su navegador.</p>

        <h3>¿Qué son las cookies?</h3>
        <p>Archivos que se descargan en su dispositivo al acceder a determinadas
            páginas web y que permiten almacenar y recuperar información sobre la
            navegación.</p>

        <h3>Tipos de cookies empleadas</h3>
        <ul>
            <li><strong>Técnicas y de personalización:</strong> recuerdan sus
                preferencias (por ejemplo, volumen o idioma).</li>
            <li><strong>Geolocalización:</strong> orientan el contenido a su región.</li>
            <li><strong>Analíticas:</strong> recopilan datos estadísticos anónimos sobre
                el uso del portal (Google Analytics).</li>
        </ul>

        <h3>Cómo gestionar las cookies</h3>
        <p>Puede permitir, bloquear o eliminar las cookies configurando su navegador.
            Consulte la ayuda de <em>Chrome</em>, <em>Firefox</em>, <em>Edge</em> o
            <em>Safari</em> para más información.
        </p>
    </section>
    </main>
    <footer style="background-color: rgb(197, 197, 197); text-decoration:none;">
    
        <a href="{{ route('espacios.index') }}">Espacios</a>
        <a href="{{ route('resenas.index') }}">Reseñas</a>
        {{-- <a href="">Iniciar sesión</a> --}}
        <a href="{{ route('contacto.create') }}">Contacta con nosotros</a>
        <a href="{{ route('legal') }}">Información legal</a>
 <p>MeetPoint &copy; 2025</p>
   </footer>

</body>

</html>
