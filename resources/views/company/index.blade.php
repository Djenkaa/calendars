@extends('layouts.app')



@section('content')


    {{--  CALENDAR OPTIONS  --}}

    <div class="container" v-cloak>
        <div class="row mt-5 mb-5">
            <div class="col-md-8 offset-md-2">

                <div class="card">
                    <div class="card-header">
                        {{__('appTerms.calendar')}}
                    </div>
                    <div class="card-body">


                        <h5 class="card-title">{{__('admin.create')}}</h5>
                        <hr>

                        {{--            FORM            --}}

                        <admin
                                inline-template
                        >
                            <div id="admin">

                                {{--   ERROR  --}}
                                <div v-if="createError" class="alert alert-danger" role="alert">
                                        @{{ createError }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">{{__('admin.selectCompany')}}</label>
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
                                            <label for="exampleInputEmail1">{{__('admin.selectYear')}}</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp"
                                                   v-model="selectYear">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">{{__('admin.selectMonth')}}</label>
                                            <select class="form-control" id="exampleFormControlSelect1"
                                                    v-model="selectMonth">

                                                <option v-for="(month, index) in months" :value="index">@{{ month }}
                                                </option>
                                            </select>
                                        </div>

                                    </div>

                                </div>


                                {{--       MORE OPTIONS     --}}

                                <h6>{{__('admin.dateType')}}
                                    <small>({{__('admin.dateTypeAtt')}})</small>
                                </h6>
                                <hr>

                                <div class="row">

                                    <div class="col-md-4">

                                        {{--        Normal      --}}
                                        <div class="form-group">
                                            <label for="normalPrice">{{__('appTerms.free')}}</label>
                                            <input type="text" class="form-control" id="normalPrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="freePrice">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        {{--        last minute      --}}
                                        <div class="form-group">
                                            <label for="lastMinutePrice">{{__('appTerms.last')}}</label>
                                            <input type="text" class="form-control" id="lastMinutePrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="lastMinute">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        {{--        special      --}}
                                        <div class="form-group">
                                            <label for="specialPrice">{{__('appTerms.special')}}</label>
                                            <input type="text" class="form-control" id="specialPrice"
                                                   aria-describedby="emailHelp"
                                                   v-model="specialOffer">
                                        </div>

                                    </div>

                                </div>

                                {{--    Generate calendar   --}}
                                <button @click="generateCalendar"
                                        class="btn btn-primary">{{__('buttons.generate')}}</button>

                                {{--       CALENDAR     --}}

                                <div class="row mt-3" v-if="showCalendar">

                                    <div class="col-md-6">

                                        <ul id="optionList">

                                            <li><span class="fieldColor"
                                                      style="background: rgba(71, 255, 105, 0.4);"></span>
                                                <input type="radio" value="free"
                                                       v-model="selectAction"> {{__('appTerms.free')}}
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(255, 71, 71,0.4);"></span>
                                                <input type="radio" value="reserved"
                                                       v-model="selectAction"> {{__('appTerms.reserved')}}
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(255, 224, 71, 0.4);"></span>
                                                <input type="radio" value="last"
                                                       v-model="selectAction"> {{__('appTerms.last')}}
                                            </li>

                                            <li><span class="fieldColor"
                                                      style="background: rgba(71, 227, 255, 0.4);"></span>
                                                <input type="radio" value="special"
                                                       v-model="selectAction"> {{__('appTerms.special')}}
                                            </li>
                                            <li><span class="fieldColor"
                                                      style="background: rgba(255, 136, 0, 0.4)"></span>
                                                <input type="radio" value="unavailable"
                                                       v-model="selectAction"> {{__('appTerms.unavailable')}}
                                            </li>
                                            <li style="margin-top: 20px;">
                                                <button v-if="daysInMonth.length > 0" @click="save"
                                                        class="btn btn-success">{{__('buttons.save')}}
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

