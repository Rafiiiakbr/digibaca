<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
 
class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('nama_kategori')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori'],
            'deskripsi'     => ['nullable', 'string'],
            'icon'          => ['nullable', 'string'],
        ]);
 
        Category::create($request->only('nama_kategori', 'deskripsi', 'icon'));
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat.');
    }
 
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori,' . $category->id],
        ]);
 
        $category->update($request->only('nama_kategori', 'deskripsi', 'icon'));
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }
 
    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus.');
    }
}