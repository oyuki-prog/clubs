<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1>所属クラブ一覧</h1>
            @foreach ($user->clubs() as $club)
                <p>
                    <a href="{{ route('clubs.plans.index', [$club , Date('Y'), Date('m')]) }}">{{ $club->name }}</a>
                </p>
            @endforeach
        </div>
    </div>
</x-app-layout>
