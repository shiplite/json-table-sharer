<?php

namespace App\Livewire;

use App\Models\SharedTable;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Layout('components.layouts.app')]
class SharedTableView extends Component
{
    public SharedTable $sharedTable;
    public array $columns = [];

    public function mount(SharedTable $sharedTable): void
    {
        if ($sharedTable->expires_at && $sharedTable->expires_at->lt(Carbon::now())) {
            throw new NotFoundHttpException();
        }

        $this->sharedTable = $sharedTable;
        $this->columns = $sharedTable->getColumns();
    }

    public function render()
    {
        return view('livewire.shared-table-view');
    }
}
