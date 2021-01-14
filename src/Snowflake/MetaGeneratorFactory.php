<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Snowflake;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Snowflake\ConfigurationInterface;
use Hyperf\Snowflake\MetaGeneratorInterface;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Snowflake\MetaGenerator\RandomMilliSecondMetaGenerator;

class MetaGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(ConfigInterface::class);
        $beginSecond = $config->get('snowflake.begin_second', MetaGeneratorInterface::DEFAULT_BEGIN_SECOND);

        return make(RandomMilliSecondMetaGenerator::class, [
            $container,
            $container->get(ConfigurationInterface::class),
            $beginSecond,
        ]);
    }
}