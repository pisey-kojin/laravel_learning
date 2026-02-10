<!--
    ＊extends：親ビューを継承する（読み込み）
    ＊親ビュー名：layoutを指定
-->
@extends('layout')

<!--
    content：子ビューにsectionをデータを定義する
    セクション名：contentを指定する
    目的：フォルダ追加するページのHTMLを表示する

-->
@section('content')    
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">フォルダを編集する</div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        @endif
                        
                        <form action="{{ route('folders.edit', ['id' => $folder_id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">フォルダ名</label>
                                <input type="text" class="form-control" name="title" id="title" value = "{{ old('title') ?? $folder_title }}"/>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('tasks.index', ['id' => $folder_id]) }}'">キャンセル</button>
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection