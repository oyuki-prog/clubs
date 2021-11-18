<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partial.errors')
            <h1 class="text-3xl">予定内容編集</h1>
            <form action="{{ route('clubs.plans.update', [$club, $plan]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="name">タイトル</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $plan->name) }}">
                </div>
                <div class="flex">
                    <div>
                        <label for="meeting_date">開始日</label>
                        <input type="date" name="meeting_date" id="meeting_date" required  value="{{ old('meeting_date', strstr($plan->meeting_time, ' ' ,true)) }}">
                    </div>
                    <div>
                        <label for="meeting_time">集合時刻</label>
                        {{-- {{ dd(substr(strstr($plan->meeting_time, ' '),1,5)) }} --}}
                        <input type="time" name="meeting_time" id="meeting_time" required  value="{{ old('meeting_time', substr(strstr($plan->meeting_time, ' '),1,5)) }}">
                    </div>
                </div>
                <div class="flex">
                    <div>
                        <label for="dissolution_date">終了日</label>
                        <input type="date" name="dissolution_date" id="dissolution_date" required value="{{ old('dissolution_date', strstr($plan->dissolution_time, ' ' ,true)) }}">
                    </div>
                    <div>
                        <label for="dissolution_time">解散時刻</label>
                        <input type="time" name="dissolution_time" id="dissolution_time" required value="{{ old('dissolution_time', substr(strstr($plan->dissolution_time, ' '),1,5)) }}">
                    </div>
                </div>
                <div>
                    <label for="place">場所</label>
                    <input type="text" name="place" id="place" required value="{{ old('place', $plan->place) }}">
                </div>
                <div>
                    <label for="remarks">備考</label>
                    <textarea name="remarks" id="remarks" rows="10">{{ old('remarks', $plan->remarks) }}</textarea>
                </div>
                <div>
                    <div>公開範囲</div>
                    @foreach ($club->clubRoles as $clubRole)
                        @if ($clubRole->role_number != config('const.defaultRequestNum') && $clubRole->role_number != config('const.adminNum'))
                            <label>
                                <input type="checkbox" name="public[{{ $clubRole->id }}]" id="disclosure_range"
                                    value="{{ $clubRole->id }}"
                                    {{ $clubRole->id == old('public.' . $clubRole->id) ? 'checked' : '' }}>
                                {{ $clubRole->role_name }}
                            </label>
                        @endif
                    @endforeach
                </div>
                <input type="submit" value="更新">
            </form>
        </div>
    </div>
</x-app-layout>
