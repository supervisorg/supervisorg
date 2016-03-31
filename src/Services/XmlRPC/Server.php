<?php

namespace Supervisorg\Services\XmlRPC;

use Supervisorg\Services\Process\Filter;

class Server
{
    private
        $name,
        $filter,
        $client;

    public function __construct($name, Client $client, Filter $filter)
    {
        $this->name = (string) $name;
        $this->filter = $filter;
        $this->client = $client;
    }

    public function getName()
    {
        return $this->name;
    }

    public function stopProcess($process)
    {
        return $this->client->stopProcess($process);
    }

    public function startProcess($process)
    {
        return $this->client->startProcess($process);
    }

    public function getProcessList()
    {
        $processList = $this->client->getProcessList();

        foreach($processList as $index => $process)
        {
            $processList[$index]['server'] = $this;
        }
        
        return $this->filter->filter($processList);
    }
}
