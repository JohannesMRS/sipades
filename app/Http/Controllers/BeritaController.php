<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Berita::query()
            ->published()
            ->with('category')
            ->latest('published_at');

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $searchLower = mb_strtolower($search);
            $query->where(function ($builder) use ($searchLower): void {
                $builder->whereRaw('LOWER(title) LIKE ?', ['%'.$searchLower.'%'])
                    ->orWhereRaw('LOWER(excerpt) LIKE ?', ['%'.$searchLower.'%']);
            });
        }

        $category = trim((string) $request->query('kategori', ''));
        if ($category !== '') {
            $query->whereHas('category', fn ($builder) => $builder->where('slug', $category));
        }

        $items = $query->paginate(6)->withQueryString();

        return view('pages.berita', compact('items', 'search', 'category'));
    }

    public function show(string $slug): View
    {
        $item = Berita::query()->published()->with('category')->where('slug', $slug)->firstOrFail();

        $others = Berita::query()->published()->with('category')->whereKeyNot($item->getKey())->latest('published_at')->take(3)->get();

        return view('pages.berita-show', compact('item', 'others'));
    }
}
