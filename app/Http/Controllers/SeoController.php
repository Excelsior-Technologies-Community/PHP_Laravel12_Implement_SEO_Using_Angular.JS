<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoPage;

class SeoController extends Controller
{
    // FRONTEND (SEO RENDER)
    public function show($slug = 'home')
    {
        $seo = SeoPage::where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$seo) {
            abort(404);
        }

        return view('layouts.app', compact('seo'));
    }

    // ADMIN LIST + SEARCH
    public function index(Request $request)
    {
        $query = SeoPage::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orwhere('description', 'like', '%' . $request->search . '%')
                  ->orwhere('keywords', 'like', '%' . $request->search . '%');
        }

        $pages = $query->paginate(4);

        return view('admin.index', compact('pages'));
    }

    // CREATE
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        SeoPage::create($request->all());
        return redirect()->route('admin.index')->with('success', 'Created!');
    }

    // EDIT
    public function edit($id)
    {
        $page = SeoPage::findOrFail($id);
        return view('admin.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = SeoPage::findOrFail($id);
        $page->update($request->all());

        return redirect()->route('admin.index')->with('success', 'Updated!');
    }

    // DELETE (SOFT)
    public function destroy($id)
    {
        SeoPage::findOrFail($id)->delete();
        return back()->with('success', 'Deleted!');
    }

    // TRASH
    public function trash()
    {
        $pages = SeoPage::onlyTrashed()->get();
        return view('admin.trash', compact('pages'));
    }

    // RESTORE
    public function restore($id)
    {
        SeoPage::withTrashed()->find($id)->restore();
        return back()->with('success', 'Restored!');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        SeoPage::withTrashed()->find($id)->forceDelete();
        return back()->with('success', 'Permanently Deleted!');
    }

    // STATUS TOGGLE
    public function toggle($id)
    {
        $page = SeoPage::findOrFail($id);
        $page->status = !$page->status;
        $page->save();

        return back();
    }


}