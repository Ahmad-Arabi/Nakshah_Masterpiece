<?php

namespace App\Http\Controllers\Admin;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminContactUsController extends Controller
{
    public function index(Request $request) {
        $query = ContactUs::query();

        if ($request->filled('search')) {
            $query->where('email', 'LIKE', "%{$request->search}%")
                    ->orWhere('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('subject', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax()) {
            return view('admin.contact_us.table', compact('messages'))->render();
        }

        return view('admin.contact_us.index', compact('messages'));

    }

    public function destroy($id) {
        $message = ContactUs::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully!');
    }

    public function update(Request $request, $id) {
        $message = ContactUs::findOrFail($id);
        $message->status = $request->input('status');
        $message->save();

        return redirect()->back()->with('success', 'Message status updated successfully!');
    }
}
