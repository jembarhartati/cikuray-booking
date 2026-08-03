<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = KnowledgeBase::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('pertanyaan', 'like', "%{$search}%")
                  ->orWhere('jawaban', 'like', "%{$search}%")
                  ->orWhere('kata_kunci', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('kategori', $category);
        }

        $items = $query->orderBy('kategori')->paginate(12)->withQueryString();

        $totalItems = KnowledgeBase::count();
        $activeItems = KnowledgeBase::where('is_active', true)->count();
        $inactiveItems = $totalItems - $activeItems;

        return view('admin.knowledge-base.index', compact('items', 'totalItems', 'activeItems', 'inactiveItems', 'search', 'category'));
    }

    public function create()
    {
        return view('admin.knowledge-base.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'   => 'required|in:biaya,jadwal,kuota,perlengkapan,aturan,booking,pembayaran,umum',
            'pertanyaan' => 'required|string',
            'kata_kunci' => 'required|string',
            'jawaban'    => 'required|string',
            'is_active'  => 'boolean',
        ]);

        $kataKunci = array_map('trim', explode(',', $request->kata_kunci));

        KnowledgeBase::create([
            'kategori'   => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'kata_kunci' => $kataKunci,
            'jawaban'    => $request->jawaban,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.knowledge-base.index')->with('success', 'Data knowledge base berhasil ditambahkan.');
    }

    public function edit(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->kata_kunci_str = implode(', ', $knowledgeBase->kata_kunci);
        return view('admin.knowledge-base.edit', compact('knowledgeBase'));
    }

    public function update(Request $request, KnowledgeBase $knowledgeBase)
    {
        $request->validate([
            'kategori'   => 'required|in:biaya,jadwal,kuota,perlengkapan,aturan,booking,pembayaran,umum',
            'pertanyaan' => 'required|string',
            'kata_kunci' => 'required|string',
            'jawaban'    => 'required|string',
        ]);

        $kataKunci = array_map('trim', explode(',', $request->kata_kunci));

        $knowledgeBase->update([
            'kategori'   => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'kata_kunci' => $kataKunci,
            'jawaban'    => $request->jawaban,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.knowledge-base.index')->with('success', 'Data knowledge base berhasil diperbarui.');
    }

    public function destroy(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->delete();
        return redirect()->route('admin.knowledge-base.index')->with('success', 'Data berhasil dihapus.');
    }
}
