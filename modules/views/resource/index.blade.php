@extends('l.base')

@section('title'){{ $init['title'] }} @stop

@section('beforeStyle')
    {{ style('bootstrap-3.0.3') }}
@stop

@section('style')
body
{
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #eee;
}
@parent @stop

@section('container')

    @include('w.navbarAdmin', array('active'=>'posts'))

    <div class="container panel" style="margin-top:2em;padding:1em;">

        @include('w.notification')

        <h3>
            {{ $init['title'] }}
            <div class="pull-right">
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                    添加新文章
                </a>
            </div>
        </h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        @foreach($init['table'] as $key=>$value)
                        <th>{{ $key }}</th>
                        @endforeach
                        <th>创建时间</th>
                        <th style="width:7em;text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                    <tr>
                        @foreach($init['table'] as $key=>$value)
                        <td>{{ $data->$value }}</td>
                        @endforeach
                        <td>{{ $data->created_at }}（{{ $data->friendly_created_at }}）</td>
                        <td>
                            <a href="{{ route('categories.edit', $data->id) }}" class="btn btn-xs">编辑</a>
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger"
                                 onclick="modal('{{ route('categories.destroy', $data->id) }}')">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pull-right" style="">
            {{ pagination($datas, 'p.slider-3') }}
        </div>

    </div>
    
<?php
$modalData['modal'] = array(
    'id'=>'myModal',
    'title'=>'系统提示',
    'message'=>'确认删除此文章？',
    'footer'=>
'
    <form id="real-delete" action="" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="DELETE" />
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-sm btn-danger">确认删除</button>
    </form>
',
        );
?>
    @include('w.modal', $modalData)

@stop


@section('end')
    {{ script(array('jquery-1.10.2', 'bootstrap-3.0.3')) }}
    <script>
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
    </script>
@stop
