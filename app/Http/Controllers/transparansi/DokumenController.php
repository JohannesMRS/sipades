<?php

namespace App\Http\Controllers\transparansi;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DokumenController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = Dokumen::query()->where('is_published', true);

        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));
        $year = trim((string) $request->query('year', ''));

        if ($search !== '') {
            $searchLower = mb_strtolower($search);
            $query->where(function ($builder) use ($searchLower): void {
                $builder->whereRaw('LOWER(title) LIKE ?', ['%'.$searchLower.'%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%'.$searchLower.'%']);
            });
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($year !== '') {
            $query->where('year', (int) $year);
        }

        $documents = $query->latest('year')->latest('id')->get();
        $categories = Dokumen::query()->where('is_published', true)->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        $years = Dokumen::query()->where('is_published', true)->distinct()->orderByDesc('year')->pluck('year');

        return view('pages.dokumen', compact('documents', 'categories', 'years', 'search', 'category', 'year'));
    }

    public function download(Dokumen $dokumen): BinaryFileResponse
    {
        abort_unless($dokumen->is_published, 404);

        $disk = Storage::disk('public');
        abort_unless($dokumen->file && $disk->exists($dokumen->file), 404);

        $dokumen->increment('download_count');

        $extension = pathinfo($dokumen->file, PATHINFO_EXTENSION);
        $filename = str($dokumen->title)->slug('-')->append($extension ? '.'.$extension : '')->toString();

        $absolutePath = storage_path('app/public/'.$dokumen->file);

        return response()->download($absolutePath, $filename);
    }
}
