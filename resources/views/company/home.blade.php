@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <a href="{{ route('admin.company.create') }}" class="btn btn-primary float-right">Add Company</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>
                <div class="card-body">
                    <div class="float-right">{{ $Companies->links() }}</div>
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>Logo</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($Companies) > 0)
                                @foreach($Companies as $Company)
                                    <tr>
                                        <td>{{$Company->name}}</td>
                                        <td>{{$Company->email}}</td>
                                        <td>{{$Company->website}}</td>
                                        <td>
                                            <img class="img-thumbnail" style="max-width: 10rem" src="{{ url('storage/Company/'.$Company->logo)}}" alt="{{$Company->logo}}">
                                        </td>
                                        <td>{{$Company->addedByAdmin->name}}</td>
                                        <td>
                                            <a href="{{route('admin.company.edit', ['id' => $Company->id])}}" class="btn btn-info" title="Edit Company">Edit</a>
                                            <a href="{{ route('admin.company.delete', ['id' => $Company->id]) }}" class="btn btn-danger" title="Edit Company">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="6" class="text-center text-danger">No Company Found</td>
                            @endif
                        </tbody>
                    </table>
                    <div class="float-right">{{ $Companies->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
