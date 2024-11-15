<?php

namespace Packages\Domain\ValueObject;

/**
 * IDの値オブジェクト
 */
final class ID
{
    /**
     * @param int $value
     */
    public function __construct(private int $value)
    {
        // 0以下はNG
        if ($value <= 0) {
            throw new \InvalidArgumentException('ID is invalid.');
        }
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}
