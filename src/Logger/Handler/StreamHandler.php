<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger\Handler;

use Monolog\Logger;
use SmallSung\Hyperf\Exception\InvalidArgumentException;

class StreamHandler extends \Monolog\Handler\StreamHandler
{
    protected array $acceptedLevels;

    public function __construct($stream, $level = Logger::DEBUG, bool $bubble = true, ?int $filePermission = null, bool $useLocking = false)
    {
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);
        $this->setAcceptedLevels($level);
    }

    /**
     * @param int|int[] $level
     * @throws InvalidArgumentException
     */
    public function setAcceptedLevels($level): void
    {
        if (is_array($level)){
            $acceptedLevels = array_map([Logger::class, 'toMonologLevel'], $level);
        }elseif (is_int($level)){
            $minLevel = Logger::toMonologLevel($level);
            $maxLevel = Logger::toMonologLevel(Logger::EMERGENCY);
            $acceptedLevels = array_values(array_filter(Logger::getLevels(), function ($level) use ($minLevel, $maxLevel){
                return $level >= $minLevel && $level <= $maxLevel;
            }));
        }else{
            throw new InvalidArgumentException();
        }
        $this->acceptedLevels = array_flip($acceptedLevels);
    }

    public function isHandling(array $record): bool
    {
        return isset($this->acceptedLevels[$record['level']]);
    }
}