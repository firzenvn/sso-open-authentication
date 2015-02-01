<?php
	$i=0;
	$output='';
	foreach($bpms as $bpm){
		if(in_array($bpm['payment_method_type'], array($cardType))){
			if ($i > 0 && $i % 10 == 0) $output.="<br/>";
			$output.=
				'<label>'
				.'<input type="radio" name="bank_payment_method_id" value="'.$bpm['id'].'"/>'
				.'<img style="margin-right:7px;" src=\''.$bpm['logo_url']."'/>"
				.'</label>';
			$i++;
		}
	}
	echo $output;
?>