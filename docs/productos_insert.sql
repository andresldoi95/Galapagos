insert into productos (codigo, descripcion, categoria, informacion_adicional, empresa_id) select id_productos, descripcion_producto,
		case
			when categoria_producto = 'PRODUCTO PERMITIDO' then 'P'
			when categoria_producto = 'PRODUCTO RESTRINGIDO' then 'R'
			else 'NP'
		end
, concat(if(titulo_especifico is null, '', titulo_especifico), if(titulo_especifico is null, '','\n')
, if(req_especifico1 is null, '', req_especifico1), if(req_especifico1 is null, '', '\n')
, if(req_especifico2 is null, '', req_especifico2), if(req_especifico2 is null, '', '\n')
, if(titulo_general is null, '', titulo_general), if(titulo_general is null, '', '\n')
, if(norma_general1 is null, '', norma_general1), if(norma_general1 is null, '', '\n')
, if(norma_general2 is null, '', norma_general2), if(norma_general2 is null, '', '\n')
, if(norma_general3 is null, '', norma_general3), if(norma_general3 is null, '', '\n')
, if(norma_general4 is null, '', norma_general4), if(norma_general4 is null, '', '\n')
, if(norma_general5 is null, '', norma_general5), if(norma_general5 is null, '', '\n')
, if(norma_general6 is null, '', norma_general6), if(norma_general6 is null, '', '\n')
, if(norma_general7 is null, '', norma_general7), if(norma_general7 is null, '', '\n')
, if(titulo_sancionado is null, '', titulo_sancionado), if(titulo_sancionado is null, '', '\n')
, if(sancion is null, '', sancion), if(sancion is null, '', '\n')), 1 from mytable;
