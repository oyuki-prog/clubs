<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <p class="text-3xl overflow-ellipsis">{{ $plan->name }}</p>
                <a href="{{ route('clubs.plans.edit', [$club, $plan->id]) }}">予定を編集する</a>
            </div>
            <p>集合時刻：{{ $plan->meeting_time }}</p>
            <p>解散時刻：{{ $plan->dissolution_time }}</p>
            <p>場所：{{ $plan->place }}</p>
            <p>備考：</p>
            <p>
                {{ $plan->remarks }}
            </p>

        </div>
    </div>
</x-app-layout>
