<?php

namespace App\Http\Controllers;

use App\DTOs\TodoDTO;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\User;
use App\Services\TodoService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
  public function __construct(
    private readonly TodoService $service,
  ) {}

  public function index(#[CurrentUser] User $user): Response
  {
    $todos = $this->service->listForUser($user->id);

    return Inertia::render('todos/index', [
      'todos' => TodoResource::collection($todos)->resolve(),
    ]);
  }

  public function store(StoreTodoRequest $request, #[CurrentUser] User $user): RedirectResponse
  {
    $this->service->create($user->id, TodoDTO::fromArray($request->validated()));

    return back();
  }

  public function update(
    UpdateTodoRequest $request,
    #[RouteParameter('id')] int $id,
    #[CurrentUser] User $user,
  ): RedirectResponse {
    $this->service->update($id, $user->id, TodoDTO::fromArray($request->validated()));

    return back();
  }

  public function toggle(
    #[RouteParameter('id')] int $id,
    #[CurrentUser] User $user,
  ): RedirectResponse {
    $this->service->toggle($id, $user->id);

    return back();
  }

  public function destroy(
    #[RouteParameter('id')] int $id,
    #[CurrentUser] User $user,
  ): RedirectResponse {
    $this->service->delete($id, $user->id);

    return back();
  }
}
