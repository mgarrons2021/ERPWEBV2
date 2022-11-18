<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{

    public function registrarCliente($clienteData)
    {
       /*  return response()->json($clienteData); */
        $cliente = Cliente::where('ci_nit', "=", $clienteData['ci_nit'])->first();
        if ($clienteData['cliente'] == "SIN NOMBRE" && $clienteData['empresa'] == "SIN EMPRESA" && $clienteData['correo'] == "SIN CORREO" && $clienteData['ci_nit'] == 0 && $clienteData['telefono'] == 0) {
            $cliente = $this->registrarclienteSN();
            return $cliente;
        } else {
            if (is_null($cliente)) {
                $cliente = new Cliente();
                $cliente->nombre = $clienteData['cliente'] ;
                $cliente->ci_nit = $clienteData['ci_nit'];
                $cliente->empresa = $clienteData['empresa'];
                $cliente->correo = $clienteData['correo'];
                $cliente->telefono = $clienteData['telefono'];
                $cliente->complemento = $clienteData['complemento'];
                $cliente->contador_visitas = $clienteData['sucursal'] == 18 ? $clienteData['cantidad_visitas'] : 0; //17 PIRAI, sino sera 0 sus visitas
                return $cliente->save() ? $cliente : "";
            } else {
                $cantidad_visitas = intval($cliente->contador_visitas) + 1;
                if ($cliente->nombre != $clienteData['cliente']) {
                    $cliente->nombre = $clienteData['cliente'];
                }
                if ($cliente->empresa != $clienteData['empresa']) {
                    $cliente->empresa = $clienteData['empresa'];
                }
                if ($cliente->telefono != $clienteData['telefono']) {
                    $cliente->telefono = $clienteData['telefono'];
                }
                if ($cliente->correo != $clienteData['correo']) {
                    $cliente->correo = $clienteData['correo'];
                }
                if ($cliente->complemento != $clienteData['complemento']) {
                    $cliente->complemento = $clienteData['complemento'];
                }
                if ($cliente->nombre != $clienteData['cliente'] || $cliente['empresa'] != $clienteData['empresa'] || $cliente['telefono'] != $clienteData['telefono'] || $cliente['correo'] != $clienteData['correo']) {
                }
                $cliente['contador_visitas'] = $clienteData['sucursal'] == 18 ? $cantidad_visitas : 0;
                return $cliente->save() ? $cliente : "";
            }
        }
    }

    public function registrarclienteSN()
    {
        $cliente = Cliente::where('nombre', "SIN NOMBRE")->first();
        if (is_null($cliente)) {
            $cliente = new Cliente();
            $cliente->nombre = "SIN NOMBRE";
            $cliente->ci_nit = 0;
            $cliente->empresa = "SIN EMPRESA";
            $cliente->correo = "SIN CORREO";
            $cliente->telefono = 0;
            $cliente->contador_visitas = 0;
            $cliente->save();
        }
        return $cliente;
    }
}
