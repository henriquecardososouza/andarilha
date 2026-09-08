<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestinyRequest;
use App\Models\Destiny;
use App\Services\Admin\DestinyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinyController extends Controller
{
    public function index(Request $request, DestinyRepository $destinies): View
    {
        $search = $request->filled('search') ? trim($request->string('search')->value()) : null;
        $results = $destinies->paginate($search);

        if ($request->header('X-Partial') === 'table') {
            return view('admin.partials.destinies-results', [
                'destinies' => $results,
            ]);
        }

        return view('admin.destinies', [
            'destinies' => $results,
            'search' => $search,
            'action' => route('admin.destinies.index'),
            'storeAction' => route('admin.destinies.store'),
        ]);
    }

    public function store(DestinyRequest $request): JsonResponse|RedirectResponse
    {
        $destiny = Destiny::create($request->payload());

        return $this->respond($request, __('admin.destinies.created', ['name' => $destiny->name]));
    }

    public function update(DestinyRequest $request, Destiny $destiny): JsonResponse|RedirectResponse
    {
        $destiny->update($request->payload());

        return $this->respond($request, __('admin.destinies.updated', ['name' => $destiny->name]));
    }

    public function toggleActive(Request $request, Destiny $destiny): JsonResponse|RedirectResponse
    {
        $destiny->update(['active' => ! $destiny->active]);

        return $this->respond($request, __(
            $destiny->active ? 'admin.destinies.activated' : 'admin.destinies.deactivated',
            ['name' => $destiny->name],
        ));
    }

    /**
     * Destinies attached to a quotation stay put, otherwise the history breaks.
     */
    public function destroy(Request $request, Destiny $destiny): JsonResponse|RedirectResponse
    {
        if ($destiny->quotations()->exists()) {
            $message = __('admin.destinies.in_use', ['name' => $destiny->name]);

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->with('toast', ['type' => 'error', 'message' => $message]);
        }

        $destiny->delete();

        return $this->respond($request, __('admin.destinies.deleted', ['name' => $destiny->name]));
    }

    private function respond(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('toast', ['type' => 'success', 'message' => $message]);
    }
}
