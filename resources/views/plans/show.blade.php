<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <p class="text-3xl overflow-ellipsis">{{ $plan->name }}</p>
                <div class="flex">
                    @if (Auth::user()->isAdmin($club->id) == true)
                        <a href="{{ route('clubs.plans.edit', [$club, $plan->id]) }}" class="inline-block ml-4">編集</a>
                        <form action="{{ route('clubs.plans.destroy', [$club, $plan]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="削除" class="inline-block ml-4">
                        </form>
                    @endif
                </div>
            </div>
            <p>日付：{{ date('Y年 m月 d日', strtotime($plan->meeting_time)) }}</p>
            <p>集合時刻：{{ date('H:i', strtotime($plan->meeting_time)) }}</p>
            <p>解散時刻：{{ date('H:i', strtotime($plan->dissolution_time)) }}</p>
            <p>場所：{{ $plan->place }}</p>
            <p>備考：</p>
            <p>
                {{ $plan->remarks }}
            </p>

            @if ($plan->threads->count() != 0)
                <div class="lg:w-1/2 lg:mx-auto bg-blue-100 py-4">
                    @foreach ($plan->threads as $thread)
                        @if ($thread->body)
                            <div class="flex px-4 mb-2 inline-block w-auto @if ($thread->user_id == Auth::id()) justify-end @else justify-start @endif">
                                <div>
                                    <p class=" @if ($thread->user_id == Auth::id()) text-right @else text-start @endif">{{ $thread->user->name }}</p>
                                    <p class=" @if ($thread->user_id == Auth::id()) bg-green-200 @else bg-gray-200 @endif py-2 px-4 rounded-full">{{ $thread->body }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($thread->file)
                            <div class="flex px-4 mb-2 inline-block w-auto @if ($thread->user_id == Auth::id()) justify-end @else justify-start @endif">
                                <div>
                                    <p class=" @if ($thread->user_id == Auth::id()) text-right @else text-start @endif">{{ $thread->user->name }}</p>
                                    <img class="block w-2/3 @if ($thread->user_id == Auth::id())  ml-auto @else mr-auto @endif"
                                        src="{{ Storage::url('thread_image/' . $thread->file) }}"
                                        alt="{{ $thread->file }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            <form action="{{ route('clubs.plans.threads.store', [$club, $plan]) }}" method="POST"
                enctype="multipart/form-data"
                class="flex fixed bottom-0 left-0 items-center w-auto lg:px-8 py-4 bg-white w-full">
                @csrf
                <input type="text" name="body" placeholder="メッセージを入力" class="w-full inline-block">
                <div class="flex items-center">
                    <input type="file" name="file" class="inline-block">
                    <input type="submit" value="送信" class="inline-block ml-4">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
