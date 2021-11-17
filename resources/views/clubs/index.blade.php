<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partial.errors')
            <h1 class="text-3xl mb-6">所属クラブ一覧</h1>
            @foreach ($user->clubs() as $club)
                <p>
                    @if ($club->isMember(Auth::id()) == false)
                    <p class="mb-4 inline-block">{{ $club->name }}(申請中)</p>
                    @else
                    <a href="{{ route('clubs.plans.index', [$club , Date('Y'), Date('m')]) }}" class="mb-4 inline-block">{{ $club->name }}</a>
                    @endif
                </p>
            @endforeach
            <a href="{{ route('clubs.create') }}" class="inline-block leading-none pr-4 bg-blue-200 w-32 h-12 align-middle line-highlight rounded text-center">チームを作る</a>
            <a href="{{ route('request.create') }}">参加申請</a>
        </div>
    </div>
</x-app-layout>
