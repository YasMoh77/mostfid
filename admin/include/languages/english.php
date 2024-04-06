<?php

function lang($phrase){

static $langray=array(
	//nav bar
"logo" => "mostfid",
"main" => "Home",
"dropDown" => "Sections",
"action1" => "Section1",
"action2" => "Section2",
"action3" => "Section3",
"link1" => "About us",
"link2" => "FAQ",
"link3" => "Contact us",


);

return $langray[$phrase];

}