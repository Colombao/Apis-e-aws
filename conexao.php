<?php
require_once 'vendor/autoload.php';

use Clicksign\Client;
use Clicksign\Resources\Signer;


class Db
{

    function conn()
    {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "composer";
        return new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
    }
    function getCredentials()
    {
        $request = $this->conn()->prepare("SELECT * FROM  `keys`");
        $request->execute();
        $keys = $request->fetch(PDO::FETCH_ASSOC);

        $access_key = $keys['access_key'];
        $secret_key = $keys['secret_key'];
        return new Aws\Credentials\Credentials($access_key, $secret_key);
    }
}

class Actions
{

    public $bucket;
    public function __construct($bucket_name)
    {
        $this->bucket = $bucket_name;
    }
    public function put($s3)
    {

        $nome = $_FILES['file']['name'];
        $path = $_FILES['file']['tmp_name'];
        $caminho = 'treinamento-teste/' . $nome;
        try {
            $s3->putObject([
                'Bucket' => 'bucket-brunorm',
                'Key' => $caminho,
                'SourceFile' => $path,
            ]);
            echo ('Deu boa');
        } catch (Exception $exception) {
            echo "Failed to upload  with error: " . $exception->getMessage();
            exit("Please fix error with file upload before continuing.");
        }
    }
    public static function list($s3)
    {


        try {

            $contents = $s3->listObjects([
                'Bucket' => 'bucket-brunorm',
            ]);
            foreach ($contents['Contents'] as $content) {
                echo $content['Key'] . "**";
            }
        } catch (Exception $exception) {
            //   echo "Failed to list objects in $bucket with error: " . $exception->getMessage();
            exit("Please fix error with listing objects before continuing.");
        }
    }
    public static function download($s3, $caminho)
    {
        $bucket = 'bucket-brunorm';
        try {

            $contents = $s3->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key' => $caminho,
            ]);
            $request = $s3->createPresignedRequest($contents, '+20 minutes');

            $presignedUrl = (string)$request->getUri();

            return ($presignedUrl);
        } catch (Exception $exception) {
            // echo "Failed to list objects in $this->bucket with error: " . $exception->getMessage();
            exit("Please fix error with listing objects before continuing.");
        }
    }
    public static function deletar($s3, $caminho)
    {
        $bucket = 'bucket-brunorm';
        $result = $s3->deleteObject(array(
            'Bucket' => $bucket,
            'Key'    => $caminho
        ));
    }
    public static function cadastrar($conn)
    {
        extract($_POST);
        $senha = md5($_POST['Senha']);

        $stmt =  $conn->prepare("INSERT INTO usuario (Login,Senha) VALUES('$Login','$senha')");
        $stmt->execute();
        if ($stmt->rowCount()) {
            echo 'Salvo com sucesso!';
        } else {
            echo 'Algo não ocorreu como o esperado tente alterar o login/senha pois podem estar em uso por outra pessoa.';
        }
    }
}


class OpenAIChatbot
{
    private $openai_api_key;

    public function __construct($api_key)
    {
        $this->openai_api_key = $api_key;
    }

    public function get_response($question)
    {
        $url = "https://api.openai.com/v1/completions";
        $data = array(
            "model" => "text-davinci-002",
            "prompt" => $question,
            "max_tokens" => 60,
            "temperature" => 0.5
        );
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . "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"
        );
        $options = array(
            "http" => array(
                "header" => $headers,
                "method" => "POST",
                "content" => json_encode($data)
            )
        );
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $response_data = json_decode($response, true);
        $answer = $response_data["choices"][0]["text"];
        return $answer;
    }
}
class CatAPI
{
    private $url = "https://api.thecatapi.com/v1/images/search?limit=10";

    public function getTenRandomCats()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}
class Conexao
{
    const link = "https://sandbox.clicksign.com/api/";
    const versao = "v1";
    const token = "5baafbfc-8b57-4da2-90e1-1cf6a697cfe5";
}
class Acoes
{
    public static function ConexaoHttpPost($variavel_sys, $parametros)
    {
        $url = sprintf('%s%s/%s?access_token=%s', Conexao::link, Conexao::versao, $variavel_sys, Conexao::token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parametros));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . Conexao::token,
            'Content-Type: application/json',
        ));
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            // throw new Exception('Erro na conexão: ' . $error);
            echo ('deu ruim');
            die();
        }
        return $response;
    }
    public static function ConexaoHttpGet($variavel_sys)
    {
        $url = sprintf('%s%s/%saccess_token=%s', Conexao::link, Conexao::versao, $variavel_sys, Conexao::token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . Conexao::token,
            'Content-Type: application/json',

        ));
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo ('deu pessimo');
            die();
        }
        return $response;
    }
}
class Chamada
{
    private Acoes $conexao;

    public function __construct(Acoes $conexao)
    {
        $this->conexao = $conexao;
    }

    public function createDocument()
    {
        $objeto = $_FILES['file2']['tmp_name'];
        $nome = $_FILES['file2']['name'];
        $nextMont = date(DATE_ATOM, strtotime('+1 month'));
        $documentoBase64 = base64_encode(file_get_contents($objeto));

        $body = [
            "document" => [
                "path" => "/$nome",
                "content_base64" => "data:application/pdf;base64,$documentoBase64",
                "deadline_at" => "$nextMont",
                "auto_close" => true,
                "locale" => "pt-BR",
                "sequence_enabled" => false,
                "block_after_refusal" => true
            ]
        ];

        return $this->conexao->ConexaoHttpPost("documents", $body);
    }
    public function create_signer()
    {

        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $name = $_POST['name'];
        $documentation = $_POST['cpf'];
        $birthday = $_POST['nascimento'];
        $auths = $_POST['auth'];

        // Obter o token de autenticação
        $api_token = '5baafbfc-8b57-4da2-90e1-1cf6a697cfe5';

        // Definir as informações do cabeçalho da solicitação HTTP
        $headers = [
            'Authorization: Token ' . $api_token,
            'Content-Type: application/json'
        ];

        // Definir as informações do corpo da solicitação HTTP
        $data = [
            'signer' => [
                'email' => $email,
                'phone_number' => $phone_number,
                'auths' => [
                    $auths
                ],
                'name' => $name,
                'documentation' => $documentation,
                'birthday' => $birthday,
                'has_documentation' => true
            ]
        ];
        return $this->conexao->ConexaoHttpPost("signers", $data);
    }
    public function getSigners()
    {
        return $this->conexao->ConexaoHttpGet("signers?");
    }
    public function getDocuments()
    {
        return $this->conexao->ConexaoHttpGet("documents?page=1&");
    }
}
