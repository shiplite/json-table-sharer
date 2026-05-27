<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class MainTool extends Component
{
    public string $input = '';
    public string $output = '';

    public function process(): void
    {
        // Replace with your tool logic
        $this->output = $this->input;
    }

    public function render()
    {
        return view('livewire.main-tool');
    }
}
