<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoPage;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function show($slug = 'home')
    {
        $seo = Cache::remember("seo_page_{$slug}", 3600, function () use ($slug) {
            return SeoPage::where('slug', $slug)->where('status', 1)->first();
        });

        if (!$seo) {
            abort(404);
        }

        return view('layouts.app', compact('seo'));
    }

    public function sitemap()
    {
        $pages = SeoPage::where('status', 1)->get();
        return response()->view('sitemap', compact('pages'))->header('Content-Type', 'text/xml');
    }

    public function index(Request $request)
    {
        $query = SeoPage::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('keywords', 'like', '%' . $request->search . '%');
        }

        $pages = $query->paginate(4);

        return view('admin.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        SeoPage::create($request->all());
        return redirect()->route('admin.index')->with('success', 'Created!');
    }

    public function edit($id)
    {
        $page = SeoPage::findOrFail($id);
        return view('admin.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = SeoPage::findOrFail($id);
        $page->update($request->all());

        Cache::forget("seo_page_{$page->slug}");

        return redirect()->route('admin.index')->with('success', 'Updated!');
    }

    public function destroy($id)
    {
        $page = SeoPage::findOrFail($id);
        Cache::forget("seo_page_{$page->slug}");
        $page->delete();

        return back()->with('success', 'Deleted!');
    }

    public function trash()
    {
        $pages = SeoPage::onlyTrashed()->get();
        return view('admin.trash', compact('pages'));
    }

    public function restore($id)
    {
        $page = SeoPage::withTrashed()->find($id);
        $page->restore();
        Cache::forget("seo_page_{$page->slug}");

        return back()->with('success', 'Restored!');
    }

    public function forceDelete($id)
    {
        $page = SeoPage::withTrashed()->find($id);
        Cache::forget("seo_page_{$page->slug}");
        $page->forceDelete();

        return back()->with('success', 'Permanently Deleted!');
    }

    public function toggle($id)
    {
        $page = SeoPage::findOrFail($id);
        $page->status = !$page->status;
        $page->save();

        Cache::forget("seo_page_{$page->slug}");

        return back();
    }
}