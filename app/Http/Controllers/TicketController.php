<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\TicketUpdaeNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $tickets = $user->isAdmin ? Ticket::latest()->get() : $user->tickets;
        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if($request->file('attachement')){
            $this->StoreAttachement($request, $ticket);
        }

        return response()->redirectTo(route('ticket.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        // $ticket->update([
        //     'title' => $request->title,
        //     'description' => $request->description
        // ]);

        $ticket->update($request->except('attachement'));

        // send request to mail
        if($request->has('status')){
            $user = User::find($ticket->user_id);
            $user->notify(new TicketUpdaeNotification($ticket));
            // Mail::to($user)->send(new TicketUpdaeNotification($ticket));
            // return (new TicketUpdaeNotification($ticket))->toMail($user);
        }

        if($request->file('attachement')){
            Storage::disk('public')->delete($ticket->attachement);

            $this->StoreAttachement($request, $ticket);
        }

        return response()->redirectTo(route('ticket.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->redirectTo(route('ticket.index'));
    }

    protected function StoreAttachement($request, $ticket){
        $ext = $request->file('attachement')->extension();
        $content = file_get_contents(request()->file('attachement'));
        $filename = Str::random(25);
        $path = "attachements/$filename.$ext";
        Storage::disk('public')->put($path ,$content);
        $ticket->update(['attachement' => $path]);
    }
}
