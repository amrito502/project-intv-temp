<tr>
    <td>1</td>
    <td>{{ @$user->placeMember->username }}</td>
    <td>{{ @$user->refMember->username }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->mobile }}</td>
    <td>{{ $user->rank }}</td>
    <td>
        {{ $user->DownLevelMemberAllIdsWithHandCount(1) }} : {{ $user->DownLevelMemberAllIdsWithHandCount(2) }}
        : {{ $user->DownLevelMemberAllIdsWithHandCount(3) }}
    </td>
    <td>
        {{ $user->downLevelAllReferWhereRankIsMemberPoint(1) }} : {{ $user->downLevelAllReferWhereRankIsMemberPoint(2) }}
        : {{ $user->downLevelAllReferWhereRankIsMemberPoint(3) }}
    </td>
    {{-- <td>
        {{ $user->status == 1 ? "Active" : "InActive" }}
    </td> --}}
</tr>
