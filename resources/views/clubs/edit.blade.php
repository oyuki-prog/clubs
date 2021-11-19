<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partial.errors')
            <h1 class="text-3xl">クラブ情報</h1>
            <form action="{{ route('clubs.update', $club) }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="name">クラブ名</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $club->name) }}">
                </div>
                <div>
                    <label for="unique_name">クラブID</label>
                    <input type="text" name="unique_name" id="unique_name" required  value="{{ old('unique_name', $club->unique_name) }}">
                </div>
                <div>
                    <label for="password">参加用パスワード</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <label for="confirm">パスワード再入力</label>
                    <input type="password" name="confirm" id="confirm" required>
                </div>
                <input type="submit" value="更新">
            </form>

        </div>
    </div>
</x-app-layout>
