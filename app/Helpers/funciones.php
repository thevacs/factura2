<?php

function active($path, $active = 'active')
{
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

function trueToString($valor)
{
    switch ($valor) {
        case 0:
            return (string) 'No Aplica';
            break;
        case 1:
            return (string) 'Aplica';
            break;

        default:
            return null;
            break;
    }
}

function getValueForCalc($coin, $amount)
{
    return (float) App\Moneda::find($coin)->valor * $amount;
}

function aporteToChange($aporte)
{
    $aporte = \App\Aporte::find($aporte);
    $result = $aporte->valor * \App\Moneda::find($aporte->moneda_id)->valor;
    return $result;
}

function tipoProductoCNT($tamano, $tipo)
{
    $tipo = \App\Producto::where('tamano', $tamano)->where('tipo', $tipo)->get();
    return $tipo->first()['id'];
}

function answerValidate($variable)
{
    if ($variable != 0) {
        return 'Validada';
    } else {
        return 'Pendiente';
    }
}
