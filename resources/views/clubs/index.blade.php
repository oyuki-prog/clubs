<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            @include('partial.errors')
            <h1 class="text-xl mb-6 text-center lg:text-left">所属クラブ一覧</h1>
            @foreach ($user->clubs as $club)
                <div class="flex mb-8 items-center bg-white p-4 rounded">
                    @if ($user->roleNumber($club->id) == config('const.defaultRequestNum'))
                        <p class="block w-auto lg:text-xl text-gray-500 pl-4">{{ $club->name }}</p>
                        <p class="w-20 ml-auto lg:ml-4 bg-gray-200 block text-center rounded-full text-sm lg:text-base">
                            {{ $user->roleName($club->id) }}</p>
                    @else
                        <a href="{{ route('clubs.plans.index', [$club, Date('Y'), Date('m')]) }}"
                            class="block w-auto lg:text-xl pl-4">{{ $club->name }}</a>
                        <p class="w-20 ml-auto lg:ml-4 bg-blue-200 block text-center rounded-full text-sm lg:text-base">
                            {{ $user->roleName($club->id) }}</p>
                    @endif
                </div>
            @endforeach
            <div class="flex justify-around items-center mt-14">
                <a href="{{ route('clubs.create') }}"
                    class="flex block bg-blue-200 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base">チームを作る</a>
                <a href="{{ route('request.create') }}"
                    class="flex block bg-green-200 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base">参加申請</a>
            </div>
        </div>
    </div>
</x-app-layout>
