<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            @include('partial.errors')
            <h1 class="text-xl mb-6 lg:text-left text-center">予定内容編集</h1>
            <form action="{{ route('clubs.plans.update', [$club, $plan]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label class="lg:w-1/4 lg:block lg:text-left" for="name">タイトル</label>
                    <input class="w-full rounded lg:block" type="text" name="name" id="name" required value="{{ old('name', $plan->name) }}">
                </div>
                <div class="flex">
                    <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                        <label class="lg:w-1/4 lg:block lg:text-left" for="meeting_date">開始日</label>
                        <input class="w-full rounded lg:block" type="date" name="meeting_date" id="meeting_date" required
                            value="{{ old('meeting_date', strstr($plan->meeting_time, ' ', true)) }}">
                    </div>
                    <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                        <label class="lg:w-1/4 lg:block lg:text-left" for="meeting_time">集合時刻</label>
                        <input class="w-full rounded lg:block" type="time" name="meeting_time" id="meeting_time" required
                            value="{{ old('meeting_time', substr(strstr($plan->meeting_time, ' '), 1, 5)) }}">
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                        <label class="lg:w-1/4 lg:block lg:text-left" for="dissolution_date">終了日</label>
                        <input class="w-full rounded lg:block" type="date" name="dissolution_date" id="dissolution_date" required
                            value="{{ old('dissolution_date', strstr($plan->dissolution_time, ' ', true)) }}">
                    </div>
                    <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                        <label class="lg:w-1/4 lg:block lg:text-left" for="dissolution_time">解散時刻</label>
                        <input class="w-full rounded lg:block" type="time" name="dissolution_time" id="dissolution_time" required
                            value="{{ old('dissolution_time', substr(strstr($plan->dissolution_time, ' '), 1, 5)) }}">
                    </div>
                </div>
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label class="lg:w-1/4 lg:block lg:text-left" for="place">場所</label>
                    <input class="w-full rounded lg:block" type="text" name="place" id="place" required value="{{ old('place', $plan->place) }}">
                </div>
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label class="lg:w-1/4 lg:block lg:text-left" for="remarks">備考</label>
                    <textarea class="w-full rounded lg:block" name="remarks" id="remarks" rows="10">{{ old('remarks', $plan->remarks) }}</textarea>
                </div>
                <div>
                    <div>公開範囲</div>
                    <div class="flex mb-4">
                        @foreach ($club->clubRoles as $clubRole)
                            @if ($clubRole->role_number != config('const.defaultRequestNum') && $clubRole->role_number != config('const.adminNum'))
                                <label class="flex items-center block mr-4">
                                    <input type="checkbox" class="block mr-2" name="public[{{ $clubRole->id }}]" id="disclosure_range"
                                        value="{{ $clubRole->id }}"
                                        {{ $clubRole->id == old('public.' . $clubRole->id) ? 'checked' : '' }}>
                                    {{ $clubRole->role_name }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex">
                    <input type="submit" value="更新"
                        class="flex block bg-blue-200 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base font-extrabold mx-auto">
                    <a href="{{ route('clubs.plans.show', [$club, $plan]) }}" class="flex block bg-gray-200 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base font-extrabold mx-auto">戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
