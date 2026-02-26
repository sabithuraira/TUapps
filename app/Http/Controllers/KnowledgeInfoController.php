<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\KnowledgeInfo;

class KnowledgeInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('knowledge_info.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('knowledge_info.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = KnowledgeInfo::with(['createdBy', 'updatedBy'])->find($id);
        if ($model == null) {
            return redirect()->route('knowledge_info.index')->with('error', 'Data tidak ditemukan.');
        }
        return view('knowledge_info.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = KnowledgeInfo::find($id);
        if ($model == null) {
            return redirect()->route('knowledge_info.index')->with('error', 'Data tidak ditemukan.');
        }
        return view('knowledge_info.edit', compact('model'));
    }

    /**
     * Load data for AJAX requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $keyword = $request->get('keyword', '');
        $filterCategory = $request->get('filter_category', '');

        $query = KnowledgeInfo::orderBy('id', 'desc');

        if ($keyword && $keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('content', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('tag', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('category', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($filterCategory && $filterCategory !== '') {
            $query->where('category', $filterCategory);
        }

        $datas = $query->paginate($perPage);

        return response()->json([
            'success' => '1',
            'datas' => $datas->items(),
            'pagination' => [
                'current_page' => $datas->currentPage(),
                'last_page' => $datas->lastPage(),
                'per_page' => $datas->perPage(),
                'total' => $datas->total(),
                'from' => $datas->firstItem(),
                'to' => $datas->lastItem(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:65535',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'tag' => 'nullable|string',
        ]);

        $model = new KnowledgeInfo();
        $model->title = $request->input('title');
        $model->content = $request->input('content') ?: null;
        $model->category = $request->input('category') ?: null;
        $model->tag = $request->input('tag') ?: null;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();

        if ($model->save()) {
            return redirect()->route('knowledge_info.index')->with('success', 'Data berhasil ditambahkan.');
        }

        return back()->withInput()->with('error', 'Gagal menyimpan data.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = KnowledgeInfo::find($id);
        if ($model == null) {
            return redirect()->route('knowledge_info.index')->with('error', 'Data tidak ditemukan.');
        }

        $request->validate([
            'title' => 'required|string|max:65535',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'tag' => 'nullable|string',
        ]);

        $model->title = $request->input('title');
        $model->content = $request->input('content') ?: null;
        $model->category = $request->input('category') ?: null;
        $model->tag = $request->input('tag') ?: null;
        $model->updated_by = Auth::id();

        if ($model->save()) {
            return redirect()->route('knowledge_info.index')->with('success', 'Data berhasil diubah.');
        }

        return back()->withInput()->with('error', 'Gagal mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        $id = $id ?? $request->form_id_data ?? $request->id;

        if ($id == 0 || $id == '') {
            return response()->json(['success' => '0', 'message' => 'ID tidak valid']);
        }

        $model = KnowledgeInfo::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        if ($model->delete()) {
            return response()->json(['success' => '1', 'message' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menghapus data']);
    }
}
