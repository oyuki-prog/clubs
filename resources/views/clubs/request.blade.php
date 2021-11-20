<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            @include('partial.errors')
            <h1 class="text-xl mb-6 lg:text-left text-center">参加申請</h1>
            <form action="{{ route('request.store') }}" method="POST">
                @csrf
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label for="name" class="lg:w-1/4 lg:block lg:text-left">クラブ内の名前</label>
                    <input class="w-full rounded lg:block" type="text" name="name" id="name">
                </div>
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label for="unique_name" class="lg:w-1/4 lg:block lg:text-left">クラブID</label>
                    <input class="w-full rounded lg:block" type="text" name="unique_name" id="unique_name">
                </div>
                <div class="mb-8 lg:flex w-full lg:items-center lg:mb-16">
                    <label for="password" class="lg:w-1/4 lg:block lg:text-left">参加用パスワード</label>
                    <input class="w-full rounded lg:block" type="password" name="password" id="password">
                </div>
                <div class="flex justify-around items-center mt-14">
                    <input class="flex block bg-green-200 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base font-extrabold" type="submit" value="申請">
                    <a href="{{ route('clubs.index') }}"
                        class="flex block bg-gray-300 w-2/5 h-12 items-center rounded justify-center text-sm lg:text-base">戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
