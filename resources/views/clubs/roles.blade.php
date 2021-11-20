<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center mb-6">
                <h2 class="text-xl lg:text-3xl inline-block text-center lg:text-left">{{ $club->name }}</h2>
                <p class="inline-block text-right ml-4 text-gray-400">{{ $club->unique_name }}</p>
                @if (Auth::user()->isAdmin($club->id))
                    <a class="block ml-auto lg:ml-4 text-sm py-1 px-2 bg-pink-300 rounded" href="{{ route('clubs.edit', $club) }}">チーム情報編集</a>
                @endif
            </div>
            <p class="text-base lg:text-xl">管理者</p>
            <div class="flex items-center mb-6">
                @if ($club->admin->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover inline-block"
                        src="{{ $club->admin->profile_photo_url }}" alt="{{ $club->admin->name }}" />
                @else
                    <svg class="ml-2 -mr-0.5 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                @endif

                    <p class="pl-4 block">{{ $club->admin->name }}</p>
                    <p class="w-20 ml-auto lg:ml-4 bg-red-200 block text-center rounded-full text-sm lg:text-base">{{ $club->admin_role_name }}</p>

            </div>

            <div class="text-center mb-12">
                <a href="{{ route('clubs.plans.index', [$club, date('Y'), date('m')]) }}" class="text-center lg:ml-4 bg-green-200 rounded text-sm lg:text-base p-2 inline-block w-auto">カレンダーを見る</a>
            </div>


            <p class="text-base lg:text-xl block mb-4">役職の編集<span class="text-sm text-gray-400">誰も属していない役職のみ削除可</span></p>
            <div class="flex mb-12">
                <form action="{{ route('clubs.clubroles.update', $club) }}" method="POST" id="form1"
                    class="w-4/5">
                    @csrf
                    @method('PATCH')
                    @foreach ($club->clubRoles as $clubRole)
                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                            <input type="text" name="clubRole[{{ $clubRole->id }}]"
                                value="{{ $clubRole->role_name }}" class="block h-12 mb-4 rounded border-gray-400 w-full">
                        @endif
                    @endforeach
                    <input type="submit" value="更新" form="form1" class="text-center lg:ml-4 bg-green-200 rounded text-sm lg:text-base p-2 inline-block w-auto px-4 font-bold">
                </form>
                <div class="w-1/5">
                    @foreach ($club->clubRoles as $clubRole)
                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                            <div class="h-12 mb-4 text-right">
                                @if (empty(\App\Models\UserRole::where('club_role_id', $clubRole->id)->first()))
                                    <form action="{{ route('clubs.clubroles.destroy', [$club, $clubRole]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除" class="h-12 rounded px-2 bg-red-600 text-white font-bold ml-auto">
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <form action="{{ route('clubs.clubroles.store', $club) }}" method="POST" id="form2">
                @csrf
                <label for="add" class="block text-base lg:text-xl block mb-4">役職の追加</label>
                <div class="flex">
                    <input type="text" name="role_name" id="add" required class="block h-12 mb-4 rounded border-gray-400 w-4/5">
                    <input type="submit" value="追加" form="form2" class="h-12 rounded px-2 bg-green-600 text-white font-bold ml-auto">
                </div>
            </form>
            <a href="{{ route('clubs.show', $club) }}" class="block mt-8 text-right">戻る</a>
        </div>
    </div>
</x-app-layout>
