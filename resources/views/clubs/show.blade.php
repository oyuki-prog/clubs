<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl">チーム名：{{ $club->name }}</h2>
            <div class="flex items-center">
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
                <p class="pl-4 block">管理者：{{ $club->admin->name }}（{{ $club->admin_role_name }}）</p>
            </div>
            <a href="{{ route('clubs.plans.index', [$club, date('Y'), date('m')]) }}">カレンダーを見る</a>
            <div class="flex justify-between">
                <p class="text-xl">メンバー</p>
                @if (Auth::user()->isAdmin($club->id))
                    <a href="{{ route('clubs.clubroles.edit', $club) }}">役職の追加･編集</a>
                @endif
            </div>
            <form action="{{ route('clubs.role.update', $club->id) }}" method="POST">
                @csrf
                @method('PATCH')
                @foreach ($club->members() as $member)
                    @if ($member->name != $club->admin->name)
                        @if ($member->profile_photo_url)
                            <div
                                class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition mb-4">
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
                        <p class="pl-4 inline-block w-1/3">
                            {{ $member->name }}
                            {{-- @if ($club->isAdmin(Auth::id())) --}}
                        </p>

                        @if (Auth::user()->isAdmin($club->id))
                            <select name="clubRole[{{ $member->id }}]" id="clubRole" class="inline-block">
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
                                {{-- @foreach ($club->clubRoles as $clubRole)
                                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                                            <option value="{{ $clubRole->id }}" @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                {{ $clubRole->role_name }}</option>
                                        @else
                                            @if ($member->roleName($club->id) == $clubRole->role_name)
                                                <option value="{{ config('const.defaultRequestNum') }}"
                                                    @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                    {{ $clubRole->role_name }}</option>
                                            @endif
                                        @endif
                                    @endforeach --}}
                            </select>
                        @else
                            ({{ $member->role($club->id)->role_name }})
                        @endif

        </div>
        @endif
        @endforeach
        @if (Auth::user()->isAdmin($club->id))
            <input type="submit" value="更新">
        @endif
        </form>

    </div>
    </div>
</x-app-layout>
