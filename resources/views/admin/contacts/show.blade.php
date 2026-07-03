@extends('admin.layouts.app')

@section('content')
@section('title', 'Contact Message')

    <x-admin.page-header title="Contact Message" description="View message details" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card>
                <div class="p-6">
                    @if($contact->subject)
                        <h2 class="text-xl font-bold text-neutral-900 mb-4">{{ $contact->subject }}</h2>
                    @endif
                    <div class="prose prose-neutral max-w-none">
                        <p class="whitespace-pre-wrap text-neutral-700">{{ $contact->message }}</p>
                    </div>
                </div>
            </x-admin.card>
        </div>

        <div class="space-y-6">
            <x-admin.card>
                <div class="p-6 space-y-4">
                    <h3 class="text-base font-semibold text-neutral-900">Sender Information</h3>
                    <div>
                        <div class="text-xs text-neutral-500 mb-1">Name</div>
                        <div class="text-sm font-medium text-neutral-900">{{ $contact->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-1">Email</div>
                        <a href="mailto:{{ $contact->email }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $contact->email }}</a>
                    </div>
                    @if($contact->phone)
                        <div>
                            <div class="text-xs text-neutral-500 mb-1">Phone</div>
                            <div class="text-sm font-medium text-neutral-900">{{ $contact->phone }}</div>
                        </div>
                    @endif
                    <div>
                        <div class="text-xs text-neutral-500 mb-1">Received</div>
                        <div class="text-sm text-neutral-900">{{ $contact->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    @if($contact->ip_address)
                        <div>
                            <div class="text-xs text-neutral-500 mb-1">IP Address</div>
                            <div class="text-xs text-neutral-600 font-mono">{{ $contact->ip_address }}</div>
                        </div>
                    @endif
                </div>
            </x-admin.card>

            <x-admin.card>
                <div class="p-6 space-y-3">
                    <h3 class="text-base font-semibold text-neutral-900">Actions</h3>
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="block w-full px-4 py-2 text-center text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800">
                        Reply via Email
                    </a>
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this message?');">
                        @csrf @method('DELETE')
                        <x-admin.button type="submit" variant="danger" class="w-full">Delete Message</x-admin.button>
                    </form>
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection