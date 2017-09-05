{{ csrf_field() }}
<input type="hidden" name="id_factor" value="{{ $factor->id_factor }}">
<div class="row" data-row="0">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="campos[0][nombre]" class="form-control" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="nombre">Visibilidad</label>
            <br>
            <div class="radio-inline i-checks">
                <label > <input type="radio" value="ambos" name="campos[0][visibilidad]" id="activo" required> <i></i> Ambos </label>
            </div>
            <div class="radio-inline i-checks">
                <label > <input type="radio" value="coordinador" name="campos[0][visibilidad]" id="inactivo" required> <i></i> Coordinador </label>
            </div>
            <div class="radio-inline i-checks">
                <label > <input type="radio" value="trabajador" name="campos[0][visibilidad]" id="inactivo" required> <i></i> Trabajador </label>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-group">
            <label for="nombre">Información del item </label>
            <textarea name="campos[0][informacion]" class="form-control editor" required placeholder="Escriba aquí toda la información que pueda ayudar al usuario con la evaluación de este ítem. Esta estará disponible en el formulario de evaluación"></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="button" class="btn btn-info" id="otro">Otro Item</button>
    <button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
