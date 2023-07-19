<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=forecast.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border=1>
<tr>
    <td bgcolor="#0099ff"><center>Compañia</td>
    <td bgcolor="#0099ff"><center>Vendedor</td>
    <td bgcolor="#0099ff"><center>Linea de Negocio</td>
    <td bgcolor="#0099ff"><center>Servicio</td>
    <td bgcolor="#0099ff"><center>Oportunidad</td>
    <td bgcolor="#0099ff"><center>Prospecto</td>
    <td bgcolor="#0099ff"><center>Partner/Fabricante</td>
    <td bgcolor="#0099ff"><center>Producto</td>
    <td bgcolor="#0099ff"><center>Etapa</td>
    <td bgcolor="#0099ff"><center>Contacto</td>
    <td bgcolor="#0099ff"><center>Moneda</td>
    <td bgcolor="#0099ff"><center>Horas consultoria</td>
    <td bgcolor="#0099ff"><center>Valor propuesta</td>
    <td bgcolor="#0099ff"><center>Costo fabricante</td>
    <td bgcolor="#0099ff"><center>Costo consultoria</td>
    <td bgcolor="#0099ff"><center>Margen estimado</td>
    <td bgcolor="#0099ff"><center>Estimacion cierre</td>
    <td bgcolor="#0099ff"><center>Dias credito</td>
    <td bgcolor="#0099ff"><center>Comentarios</td>
    <td bgcolor="#0099ff"><center>Registrado</td>
</tr>
<?php
foreach ($registros as $oportunidad) {
	?>
<tr>
<td>{{$oportunidad->compania->nombre}}</td>
<td>{{$oportunidad->user->name}}</td>
<td>{{$oportunidad->linea_negocio->nombre}}</td>
<td>{{$oportunidad->servicio->nombre}}</td>
<td>{{$oportunidad->oportunidad}}</td>
<td>{{$oportunidad->prospecto->razon_social}}</td>
<td>{{$oportunidad->partner}}</td>
<td>{{$oportunidad->producto}}</td>
<td>{{$oportunidad->etapa->nombre}}</td>
<td>{{$oportunidad->contacto->nombre}}</td>
<td>{{$oportunidad->moneda->nombre}}</td>
<td>{{$oportunidad->horas_consultoria}}</td>
<td>{{$oportunidad->valor_propuesta}}</td>
<td>{{$oportunidad->costo_fabricante}}</td>
<td>{{$oportunidad->costo_consultoria}}</td>
<td>{{$oportunidad->margen_estimado}}</td>
<td>{{$oportunidad->estimacion_cierre}}</td>
<td>{{$oportunidad->dias_credito}}</td>
<td>{{$oportunidad->dias_comentarios}}</td>

<td class=""><center>{{$oportunidad->created_at}}</td>
</tr>
<?php
}
?>
</table>