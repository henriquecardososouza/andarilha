<?php

namespace App\View\Composers;

use App\Services\Admin\PanelNavigation;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminChromeComposer
{
    public function __construct(private readonly PanelNavigation $navigation) {}

    public function compose(View $view): void
    {
        $user = auth()->user();

        $view->with([
            'panelNavigation' => $this->navigation->items(),
            'user' => $user,
            'userInitials' => $user ? $this->initials($user->name) : '',
        ]);
    }

    private function initials(string $name): string
    {
        return Str::of($name)
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $part) => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');
    }
}
