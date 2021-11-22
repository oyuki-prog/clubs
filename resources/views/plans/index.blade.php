<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="lg:flex items-center">
                <h2 class="inline-block lg:text-3xl text-2xl mb-4">{{ $club->name }}</h2>
                <div class="lg:w-full flex mb-4 items-center lg:ml-4 justify-between  flex-1">
                    <a href="{{ route('clubs.show', $club) }}" class="bg-green-300 p-2 px-4 block rounded-full">チーム情報</a>
                    @if (Auth::user()->isAdmin($club->id) == true)
                        <a href="{{ route('clubs.plans.create', $club) }}"
                            class="flex lg:ml-auto items-center justify-center bg-blue-300 font-extrabold text-white p-2 h-8 w-8 block rounded-full">＋</a>
                    @endif
                </div>
            </div>

            <table class="table-fixed border w-full bg-white h-full">
                <thead class="w-full">
                    <tr>
                        <th colspan="7" class="h-8">
                            <div class="flex justify-between">
                                <div class="pl-4"><a href="
                                         @if ($month !=1)
                                        {{ route('clubs.plans.index', [$club, $year, $month - 1]) }}
                                    @else
                                        {{ route('clubs.plans.index', [$club, $year - 1, 12]) }}
                                        @endif
                                        "> < </a>
                                </div>
                                <div>
                                    {{ $year . '年  ' . $month . '月' }}
                                </div>
                                <div class="pr-4"><a href="
                                         @if ($month !=12)
                                        {{ route('clubs.plans.index', [$club, $year, $month + 1]) }}
                                    @else
                                        {{ route('clubs.plans.index', [$club, $year + 1, 1]) }}
                                        @endif
                                        "> > </a></div>
                            </div>
                        </th>
                    </tr>
                    <tr class="w-full h-8">
                        @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                            <th class="border w-1/7">{{ $dayOfWeek }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dates as $date)
                        @if ($date->dayOfWeek == 0)
                            <tr class="h-28">
                        @endif
                        <td
                            class="@if ($date->month != $month) bg-gray-100 @endif border align-top"

                    >
                    {{ $date->day }}
                    @foreach ($plans as $plan)
                        @if ($plan->day() == $date->day)
                            @if ($plan->check(Auth::id()) == true || $club->isAdmin(Auth::id()) == true)
                                <a href="{{ route('clubs.plans.show', [$club, $plan]) }}">
                                    <p class="inline-block px-1 w-full bg-blue-200 truncate text-sm">{{ $plan->name }}</p>
                                </a>
                            @else
                                <p class="inline-block px-1 w-full bg-gray-200 truncate text-sm">予定あり</p>
                            @endif
                        @endif
                    @endforeach
                    </td>
                    @if ($date->dayOfWeek == 6)
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
