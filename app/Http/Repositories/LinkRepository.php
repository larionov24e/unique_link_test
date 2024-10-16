<?php

namespace App\Http\Repositories;

use App\Models\Link;
use Exception;

class LinkRepository
{
    public function create(array $data): Link
    {
        return Link::create(
            $data
        );
    }

    /**
     * @throws Exception
     */
    public function updateByHash(string $hash, array $data): Link
    {
        $link = Link::where('hash', $hash)->first();

        if (!$link) {
            throw new Exception('Link not found');
        }

        $link->update($data);

        return $link;
    }

    public function getLinkByHash(string $hash): ?Link
    {
        return Link::where('hash', $hash)->first();
    }
}
