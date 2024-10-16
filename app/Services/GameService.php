<?php

namespace App\Services;

use App\DTO\LotteryDTO;
use App\Http\Repositories\LinkRepository;
use Illuminate\Container\Container;

final class GameService
{
    private int $randomNum;
    private string $outcome;
    private float $prize;

    public function __construct(
        private readonly HistoryService $historyService,
        private readonly LinkRepository $linkRepository
    ) {
    }

    public function play(): void
    {
        $this->randomNum = rand(1, 1000);

        if ($this->randomNum % 2 === 0) {
            $this->outcome = "Win";
            $this->calculatePrize();
        } else {
            $this->outcome = "Lose";
            $this->prize = 0;
        }

        $this->randomNum = round($this->randomNum);
    }

    private function calculatePrize(): void
    {
        if ($this->randomNum > 900) {
            $this->prize = $this->randomNum * 0.7;
        } elseif ($this->randomNum > 600) {
            $this->prize = $this->randomNum * 0.5;
        } elseif ($this->randomNum > 300) {
            $this->prize = $this->randomNum * 0.3;
        } else {
            $this->prize = $this->randomNum * 0.1;
        }

        $this->prize = round($this->prize, 2);
    }

    public function getRandomNum(): int
    {
        return $this->randomNum;
    }

    public function getOutcome(): string
    {
        return $this->outcome;
    }

    public function getPrize(): float
    {
        return $this->prize;
    }

    public function playForHash(string $hash): array
    {
        $link = $this->linkRepository->getLinkByHash($hash);

        $this->play();

        $lotteryDTO = Container::getInstance()->make(LotteryDTO::class, [
            'linkId' => $link->id,
            'outcome' => $this->getOutcome(),
            'prize' => $this->getPrize(),
            'randomNumber' => $this->getRandomNum(),
        ]);

        $this->historyService->add($lotteryDTO);

        return [
            'outcome' => $this->getOutcome(),
            'prize' => $this->getPrize(),
            'random_number' => $this->getRandomNum(),
        ];
    }
}
