<?php
require 'vendor/autoload.php';
include 'classes/myEnv.php';

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$sqsClient_env = new MyEnv("SQS_CLI");
$queue_env = new MyEnv("QUEUE");

$client = new SqsClient([
    'profile' => $sqsClient_env->getValueByKey("SQS_CLI_Profile"),
    'region' => $sqsClient_env->getValueByKey("SQS_CLI_Region"),
    'version' => $sqsClient_env->getValueByKey("SQS_CLI_Version")
]);

try {
    $result = $client->createQueue(array(
        'QueueName' => $queue_env->getValueByKey("QUEUE_Name"),
        'Attributes' => array(
            'DelaySeconds' => $queue_env->getValueByKey("QUEUE_DelaySeconds"),
            'MaximumMessageSize' => $queue_env->getValueByKey("QUEUE_MaximumMessageSize"), 
        ),
    ));
    var_dump($result);
    echo "\nQueue criada!\n";
} catch (AwsException $e) {
    error_log($e->getMessage());
}