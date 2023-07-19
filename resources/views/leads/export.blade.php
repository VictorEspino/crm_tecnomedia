<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=pipeline.xls");
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
    <td bgcolor="#0099ff"><center>Fuente</td>
    <td bgcolor="#0099ff"><center>Contacto</td>
    <td bgcolor="#0099ff"><center>Fecha</td>
    <td bgcolor="#0099ff"><center>Registrado</td>
</tr>
<?php
foreach ($registros as $lead) {
	?>
<tr>
<td>{{$lead->compania->nombre}}</td>
<td>{{$lead->user->name}}</td>
<td>{{$lead->linea_negocio->nombre}}</td>
<td>{{$lead->servicio->nombre}}</td>
<td>{{$lead->oportunidad}}</td>
<td>{{$lead->prospecto->razon_social}}</td>
<td>{{$lead->partner}}</td>
<td>{{$lead->producto}}</td>
<td>{{$lead->etapa_id}}</td>
<td>{{$lead->fuente->nombre}}</td>
<td>{{$lead->contacto->nombre}}</td>
<td>{{$lead->fecha_contacto}}</td>
<td class=""><center>{{$lead->created_at}}</td>
</tr>
<?php
}
?>
</table>