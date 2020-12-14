<?php

class MyEnv {
    var $envs;

    public function MyEnv($config) {
        switch ($config) {
            case $config == 'AWS':
                $this->envs = parse_ini_file('config/aws.env');
                break;
            case $config == 'QUEUE':
                $this->envs = parse_ini_file('config/queue.env');
                break;
            case $config == 'SQS_CLI':
                $this->envs = parse_ini_file('config/sqsClient.env');
                break;
            default:
                $this->envs = null;
                break;
        }
    }

    public function getValueByKey($key) {
        if (is_null($this->envs))
            return null;

        return empty($this->envs[$key]) ? null : $this->envs[$key];
    }

    public function getAllValues() {
        if (is_null($this->envs))
            return null;

        foreach ($this->envs as $key => $value) {
            echo "$key: $value\n";
        }
    }
}

?>