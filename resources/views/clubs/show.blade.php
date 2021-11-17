<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl">チーム名：{{ $club->name }}</h2>
            <div class="flex">
                @if ($club->leader()->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover inline-block"
                        src="{{ $club->leader()->profile_photo_url }}" alt="{{ $club->leader()->name }}" />
                @else
                    <svg class="ml-2 -mr-0.5 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
                <p class="mb-6 block">管理者：{{ $club->leader()->name }}（{{ $club->leaderRoleName() }}）</p>
            </div>
            <div class="flex justify-between">
                <p class="text-xl">メンバー</p>
                <a href="{{ route('clubs.clubroles.edit', $club) }}">役職の追加･編集</a>
            </div>
            <form action="{{ route('clubs.role.update', $club->id) }}" method="POST">
                @csrf
                @method('PATCH')
                @foreach ($club->members() as $member)
                    @if ($member->name != $club->leader()->name)
                        @if ($member->profile_photo_url)
                            <div
                                class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover inline-block"
                                    src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}" />
                                <p class="pl-4 inline-block">
                                    {{ $member->name }}({{ $club->role($member->id)->role_name }})
                                </p>
                                @if ($club->isAdmin(Auth::id()))

                                    <select name="clubRole[{{ $member->id }}]" id="clubRole">
                                        @foreach ($club->clubRoles as $clubRole)
                                            @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                                                <option value="{{ $clubRole->id }}" @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                    {{ $clubRole->role_name }}</option>
                                            @else
                                                @if ($club->role($member->id) == $clubRole)
                                                    <option value="{{ config('const.defaultRequestNum') }}"
                                                        @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                        {{ $clubRole->role_name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @else
                            <span class="inline-flex rounded-md">
                                <div
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ $member->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="pl-4 inline-block">
                                        {{ $member->name }}({{ $club->role($member->id) }})
                                    </p>
                                    @if ($club->isAdmin(Auth::id()))

                                        <select name="clubRole[{{ $member->id }}]" id="clubRole">
                                                                                    @foreach ($club->clubRoles as $clubRole)
                                            @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                                                <option value="{{ $clubRole->id }}" @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                    {{ $clubRole->role_name }}</option>
                                            @else
                                                @if ($club->role($member->id)->role_number == config('const.defaultRequestNum'))
                                                    <option value="{{ config('const.defaultRequestNum') }}"
                                                        @if ($club->role($member->id)->id == $clubRole->id) selected @endif>
                                                        {{ $clubRole->role_name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                        </select>
                                    @endif
                                </div>
                            </span>
                        @endif
                    @endif
                @endforeach
                @if ($club->isAdmin(Auth::id()))
                    <input type="submit" value="更新">
                @endif
            </form>

        </div>
    </div>
</x-app-layout>
