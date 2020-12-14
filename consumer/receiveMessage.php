<?php
require 'vendor/autoload.php';
include 'classes/myEnv.php';

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$queue_env = new MyEnv("QUEUE");
$sqsClient_env = new MyEnv("SQS_CLI");
$queueUrl = $queue_env->getValueByKey("QUEUE_URL");

$client = new SqsClient([
    'profile' => $sqsClient_env->getValueByKey("SQS_CLI_Profile"),
    'region' => $sqsClient_env->getValueByKey("SQS_CLI_Region"),
    'version' => $sqsClient_env->getValueByKey("SQS_CLI_Version")
]);

function receiveMessage() {
    global $queueUrl;
    global $client;

    $result = $client->receiveMessage(array(
        'QueueUrl' => $queueUrl
    ));

    if (!empty($result->get('Messages'))) {
        echo $result->get('Messages')[0]['Body'] . " (Mensagem apagada)" .PHP_EOL;
        
        $result = $client->deleteMessage([
            'QueueUrl' => $queueUrl,
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle']
        ]);

        sleep(5);
        receiveMessage();
    } else {
        echo "Nenhuma mensagem na fila!\n";
    }
}

try {
    receiveMessage();
} catch (AwsException $e) {
    echo $e->getMessage();
}