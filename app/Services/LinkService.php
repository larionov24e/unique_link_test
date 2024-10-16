<?php

namespace App\Services;

use App\Http\Repositories\LinkRepository;
use App\Models\Link;
use App\Models\User;
use Exception;

final readonly class LinkService
{

    public function __construct(
        public LinkRepository $linkRepository
    )
    {}

    /**
     * @param User $user
     * @return string
     */
    public function createLinkByUser(User $user): string
    {
        $link = $this->linkRepository->create(
            [
                'user_id' => $user->id,
                'hash' => md5(now()->toString()),
                'expiry_at' => now()->addDays(7),
            ]
        );

        return sprintf('%s/link/%s', config('app.url'), $link->hash);
    }

    /**
     * @throws Exception
     */
    public function updateExistingLink(string $hash): string
    {
        $link = $this->linkRepository->updateByHash(
            $hash,
            [
                'hash' => md5(now()->toString()),
                'expiry_at' => now()->addDays(7),
            ]
        );

        return $link->hash;
    }

    /**
     * @throws Exception
     */
    public function deactivateLinkByHash(string $hash): void
    {
        $this->linkRepository->updateByHash(
            $hash,
            [
                'is_active' => false,
            ]
        );
    }

    public function isActiveLink(string $hash): bool
    {
        $link = $this->linkRepository->getLinkByHash($hash);

        return !($link && !$link->is_active || $link->expiry_at < now());
    }
}
