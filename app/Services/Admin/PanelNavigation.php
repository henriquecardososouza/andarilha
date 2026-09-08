<?php

namespace App\Services\Admin;

use Illuminate\Support\Collection;

final class PanelNavigation
{
    /**
     * @return Collection<int, array{key: string, url: string, active: bool}>
     */
    public function items(): Collection
    {
        return collect([
            $this->item('quotations', 'admin.quotations.index'),
            $this->item('destinies', 'admin.destinies.index'),
            $this->item('users', 'admin.users.index'),
        ]);
    }

    /**
     * @return array{key: string, url: string, active: bool}
     */
    private function item(string $key, string $route): array
    {
        return [
            'key' => $key,
            'url' => route($route),
            'active' => request()->routeIs($route.'*'),
        ];
    }
}
