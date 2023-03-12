<main>
    <form action="mailto:ignatiusconqueso@gmail.com" method="post" enctype="text/plain">
      <h2>Formulario de contacto</h2>
      <h3>Escríbenos y en breve los pondremos en contacto contigo</h3>
      <section>
        <h4>Nombre<span class="obligatorio">*</span></h4>
        <label for="nombre"></label>
        <input id="nombre" type="text" name="nombre" placeholder="Escribe tu nombre" value="" required>
      </section>
      <section>
        <h4>Email<span class="obligatorio">*</span></h4>
        <label for="email"></label>
        <input id="email" type="email" name="email" placeholder="Escribe tu email" value="" required>
      </section>
      <section>
        <h4>Asunto<span class="obligatorio">*</span></h4>
        <fieldset>
          <label><input id="asunto" type="radio" name="asunto" value="Pregunta" required>Pregunta</label>
          <label><input id="asunto2" type="radio" name="asunto" value="Sugerencia" required>Sugerencia</label>
          <label><input id="asunto3" type="radio" name="asunto" value="Crítica" required>Crítica</label>
        </fieldset>
      </section>

      <section>
        <label for="aceptar"></label>
        <h4><input id="aceptar" type="checkbox" name="aceptar" required>
          Marque esta casilla para verificar que ha leído nuestros términos
          y condiciones del servicio.
          <span class="obligatorio">*</span>
        </h4>
      </section>

      <section>
        <h4>Mensaje<span class="obligatorio">*</span></h4>
        <label for="mensaje"></label>
        <textarea id="mensaje" name="mensaje" placeholder="Escribe aquí tu comentario..." required></textarea>
      </section>

    </form>
  </main>