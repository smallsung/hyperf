<?php

declare(strict_types=1);

namespace SmallSung\Hyperf;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies'=>$this->dependencies(),
            'logger'=>$this->logger(),
        ];
    }

    private function dependencies(): array
    {
        return [
            \Hyperf\Logger\LoggerFactory::class=>\SmallSung\Hyperf\Logger\LoggerFactory::class,
            \Hyperf\Contract\StdoutLoggerInterface::class=>\SmallSung\Hyperf\Logger\StdoutLogger::class,
            \Psr\Log\LoggerInterface::class=>\SmallSung\Hyperf\Logger\DefaultLogger::class,
        ];
    }

    private function logger(): array
    {
        $loggers = [];
        $handlers = [
            [
                'class'=>\SmallSung\Hyperf\Logger\Handler\ConsoleHandler::class,
                'constructor'=>[
                    'level'=>\Monolog\Logger::DEBUG,
                ],
                'formatter'=>[
                    'class'=>\SmallSung\Hyperf\Logger\Formatter\ColoredLineFormatter::class,
                    'constructor'=>[],
                ]
            ],
            [
                'class'=>\Monolog\Handler\RotatingFileHandler::class,
                'constructor'=>[
                    'filename'=>BASE_PATH.'/runtime/logs/hyperf.log',
                    'maxFiles'=>180,
                    'level'=>\Monolog\Logger::DEBUG,
                ],
                'formatter'=>[
                    'class'=>\Monolog\Formatter\LineFormatter::class,
                    'constructor'=>[],
                ]
            ],
        ];

        $loggers[\SmallSung\Hyperf\Logger\LoggerFactory::DEFAULT_GROUP_NAME] = [
            'handlers'=>$handlers
        ];
        return $loggers;
    }
}