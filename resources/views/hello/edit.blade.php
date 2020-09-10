@extends('layouts/helloapp')
@section('title', 'Edit')
@section('menubar')
    @parent
    更新ページ
@endsection

@section('content')
    <form action="edit" method="post">
        <table>
            @csrf
            <input type="hidden" name="id" value="{{$form->id}}">
            <th>Name: </th>
            <td><input type="text" name="name" value="{{$form->name}}"></td>
            <th>Mail: </th>
            <td><input type="text" name="mail" value="{{$form->mail}}"></td>
            <th>Age: </th>
            <td><input type="text" name="age" value="{{$form->age}}"></td>
            <th></th>
            <td><input type="submit" value="send"></td>
        </table>
    </form>
@endsection

@section('footer')
copyright 2020 tuyano
@endsection