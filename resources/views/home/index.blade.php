@extends('base')
@section('title', 'Configuración')
@section('body')
    @include('navbar')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-12 pt-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="col-md-12 d-flex justify-content-center">
                            <h5 class="card-title">Configuración de usuarios &nbsp<i class="fa-solid fa-user-gear"></i>
                            </h5>
                        </div>
                        <form id="userConfigForm" class="row pt-4">
                            <!-- Input para el correo -->
                            <div class="col-md-4 justify-content-center">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Nombre</span>
                                    <input type="text" id="name" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-md-4 justify-content-center">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Correo</span>
                                    <input type="email" id="email" class="form-control" placeholder="correo@usuario">
                                </div>
                            </div>
                            <div class="col-md-4 justify-content-center">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Tipo usuario</span>
                                    <select class="form-select" id="user_type">
                                        <option value="" selected>Seleccione</option>
                                        {{-- @foreach ($userType as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" onclick="registerModal();">Registrar &nbsp<i
                                        class="fa-solid fa-user-plus fa-sm"></i></button>
                            </div>
                            <div class="col-md-10 d-flex justify-content-end">
                                <button class="btn btn-danger" onclick="restart();">Limpiar &nbsp<i
                                        class="fa-solid fa-eraser"></i></button>&nbsp
                                <button class="btn btn-warning" onclick="filter();">Filtrar &nbsp<i
                                        class="fa-solid fa-magnifying-glass fa-sm"></i></button>
                            </div>
                        </form>
                        <div class="col-md-12 pt-4">
                            <table class="table table-striped table-hover" style="width: 100%;" id="userTable">
                                <thead class="table-success">
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/config/userConfig.js') }}" defer></script>
@endpush
