<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger\Formatter;

use Bramus\Monolog\Formatter\ColorSchemes\ColorSchemeInterface;

class ColoredLineFormatter extends \Bramus\Monolog\Formatter\ColoredLineFormatter
{
    public const SIMPLE_DATE = "Y-m-d H:i:sP";
    public const SIMPLE_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %extra%\n";

    public function __construct(?ColorSchemeInterface $colorScheme = null, ?string $format = null, ?string $dateFormat = null, bool $allowInlineLineBreaks = true, bool $ignoreEmptyContextAndExtra = true)
    {
        $format ??= static::SIMPLE_FORMAT;
        $dateFormat ??= static::SIMPLE_DATE;
        parent::__construct($colorScheme, $format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }
}