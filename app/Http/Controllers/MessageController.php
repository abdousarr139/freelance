<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Liste des conversations
    public function index()
    {
        $userId = Auth::id();

        // Récupérer tous les interlocuteurs uniques
        $conversations = Message::where('expediteur_id', $userId)
            ->orWhere('destinataire_id', $userId)
            ->with(['expediteur', 'destinataire'])
            ->latest()
            ->get()
            ->groupBy(function($msg) use ($userId) {
                // Grouper par l'autre personne
                return $msg->expediteur_id === $userId
                    ? $msg->destinataire_id
                    : $msg->expediteur_id;
            });

        return view('messages.index', compact('conversations'));
    }

    // Conversation avec un utilisateur
    public function conversation(User $user)
    {
        $myId = Auth::id();

        $messages = Message::where(function($q) use ($myId, $user) {
                $q->where('expediteur_id', $myId)
                  ->where('destinataire_id', $user->id);
            })
            ->orWhere(function($q) use ($myId, $user) {
                $q->where('expediteur_id', $user->id)
                  ->where('destinataire_id', $myId);
            })
            ->with(['expediteur', 'destinataire'])
            ->oldest()
            ->get();

        // Marquer les messages reçus comme lus
        Message::where('expediteur_id', $user->id)
            ->where('destinataire_id', $myId)
            ->where('lu', false)
            ->update(['lu' => true]);

        return view('messages.conversation', compact('messages', 'user'));
    }

    // Envoyer un message
    public function send(Request $request, User $user)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        Message::create([
            'expediteur_id'   => Auth::id(),
            'destinataire_id' => $user->id,
            'contenu'         => $request->contenu,
            'lu'              => false,
        ]);

        return back()->with('success', 'Message envoyé !');
    }
}