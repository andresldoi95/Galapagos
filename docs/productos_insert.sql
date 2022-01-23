insert into productos (codigo, descripcion, categoria, informacion_adicional, empresa_id) select id_productos, descripcion_producto,
		case
			when categoria_producto = 'PRODUCTO PERMITIDO' then 'P'
			when categoria_producto = 'PRODUCTO RESTRINGIDO' then 'R'
			else 'NP'
		end
, concat(if(titulo_especifico is null, '', concat('<b>', titulo_especifico, '</b>')), if(titulo_especifico is null, '','<br>')
, if(req_especifico1 is null, '', req_especifico1), if(req_especifico1 is null, '', '<br>')
, if(req_especifico2 is null, '', req_especifico2), if(req_especifico2 is null, '', '<br>')
, if(titulo_general is null, '', concat('<b>', titulo_general, '</b>')), if(titulo_general is null, '', '<br>')
, if(norma_general1 is null, '', norma_general1), if(norma_general1 is null, '', '<br>')
, if(norma_general2 is null, '', norma_general2), if(norma_general2 is null, '', '<br>')
, if(norma_general3 is null, '', norma_general3), if(norma_general3 is null, '', '<br>')
, if(norma_general4 is null, '', norma_general4), if(norma_general4 is null, '', '<br>')
, if(norma_general5 is null, '', norma_general5), if(norma_general5 is null, '', '<br>')
, if(norma_general6 is null, '', norma_general6), if(norma_general6 is null, '', '<br>')
, if(norma_general7 is null, '', norma_general7), if(norma_general7 is null, '', '<br>')
, if(titulo_sancionado is null, '', concat('<b>', titulo_sancionado, '</b>')), if(titulo_sancionado is null, '', '<br>')
, if(sancion is null, '', sancion), if(sancion is null, '', '<br>')), 1 from mytable;

