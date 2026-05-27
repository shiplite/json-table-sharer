<?php

namespace App\Livewire;

use App\Models\SharedTable;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class MainTool extends Component
{
    public string $jsonInput = '';
    public ?array $parsedData = null;
    public ?array $columns = null;
    public ?string $error = null;
    public ?string $shareUrl = null;
    public string $title = '';

    public function updatedJsonInput(): void
    {
        $this->shareUrl = null;
        $this->parseJson();
    }

    public function parseJson(): void
    {
        $this->error = null;
        $this->parsedData = null;
        $this->columns = null;

        $trimmed = trim($this->jsonInput);
        if ($trimmed === '') {
            return;
        }

        if (strlen($trimmed) > 204800) {
            $this->error = 'JSON too large (max 200 KB).';
            return;
        }

        $decoded = json_decode($trimmed, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = 'Invalid JSON: ' . json_last_error_msg();
            return;
        }

        // Normalize: if it's a single object, wrap in array
        if (is_array($decoded) && !array_is_list($decoded)) {
            $decoded = [$decoded];
        }

        if (!is_array($decoded) || empty($decoded)) {
            $this->error = 'JSON must be an array of objects or a single object.';
            return;
        }

        if (count($decoded) > 1000) {
            $this->error = 'Too many rows (max 1,000).';
            return;
        }

        // Extract all unique keys as columns
        $cols = [];
        foreach ($decoded as $row) {
            if (!is_array($row)) {
                $this->error = 'Each item in the array must be an object.';
                return;
            }
            foreach (array_keys($row) as $key) {
                $cols[$key] = true;
            }
        }

        if (count($cols) > 100) {
            $this->error = 'Too many columns (max 100).';
            return;
        }

        $this->columns = array_keys($cols);
        $this->parsedData = $decoded;
    }

    public function share(): void
    {
        $ip = request()->header('X-Forwarded-For')
            ? explode(',', request()->header('X-Forwarded-For'))[0]
            : request()->ip();
        $key = 'share:' . trim($ip);

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->error = 'Too many shares. Please wait a minute.';
            return;
        }

        RateLimiter::hit($key, 60);

        if (!$this->parsedData) {
            $this->parseJson();
        }

        if ($this->error || !$this->parsedData) {
            return;
        }

        $titleTrimmed = mb_substr(trim($this->title), 0, 200) ?: null;

        $shared = SharedTable::create([
            'title' => $titleTrimmed,
            'json_data' => $this->parsedData,
        ]);

        $this->shareUrl = $shared->getUrl();
    }

    public function clear(): void
    {
        $this->reset(['jsonInput', 'parsedData', 'columns', 'error', 'shareUrl', 'title']);
    }

    public function render()
    {
        return view('livewire.main-tool');
    }
}
