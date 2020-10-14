<?php
include ('../TPSServices/config.php' );
$main = new main($CONF, $conn);
$main->connect();
$SQL = "select NO_ANTRIAN from t_antrian_user"; 
$Query = $conn->query($SQL);
?>
  <div class="col-lg-6">
		<?php
		if ($Query->size() == 0) { 
			for($i=1;$i<=6;$i++){ 
				echo '<div class="panel panel-default"><div class="panel-heading">Loket '.$i.'</div><div class="panel-body">-</div></div>';
			}
		} else { $i=1;
			while ($Query->next()) {
				$antrian=($Query->get("NO_ANTRIAN")==null)?"-":$Query->get("NO_ANTRIAN");
				echo '<div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading text-center loket">Loket '.$i.'</div><div class="panel-body text-center nomor"><strong>'.$antrian.'</strong></div></div></div>';
				$i++;
			} 
		}
		?>
	<!--table class="table">
		<tr><th style='text-align:center; vertical-align:middle'><h1 class="margi">Nomor</h1></th>
		<th style='text-align:center; vertical-align:middle'><h1 class='margi'>Loket</h1></th></tr>
		<?php
		if ($Query->size() == 0) { 
			for($i=1;$i<=6;$i++){ 
				echo "<tr><td style='text-align:center; vertical-align:middle'><h2 class='margi'><strong>-".$i."</strong></h2></td>
				<td style='text-align:center; vertical-align:middle'><h2 class='margi'><strong>".$i."</strong></h2></td></tr>";
			}
		} else { $i=1;
			while ($Query->next()) {
				echo "<tr><td style='text-align:center; vertical-align:middle'><h2 class='margi'><strong>".$Query->get("NO_ANTRIAN")."</strong></h2></td><td style='text-align:center; vertical-align:middle'><h2 class='margi'><strong>".$i."</strong></h2></td></tr>"; 
				$i++;
			} 
		}
		?>
	</table-->
  </div>
  <!--div class="col-lg-3">
	<table class="table">
		<tr><th><h1 class='margi'>Loket</h1></th></tr>
		<?php for($i=1;$i<=6;$i++){ 
		echo "<tr><td style='text-align:center; vertical-align:middle'><h2 class='margi'><strong>".$i."</strong></h2></td></tr>";
		} ?>
	</table>
  </div-->
<?php
$main->connect(false);
?>