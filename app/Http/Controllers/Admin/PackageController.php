<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::withTrashed()->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }
    
    public function create()
    {
        return view('admin.packages.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }
    
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }
    
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        
        $package->update($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }
    
    // Soft delete
    public function destroy(Package $package)
    {
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deactivated successfully.');
    }
    
    // Restore from soft delete
    public function restore($id)
    {
        $package = Package::withTrashed()->findOrFail($id);
        $package->restore();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package restored successfully.');
    }
    
    // Hard delete
    public function forceDelete($id)
    {
        $package = Package::withTrashed()->findOrFail($id);
        $package->forceDelete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package permanently deleted.');
    }
}