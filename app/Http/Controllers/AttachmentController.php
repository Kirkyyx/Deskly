<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function index()
    {
        return response()->json(Attachment::with(['ticket','uploader'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'filename'  => 'required|string|max:255',
            'path'      => 'required|string',
            'uploaded_by' => 'required|exists:users,id',
        ]);

        $attachment = Attachment::create($validated);

        return response()->json($attachment, 201);
    }

    public function show(Attachment $attachment)
    {
        return response()->json($attachment->load(['ticket','uploader']));
    }

    public function update(Request $request, Attachment $attachment)
    {
        $validated = $request->validate([
            'filename' => 'sometimes|string|max:255',
            'path'     => 'sometimes|string',
        ]);

        $attachment->update($validated);

        return response()->json($attachment);
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        return response()->json(null, 204);
    }
}

