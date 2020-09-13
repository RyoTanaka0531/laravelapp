<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Person;

class HelloController extends Controller
{
    public function index(Request $request)
    {
        // sortの値を変数に取り出し、orderByの引数に指定している。
        // こうすることでクエリー文字列としてsort=〇〇と渡されたフィールド名でレコードを並べ替えれる。
        $sort = $request->sort;
        // $items = DB::table('people')->orderBy('age', 'asc')->simplePaginate(5);
        $items = Person::orderBy($sort, 'asc')->paginate(5);
        $param = ['items' => $items, 'sort' => $sort];
        return view('hello.index', $param);
    }

    public function post(Request $request)
    {
        $validate_rule = [
            'msg' => 'required',
        ];
        $this->validate($request, $validate_rule);
        $msg = $request->msg;
        $response = response()->view('hello.index', ['msg' => '「' . $msg . '」をクッキーに保存しました。']);
        $response->cookie('msg', $msg, 100);
        return $response;
    }

    public function add(Request $request)
    {
        return view('hello.add');
    }

    public function create(Request $request)
    {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::table('people')->insert($param);
        return redirect('hello');
    }

    public function edit(Request $request)
    {
        $item = DB::table('people')->where('id', $request->id)->first();
        // 'form' => $item[0]は配列の要素の「n番目」を出力を定義している。今回は「id」を参照するので、配列の「０番目」であり、それを指定。
        return view('hello.edit', ['form' => $item]);
    }

    public function update(Request $request)
    {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        $item = DB::table('people')->where('id', $request->id)->update($param);
        return redirect('hello');
    }

    public function del(Request $request)
    {
        $param = ['id' => $request->id];
        $item = DB::select('select * from people where id = :id', $param);
        return view('hello.del', ['form' => $item[0]]);
    }

    public function remove(Request $request)
    {
        DB::table('people')->where('id', $request->id)->delete();
        return redirect('hello');
    }

    public function show(Request $request)
    {
        $page = $request->page;
        $items = DB::table('people')
        ->offset($page * 3)
        ->limit(3)
        ->get();
        return view('hello.show', ['items' => $items]);
    }

    public function rest(Request $request)
    {
        return view('hello.rest');
    }

    public function ses_get(Request $request)
    {
        // 入力されたセッションデータの名前を指定して値を取得する。
        $sesdata = $request->session()->get('msg');
        return view('hello.session', ['session_data' => $sesdata]);
    }

    public function ses_put(Request $request)
    {
        // 入力された値を$msgという変数に代入
        $msg = $request->input;
        // 値に名前をつけて保存する。
        $request->session()->put('msg', $msg);
        return redirect('hello/session');
    }
}