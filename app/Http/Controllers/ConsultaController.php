<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ConsultaController extends Controller{

    private $apiBaseUrl = "https://curp.tabasco.gob.mx/";

//    private $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc1ODkxODYzMywianRpIjoiZmIyMTkyMTctYzFmYS00MTNlLThjY2MtNmI1OWM1ODE5NzY5IiwidHlwZSI6ImFjY2VzcyIsInN1YiI6IkNhcmxvc0ZyYW5jaXNjb1JleWVzMiIsIm5iZiI6MTc1ODkxODYzMywiY3NyZiI6IjdjMjJmNTZkLWE4YjUtNDllOC04ZTUwLWI4ZDI5MWVjNDIxNyIsImV4cCI6MTc5MDQ1NDYzM30.uNJb1u_HeIvRpdo1k14IwtxjhDn9kwcHNajJl0OTQfk";
//    private $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTczNzY2MDk0MiwianRpIjoiMDViMGVhYTAtNDY0ZS00MzQ2LWIwNTMtNjUxY2MyZTZiYWZmIiwidHlwZSI6ImFjY2VzcyIsInN1YiI6IkFsYmVydG9BbG9uc29QZXJlejgiLCJuYmYiOjE3Mzc2NjA5NDIsImNzcmYiOiI1ZjEzYjg5My0zZGM3LTQxZGYtYWZlMy01NTA1ZDllM2FkNzMiLCJleHAiOjE3NjkxOTY5NDJ9.6082Z3gGfDfYigC7_WSnVQAWFlUGb95LoF8tTJgefjg";

    private $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc2MDYzNzI2NCwianRpIjoiMjUwYjdhMzMtNWVmNC00MzYzLTkwYjAtMWE0NDg0NzE3Y2IwIiwidHlwZSI6ImFjY2VzcyIsInN1YiI6IlpvaWxhSGVybW9zaW5kYU11b3o2IiwibmJmIjoxNzYwNjM3MjY0LCJjc3JmIjoiY2NiMzM4NzctNGQ2MS00NDViLTg3MGUtMGY0OGM5ZmJjNDgwIiwiZXhwIjoxNzkyMTczMjY0fQ.nJM9iZcuqLAeBIcy6Blxbqr9AwsAgH3ZOc53ZL-5dbE";


    public function consultaPorDatos(Request $request){

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:H,M',
            'clave_estado' => 'required|string|size:2'
        ]);

//        if ($validator->fails()) {
//            return response()->json([
//                'nombre' => false,
//                'message' => 'Error de validación',
//                'errors' => $validator->errors()
//            ], 422);
//        }

        try {
            $urlExterna = $this->apiBaseUrl.'consulta-datos';

            $fn = explode("-",$request->fecha_nacimiento);
            $fecha_nac = $fn[2]."/".$fn[1]."/".$fn[0];

            $datos = [
                'nombre'           => strtoupper($request->nombre),
                'apellido_paterno' => strtoupper($request->apellido_paterno),
                'apellido_materno' => strtoupper($request->apellido_materno),
                'sexo'             => strtoupper($request->sexo),
                'fecha_nacimiento' => $fecha_nac,
                'clave_estado'     => strtoupper($request->clave_estado)
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlExterna);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $this->token,
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $respuesta = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new RuntimeException("Error en conexión cURL: " . $error);
            }

            // Decodificar respuesta
            $respuestaJson = json_decode($respuesta, true);

            if ($respuestaJson !== null) {
                $consulta = Consulta::create([
                    'user_id' => Auth::id(),
                    'tipo' => 'datos',
                    'datos_consulta' => $request->all(),
                    'resultado' => $respuestaJson
                ]);
            }

//            return response()->json($respuestaJson);

            return redirect()->route('home')->with([
                'success' => 'Consulta realizada correctamente',
                'consulta_reciente' => $consulta
            ]);

        } catch (\Exception $e) {
            Log::error('Error en consulta por datos: ' . $e->getMessage());

            return redirect()->back()->with([
                'error' => 'Error en la consulta: ' . $e->getMessage()
            ]);
        }

    }

    public function consultaPorCurp(Request $request){


        $request->validate([
            'curp' => 'required|string|size:18'
        ]);

        try {

            $urlExterna = $this->apiBaseUrl.'consulta-curp';

//            dd($urlExterna);

            $datos = [
                'curp'           => $request->curp,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlExterna);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $this->token,
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $respuesta = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);

//            dd($error);



            curl_close($ch);

            if ($error) {
                throw new Exception("Error en conexión cURL: " . $error);
            }


            $respuestaJson = json_decode($respuesta, true);


            if ($respuestaJson !== null){
                $consulta = Consulta::create([
                    'user_id' => Auth::id(),
                    'tipo' => 'curp',
                    'datos_consulta' => $request->all(),
                    'resultado' => $respuestaJson
                ]);
            }

//            return response()->json($respuestaJson);

            return redirect()->route('home')->with([
                'success' => 'Consulta realizada correctamente',
                'consulta_reciente' => $consulta
            ]);

        } catch (\Exception $e) {
            Log::error('Error en consulta por datos: ' . $e->getMessage());

            return redirect()->back()->with([
                'error' => 'Error en la consulta: ' . $e->getMessage()
            ]);
        }
    }

    private function obtenerEstado($clave)
    {
        $estados = json_decode(file_get_contents(public_path('js/estados.json')), true);
        return $estados[$clave] ?? 'Desconocido';
    }

}
