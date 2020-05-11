@extends('layouts.app')


@section('content')

    <example-component
            companies="{{$companies}}"
            inline-template
    >

        <div class="container" v-cloak>

            <div class="row mt-5 card" v-for="company in firms">

                <div class="col-md-12">

                    <h2><img height="50" width="50" :src="company.image" alt=""> @{{company.name}}
                    </h2>

                    <p class="text-muted text-center mt-2">{{__('welcome.nights')}}</p>
                    <!--           CALENDARS             -->
                    <div class="row flex-nowrap calendarWrap" style="height: 400px; overflow-x:scroll;">

                        <div class="col-md-4" v-for="calendar in company.current_year">

                            <div @click="reservation(calendar.id)" class="jzdbox jzdbasf jzdcal">

                                <div class="jzdcalt"> @{{months[calendar.month]}} @{{calendar.year}}</div>

                                <span v-for="day in daysInWeek">@{{day}}</span>


                                <span class="jzdb" v-for="blank in calendar.firstDay">
                <!--BLANK--></span>

                                <span class="day" v-for="(date,index) in JSON.parse(calendar.dates)"
                                      :style="{background: paintField(index + 1, JSON.parse(calendar.dates))}"
                                >
                             @{{date.field}}
                                </span>


                            </div>

                        </div>
                    </div>

                </div>

            </div>


            <!-- MODAL FOR CALENDAR -->
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-4">
                        <h2>{{__('appTerms.reservation')}}</h2>
                        <hr>

                        <!--       TYPE OF FIELD         -->

                        <div class="row">

                            <div class="col-md-6">

                                <ul id="optionList">

                                    <li>
                                    <span class="typeOfField">
                                        <span class="fieldColor" style="background:rgba(71, 255, 105, 0.4);"></span>
                                        {{__('appTerms.free')}} @{{cal.free + '€'}}</span>
                                    </li>

                                    <li>
                                    <span class="typeOfField">
                                        <span class="fieldColor" style="background:rgba(255, 71, 71,0.4);"></span>
                                        {{__('appTerms.reserved')}} </span>

                                    </li>

                                    <li>
                                    <span class="typeOfField">
                                        <span class="fieldColor" style="background: rgba(71, 227, 255, 0.4);"></span>
                                        {{__('appTerms.special')}} @{{cal.special ? cal.special + '€' : ''}}</span>
                                    </li>

                                    <li>
                                    <span class="typeOfField">
                                        <span class="fieldColor" style="background: rgba(255, 224, 71, 0.4);"></span>
                                        {{__('appTerms.last')}} @{{cal.lastMinute ? cal.lastMinute + '€' : ''}}</span>
                                    </li>

                                </ul>

                                <!--    BOOKING DETAILS   -->
                                <div class="bookingDetails" v-if="user.userDates.length >= 3">

                                    <p class="priceAndPeriod">@{{user.period}}
                                        <span class="float-right" style="font-size: 18px;">@{{user.price}}€</span>
                                    </p>

                                    {{--    ERROR   --}}
                                    <div v-if="reservationError" class="alert alert-danger alert-dismissible fade show" role="alert">
                                            @{{ reservationError }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>


                                    <div class="form-group">
                                        <label for="fullName">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" v-model="user.fullName">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Telefon</label>
                                        <input type="text" class="form-control" id="phone" v-model="user.phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" v-model="user.email">
                                    </div>

                                    <button class="btn btn-primary"
                                            @click="sendReservation(cal.id)">{{__('buttons.reserve')}}</button>
                                    <button class="btn btn-danger"
                                            @click="reset(cal.id)">{{__('buttons.restart')}}</button>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <!--           CALENDAR         -->
                                <div class="jzdbox jzdbasf jzdcal">

                                    <div class="jzdcalt"> @{{months[cal.month]}} @{{cal.year}}</div>

                                    <span v-for="day in daysInWeek">@{{day}}</span>


                                    <span class="jzdb" v-for="n in cal.firstDay">
                                <!--BLANK--></span>

                                    <span class="day" v-for="(date, index) in dates"
                                          @click="reserve(date.field, cal.id)"
                                          :style="{background: paintField(index + 1, dates)}">
                            @{{date.field}}
                        </span>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </example-component>

@endsection


