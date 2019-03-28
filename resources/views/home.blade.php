@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route('shorten.store')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">sk.sh this URL</span>
                                <input type="url" name="url" class="form-control" placeholder="url">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Go!</button>
                            </span>
                            </div>
                        </form>
                        <hr/>

                        <h2>My URLS:</h2>


                        <ul class="list-group">
                            @foreach(auth()->user()->urls as $url)
                                <li class="list-group-item"><b>{{url('')}}/{{$url->short_url_slug}}</b> points to {{$url->original_url}}</li>

                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
