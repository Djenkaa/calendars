@extends('layouts.app')



@section('content')


    {{--  CALENDAR OPTIONS  --}}

    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-md-8 offset-md-2">

                <div class="card">
                    <div class="card-header">
                        Calendar
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Make calendar</h5>
                        <hr>

                        {{--            FORM            --}}

                        <admin
                                inline-template
                        >
                            <div id="admin">

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Izaberi firmu</label>
                                            <select class="form-control" id="exampleFormControlSelect1"
                                                    v-model="selectCompany">
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Godina</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp"
                                                   v-model="selectYear">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Izaberi mesec</label>
                                            <select class="form-control" id="exampleFormControlSelect1"
                                                    v-model="selectMonth">

                                                <option v-for="(month, index) in months" :value="index">@{{ month }}
                                                </option>
                                            </select>
                                        </div>

                                    </div>

                                </div>


                                {{--       MORE OPTIONS     --}}

                                <div class="alert alert-info" role="alert">
                                    Na poljima ispod upistie odredjenu cenu za datume.
                                    Ako ne zelite u ponudu da stavite last minute ili special offer ostavite 0 na tim
                                    poljima.
                                </div>

                                <div class="row">

                                    <div class="col-md-4">

                                        {{--        Normal      --}}
                                        <div class="form-group">
                                            <label for="normalPrice">Normal</label>
                                            <input type="text" class="form-control" id="normalPrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="freePrice">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        {{--        last minute      --}}
                                        <div class="form-group">
                                            <label for="lastMinutePrice">Last minute</label>
                                            <input type="text" class="form-control" id="lastMinutePrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="lastMinute">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        {{--        special      --}}
                                        <div class="form-group">
                                            <label for="specialPrice">Special</label>
                                            <input type="text" class="form-control" id="specialPrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="specialOffer">
                                        </div>

                                    </div>

                                </div>

                                {{--    Generate calendar   --}}
                                <button @click="generateCalendar" class="btn btn-primary">Generate Calendar</button>

                                {{--       CALENDAR     --}}

                                <div class="row mt-3" v-if="showCalendar">

                                    <div class="col-md-6">

                                        <ul id="optionList">

                                            <li><span class="fieldColor"
                                                      style="background: rgba(71, 255, 105, 0.4);"></span>
                                                <input type="radio" value="free" v-model="selectAction"> Slobodno
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(255, 71, 71,0.4);"></span>
                                                <input type="radio" value="reserved" v-model="selectAction"> Rezervisano
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(255, 224, 71, 0.4);"></span>
                                                <input type="radio" value="last" v-model="selectAction"> Last minute
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(71, 227, 255, 0.4);"></span>
                                                <input type="radio" value="special" v-model="selectAction"> Specijalna
                                                ponuda
                                            </li>
                                            <li style="margin-top: 20px;">
                                                <button v-if="daysInMonth.length > 0" @click="save"
                                                        class="btn btn-success">Save
                                                </button>
                                            </li>

                                        </ul>
                                        {{--    errors   --}}
                                        <div v-for="error in errors" class="alert alert-danger" role="alert">
                                          @{{ error }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="col-md-6">


                                        <div class="jzdbox jzdbasf jzdcal">

                                            <div class="jzdcalt">@{{ calendarMonth }} @{{ selectYear }}</div>

                                            <span v-for="day in daysInWeek">@{{day}}</span>


                                            <span class="jzdb" v-for="n in firstDay"><!--BLANK--></span>

                                            <span class="day" v-for="days in daysInMonth"
                                                  @click="modify(days.field)"
                                                  :style="{background:days.type.background}">@{{days.field}}</span>


                                        </div>

                                    </div>

                                </div>

                            </div>
                        </admin>

                    </div>
                </div>

            </div>
        </div>
    </div>






@endsection

