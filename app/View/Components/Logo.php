<?php

namespace App\View\Components;

use App\Services\AssetService;
use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    public string $logoUrl;

    public string $alt;

    public function __construct(string $alt = '')
    {
        $this->logoUrl = app(AssetService::class)->logoUrl();
        $this->alt = $alt !== ''
            ? $alt
            : app(SettingService::class)->get('company_name', 'Elama Healthcare Solutions Pvt. Ltd.');
    }

    public function render(): View|Closure|string
    {
        return view('components.logo');
    }
}
