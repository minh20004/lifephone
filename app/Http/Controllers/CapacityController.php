<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public $capacities;

    public function __construct()
    {
        $this->capacities = new Capacity();
    }

    public function index()
    {
        $listCapacity = Capacity::paginate(5);
        return view('admin.page.product.capacity.index', ['capacities' => $listCapacity]);
    }

    
    public function create()
    {
        $capacities = Capacity::where('status', 1)->get();
        return view('admin.page.product.capacity.add');
    }

    
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:capacities,name',
        ]);

        

        // Kiểm tra nếu danh mục đã tồn tại
        $exitstingCapacity = $this->capacities->where('name', $request->name)->first();

        if ($exitstingCapacity) {
            // Nếu danh mục đã tồn tại, trả về thông báo lỗi
            if ($request->ajax()) {
                return response()->json(['error' => 'Danh mục đã tồn tại!'], 400);
            }

            return redirect()->route('capacity.index')->with('error', 'Danh mục đã tồn tại!');
        }

        $this->capacities->create([
            'name' => $validateData['name'],
        ]);

        // sử lý thêm danh mục bên add sản phẩm
        // if ($request->ajax()) {
        //     return response()->json(['success' => 'Danh mục đã được thêm thành công!']);
        // }

        return redirect()->route('capacity.index');
    }

    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $capacity = $this->capacities->find($id);
        return view('admin.page.product.capacity.update', compact('capacity'));
    }

    
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:capacities,name',
        ]);
        
        $capacity = Capacity::findOrFail($id);

        $capacity->update([
            'name' => $validateData['name'],
        ]);

        return redirect()->route('capacity.index');

    }

    public function destroy(string $id)
    {
        $capacity = Capacity::FindorFail($id);

        // if ($capacity->capacities()->withTrashed()->count() > 0) {
        //     return redirect()->route('capac$capacity.index')->with('error', 'Không thể xóa dung lượng vì vẫn còn sản phẩm trong dung lượng này.');
        // }

        $capacity->status = 0;
        $capacity->save();

        $capacity->delete();
        return redirect()->route('capacity.index')->with('success', 'Dung lượng đã được xóa thành công.');
    }

    public function trashed()
    {
        $capacities = Capacity::onlyTrashed()->paginate(5);

        return view('admin.page.product.capacity.trashed', compact('capacities'));
    }

    public function restore($id)
    {
        $capacity = Capacity::withTrashed()->findOrFail($id);
        $capacity->restore();

        $capacity->status = 1;
        $capacity->save();
        return redirect()->route('capacity.trashed')->with('success', 'Dung lượng đã được khôi phục thành công.');
    }
}
