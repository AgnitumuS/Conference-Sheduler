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
                                {{ Form::datetime('start', null, array('class' => 'form-control', 'required', 'id'=>'start_datetimepicker')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('stop','Дата/время окончания') }}
                                {{ Form::datetime('stop', null, array('class' => 'form-control', 'required', 'id'=>'stop_datetimepicker')) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('description','Описание') }}
                        {{ Form::textarea('description', null, array('class' => 'form-control', 'placeholder'=>'Описание конференции')) }}
                    </div>


                    {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $.datetimepicker.setLocale('ru');


        $('#start_datetimepicker').datetimepicker({
            format: 'd.m.Y H:i',
            //yearStart: 2016,
            dayOfWeekStart: 1,
            disabledWeekDays: [0, 6],
            //allowTimes: ['08:00','8:30','9:00','9:30','10:00','10:30','11:00','11:30','12:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'],
            //minDate: new Date(),
            //minTime: new Date(),
            step: 30,
            onShow: function (ct) {
                this.setOptions({
                    maxDate: $('#stop_datetimepicker').val() ? $('#stop_datetimepicker').val() : false
                })
            },
        });

        $('#stop_datetimepicker').datetimepicker({
            format: 'd.m.Y H:i',
            //yearStart: 2016,
            dayOfWeekStart: 1,
            disabledWeekDays: [0, 6],
            //allowTimes: ['08:00','8:30','9:00','9:30','10:00','10:30','11:00','11:30','12:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'],
            //minDate: new Date(),
            //minTime: new Date(),
            step: 30,
            onShow: function (ct) {
                this.setOptions({
                    minDate: ($('#start_datetimepicker').val()) ? $('#start_datetimepicker').val() : false
                })
            },
        });
    });
</script>
@endsection