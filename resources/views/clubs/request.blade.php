<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partial.errors')
            <h1 class="text-3xl">参加申請</h1>
            <form action="{{ route('request.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name">クラブ内の名前</label>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <label for="unique_name">クラブID</label>
                    <input type="text" name="unique_name" id="unique_name">
                </div>
                <div>
                    <label for="password">参加用パスワード</label>
                    <input type="password" name="password" id="password">
                </div>
                <input type="submit" value="参加申請する">
            </form>
        </div>
    </div>
</x-app-layout>
