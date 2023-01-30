<?php require_once('Connections/contratos_londres.php'); ?>

<?php
	function menu_opcion($link,$opcion,$permiso1=0,$permiso2=0,$permiso3=0){
		if($permiso1==0 && $permiso2==0 && $permiso3==0){
			if ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==2 || $_SESSION['MM_UserGroup']==3){
				echo "<li><a href='".$link."'><span>".$opcion."</span></a></li> ";
			}
		}
		
		if($permiso1==1 && $permiso2==0 && $permiso3==0){
			if ($_SESSION['MM_UserGroup']==1){
				echo "<li><a href='".$link."'><span>".$opcion."</span></a></li> ";
			}
		}
		
		if($permiso1==1 && $permiso2==2 && $permiso3==0){
			if ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==2){
				echo "<li><a href='".$link."'><span>".$opcion."</span></a></li> ";
			}
		}
		
		if($permiso1==1 && $permiso2==2 && $permiso3==3){
			if ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==2 || $_SESSION['MM_UserGroup']==3){
				echo "<li><a href='".$link."'><span>".$opcion."</span></a></li> ";
			}
		}	
	}
	

?>
<style type="text/css">
.pendiente{background:#A00000;} 
</style>
<ul>
   <li><a href='principal.php'><span>Inicio</span></a></li>
   
   <?php if ($_SESSION['MM_UserGroup']==1){
		echo "<li class='has-sub'><a href='#'><span>Configuración</span></a>";
		echo "<ul>";
				 
					menu_opcion("usuarios_list.php","Usuarios",1,2); 
					menu_opcion("empresas_list.php","Empresas",1,2); 
					menu_opcion("clientes_list.php","Clientes",1,2);
					menu_opcion("vendedores_list.php","Ingenieros",1,2);
					 
		echo "</ul>";
		echo "</li>";
		}
   ?>

   

   
   <?php 
   	/*
   	if ($_SESSION['MM_UserGroup']==1){
			echo "<li class='has-sub'><a href='#'><span>Inventario de Autos</span></a>";
			echo "<ul>";
				 
			menu_opcion("marca_list.php","Marcas",1); 
			menu_opcion("tipo_list.php","Tipos",1); 
			menu_opcion("inventario_list.php","Inventario",1); 			
			echo "</ul>";
			echo "</li>";
		}
		*/
   ?>

					


      <li class='has-sub'><a href='#'><span>Ordenes de Trabajo</span></a>
      <ul>
         <li><a href='contrato.php'><span>Nueva Orden de Trabajo</span></a></li>
         <li><a href='contratos_list.php'><span>Lista de Ordenes de Trabajo</span></a></li>

      </ul>
   </li>
   
   <li><a href="<?php /*echo $logoutAction;*/ echo "ds.php";  ?>">Cerrar Sesion (<?php echo $_SESSION['MM_Username'];  ?>)</a></li>
</ul>



