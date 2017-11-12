<?php

namespace App\Http\Services;

class StreamFilter
{
    /** @var  array $gameIds */
    protected $gameIds = [];
    /** @var  \DateTime */
    protected $period;
    /** @var  \DateTime */
    protected $periodEnd;

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
    public function getPeriod(): \DateTime
    {
        return $this->period;
    }

    /**
     * @param \DateTime $period
     * @return $this
     */
    public function setPeriod(\DateTime $period)
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodEnd(): \DateTime
    {
        return $this->periodEnd;
    }

    /**
     * @param \DateTime $periodEnd
     * @return $this
     */
    public function setPeriodEnd(\DateTime $periodEnd)
    {
        $this->periodEnd = $periodEnd;
        return $this;
    }
}