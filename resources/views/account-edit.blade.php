@extends('layouts.app')

@section('main')
    <div class="container">
        <form action="{{route('account.update', ['id' => $user->id])}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{$user->name}}">
            </div>
            <div class="form-group mb-2">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter Surname" value="{{$user->surname}}">
            </div>
            <button type="submit" class="btn btn-outline-primary">Submit</button>
            <button type="button" class="btn btn-outline-secondary">Cancel</button>
        </form>
    </div>
@endsection
