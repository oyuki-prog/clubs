<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center mb-8">
                <p class="text-3xl overflow-ellipsis">{{ $plan->name }}</p>
                <div class="flex justify-between items-center flex-1">
                    @if (Auth::user()->isAdmin($club->id) == true)
                        <a href="{{ route('clubs.plans.edit', [$club, $plan->id]) }}"
                            class="block ml-4 bg-green-200 rounded p-2 w-auto">編集</a>
                        <form action="{{ route('clubs.plans.destroy', [$club, $plan]) }}" method="POST"
                            class="block ml-auto text-right">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="削除" class="block ml-4 bg-red-600 text-white rounded p-2 ml-auto">
                        </form>
                    @endif
                </div>
            </div>
            <div class="mb-8">
                <div class="flex mb-2">
                    <div class="w-1/3 text-center">
                        <p>日　　付</p>
                    </div>
                    <div class="w-2/3">
                        <p>{{ date('Y年 m月 d日', strtotime($plan->meeting_time)) }}</p>
                    </div>
                </div>
                <div class="flex mb-2">
                    <div class="w-1/3 text-center">
                        <p>集合時刻</p>
                    </div>
                    <div class="w-2/3">
                        <p>{{ date('H:i', strtotime($plan->meeting_time)) }}</p>
                    </div>
                </div>
                <div class="flex mb-2">
                    <div class="w-1/3 text-center">
                        <p>解散時刻</p>
                    </div>
                    <div class="w-2/3">
                        <p>{{ date('H:i', strtotime($plan->dissolution_time)) }}</p>
                    </div>
                </div>
                <div class="flex mb-2">
                    <div class="w-1/3 text-center">
                        <p>場　　所</p>
                    </div>
                    <div class="w-2/3">
                        <p>{{ $plan->place }}</p>
                    </div>
                </div>
                <div class="flex mb-2">
                    <div class="w-1/3 text-center">
                        <p>備　　考</p>
                    </div>
                    <div class="w-2/3">
                        <p>{{ $plan->remarks }}</p>
                    </div>
                </div>
            </div>
            <div class="text-center mb-12">
                <a href="{{ route('clubs.plans.index', [$club, date('Y'), date('m')]) }}"
                    class="text-center lg:ml-4 bg-green-200 rounded text-sm lg:text-base p-2 inline-block w-auto">カレンダーを見る</a>
            </div>
            @if ($threads->count() != 0)
                <div class="lg:w-1/2 md:w-2/3 mx-auto bg-blue-100 py-4 mb-20">
                    @foreach ($threads as $thread)
                        <div class="flex px-4 mb-2 inline-block w-auto @if ($thread->user_id == Auth::id()) justify-end @else justify-start @endif">
                            <div>
                                <p class=" @if ($thread->user_id == Auth::id()) text-right @else text-start @endif text-xs lg:text-sm">
                                    {{ $thread->user->nickName($club->id) }}</p>
                                @if ($thread->body)
                                    <div class="flex @if ($thread->user_id == Auth::id()) justify-end @else justify-start @endif">
                                        <p
                                            class=" @if ($thread->user_id == Auth::id()) bg-green-200 @else bg-gray-200 @endif py-2 px-4 rounded-full block w-auto text-sm lg:text-base">
                                            {{ $thread->body }}</p>
                                    </div>
                                @endif
                                @if ($thread->file)
                                    <img class="block w-2/3 @if ($thread->user_id == Auth::id())  ml-auto @else mr-auto @endif"
                                        src="{{ Storage::url('thread_image/' . $thread->file) }}"
                                        alt="{{ $thread->file }}">
                                @endif
                            </div>
                        </div>

                    @endforeach
                    <div class="mx-4 mt-4">
                        {{ $threads->links() }}
                    </div>
                </div>
            @endif
            <form action="{{ route('clubs.plans.threads.store', [$club, $plan]) }}" method="POST"
                enctype="multipart/form-data"
                class="fixed bottom-0 left-0 items-center lg:px-8 py-4 px-4 bg-white w-full">
                @csrf
                <input type="text" name="body" placeholder="メッセージを入力" class="block w-full mb-2 rounded">
                <div class="flex items-center">
                    <input type="file" name="file" class="inline-block flex-1">
                    <input type="submit" value="送信"
                        class="inline-block ml-4 w-auto bg-green-200 font-bold p-1 align-middle rounded">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
