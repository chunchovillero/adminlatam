<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Porcentaje;
use App\Venta;
use Illuminate\Support\Facades\Hash;

class VentasController extends Controller
{
	public function gettoken($empresa, $user, $pass)
	{
		$empresa=Empresa::where('id',$empresa)->first();

        //dd($empresa);

		if($empresa!==null){
			if($user ==  $empresa->userapi ){
				if(Hash::check($pass, $empresa->passapi)) {
					$token = random_bytes(32);
					$token = bin2hex($token);
					$empresa->token = $token;
					$empresa->save();
					return response()->json([
						'state' => 'Login Correcto',
						'token' => $token,
					]);
				}
				else{
					return response()->json([
						'state' => 'password de api Incorrecto',
					]);
				}
			}else{
				return response()->json([
					'state' => 'Usuario de api incorrecto',
				]);
			}
		}else{
			return response()->json([
				'state' => 'Empresa afiliada no existe',
			]);
		}
	}

	public function sendventa($token, $afiliado, $vendedor, $pedido, $monto, $fecha ){

		$empresa=Empresa::where('id',$afiliado)->first();
		if($empresa){
			if($empresa->token == $token ){
				if($pedido){
				}
				else{
					return response()->json([
						'response' => 'Numero de pedido no existe',
					]);
				}
				if($afiliado){

					if(is_int($afiliado)){
						return response()->json([
							'response' => 'Empresa afiliada debe ser integer',
						], 400);  
					}
					else{

					}
				}
				else{
					return response()->json([
						'response' => 'Id de empresa afiliada es obligatorio',
					]);
				}

				if($vendedor){
					if(is_int($vendedor)){
						return response()->json([
							'response' => 'Empresa vendedora debe ser integer',
						]);  
					}
					else{
					}
				}
				else{
					return response()->json([
						'response' => 'Id de empresa vendedora es obligatorio',
					]);
				}
				if($pedido){
				}
				else{
					return response()->json([
						'response' => 'El numero de pedido es obligatorio',
					]);
				}
				if($monto){
				}
				else{
					return response()->json([
						'response' => 'El monto es obligatorio',
					]);
				}

				if($fecha){
				}
				else{
					return response()->json([
						'response' => 'La Fecha es obligatoria',
					]);
				}

				$getporcentaje = Porcentaje::where('afiliado_id',$afiliado)->where('vendedor_id',$vendedor)->orderBy('id', 'desc')->first();

                //dd($getporcentaje);
				$porcentaje = decrypt($getporcentaje->porcentaje);

				$venta = new Venta();
				$venta->pedido = encrypt($pedido);
				$venta->monto = encrypt($monto);
				$venta->porcentaje = encrypt($porcentaje);
				$venta->desde_id = $afiliado;
				$venta->hacia_id = $vendedor;
				$venta->fechaventa = encrypt($fecha);
				$venta->save();

				return response()->json([
					'status' => 'ok',
					'response' => 'Pedido agregado correctamente',
				], 200);
			}else{
				return response()->json([
					'response' => 'El token es incorrecto',
				]);
			}
		}else{
			return response()->json([
				'response' => 'No existe la empresa',
			]);
		}
	}
}
