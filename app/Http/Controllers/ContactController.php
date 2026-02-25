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

        // Log the contact form submission
        Log::info('Contact form submitted', $validated);

        try {
            // Trimite email-ul folosind Mailjet
            Mail::send('emails.contact', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'contactMessage' => $validated['message']
            ], function ($mail) use ($validated) {
                $mail->from('contact@negibamaxim.eu', 'Doctor IT')
                     ->to('negibamaxim@gmail.com')  // Înlocuiește cu adresa unde vrei să primești email-uri
                     ->subject('Mesaj nou Doctor IT: ' . $validated['subject']);
            });

            Log::info('Email sent successfully', ['to' => 'negibamaxim@gmail.com']);

        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'A apărut o eroare la trimiterea mesajului. Vă rugăm încercați mai târziu.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'A apărut o eroare la trimiterea mesajului. Vă rugăm încercați mai târziu.')
                ->withInput();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mesajul a fost trimis cu succes!'
            ]);
        }

        return redirect()->back()
            ->with('success', 'Mesajul a fost trimis cu succes!')
            ->withInput();
    }
}