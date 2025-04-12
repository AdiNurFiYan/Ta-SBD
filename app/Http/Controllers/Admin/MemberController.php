<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::withTrashed();
        
        // Search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $members = $query->latest()->paginate(10);
        
        return view('admin.members.index', compact('members'));
    }
    
    public function show(Member $member)
    {
        $bookings = $member->bookings()->with(['package', 'slot'])->latest()->get();
        return view('admin.members.show', compact('member', 'bookings'));
    }
    
    // Soft delete (suspend)
    public function destroy(Member $member)
    {
        $member->delete();
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member suspended successfully.');
    }
    
    // Restore from soft delete
    public function restore($id)
    {
        $member = Member::withTrashed()->findOrFail($id);
        $member->restore();
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member activated successfully.');
    }
    
    // Hard delete
    public function forceDelete($id)
    {
        $member = Member::withTrashed()->findOrFail($id);
        $member->forceDelete();
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member permanently deleted.');
    }
}