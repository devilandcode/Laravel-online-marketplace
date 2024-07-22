<?php

namespace Domain\Cart\StorageIdentoties;

use Domain\Cart\Contracts\CartIdentityStorageContract;

class SessionIdentityStoragei implements CartIdentityStorageContract
{

    public function get(): string
    {
        return session()->getId();
    }
}
