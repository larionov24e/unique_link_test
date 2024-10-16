<?php

namespace App\Services;

use App\DTO\LotteryDTO;
use Illuminate\Support\Facades\Redis;

final readonly class HistoryService
{
    /**
     * @param LotteryDTO $lotteryDTO
     * @return void
     */
    public function add(LotteryDTO $lotteryDTO): void
    {
        $this->addToFixedList('history:' . $lotteryDTO->getLinkId(), $lotteryDTO);
    }

    /**
     * @param $key
     * @param LotteryDTO $item
     * @param int $maxSize
     * @return void
     */
    protected function addToFixedList($key, LotteryDTO $item, int $maxSize = 3): void
    {
        Redis::lpush($key, json_encode(
            [
                'outcome' => $item->getOutcome(),
                'prize' => $item->getPrize(),
                'random_number' => $item->getRandomNumber(),
            ]
        ));

        Redis::ltrim($key, 0, $maxSize - 1);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getLatestById(int $id): array
    {
        return Redis::lrange('history:' . $id, 0, -1);
    }
}
