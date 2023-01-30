<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


<script type="text/javascript">
	
	function sumafecha(s) {
		//alert("hola");
		var myDate1=new Date();
		//myDate1.setFullYear(10,10,);
		var Dias   		= 60;
		var dia    		= parseInt(myDate1.getDate());
		var mes  	 	= parseInt(myDate1.getMonth())+1;
		var ano       	= parseInt(myDate1.getFullYear());
		var diferencia 	= 0;
		var bandera     = false;
		//alert ("Fecha: "+dia+"-"+mes+"-"+ano);
		
		var variable=dia+"-"+mes+"-"+ano;
		
		//alert(variable);
		
		if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0)))
			var aFinMes = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		 else
			var aFinMes = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		
		//alert (aFinMes[mes-1]);
		
		
		while(!bandera){
		/*	if (aFinMes[mes-1] == 31) {
				bandera = true;
				alert ("mes: "+mes+" con dias: "+aFinMes[mes-1]);
				}
		*/
			var comparacion = 0;
			if (dia == 0)
				comparacion = Dias+dia;
			else
				comparacion = Dias;
			
			if (aFinMes[mes-1] >= comparacion)
			{
				dia=Dias;
				bandera = true;
			}
			else
			{
				diferencia = aFinMes[mes-1]-dia;
				Dias = Dias - diferencia;
				dia = 0;
				mes = mes + 1;
				if (mes == 13)
				{
					mes = 1;
					ano = ano +1;
					if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0)))
						aFinMes[1]=29; 
					else
						aFinMes[1]=28;
				}
				bandera = false;
			}
		}		
		//alert ("Fecha: "+dia+"-"+mes+"-"+ano);
		document.getElementById('fecha1').value=variable;
		var myDate2=new Date();
		//myDate2.setFullYear(myDate1.getDate()+5);
		var variable2=dia+"-"+mes+"-"+ano;
		//myDate2.setFullYear(dia,mes,ano);
		document.getElementById('fecha2').value=variable2;
	}
	
</script>

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <label>
    <input name="fecha1" type="text" id="fecha1" onfocus="sumafecha(this);" onselect="sumafecha(this);" onchange="sumafecha(this);" onclick="sumafecha(this);" />
    </label>
  </p>
  <p>
    <label>
    <input name="fecha2" type="text" id="fecha2" onfocus="sumafecha(this);" onselect="sumafecha(this);" onchange="sumafecha(this);" onclick="sumafecha(this);" />
    </label>
  </p>
</form>
</body>
</html>
