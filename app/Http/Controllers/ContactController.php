<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Log the contact form submission for now
        Log::info('Contact form submitted', $validated);

        // TODO: Implement email sending
        // Mail::to('your-email@example.com')->send(new ContactFormMail($validated));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}