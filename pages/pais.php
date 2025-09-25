<?php

$pais = isset($_GET["paisbuscado"]) ? trim($_GET["paisbuscado"]) : '';
$error = null;
$dados = [];

if ($pais == "") {
    $error = "digite um país";
} else {
    $url = "https://restcountries.com/v3.1/name/" . rawurlencode($pais);

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "Content-Type: application/json"
        ]
    ]);

    $result = @file_get_contents($url, false, $context);

    if ($result === false) {
        $error = "país inválido";
    } else {
        $json = json_decode($result, true);

        if (!isset($json[0])) {
            $error = "nenhum país encontrado";
        } else {
            $dados = $json[0];
        }
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Resultado da busca</title>
   <link rel="stylesheet" href="./../CSS/style.css">
</head>
<body>
   <!-- Formulário simples para pesquisar país -->
   <form method="get" action="">
       <input type="text" name="paisbuscado" placeholder="Digite o país" value="<?= htmlspecialchars($pais) ?>">
       <button type="submit">Buscar</button>
   </form>

   <div id="paisbuscado" style="margin-top:20px;">
      <span id="error"><?= htmlspecialchars($error ?? '') ?></span>

      <div>
         <label>Nome</label>
         <input type="text" value="<?= isset($dados['name']['common']) ? ($dados['name']['common']) : '' ?>" disabled>
      </div>

      <div>
         <label>População</label>
         <input type="text" value="<?= isset($dados['population']) ? number_format($dados['population'],0,',','.') : '' ?>" disabled>
      </div>

      <div>
         <label>Capital</label>
         <input type="text" value="<?= isset($dados['capital'][0]) ? ($dados['capital'][0]) : '' ?>" disabled>
      </div>

      <div>
         <label>Região</label>
         <input type="text" value="<?= isset($dados['region']) ? ($dados['region']) : '' ?>" disabled>
      </div>

      <div>
         <label>Sub-região</label>
         <input type="text" value="<?= isset($dados['subregion']) ? ($dados['subregion']) : '' ?>" disabled>
      </div>

      <div>
         <label>Idioma</label>
       <input type="text" value="<?= isset($dados['languages']) ? array_values($dados['languages'])[0] : '' ?>" disabled>

      </div>

      <div>
         <label>Bandeira</label><br>
         <?= isset($dados['flags']['svg']) ? '<img src="'.($dados['flags']['svg']).'" alt="bandeira" width="150">' : '' ?>
      </div>
   </div>
</body>
</html>