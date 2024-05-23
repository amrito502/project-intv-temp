<a href="{{ route('my_tree') }}?uname={{ $user->username }}">

    <img src="{{ $user->profile_image() }}" class="mb-3 mt-3" style="width: 50px;height:60px;" alt="">

    <table>
        <tr>
            <td width="80px" class="text-left">User</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">{{ $user->username }}</td>
        </tr>
        <tr>
            <td width="80px" class="text-left">Name</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">
                {{ $user->name }}
            </td>
        </tr>
        <tr>
            <td width="80px" class="text-left">Rank</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">
                {{ $user->currentRank() }}
            </td>
        </tr>
        <tr>
            <td width="80px" class="text-left">My Point</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">
                {{ $user->totalPointIncome() }}
            </td>
        </tr>
        <tr>
            <td width="80px" class="text-left">My Team</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">
                {{ $user->DownLevelMemberAllIdsWithHandCount(1) }} : {{
                $user->DownLevelMemberAllIdsWithHandCount(2) }}
                : {{ $user->DownLevelMemberAllIdsWithHandCount(3) }}
            </td>
        </tr>
        <tr>
            <td width="80px" class="text-left">Rank Points</td>
            <td width="15px">:</td>
            <td width="85px" class="text-left">
                {{ $user->downLevelAllReferWhereRankIsMemberPoint(1) }} : {{
                $user->downLevelAllReferWhereRankIsMemberPoint(2) }}
                : {{ $user->downLevelAllReferWhereRankIsMemberPoint(3) }}
            </td>
        </tr>

    </table>
</a>

