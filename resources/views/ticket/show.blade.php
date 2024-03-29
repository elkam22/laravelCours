<x-app-layout>
    <div class="min-h-screen flex items-center flex-col sm:justify-center  pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-dark text-lg font-bold">{{ $ticket->title }}</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
            <div class="text-dark flex justify-between py-4">
                <p>{{ $ticket->description }}</p>
                <p>{{ $ticket->created_at->diffForHumans() }}</p>
                @if ($ticket->attachement)
                    <a href="{{ '/storage/' . $ticket->attachement }}" target="_blank">Attachement</a>
                @endif
            </div>
            <div class="flex justify-between">
                <div class="flex">
                    <x-primary-button>
                        <a href="{{ route('ticket.edit', $ticket) }}">Edit</a>
                    </x-primary-button>
                    <form class="ml-2" action="{{ route('ticket.destroy', $ticket->id) }}" method="post">
                        @method('delete')
                        @csrf

                        <x-primary-button>Delete</x-primary-button>
                    </form>
                </div>
                @if(auth()->user()->isAdmin)
                    <div class="flex">
                        <form action="{{ route('ticket.update', $ticket) }}" method="post">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="status" value="resolved">
                            <x-primary-button>Resolv</x-primary-button>
                        </form>
                        <form action="{{ route('ticket.update', $ticket) }}" method="post">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="status" value="rejected">
                            <x-primary-button class="ml-2">Reject</x-primary-button>
                        </form>

                    </div>
                @else
                    <p>Status is : {{ $ticket->status }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
