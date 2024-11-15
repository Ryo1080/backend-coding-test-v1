<?php

namespace Packages\Domain\ValueObject;

/**
 * メールアドレスの値オブジェクト
 */
final class Email
{
    // メールアドレスの正規表現
    public const PATTERN = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (!preg_match(self::PATTERN, $value)) {
            throw new \InvalidArgumentException('Invalid email format.');
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
