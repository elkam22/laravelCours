<x-app-layout>

    <div class="min-h-screen flex items-center" style="">
        <div style="width: max-content; height: max-content;margin-top: 20px;margin-bottom: 20px;" class="rounded mx-auto flex flex-col sm:justify-center items-center p-6 sm-pt-0 bg-white dark:bg-gray-900">
            <h1 class="text-lg font-bold py-2">Support ticket</h1>
            <x-primary-button>
                <a href="{{ route('ticket.create')}}" class="ml-3 text-white-500 rounded-lg p-1" style="margin: 0px">Create Ticket</a>
            </x-primary-button>

            @isset($tickets)
                <div class="min-h-screen flex items-center flex-col sm:justify-center pt-6 sm:pt-0">
                    <div class="rounded flex flex-col sm:justify-center items-center p-6 sm-pt-0 bg-white dark:bg-gray-900">
                        @forelse ($tickets as $ticket)
                            <a href="{{ route('ticket.show', $ticket) }}" style="margin-bottom: 10px;" class="w-full rounded p-2 bg-gray-100 dark:bg-gray-900">
                                <h4 class="text-dark text-center text-lg font-bold">{{$ticket->title}}</h4>
                                <div class="text-dark flex justify-between py-4">
                                    <span>{{ $ticket->description }}</span>
                                    <span>{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @empty
                            <p>You don't have any ticket yet. Create a new one if you want!</p>
                        @endforelse
                    </div>
                </div>
            @endisset

        </div>
    </div>

</x-app-layout>
