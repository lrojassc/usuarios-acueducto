@extends('layouts.layout')

@section('title', 'Usuarios')

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Número de documento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Dirección</th>
                <th scope="col">Acción</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->document_number}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>{{$user->address}}</td>
                    <td><a href="{{ route('user.show', $user->id) }}">VER</a></td>
                    <td><a href="{{ route('user.edit', $user->id) }}">EDITAR</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="import_file_users">
            <button class="btn btn-primary">Importar</button>
        </form>
    </div>
@endsection
