<?php

namespace Packages\Domain\ValueObject;

/**
 * 住所の値オブジェクト
 */
final class Address
{
    private const MIN_LENGTH = 1;

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        // 空文字はNG
        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException('Invalid address format.');
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
