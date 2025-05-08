<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
    <nav>
        <p>MeetPoint
            <a href="{{ route('espacios.index') }}">Espacios</a>
            <a href="{{ route('resenas.index') }}">Reseñas</a>
            <a href="{{ route('contacto.create') }}">Contacto</a></p>
    </nav>
    <main>

        <h1>Preguntas frecuentes (FAQ)</h1>

        {{-- Índice de secciones – enlaces de desplazamiento interno --}}
        <ul class="indice">
            <li><a href="#alta">Registro y alta de centro</a></li>
            <li><a href="#planes">Planes Premium & tarifas</a></li>
            <li><a href="#cuenta">Gestión de cuenta</a></li>
            <li><a href="#ventas">Ventas y facturación</a></li>
            <li><a href="#reservas">Reservas & oportunidades</a></li>
            <li><a href="#otros">Otras dudas</a></li>
            <li><a href="#contacto">Contacto</a></li>
        </ul>

        {{-- === 1. REGISTRO Y ALTA DE CENTRO ================================= --}}
        <section id="alta" class="faq">
            <h2>Registro y alta de espacio</h2>

            <h3>¿Cómo me doy de alta?</h3>
            <ol>
                <li>Haz clic en <b>Entrar</b>.</li>
                <li>Selecciona <b>Crea una cuenta y añade tu espacio</b>.</li>
                <li>Introduce tus datos personales.</li>
                <li>Guarda los cambios.</li>
            </ol>

            <h3>¿Cómo doy de alta un centro?</h3>
            <ol>
                <li>Inicia sesión en MeetPoint.</li>
                <li>Haz clic en <b>Añade un espacio</b>.</li>
                <li>Rellena los datos de tu espacio y guarda.</li>
                <li>Después de guardar, podrás añadir las tarifas que desees.</li>
            </ol>
        </section>

        {{-- === 2. PLANES, TARIFAS, ACUERDO, VISA ============================ --}}
        <section id="planes" class="faq">
            <h2>Planes Premium y tarifas</h2>

            <h3>¿Cómo me hago Premium?</h3>
            <ol>
                <li>Accede a tu cuenta.</li>
                <li>Haz clic en <b>Ver planes y precios</b>.</li>
                <li>Elige el plan que te interese y abónalo con tarjeta.</li>
            </ol>

            <h3>¿Cómo añado una tarifa?</h3>
            <ol>
                <li>Inicia sesión y haz clic en <b>Editar</b> tu espacio.</li>
                <li>Pulsa <b>Añadir tarifa</b>, introduce los datos y guarda.</li>
                <li>Recuerda: para añadir tarifas debes firmar el acuerdo de colaboración.</li>
            </ol>

            <h3>¿Cómo firmo el acuerdo de colaboración?</h3>
            <p>Puedes descargarlo desde tu <b>Panel → Documentos</b>; fírmalo y súbelo.</p>

            <h3>¿Qué tipos de tarifas puedo configurar?</h3>
            <ul>
                <li>Mesa fija / Mesa flexible</li>
                <li>Despacho privado / Hot Desk</li>
                <li>Pases y bonos</li>
                <li>Salas de reuniones / Eventos y formación</li>
                <li>Oficina virtual</li>
            </ul>

            <h3>¿Qué tarifas permiten la venta online?</h3>
            <p>Pases y bonos, y Salas de reuniones.</p>

            <h3>¿Cómo modificar el orden de aparición de las tarifas?</h3>
            <p>En la lista de tarifas haz clic en <b>Ordenar tarifas</b> y arrastra con las
               flechas la tarifa deseada a la primera posición.</p>

            <h3>¿Cómo me hago Coworking Visa?</h3>
            <ol>
                <li>En tu perfil pulsa <b>Editar</b>.</li>
                <li>Activa <b>Coworking Visa</b> en el apartado de servicios y guarda.</li>
            </ol>
        </section>

        {{-- === 3. CUENTA Y PERFIL ========================================== --}}
        <section id="cuenta" class="faq">
            <h2>Gestión de cuenta</h2>

            <h3>¿Cómo modificar los datos de mi perfil personal?</h3>
            <ol>
                <li>Entra en tu perfil y pulsa <b>Editar mi cuenta</b>.</li>
                <li>Modifica los campos necesarios y guarda.</li>
            </ol>

            <h3>He olvidado mi contraseña</h3>
            <ol>
                <li>En la página de inicio de sesión, haz clic en <b>He olvidado mi contraseña</b>.</li>
                <li>Introduce tu e-mail y recibirás un enlace de recuperación.</li>
                <li>Sigue el enlace, introduce nueva contraseña y guarda.</li>
            </ol>

            <h3>¿Cómo eliminar mi cuenta?</h3>
            <ol>
                <li>Perfil → Editar.</li>
                <li>Pulsa el botón <b>Eliminar</b> al final del formulario.</li>
            </ol>

            <h3>Tamaños de imagen recomendados</h3>
            <ul>
                <li>Mínimo 1920 × 1080 px.</li>
                <li>Peso &lt; 2 MB; formatos: jpg, jpeg, png, gif.</li>
            </ul>
        </section>

        {{-- === 4. VENTAS Y FACTURACIÓN ====================================== --}}
        <section id="ventas" class="faq">
            <h2>Ventas, facturas y suscripciones</h2>

            <h3>¿Cómo puedo ver mis ventas?</h3>
            <p>Cuenta → <b>Ventas</b> para ver todas las operaciones y detalles del cliente.</p>

            <h3>¿Cómo obtengo el informe de ventas?</h3>
            <p>En <b>Ventas</b> pulsa <b>Informe de ventas</b> para ver resumen por periodo,
               estadísticas y exportar en PDF/Excel.</p>

            <h3>¿Cómo funciona el proceso de cobro?</h3>
            <ol>
                <li><b>Factura al cliente:</b> la emite tu espacio.</li>
                <li><b>Comisión:</b> MeetPoint factura la comisión a principio de mes
                    (ya descontada del pago).</li>
                <li><b>Transferencia:</b> MeetPoint te ingresa el total – comisión
                    el día 15 del mes siguiente.</li>
            </ol>

            <h3>¿Cómo veo y descargo mis facturas?</h3>
            <p>Cuenta → <b>Facturas</b>; pulsa sobre el icono de descarga.</p>

            <h3>¿Cómo me doy de baja de los servicios premium?</h3>
            <p>Perfil → <b>Suscripciones</b> → <b>Cancelar suscripción</b>.</p>
        </section>

        {{-- === 5. RESERVAS Y OPORTUNIDADES ================================= --}}
        <section id="reservas" class="faq">
            <h2>Reservas y oportunidades</h2>

            <h3>¿Cómo gestiono las oportunidades de clientes?</h3>
            <ol>
                <li>Recibirás un correo cada vez que un usuario envíe un formulario.</li>
                <li>En tu panel → <b>Oportunidades</b> puedes <b>Aceptar</b> (ver datos) o
                    <b>Rechazar</b> (el sistema avisará al usuario).</li>
                <li>Tras aceptar, contacta con el cliente; MeetPoint hará seguimiento en 7 días.</li>
            </ol>

            <h3>¿Cómo acepto las reservas de mis salas?</h3>
            <ol>
                <li>Panel → <b>Reservas</b>.</li>
                <li>Localiza la solicitud pendiente y pulsa <b>Confirmar</b>.</li>
                <li>Comprueba antes la disponibilidad para evitar solapamientos.</li>
            </ol>

            <h3>¿Cómo veo los mensajes recibidos?</h3>
            <p>Panel → <b>Oportunidades</b>; cada oportunidad incluye los mensajes del usuario.</p>
        </section>

        {{-- === 6. OTROS ====================================================== --}}
        <section id="otros" class="faq">
            <h2>Otras preguntas</h2>

            <h3>¿Cómo descargar el acuerdo de colaboración?</h3>
            <p>Panel → <b>Documentos</b>; encontrarás siempre la última versión.</p>
        </section>
    </main>

    <hr>
    <h1 id="contacto">Contacto</h1>
    <form action="{{ route('contacto.store') }}" method="POST">
        @csrf
        <label for="asunto">Asunto</label>
        <input type="text" name="asunto" id="asunto" required><br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required><br>
        <label for="telefono">Teléfono (Opcional)</label>
        <input type="text" name="telefono" id="telefono" required><br>

        <label for="mensaje">Mensaje</label>
        <textarea name="mensaje" id="mensaje" required></textarea><br>

        <button type="submit">Enviar</button>
    </form>

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
