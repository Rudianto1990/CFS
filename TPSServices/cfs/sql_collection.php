<?php 
/*+---------------------------------------------------------------------------------------------------+
  | $Web Service Template$                                                         					  |
  | Author                  : -                                                         			  |
  | Template Created Date	: 22-Des-2014                                                             |
  | Template Version        : 1.0                                                                     |
  |---------------------------------------------------------------------------------------------------|
  | $Template Modification History$                                                                   |
  |---------------------------------------------------------------------------------------------------|
  | Modification                                Date                                  Modification By |
  |---------------------------------------------------------------------------------------------------|
  */

//======= SQL Collection ========// 
function getPKKInfo ($pkk,$agent_id)
{
	return "SELECT COUNT(*) as JUMLAH FROM xmti.tth_nota_all2 where no_nota = '$in_no_nota'";
}
?>