<?php

namespace App\Services;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\InvoiceHeader;

class CufService
{

	public function buildCuf($dataCuf)
	{
		$nitEmisor 			= str_pad($dataCuf['nitEmisor'], 13, '0', STR_PAD_LEFT);
		$sucursalNro 		= str_pad($dataCuf['codigoSucursal'], 4, '0', STR_PAD_LEFT);
		$tipoSector 		= str_pad($dataCuf['codigoDocumentoSector'], 2, '0', STR_PAD_LEFT);
		$numeroFactura 		= str_pad($dataCuf['numeroFactura'], 10, '0', STR_PAD_LEFT);
		$numeroPuntoVenta 	= str_pad($dataCuf['codigoPuntoVenta'], 4, '0', STR_PAD_LEFT);
		$fechaHora 			= date('YmdHisv', strtotime($dataCuf['fechaEmision'])); //date('YmdHisv');
		$modalidad = $dataCuf['modalidad'];
		$tipoEmision = $dataCuf['tipoEmision'];
		$tipoFactura = $dataCuf['tipoFactura'];
		$codigoControl = $dataCuf['codigoControl'];

		$cadena 		= "{$nitEmisor}{$fechaHora}{$sucursalNro}{$modalidad}{$tipoEmision}{$tipoFactura}{$tipoSector}{$numeroFactura}{$numeroPuntoVenta}";
		$verificador 	= $this->calculaDigitoMod11($cadena, 1, 9, false);
		$b16_str 		= strtoupper($this->bcdechex($cadena . $verificador));
		$cuf = $b16_str . $codigoControl;
		return $cuf;
	}
	public function bcdechex($dec)
	{
		$hex = '';
		do {
			$last = bcmod($dec, 16);
			$hex = dechex($last) . $hex;
			$dec = bcdiv(bcsub($dec, $last), 16);
		} while ($dec > 0);
		return $hex;
	}

	public function calculaDigitoMod11(string $cadena, int $numDig, int $limMult, bool $x10)
	{
		$cadenaSrc = $cadena;
		$mult = $suma = $i = $n = $dig = 0;
		if (!$x10) $numDig = 1;
		for ($n = 1; $n <= $numDig; $n++) {
			$suma = 0;
			$mult = 2;
			for ($i = strlen($cadena) - 1; $i >= 0; $i--) {
				$cadestr = $cadena[$i];
				$intNum = (int)($cadestr);
				$suma += ($mult * $intNum);
				if (++$mult > $limMult) $mult = 2;
			}
			if ($x10) {
				$dig = (($suma * 10) % 11) % 10;
			} else {
				$dig = $suma % 11;
			}
			if ($dig == 10) {
				$cadena .= "1";
			}
			if ($dig == 11) {
				$cadena .= "0";
			}
			if ($dig < 10) {

				//$cadena .= String.valueOf(dig);
				$cadena .= $dig;
			}
			//echo "Dig: ", $dig, "\n";
		}
		$modulo = substr($cadena, strlen($cadena) - $numDig, strlen($cadena));
		return $modulo;
	}
}
