<?php

declare(strict_types=1);

namespace SmallSung\Hyperf;

use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use JsonException;
use Psr\EventDispatcher\EventDispatcherInterface;
use function json_decode;
use function json_encode;

/**
 * @param string $json
 * @param bool $assoc
 * @param int $depth
 * @param int $options
 * @return mixed
 * @throws JsonException
 */
function jsonDecode(string $json, bool $assoc = true, $depth = 512, int $options = JSON_ERROR_NONE)
{
    return json_decode($json, $assoc, $depth, $options | JSON_THROW_ON_ERROR);
}

/**
 * @param $value
 * @param int $options
 * @param int $depth
 * @return string
 * @throws JsonException
 */
function jsonEncode($value, int $options = JSON_ERROR_NONE, $depth = 512): string
{
    return json_encode($value, $options | JSON_THROW_ON_ERROR, $depth);
}

/**
 * @return int
 */
function generateSnowflakeId(): int
{
    return ApplicationContext::getContainer()->get(IdGeneratorInterface::class)->generate();
}

/**
 * @param object $event
 */
function emit(object $event): void
{
    ApplicationContext::getContainer()->get(EventDispatcherInterface::class)->dispatch($event);
}