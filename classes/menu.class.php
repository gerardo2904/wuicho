<?php
class menubuillder
{
public $menu;
private $aElementos;
private $mnuact;
public $html;
function __construct($_aelementos)
{
$this->menu =array();
$this->aElementos = $_aelementos;
$this->mnuact=-1;
$this->html=" ";
$this->html.="<link href='css/menu_assets/styles.css' rel='stylesheet' type='text/css' /> ";
$this->html.="<div id='cssmenu'> ";
$this->html.="<ul>";
}

function makemenu($mimenu=array())
{
	$mimenu= array();
	foreach($this->aElementos as $reg)
	{
		if($reg[2]== 0) //es menu principal
		{
			$ar = $this->filterarra($reg[0]);
			if(sizeof($ar)>0)
				{
					$this->html.="<li class='has-sub'><a href='".$reg[3]."'><span>".$reg[1]."</span></a>";
					$mival = $this->makesubitems($ar);
					$mimenu[$reg[1]]=array($reg[0],$reg[1],$mival);
					$this->html.="</li>";
				}
			else
				{
					$mimenu[$reg[1]]=array($reg[0],$reg[1],null);
					$this->html.="<li><a href='".$reg[3]."'><span>".$reg[1]."</span></a></li>";
				}
		}
	}
	$this->html.="</ul></div>";
	$this->menu= $mimenu;
}

function makesubitems($arr)
{
	$mnu =array();
	$this->html.="<ul>";
	foreach($arr as $reg)
	{
		$ar = $this->filterarra($reg[0]);
		if(sizeof($ar)>0)
		{
			$this->html.="<li><a href='".$reg[3]."'><span>".$reg[1]."</span></a></li>";
			$mnu[$reg[1]]=array($reg[0],$reg[1],$this->makesubitems($ar));
			}
		else
			{
			$this->html.="<li><a href='".$reg[3]."'><span>".$reg[1]."</span></a></li>";
			$mnu[$reg[1]]=array($reg[0],$reg[1],null);
			}
		}
		$this->html.="</ul>";
		return $mnu;
}

function filterarra($valor)
{
	$newarray = array();
	foreach($this->aElementos as $elem)
	{
		if($elem[2]==$valor)
		{
			$newarray[]=$elem;
		}
	}
	return $newarray;
}

}
?>