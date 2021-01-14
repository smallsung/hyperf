<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Snowflake\MetaGenerator;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Snowflake\ConfigurationInterface;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Exception\Exception;
use Swoole\Server;

class RandomMilliSecondMetaGenerator extends \Hyperf\Snowflake\MetaGenerator\RandomMilliSecondMetaGenerator
{
    protected int $workerId;
    protected int $dataCenterId;

    /**
     * RandomMilliSecondMetaGenerator constructor.
     * @param ContainerInterface $container
     * @param ConfigurationInterface $configuration
     * @param int $beginTimestamp
     * @throws Exception
     */
    public function __construct(ContainerInterface $container, ConfigurationInterface $configuration, int $beginTimestamp)
    {
        parent::__construct($configuration, $beginTimestamp);

        $maxDataCenterId = $this->configuration->maxDataCenterId();

        $configInstance = $container->get(ConfigInterface::class);
        $dataCenterId = $configInstance->get('snowflake.dataCenterId', null);
        if (!is_int($dataCenterId) || $dataCenterId < 0 || $dataCenterId > $maxDataCenterId){
            throw new Exception(sprintf('%s 必须配置 int:[0, %s]', 'snowflake.dataCenterId', $maxDataCenterId));
        }
        $this->dataCenterId = $dataCenterId;

        try {
            $workerId = $container->get(Server::class)->worker_id ?? 0;
        }catch (\Throwable $throwable){
            $workerId = 0;
        }
        $this->workerId = $workerId % $this->configuration->maxWorkerId();
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }

    public function getDataCenterId(): int
    {
        return $this->dataCenterId;
    }
}