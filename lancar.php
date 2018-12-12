<?php
  include_once("./mysql.php");

  //  Realiza a busca na base de dados
  $con = new Conexao();
  $link = $con->conexao();

  function tofloat($num) {
    $dotPos = strrpos($num, ',');
    $commaPos = strrpos($num, '.');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
  
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
  }

  $id_tipo = $_POST['id_tipo'];
  $money = $_POST['valor'];
  $valor = str_replace(',', '.', str_replace('.','',$money));
  //  $valor = money_format("%,2n", $money);
  $data_Nasc = new DateTime($_POST['data_venc']);
  $data = $data_Nasc->format('Y-m-d');
  $id_integrante = $_POST['id_integrante'];

  $sql = $link->prepare("INSERT INTO conta(id_tipo, valor, data_venc, id_integrante) VALUES('$id_tipo', '$valor', '$data', '$id_integrante');");
  
  //  Verifica o acesso ao usuário e redireciona a página correta
  if(!$sql->execute()){
    //  Usuário não existe
    echo"<script language='javascript' type='text/javascript'>alert('Erro no Lançamento.');window.location.href='./lancamento.php';</script>";
        //  header("Location:./index.html");
  } else {
    echo"<script language='javascript' type='text/javascript'>alert('Lançamento Efetuado.');window.location.href='./lancamento.php';</script>";
  }
?>