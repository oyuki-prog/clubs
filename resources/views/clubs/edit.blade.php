<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            @include('partial.errors')
            <h1 class="text-xl mb-6 lg:text-left text-center">クラブ情報編集</h1>
            <form action="{{ route('clubs.update', $club) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label for="name" class="lg:w-1/4 lg:block lg:text-left">クラブ名</label>
                    <input class="w-full rounded lg:block" type="text" name="name" id="name" required value="{{ old('name', $club->name) }}">
                </div>
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label for="unique_name" class="lg:w-1/4 lg:block lg:text-left">クラブID</label>
                    <input class="w-full rounded lg:block" type="text" name="unique_name" id="unique_name" required
                        value="{{ old('unique_name', $club->unique_name) }}">
                </div>
                <div class="mb-4 lg:flex w-full lg:items-center lg:mb-12">
                    <label for="password" class="lg:w-1/4 lg:block lg:text-left">参加用パスワード</label>
                    <input class="w-full rounded lg:block" type="password" name="password" id="password" required>
                </div>
                <div class="mb-8 lg:flex w-full lg:items-center lg:mb-16">
                    <label for="confirm" class="lg:w-1/4 lg:block lg:text-left">パスワード再入力</label>
                    <input class="w-full rounded lg:block" type="password" name="confirm" id="confirm" required>
                </div>
                <input class="w-1/2 mx-auto py-2 block rounded bg-green-600 font-extrabold text-white text-2xl" type="submit" value="更新">
            </form>

        </div>
    </div>
</x-app-layout>
