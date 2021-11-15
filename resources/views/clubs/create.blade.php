<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1>新規クラブ登録</h1>
            <form action="{{ route('clubs.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name">クラブ名</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="unique_name">クラブID</label>
                    <input type="text" name="unique_name" id="unique_name" required>
                </div>
                <div>
                    <label for="password">参加用パスワード</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <input type="submit" value="登録">
            </form>

        </div>
    </div>
</x-app-layout>
