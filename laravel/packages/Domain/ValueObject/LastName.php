<?php

namespace Packages\Domain\ValueObject;

/**
 * 姓の値オブジェクト
 */
final class LastName
{
    private const MIN_LENGTH = 1;

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        // 空文字はNG
        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException('Invalid last name format.');
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
