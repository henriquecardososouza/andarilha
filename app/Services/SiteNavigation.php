<?php

namespace App\Services;

use Illuminate\Support\Collection;

final class SiteNavigation
{
    /**
     * @return Collection<int, array{key: string, url: string, active: bool}>
     */
    public function items(): Collection
    {
        return collect([
            $this->page('home', 'landing'),
            $this->page('about', 'about'),
            $this->anchor('destinations', 'destinos'),
            $this->page('contact', 'contact'),
        ]);
    }

    /**
     * @return array{key: string, url: string, active: bool}
     */
    private function page(string $key, string $route): array
    {
        return [
            'key' => $key,
            'url' => route($route),
            'active' => request()->routeIs($route),
        ];
    }

    /**
     * @return array{key: string, url: string, active: bool}
     */
    private function anchor(string $key, string $fragment): array
    {
        return [
            'key' => $key,
            'url' => route('landing').'#'.$fragment,
            'active' => false,
        ];
    }
}
