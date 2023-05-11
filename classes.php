<?php

require "conexao.php";
require 'vendor/autoload.php';

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

class Acoes
{
    function put()
    {
        require "conexao.php";

        $request = $conn->prepare("SELECT * FROM  `keys`");
        $request->execute();
        $keys = $request->fetch(PDO::FETCH_ASSOC);

        $access_key = $keys['access_key'];
        $secret_key = $keys['secret_key'];
        $credentials = new Credentials($access_key, $secret_key);
        $caminho = 'treinamento-teste/' . $_FILES['file']['name'];
        $s3client = new Aws\S3\S3Client(['region' => 'sa-east-1', 'version' => 'latest', 'credentials' => $credentials]);
        $bucket = 'bucket-brunorm';
        try {
            $s3client->putObject([
                'Bucket' => $bucket,
                'Key' => $caminho,
                'SourceFile' => $_FILES['file']['tmp_name']
            ]);
            echo "Uploaded  arquivo to $bucket.\n";
        } catch (Exception $exception) {
            // echo "Failed to upload  with error: " . $exception->getMessage();
            exit("Please fix error with file upload before continuing.");
        }
    }
}
