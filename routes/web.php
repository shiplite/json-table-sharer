<?php

use App\Livewire\MainTool;
use App\Livewire\SharedTableView;
use Illuminate\Support\Facades\Route;

Route::get('/', MainTool::class)->name('main-tool');
Route::get('/s/{sharedTable:slug}', SharedTableView::class)
    ->name('shared-table')
    ->where('sharedTable', '[A-Za-z0-9]{20}');
