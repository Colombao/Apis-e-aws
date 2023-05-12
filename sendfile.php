<?php

include 'conexao.php';
require 'vendor/autoload.php';

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;



$db = new Db();
$credentials = $db->getCredentials();
$s3 = new Aws\S3\S3Client(['region' => 'sa-east-1', 'version' => 'latest', 'credentials' => $credentials]);

$acoes = new Actions("bucket-brunorm");

$api = new OpenAIChatbot("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");

$catAPI = new CatAPI();
$cats = $catAPI->getTenRandomCats();

$conexao = new Acoes();

extract($_POST);
extract($_GET);

if (isset($_GET['gato'])) {
  foreach ($cats as $cat) {
    echo $cat["url"] . "**";
  }
}

if (isset($_GET['api'])) {
  $resposta = $api->get_response($_GET['text']);
  echo ($resposta);
}

if (isset($_GET['file'])) {
  $uri =  Actions::download($s3, $_GET['file']);
  echo ($uri);
}

if (isset($_GET['visualizar'])) {
  Actions::list($s3);
}

if (isset($_FILES['file'])) {
  $resposta = $acoes->put($s3);
  echo ($resposta);
}

if (isset($_GET['apagar'])) {
  $uri = Actions::deletar($s3, $_GET['fto']);
}
if (isset($_POST['Login'])) {
  Actions::cadastrar($db->conn());
}

if (isset($_FILES['file2'])) {
  echo (new Chamada($conexao))->createDocument();
}
if (isset($_POST['name'])) {

  echo (new Chamada($conexao))->create_signer();
}
if (isset($_GET['actions'])) {
  echo (new Chamada($conexao))->getSigners();
}
if (isset($_GET['objects'])) {
  echo (new Chamada($conexao))->getDocuments();
}
if (isset($_POST['signers'])) {
  echo (new Chamada($conexao))->vincular();
}
if (isset($action)) {
  if ($action == 'zap') {
    echo (new Chamada($conexao))->zap();
  }
  if ($action == 'email') {
    echo (new Chamada($conexao))->email();
  }
}
