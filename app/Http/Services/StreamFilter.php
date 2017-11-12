<?php

namespace App\Http\Services;

class StreamFilter
{
    /** @var  array $gameIds */
    protected $gameIds = [];
    /** @var  \DateTime */
    protected $periodFrom;
    /** @var  \DateTime */
    protected $periodTo;

    /**
     * @return array
     */
    public function getGameIds(): array
    {
        return $this->gameIds;
    }

    /**
     * @param array $gameIds
     * @return $this
     */
    public function setGameIds(array $gameIds)
    {
        $this->gameIds = $gameIds;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodFrom(): \DateTime
    {
        return $this->periodFrom;
    }

    /**
     * @param \DateTime $periodFrom
     * @return $this
     */
    public function setPeriodFrom(\DateTime $periodFrom)
    {
        $this->periodFrom = $periodFrom;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodTo(): \DateTime
    {
        return $this->periodTo;
    }

    /**
     * @param \DateTime $periodTo
     * @return $this
     */
    public function setPeriodTo(\DateTime $periodTo)
    {
        $this->periodTo = $periodTo;
        return $this;
    }
}