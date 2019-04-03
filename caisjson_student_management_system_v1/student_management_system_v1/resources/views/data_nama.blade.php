@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">DATA NAMA</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    INI HALAMAN DATA NAMA

  <br><br>

                    @foreach($datas as $key=> $data)
                      {{$data->email}} <br>
                      {{$data->name}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
