<?php

namespace App\DTO;

final class LotteryDTO
{
    private int $linkId;
    private string $outcome;

    private float $prize;
    private int $randomNumber;

    public function __construct(int $linkId, string $outcome, float $prize, int $randomNumber)
    {
        $this->linkId = $linkId;
        $this->outcome = $outcome;
        $this->prize = $prize;
        $this->randomNumber = $randomNumber;
    }

    public function getLinkId(): int
    {
        return $this->linkId;
    }

    public function getOutcome(): string
    {
        return $this->outcome;
    }

    public function getPrize(): float
    {
        return $this->prize;
    }

    public function getRandomNumber(): int
    {
        return $this->randomNumber;
    }

}
