@extends('layouts.app')



@section('content')

    <admin
            inline-template
    >
        <div id="admin">

            <div class="form-group">
                <label for="exampleFormControlSelect1">Izaberi firmu</label>
                <select class="form-control" id="exampleFormControlSelect1" v-model="selectCompany">
                    @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Godina</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       v-model="selectYear">
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Izaberi mesec</label>
                <select class="form-control" id="exampleFormControlSelect1" v-model="selectMonth">

                    <option v-for="(month, index) in months" :value="index">@{{ month }}</option>
                </select>
            </div>

            {{--       MORE OPTIONS     --}}
            <p class="showOption">Dodatne opcije</p>

            <div class="mb-4 moreOptions" style="display: none;">
                <input type="text" placeholder="last minute price" v-model="lastMinute">
                <input type="text" placeholder="special offer price" v-model="specialOffer">
            </div>

            <button @click="generateCalendar" class="btn btn-primary">Generate Calendar</button>
            <button @click="save" class="btn btn-success">Save</button>

            {{--       CALENDAR     --}}

            <div v-if="showCalendar" class="col-md-4 mt-5">

                <div class="jzdbox jzdbasf jzdcal">

                    <div class="jzdcalt">@{{ calendarMonth }} @{{ selectYear }}</div>

                    <span v-for="day in daysInWeek">@{{day}}</span>


                    <span class="jzdb" v-for="n in firstDay">
        <!--BLANK--></span>

                    <span class="day" v-for="days in daysInMonth" @click="modify(days.field)"
                          :style="{background:days.type.background}">@{{days.field}}</span>


                </div>

            </div>

            <div v-if="showCalendar">
                <input type="radio" value="free" v-model="selectAction"> Dostupno
                <input type="radio" value="busy" v-model="selectAction"> Zauzeto
                <input type="radio" value="last" v-model="selectAction"> Last minute
                <input type="radio" value="special" v-model="selectAction"> Special
            </div>

        </div>
    </admin>

@endsection

@section('myJs')

    <script>

        $('.showOption').click(function () {
           $('.moreOptions').toggle();
        });

    </script>

    @endsection
