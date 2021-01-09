<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger\Formatter;

class ColoredLineFormatter extends \Bramus\Monolog\Formatter\ColoredLineFormatter
{
    public function __construct($colorScheme = null, string $format = null, string $dateFormat = null, bool $allowInlineLineBreaks = true, bool $ignoreEmptyContextAndExtra = false)
    {
        $format ??= static::SIMPLE_FORMAT;
        $dateFormat ??= static::SIMPLE_DATE;
        parent::__construct($colorScheme, $format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }
}