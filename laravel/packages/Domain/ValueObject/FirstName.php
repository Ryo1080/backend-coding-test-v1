<?php

namespace Packages\Domain\ValueObject;

/**
 * 名の値オブジェクト
 */
final class FirstName
{
    private const MIN_LENGTH = 1;

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        // 空文字はNG
        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException('Invalid first name format.');
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
