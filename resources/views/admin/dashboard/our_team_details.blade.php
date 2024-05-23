@extends('admin.layouts.master')

@section('custom_css')

@endsection

@section('content')

<div class="container-fluid">

    <div class="row">

        <table class="table table-bordered w-100">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Reference</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data->users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ @$user->refMember->name }} ({{ @$user->refMember->username }})</td>
                    <td>{{ $user->name }} ({{ $user->username }})</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection


@section('custom-js')

@endsection
