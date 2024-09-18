<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use \stdClass;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('personal_access_token')->plainTextToken;

        return response()->json(['data'=>$user,'token' => $token,'token_type'=>"Bearer"],);
    }


    public function login(Request $request)
    {
    // Validar que se envíe un identificador (email o username) y una contraseña
    $validator = Validator::make($request->all(), [
        'identifier' => 'required|string', // Puede ser email o username
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $identifier = $request->input('identifier');
    $password = $request->input('password');

      // Determinar si el identificador es un correo electrónico o nombre de usuario
      $query = User::query();
        
      if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
          // Si el identificador es un correo electrónico
          $query->where('email', $identifier);
      } else {
          // Si el identificador es un nombre de usuario
          $query->where('name', $identifier);
      }

      // Buscar el usuario en la base de datos o lanzar excepción si no se encuentra
      $user = $query->first();

      if (!$user || !Hash::check($password, $user->password)) {
          // Usuario no encontrado o la contraseña no coincide
          return response()->json(['error' => 'Unauthorized'], 401);
      }

      // Generar el token de acceso si la autenticación es exitosa
      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json(['message' => 'Welcome, ' . $user->name], 200);
    }
    public function logout()
    {
    auth()->user()->tokens()->delete();

    return [
        'message' => 'Has cerrado sesión correctamente y el token se ha eliminado con éxito',
    ];
    }

    public function welcome(Request $request, $id)
    {
    
        $user = User::find($id);
    
        return response()->json(['message' => 'Welcome, ' . $user->name], 200);
    }

}
