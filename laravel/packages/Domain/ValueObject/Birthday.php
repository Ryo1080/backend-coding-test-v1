<?php

namespace Packages\Domain\ValueObject;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

/**
 * 誕生日の値オブジェクト
 */
final class Birthday
{
    // 誕生日の正規表現
    public const PATTERN = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

    /**
     * @param Carbon $value
     */
    private Carbon $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!preg_match(self::PATTERN, $value)) {
            throw new \InvalidArgumentException('Invalid birthday format.');
        }

        $this->value = Date::parse($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value->format('Y-m-d');
    }
}
