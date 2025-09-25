<?php

$pais = isset($_GET["paisbuscado"]) ? trim($_GET["paisbuscado"] ) : '' ;
$error = null;  //nao tem valor 
$dados = [] ;

if( $pais == "" ) {

    $error = "digite um pais";     }

    else {
        
        $url = "https://restcountries.com/v3.1/name/{$pais}";
    
        $config = [
            "http"=>             [ 
                               "method" => "GET",

            "header" => "Content-Type: application/json"
            
            ]];

            $context = stream_context_create($config);
  $result = file_get_contents($url, false, $context);

  if( $result === false ) {$error = "pais invalido";}

else {
    $dados = json_decode($result, true);

if(!isset($dados[0]))   {

    $error = "nenhum pais encontrado";

}
else {$dados = $dados[0];            }
                          }
 
}



?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>resultado da busca </title>
<link rel="stylesheet" href="./../CSS/style.css">
</head>

<body>
   <div id="paisbuscado">
      <span id="error"><?= $error  ?? '' ?></span>

      <div>
         <label>nome </label>
         <input type="text" value="<?=  isset($dados['name']['common'])  ? $dados['name']['common'] : ''  ?>" disabled>
      </div>

      <div>
         <label>população </label>
         <!-- <input type="text" value="" disabled>   pode ser usado assim-->
     <input type="text" value="<?=  isset($dados['population']) ?number_format ($dados['population'], 0, ',','.' ): ''  ?>" disabled>
      </div>

   <div>
      <label>Região: </label>
   <input type="text" value="<?= isset($dados['region']) ? $dados['region'] : '' ?>" disabled>
</div>

<div>
   <label>Sub-região: </label>
   <input type="text" value="<?= isset($dados['subregion']) ? $dados['subregion'] : '' ?>" disabled>
</div>

<div>
   <label>Idioma: </label>
   <input type="text" value="<?= isset($dados['languages']['por']) ? $dados['languages']['por'] : '' ?>" disabled>
</div>

<div>
   <label>Mapa </label><br>
   <?= isset($dados['maps']['googleMaps']) ? '<a href="'.$dados['maps']['googleMaps'].'" target="_blank">ver no google Maps</a>':'' ?> 
</div>

<div>
<label >Bandeira </label><br>
<?= isset($dados['flags']['svg']) ? '<img src="'. $dados['flags']['svg']. '" alt ="bandeira" width="150">' : '' ?> 






</div>






</body>

</html>







        










        

 











