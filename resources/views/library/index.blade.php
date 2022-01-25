@extends("layouts.dashboard")
@section("title","Library")
@section("content")

<link rel="stylesheet" href="{{asset('/css/library/library.css')}}">


@include('library.helpers.history')
@include('library.helpers.borrow')
@include('library.helpers.return')


<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="tblLibrary" class="table table-hover">
                        <thead>
                            <th>Book</th>
                            <th>Category</th>
                            <th>Published date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($books as $b)
                            <tr>
                                <td>{{$b->name}}</td>
                                <td class="text-center">{{$b->bookCategory->name}}</td>
                                <td class="text-center">{{$b->publication_date}}</td>
                                <td class="text-center">
                                    @if($b->user_id == NULL)
                                    <strong class="text-success">In library</strong>
                                    @else
                                    <strong>Borrowed to {{$b->bookUser->name}}</strong>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn-link {{($b->user_id==NULL) ? 'text-success btnBorrow' : 'text-danger btnReturn'}}" data-bs-target="#{{($b->user_id == NULL) ? 'mdlBorrow' : 'mdlReturn'}}" data-bs-toggle="modal" data-id="{{($b->user_id == NULL) ? $b->id : $b->bookLibrary[0]->id }}" title="{{($b->user_id == NULL) ? 'Borrow book' : 'Return book' }}" data-info="{{$b}}">@if($b->user_id==NULL)<i class="fas fa-sign-out-alt"></i>@else<i class="fas fa-sign-in-alt"></i>@endif</a>
                                    <a href="#" class="btn-link text-secondary btnHistory" data-bs-target="#mdlHistory" data-bs-toggle="modal" data-history="{{$b}}" title="Book history"><i class="fas fa-th-list"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('/js/library/library.js')}}"></script>

@endsection
