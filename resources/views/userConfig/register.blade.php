@extends('base')
@section('body')
    <div class="row">
        <div class="col-12 justify-content-center align-items-center">
            <h5>Ingrese los datos</h5>
            <form class="row" id="registerForm">
                <div class="col-12 pt-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Nombre</span>
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="col-12 pt-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Email</span>
                        <input type="email" name="email" class="form-control" placeholder="correo@correo.com" required>
                    </div>
                </div>
                <div class="col-12 pt-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Contraseña</span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text">Tipo Usuario</label>
                    <select class="form-select" name="user_type_id" required>
                        <option value="" selected>Seleccione una opción</option>
                        @foreach ($userType as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 pt-2 d-flex justify-content-end">
                    <button class="btn btn-success" onclick="register();">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
