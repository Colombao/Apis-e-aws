<?php
$json = file_get_contents('php://input');
$jsonObj = json_decode($json);

$urlAssinada = null;

while (!$urlAssinada) {
    if (property_exists($jsonObj->document->downloads, 'signed_file_url')) {
        $signedFileUrl = $jsonObj->document->downloads->signed_file_url;
        $filename = $jsonObj->document->filename;
        $tempFilePath = "./$filename";
        file_put_contents($tempFilePath, file_get_contents($signedFileUrl));

        require_once 'vendor/autoload.php';
        include "conexao.php";

        $db = new Db();
        $credentials = $db->getCredentials();
        $s3 = new Aws\S3\S3Client(['region' => 'sa-east-1', 'version' => 'latest', 'credentials' => $credentials]);

        $nome = $filename;
        $path = $tempFilePath;
        $caminho = 'treinamento-teste/signed-documents/' . $nome;
        try {
            $s3->putObject([
                'Bucket' => 'bucket-brunorm',
                'Key' => $caminho,
                'SourceFile' => $path,
            ]);
            echo ('Deu boa');
            unlink($tempFilePath);
        } catch (Exception $exception) {
            echo "Failed to upload  with error: " . $exception->getMessage();
            exit("Please fix error with file upload before continuing.");
        }
    } else {
        // Se o arquivo assinado não estiver disponível, aguardar ou realizar outra ação
        sleep(20);
    }
}
