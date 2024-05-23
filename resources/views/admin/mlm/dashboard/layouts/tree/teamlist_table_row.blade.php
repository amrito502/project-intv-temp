<tr>
    <td>{{ $data->counter++ }}</td>
    <td>{{ @$user->refMember->username }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->mobile }}</td>
    <td>{{ $user->currentRank() }}</td>
    <td>{{ $user->totalPointIncome() }}</td>
    <td>
        <button class="btn btn-sm btn-block btn-primary" id="show_handcount_btn{{ $user->id }}" onclick="showHandCount('{{ $user->id }}')">Show</button>
        <p id="handcount_{{ $user->id }}"></p>
    </td>
    <td>
        <button class="btn btn-sm btn-block btn-primary" id="show_rankpoint_btn{{ $user->id }}" onclick="showRankPointCount('{{ $user->id }}')">Show</button>
        <p id="rankpoint_{{ $user->id }}"></p>
    </td>
    {{-- <td>
        {{ $user->status == 1 ? "Active" : "InActive" }}
    </td> --}}
</tr>
