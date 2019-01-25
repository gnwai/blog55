@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <textarea class="form-control wait-send" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary pull-right"
                                role="button" id="send2">发送
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src='http://cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script src="{{asset('js/ws.js')}}"></script>
