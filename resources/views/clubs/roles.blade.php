<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            role編集
            <div class="flex">
                <form action="{{ route('clubs.clubroles.update', $club) }}" method="POST" id="form1">
                    @csrf
                    @method('PATCH')
                    @foreach ($club->clubRoles as $clubRole)
                    @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum') )
                    <input type="text" name="clubRole[{{ $clubRole->id }}]" value="{{ $clubRole->role_name }}" class="block">
                    @endif
                    @endforeach
                    <input type="submit" value="更新" form="form1">
                </form>
                <div>
                    @foreach ($club->clubRoles as $clubRole)
                    <form action="{{ route('clubs.clubroles.destroy', $clubRole) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        @if ($clubRole->role_number != config('const.adminNum') && $clubRole->role_number != config('const.defaultRequestNum') )
                    <input type="submit" value="削除">
                    @endif
                </form>
                @endforeach
                </div>
            </div>
            <form action="{{ route('clubs.clubroles.store', $club) }}" method="POST" id="form2">
                @csrf
                <label for="add">役職の追加</label>
                <input type="text" name="role_name" id="add" required>
                <input type="submit" value="追加" form="form2">
            </form>
        </div>
    </div>
</x-app-layout>
