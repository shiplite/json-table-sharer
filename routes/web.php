<?php

use App\Livewire\MainTool;
use Illuminate\Support\Facades\Route;

Route::get('/', MainTool::class)->name('main-tool');
