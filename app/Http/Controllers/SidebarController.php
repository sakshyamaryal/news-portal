<?php
namespace App\Http\Controllers;

use App\Models\Sidebar;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function __construct()
    {
        $access = $this->middleware('can:manage sidebar');
        if (!$access) {
            abort(403, 'You do not have access to this page');
        }
    }

    public function index()
    {
        $sidebars = Sidebar::where('is_active', true)->orderBy('order')->get();

        return view('Setting.sidebar', compact('sidebars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:sidebars,id',
        ]);

        $sidebar = Sidebar::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
            'admin_access_only' => $request->has('admin_access_only'),
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['success' => true, 'sidebar' => $sidebar]);
    }

    public function update(Request $request, Sidebar $sidebar)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:sidebars,id',
        ]);

        $sidebar->update([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
            'admin_access_only' => $request->has('admin_access_only'),
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['success' => true, 'sidebar' => $sidebar]);
    }
    public function show(Sidebar $sidebar)
    {
        return response()->json(['sidebar' => $sidebar]);
    }
    public function destroy(Sidebar $sidebar)
    {
        $sidebar->delete();

        return response()->json(['success' => true]);
    }
}
