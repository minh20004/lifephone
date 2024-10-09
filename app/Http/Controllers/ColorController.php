<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public $colors;

    public function __construct()
    {
        $this->colors = new Color();
    }
    public function index()
    {
        $listColor = Color::paginate(5);
        return view('admin.page.product.color.index', ['colors' => $listColor]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.product.color.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:colors,name',
            'code' => 'required',
        ]);

        $color = Color::create([
            'name' => $validateData['name'],
            'code' => $validateData['code'],
        ]);

        return redirect()->route('color.index')->with('success', 'Màu sắc đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $color = Color::findOrFail($id);
        return view('admin.page.product.color.update', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:colors,name',
            'code' => 'required',
        ]);

        $color = Color::findOrFail($id);

        $color->update([
            'name' => $validateData['name'],
            'code' => $validateData['code'],
        ]);

        return redirect()->route('color.index')->with('success', 'Màu sắc đã được sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);

        $color->status = 0;
        $color->save();

        $color->delete();

        return redirect()->route('color.index')->with('success', 'Màu sắc đã được xóa thành công !');
    }

    public function trashed()
    {
        $colors = Color::onlyTrashed()->paginate(5);

        return view('admin.page.product.color.trashed', compact('colors'));
    }

    public function restore($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->restore();

        $color->status = 1;
        $color->save();
        return redirect()->route('color.trashed')->with('success', 'Màu săc đã được khôi phục thành công.');
    }
}
