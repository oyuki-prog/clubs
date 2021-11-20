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
            <div class="flex mb-6">
                <p class="text-base lg:text-xl">メンバー</p>
                @if (Auth::user()->isAdmin($club->id))
                    <a class="block ml-auto lg:ml-4 text-sm py-1 px-2 bg-pink-300 rounded" href="{{ route('clubs.clubroles.edit', $club) }}">役職の追加･編集</a>
                @endif
            </div>

            <form action="{{ route('clubs.role.update', $club->id) }}" method="POST" id="form" class="lg:flex lg:justify-around lg:flex-wrap">
                @csrf
                @method('PATCH')
                @foreach ($club->members() as $member)
                    @if ($member->name != $club->admin->name)
                        @if ($member->profile_photo_url)
                            <div
                                class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition mb-4 lg:w-5/12">
                                <img class="h-8 w-8 rounded-full object-cover inline-block"
                                    src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}" />
                            @else
                                <div
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ $member->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                        @endif

                        <p class="pl-4 inline-block">
                            {{ $member->name }}
                        </p>

                        @if (Auth::user()->isAdmin($club->id))
                            <select name="clubRole[{{ $member->id }}]" id="clubRole" class="inline-block rounded border-gray-300 py-1 ml-auto">
                                @foreach ($club->clubRoles as $clubRole)
                                    @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                                        <option value="{{ $clubRole->id }}" @if ($member->role($club->id)->id == $clubRole->id) selected @endif>
                                            {{ $clubRole->role_name }}</option>
                                    @else
                                        @if ($member->roleName($club->id) == $clubRole->role_name)
                                            <option value="{{ config('const.defaultRequestNum') }}"
                                                @if ($member->role($club->id)->id == $clubRole->id) selected @endif>
                                                {{ $clubRole->role_name }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        @else
                        <p class="w-20 ml-auto lg:ml-4 bg-blue-200 block text-center rounded-full text-sm lg:text-base">
                            {{ $member->roleName($club->id)}}</p>
                            {{-- () --}}
                        @endif

        </div>
        @endif
        @endforeach
        @if (Auth::user()->isAdmin($club->id))
        @endif
    </form>
    <div class="w-full">
        <input type="submit" value="更新" class="text-center bg-green-200 rounded text-sm lg:text-base p-2 px-4 block ml-auto font-bold" form="form">
    </div>

    </div>
    </div>
</x-app-layout>
