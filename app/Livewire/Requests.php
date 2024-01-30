<?php

namespace App\Livewire;

use App\Fly\Metrics;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Card;
use Livewire\Component;

class Requests extends Card
{
    public $httpMetrics;

    public function mount()
    {
        $this->httpMetrics = (new Metrics)->http_requests('fideloper', now()->subHours(4  )->timestamp, now()->timestamp);
    }

    public function render()
    {
        return view('livewire.requests');
    }
}
