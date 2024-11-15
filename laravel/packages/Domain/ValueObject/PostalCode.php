<?php

namespace Packages\Domain\ValueObject;

/**
 * 郵便番号の値オブジェクト
 */
final class PostalCode
{
    // 7桁の数字
    public const PATTERN = '/^[0-9]{7}$/';

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (!preg_match(self::PATTERN, $value)) {
            throw new \InvalidArgumentException('Invalid postal code format.');
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
