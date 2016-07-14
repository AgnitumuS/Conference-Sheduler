@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h5>Создать конференцию</h5></div>
                        <div class="col-md-6 "><a href="{{ url('/')}}" class="btn btn-default pull-right">Отмена</a></div>
                    </div>
                </div> 

                <div class="panel-body">
                    @include('errors.form')

                    {!! Form::open(array('url' => 'event', 'method' => 'POST')) !!}
                    {{ csrf_field() }}
                    <div class="form-group">
                        {{ Form::label('title','Название конференции') }}
                        {{ Form::text('title', '', array('class' => 'form-control', 'required')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('room','Место проведения конференции') }}
                        {{ Form::select('room', $rooms, null, ['class' => 'form-control', 'placeholder'=>' ', 'required']) }}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('start','Дата/время начала') }}
                                {{ Form::datetime('start', null, array('class' => 'form-control', 'required', 'id'=>'start_datetimepicker', 'autocomplete'=>'off')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('stop','Дата/время окончания') }}
                                {{ Form::datetime('stop', null, array('class' => 'form-control', 'required', 'id'=>'stop_datetimepicker', 'autocomplete'=>'off')) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('description','Описание') }}
                        {{ Form::textarea('description', null, array('id'=>'ckeditor','class' => 'form-control', 'placeholder'=>'Описание конференции')) }}
                    </div>


                    {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#start_datetimepicker').datetimepicker({
             locale: 'ru',
             sideBySide: true,
             daysOfWeekDisabled: [0, 6],
             enabledHours: [8, 9, 10, 11, 13, 14, 15, 16, 17, 18],
             useCurrent: true,
        });
         $('#stop_datetimepicker').datetimepicker({
            locale: 'ru',
            sideBySide: true,
            daysOfWeekDisabled: [0, 6],
            enabledHours: [8, 9, 10, 11, 13, 14, 15, 16, 17, 18],
            useCurrent: false //Important! See issue #1075
        });
        
        $("#start_datetimepicker").on("dp.change", function (e) {
            $('#stop_datetimepicker').data("DateTimePicker").minDate(e.date);
        });
        $("#stop_datetimepicker").on("dp.change", function (e) {
            $('#start_datetimepicker').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

@endsection