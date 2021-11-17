<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>役職の編集(削除は誰も属していない役割しかできません)</p>
            <div class="flex">
                <form action="{{ route('clubs.clubroles.update', $club) }}" method="POST" id="form1"
                    class="mb-8">
                    @csrf
                    @method('PATCH')
                    @foreach ($club->clubRoles as $clubRole)
                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                            <input type="text" name="clubRole[{{ $clubRole->id }}]"
                                value="{{ $clubRole->role_name }}" class="block h-12 mb-4">
                        @endif
                    @endforeach
                    <input type="submit" value="更新" form="form1">
                </form>
                <div class="ml-4">
                    @foreach ($club->clubRoles as $clubRole)
                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum'))
                            <div class="h-12 mb-4">
                                {{-- {{ dd(empty(\App\Models\UserRole::where('club_role_id', $clubRole->id)->first())) }} --}}
                                @if (empty(\App\Models\UserRole::where('club_role_id', $clubRole->id)->first()))
                                    <form action="{{ route('clubs.clubroles.destroy', [$club, $clubRole]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除" class="h-12 w-full">
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <form action="{{ route('clubs.clubroles.store', $club) }}" method="POST" id="form2">
                @csrf
                <label for="add" class="block">役職の追加</label>
                <input type="text" name="role_name" id="add" required>
                <input type="submit" value="追加" form="form2">
            </form>
            <a href="{{ route('clubs.show', $club) }}">戻る</a>
        </div>
    </div>
</x-app-layout>
