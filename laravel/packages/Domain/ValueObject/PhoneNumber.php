<?php

namespace Packages\Domain\ValueObject;

/**
 * 電話番号の値オブジェクト
 */
final class PhoneNumber
{
    // 10桁または11桁の数字
    public const PATTERN = '/^[0-9]{10,11}$/';

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (!preg_match(self::PATTERN, $value)) {
            throw new \InvalidArgumentException('Invalid phone number format.');
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
