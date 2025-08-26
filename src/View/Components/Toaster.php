<?php

namespace Nawasara\Toaster\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Toaster extends Component
{
    public string $position;
    public int $duration;
    public int $maxToasts;
    public bool $stackable;
    public bool $showProgress;
    public string $theme;

    public function __construct(
        string $position = 'top-right',
        int $duration = 5000,
        int $maxToasts = 5,
        bool $stackable = true,
        bool $showProgress = false,
        string $theme = 'default'
    ) {
        $this->position = $position;
        $this->duration = $duration;
        $this->maxToasts = $maxToasts;
        $this->stackable = $stackable;
        $this->showProgress = $showProgress;
        $this->theme = $theme;
    }

    public function getPositionClasses(): string
    {
        $positions = config('toaster.positions', [
            'top-left' => 'top-4 left-4',
            'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
            'top-right' => 'top-4 right-4',
        ]);

        return $positions[$this->position] ?? $positions['top-right'];
    }

    public function getThemeClasses(): array
    {
        $themes = config('toaster.themes', [
            'default' => [
                'container' => 'bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700',
                'text' => 'text-sm text-gray-700 dark:text-neutral-400',
            ]
        ]);

        return $themes[$this->theme] ?? $themes['default'];
    }

    public function render(): View
    {
        return view('nawasara-toaster::components.toaster');
    }
}