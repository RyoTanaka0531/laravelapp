@extends('layouts/helloapp')
@section('title', 'Delete')
@section('menubar')
    @parent
    削除ページ
@endsection

@section('content')
    <form action="del" method="post">
        <table>
            @csrf
            <input type="hidden" name="id" value="{{$form->id}}">
            <th>name: </th>
            <td><input type="text" name="name" value="{{$form->name}}"></td>
            <th>mail: </th>
            <td><input type="text" name="mail" value="{{$form->mail}}"></td>
            <th>age: </th>
            <td><input type="text" name="age" value="{{$form->age}}"></td>
            <th></th>
            <td><input type="submit" value="delete"></td>
        </table>
    </form>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection