<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoListController::class, 'index'])->name('home');
Route::get('/todo-data', [TodoListController::class, 'getTodoListData'])->name('todo.data');
Route::post('/todo-create', [TodoListController::class, 'store'])->name('todo.store');
Route::put('/todo-update/{id}', [TodoListController::class, 'update'])->name('todo.update');
Route::delete('/todo-delete/{id}', [TodoListController::class, 'destroy'])->name('todo.destroy');