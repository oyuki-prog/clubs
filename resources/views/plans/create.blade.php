<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partial.errors')
            <h1 class="text-3xl">新規予定登録</h1>
            <form action="{{ route('clubs.plans.store', $club) }}" method="POST">
                @csrf
                <div>
                    <label for="name">タイトル</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}">
                </div>
                <div>
                    <label for="meeting_time">集合時間</label>
                    <input type="datetime-local" name="meeting_time" id="meeting_time" required  value="{{ old('meeting_time') }}">
                </div>
                <div>
                    <label for="dissolution_time">解散時間</label>
                    <input type="datetime-local" name="dissolution_time" id="dissolution_time" required value="{{ old('dissolution_time') }}">
                </div>
                <div>
                    <label for="place">場所</label>
                    <input type="text" name="place" id="place" required value="{{ old('place') }}">
                </div>
                <div>
                    <label for="remarks">備考</label>
                    <textarea name="remarks" id="remarks" rows="10">{{ old('remarks') }}</textarea>
                </div>
                <div>
                    <div>公開範囲</div>
                    @foreach ($club->clubRoles as $clubRole)
                    @if ($clubRole->role_number != config('const.defaultRequestNum') && $clubRole->role_number != config('const.adminNum'))
                    <label>
                        <input type="checkbox" name="public[{{ $clubRole->id }}]" id="disclosure_range" value="{{ $clubRole->id }}" {{ $clubRole->id == old('public.'. $clubRole->id) ? "checked" : '' }}>
                        {{ $clubRole->role_name }}
                    </label>
                    @endif
                    @endforeach
                </div>
                <input type="submit" value="登録">
            </form>
        </div>
    </div>
</x-app-layout>
