<?php
require 'vendor/autoload.php';
include 'classes/myEnv.php';

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$queue_env = new MyEnv("QUEUE");
$sqsClient_env = new MyEnv("SQS_CLI");

$client = new SqsClient([
    'profile' => $sqsClient_env->getValueByKey("SQS_CLI_Profile"),
    'region' => $sqsClient_env->getValueByKey("SQS_CLI_Region"),
    'version' => $sqsClient_env->getValueByKey("SQS_CLI_Version")
]);

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}

try {
    for ($i=0; $i < 10; $i++) { 
        $params = [
            'DelaySeconds' => $queue_env->getValueByKey("QUEUE_DelaySeconds"),
            'MessageAttributes' => [
                "Title" => [
                    'DataType' => "String",
                    'StringValue' => 'Title - '.generate_string($permitted_chars, 20)
                ],
                "Author" => [
                    'DataType' => "String",
                    'StringValue' => $queue_env->getValueByKey("QUEUE_Author")
                ]
                ],
                'MessageBody' => 'Message: '.generate_string($permitted_chars, 100),
                'QueueUrl' => $queue_env->getValueByKey("QUEUE_URL")
        ];

        $result = $client->sendMessage($params);
        echo "Mensagem enviada!\n";
    }
} catch (AwsException $e) {
    echo $e->getMessage();
}