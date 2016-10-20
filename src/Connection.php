<?php

namespace Codeages\SCPC;

class Connection
{
    private $client;
    private $isConnected = false;
    private $serverHost;
    private $serverPort;

    protected $clientConfig = array();

    public function setServerHost($host)
    {
        $this->serverHost = $host;
    }

    public function setServerPort($port)
    {
        $this->serverPort = $port;
    }

    public function setClientConfig($config)
    {
        $this->clientConfig = $config;
    }

    public function __call($name, $arguments)
    {
        if (!$this->isConnected) {
            $this->connect();
        }

        $data = array(
            'method' => $name,
            'args' => $arguments,
        );

        $this->client->send(json_encode($data).'\r\n\r\n');
        $data = $this->client->recv();
        $data = json_decode($data, true);
        return $data['data'];
    }

    protected function connect()
    {
        $this->client = new \swoole_client(SWOOLE_TCP | SWOOLE_KEEP);
        if (!$this->client->connect($this->serverHost, $this->server_port, -1)) {
            throw new Exception("Connect to pool server failed. Error: {$this->client->errCode}\n");
        }

        $defaultConfig = array(
            'open_eof_check' => true,
            'package_eof' => "\r\n\r\n",
            'package_max_length' => 1024 * 1024 * 2,
        );

        $this->client->set(array_merge($defaultConfig, $this->clientConfig));

        $this->isConnected = true;
    }
}
