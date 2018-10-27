<?php

namespace MadWeb\NovaTelescopeLink;

use Laravel\Nova\Tool;
use Laravel\Telescope\Telescope;

class TelescopeLink extends Tool
{
    protected $label;
    protected $target;

    const VIEW_NAME = 'nova-telescope-link::navigation';

    public function __construct(?string $label = 'Telescope Debug', ?string $target = 'self')
    {
        parent::__construct();

        $this->label = $label;
        $this->target = $target;
    }

    /**
     * Create link with _Telescope_ logo.
     */
    public static function useLogo(?string $target = 'self'): self
    {
        return new static(null, $target);
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(self::VIEW_NAME, function ($view) {
            $view->with('label', $this->label);
            $view->with('target', $this->target);
        });

        $this->canSee(function ($request) {
            return Telescope::check($request);
        });
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view(self::VIEW_NAME);
    }
}
