<?php

$d = filter_input(INPUT_GET, 'd', FILTER_SANITIZE_STRING);
$i =  filter_input(INPUT_GET, 'i', FILTER_SANITIZE_STRING);
$s =  filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
$c =  filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);


?>



<img style="width:100%" src="https://your site/funcoes/grafico.php?d=<?php echo $d ?>&i=<?php echo $i ?>&s=<?php echo $s ?>&c=<?php echo $c ?>">