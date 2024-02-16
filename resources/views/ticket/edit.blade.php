<x-app-layout>

    <div class="min-h-screen flex items-center">
        <div style="width: max-content; height: max-content;" class="rounded mx-auto flex flex-col sm:justify-center items-center p-6 sm-pt-0 bg-white dark:bg-gray-900">
            <h1 class="text-lg font-bold">Update ticket</h1>
            <form method="POST" action="{{ route('ticket.update', $ticket) }}" enctype="multipart/form-data">
                @method('patch')
                @csrf

                <div class="mt-4">
                    <x-input-label  for="title" :value="__('Title')"/>
                    <x-text-input id="title" type="text" name="title" class="block mt-1 w-full" value="{{ $ticket->title }}" autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div class="mt-4">
                    <x-input-label  for="description" :value="__('Description')"/>
                    <x-text-area id="description" name="description" value="{{ $ticket->description }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="mt-4">
                    <x-input-label  for="attachement" :value="__('Attachement')"/>
                    <x-file-input id="attachement" name="attachement" />
                    <x-input-error class="mt-2" :messages="$errors->get('attachement')" />
                    @if ($ticket->attachement)
                        <a href="{{ '/storage/' . $ticket->attachement }}" target="_blank">See Attachement</a>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-3">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
