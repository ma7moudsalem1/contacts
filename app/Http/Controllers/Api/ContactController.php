<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = auth()->user()->contacts()->orderBy('created_at','desc')->paginate(10);
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|min:3|max:60',
            'phone' => 'required'
        ]);
        $contact = auth()->user()->contacts()->create($input);
        return response()->json($contact);
    }

    public function update($id, Request $request)
    {
        $input = $request->validate([
            'name' => 'required|min:3|max:60',
            'phone' => 'required'
        ]);
        $contact = auth()->user()->contacts()->where('_id', $id)->firstOrFail();
        $contact->update($input);
        return response()->json($contact);
    }

    public function destroy($id)
    {
        auth()->user()->contacts()->where('_id', $id)->firstOrFail()->delete();
        return response()->json(['status' => 'success']);
    }
}
