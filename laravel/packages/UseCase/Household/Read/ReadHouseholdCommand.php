<?php

namespace Packages\UseCase\Household\Read;

use Packages\Domain\ValueObject\ID;

final class ReadHouseholdCommand
{
    /**
     * @param ID $id
     */
    public function __construct(private ID $id)
    {
    }

    /**
     * @return ID
     */
    public function id(): ID
    {
        return $this->id;
    }
}
