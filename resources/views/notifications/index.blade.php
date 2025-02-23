<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📢 Notifications
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">🔔 Toutes les notifications</h3>

                @if($notifications->count() > 0)
                <ul class="divide-y divide-gray-300 dark:divide-gray-700">
                    @foreach($notifications as $notification)
                    <li class="py-4 flex justify-between items-center 
                                {{ $notification->read_at ? 'bg-gray-100 dark:bg-gray-700' : 'bg-blue-100 dark:bg-blue-700' }} 
                                p-3 rounded">
                        <div>
                            <p class="text-gray-800 dark:text-gray-200 font-semibold">
                                {{ $notification->title ?? 'Nouvelle notification' }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                Reçu le {{ $notification->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>

                        <div class="flex space-x-2">
                            @if(!$notification->read_at)
                            <form action="{{ route('notifications.acceptOrRejectProject', ['id' => $notification->id, 'accept' => true]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">✔ Accepter</button>
                            </form>
                            <form action="{{ route('notifications.acceptOrRejectProject', ['id' => $notification->id, 'accept' => false]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">🗑 Réfuser</button>
                            </form>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500">Aucune notification pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>