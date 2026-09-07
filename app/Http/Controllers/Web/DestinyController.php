<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Destiny;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DestinyController extends Controller
{
    /**
     * How many matches the searchable select shows at once.
     */
    private const LIMIT = 20;

    /**
     * Active destinies for the quote form's select, narrowed by a search term.
     */
    public function index(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        $destinies = Destiny::query()
            ->where('active', true)
            ->when($term !== '', function ($query) use ($term) {
                $like = '%'.addcslashes($term, '%_\\').'%';

                $query->where(fn ($group) => $group
                    ->where('name', 'like', $like)
                    ->orWhere('country', 'like', $like));
            })
            ->orderBy('name')
            ->limit(self::LIMIT)
            ->get(['uuid', 'name', 'country']);

        return response()->json([
            'data' => $destinies->map(fn (Destiny $destiny) => [
                'value' => $destiny->uuid,
                'label' => $destiny->name,
                'note' => $destiny->country,
            ])->all(),
        ]);
    }
}
