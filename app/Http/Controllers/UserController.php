<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $userType = UserType::whereNot('id', 1)->get();
        return view('home.index', compact('userType'));
    }

    public function filter(Request $request)
    {
        $usersData = User::with('userType')->whereNot('id', 1);

        if ($request->name) $usersData->where('name', 'like', '%' . $request->name . '%');

        if ($request->email) $usersData->where('email', 'like', '%' . $request->email . '%');

        if ($request->user_type) $usersData->where('user_type_id', $request->user_type);

        $usersData = $usersData->get();

        return DataTables()->of($usersData)->make(true);
    }

    public function create(Request $request)
    {
        $userType = UserType::whereNot('id', 1)->get();
        return view('userConfig.register', compact('userType'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'user_type_id' => 'required|in:2,3'
        ]);

        // Si la validación falla, devuelve un mensaje de error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Intenta crear el usuario
        try {
            // Encriptar la contraseña antes de almacenarla en la base de datos
            $request['password'] = bcrypt($request['password']);

            // Asignar user_type_id al usuario
            $user = User::create($request->all());

            if (!$user) {
                return response()->json(['error' => 'Error al crear usuario.'], 400);
            }

            return response()->json('Usuario creado correctamente');
        } catch (\Exception $e) {
            // Si ocurre una excepción, devuelve un mensaje de error
            return response()->json(['error' => 'Error al crear usuario.'], 500);
        }
    }

    public function edit(int $id)
    {
        $userType = UserType::whereNot('id', 1)->get();
        $userData = User::with('userType')->where('id', $id)->first();
        return view('userConfig.edit', compact('userType', 'userData'));
    }

    public function update(Request $request, int $id)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        // Si la validación falla, devuelve un mensaje de error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Encriptar la contraseña antes de almacenarla en la base de datos
        $request['password'] = bcrypt($request['password']);

        // Intenta actualizar el usuario
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }

            // Actualiza los campos proporcionados
            $user->update($request->all());

            return response()->json('Usuario actualizado correctamente');
        } catch (\Exception $e) {
            // Si ocurre una excepción, devuelve un mensaje de error
            return response()->json(['error' => 'Error al actualizar usuario.'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }
            $user->delete();
            return response()->json('Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar usuario. Detalles: ' . $e->getMessage()], 500);
        }
    }
}
