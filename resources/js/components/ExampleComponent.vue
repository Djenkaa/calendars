<template>

    <div class="container">

        <div class="row mt-5 card" v-for="company in firms">

            <div class="col-md-12">

                <h2><img height="50" width="50" :src="company.image" alt=""> {{company.name}}
                </h2>


                <!--           CALENDARS             -->
                <div class="row">

                    <div class="col-md-4" v-for="calendar in company.current_year">

                        <div @click="reservation(calendar.id)" class="jzdbox jzdbasf jzdcal">

                            <div class="jzdcalt"> {{months[calendar.month]}} {{calendar.year}}</div>

                            <span v-for="day in daysInWeek">{{day}}</span>


                            <span class="jzdb" v-for="blank in calendar.firstDay">
                <!--BLANK--></span>

                            <span class="day" v-for="(date,index) in JSON.parse(calendar.dates)"
                                :style="{background: paintField(index + 1, JSON.parse(calendar.dates))}"
                            >
                             {{date.field}}
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
                    <h2>Napravite vasu rezervaciju!</h2>
                    <hr>

                    <!--       TYPE OF FIELD         -->

                    <div class="row">
                        <span class="typeOfField"> <span class="fieldColor rounded-circle"
                                                         style="background:#749d9e"></span> Free</span>
                        <span class="typeOfField"><span class="fieldColor rounded-circle" style="background:red"></span> Reserved</span>
                        <span class="typeOfField"><span class="fieldColor rounded-circle"
                                                        style="background:blue"></span> Special Offer</span>
                        <span class="typeOfField"><span class="fieldColor rounded-circle"
                                                        style="background:yellow"></span> Last minute offer</span>
                    </div>

                    <!--           CALENDAR         -->
                    <div class="jzdbox jzdbasf jzdcal">

                        <div class="jzdcalt"> {{months[cal.month]}} {{cal.year}}</div>

                        <span v-for="day in daysInWeek">{{day}}</span>


                        <span class="jzdb" v-for="n in cal.firstDay">
                <!--BLANK--></span>

                        <span class="day" v-for="date in dates" @click="reserve(date.field)"
                              :style="{background: date.type.background}">
                            {{date.field}}
                        </span>


                    </div>
                    <br>

                    <!--          USER DATA          -->
                    <input type="text" placeholder="full name" v-model="user.fullName">
                    <input type="text" placeholder="phone" v-model="user.phone">
                    <button class="btn btn-primary" @click="sendReservation(cal.id)">Reserve</button>

                </div>
            </div>
        </div>
    </div>


</template>

<script>

    export default {

        data() {
            return {
                daysInWeek: ['Ne', 'Po', 'Ut', 'Sr', 'Ce', 'Pe', 'Su'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
                firms: JSON.parse(this.companies),
                cal: '',
                dates: '',
                user: {
                    userDates: [],
                    fullName: '',
                    phone: '',
                }
            }
        },

        props: ['companies'],

        methods: {

            reservation(calendarId) {

                axios.get('/calendar/show/' + calendarId)
                    .then(data => {
                        console.log(data.data);

                        this.cal = data.data;
                        this.dates = JSON.parse(data.data.dates);
                        $('.modal').modal('show');
                    })
                    .catch(e => {
                        console.log(e);
                    });

            },

            availableFields(field) {

                var count = field;

                for (var i = 0; i < this.dates.length; i++) {

                    if (this.dates[i].type.status == 'free') {
                        this.dates[i].type.status = 'unavailable';
                        this.dates[i].type.background = '#FF8A75';
                    }
                }
                if (field != this.dates.length) {

                    var possibleField = this.dates.find(el => {
                        return el.field == count + 1;
                    });

                    while (possibleField.type.status == 'busy') {
                        count++;

                        possibleField = this.dates.find(el => {
                            return el.field == count + 1;
                        });
                    }
                    possibleField.type.status = 'free';
                    possibleField.type.background = '';
                }
            },

            reserve(field) {

                var searchDate = this.dates.find(el => {
                    return el.field == field
                });

                if (searchDate.type.status == 'busy' || searchDate.type.status == 'unavailable') {
                    return;
                }

                this.availableFields(field);

                searchDate.type.status = 'busy';
                searchDate.type.background = 'rgba(255,255,255, 0.3)';

                this.user.userDates.push(field);

            },

            sendReservation(calendarId) {

                axios.post('/calendar/reserve', {
                    calendarId,
                    dates: this.user.userDates,
                    fullName: this.user.fullName,
                    phone: this.user.phone

                })
                    .then(data => {
                        console.log(data.data);
                    }).catch(e => {
                    console.log(e);
                });
            },

            paintField(index, fields){

              var field = fields.find(el=>{
                  return  el.field == index;
              });
              console.log(field);

              var nextField = fields.find(el=>{
                 return el.field == index +1;
              });

              if(nextField){
                  if(field.type.background != nextField.type.background){
                      return  'linear-gradient(to right bottom, '+field.type.background+' 50%, '+nextField.type.background+' 50%)';

                  }
              }
                  return field.type.background;
            }

        },

        mounted() {

        }

    }
</script>


<style scoped>

    @import url(https://fonts.googleapis.com/css?family=Fjalla+One:400|Roboto:400,400italic,700);

    body {
        background-color: #282423;
    }

    .card {
        background: white;
        border: 1px solid #eee;
        box-shadow: 0px 0px 10px #ccc;
        padding: 10px;
    }

    .jzdbox {
        width: 315px;
        background: #332f2e;
        border-radius: 5px;
        overflow: hidden;
        display: block;
        margin-bottom: 10px;
        box-shadow: 0 0 10px #201d1c;
        margin: 0 auto;
        margin-top: 20px;
    }

    .jzdcal {
        padding: 0 10px 10px 10px;
        box-sizing: border-box !important;
        background: #749d9e;
        background: -webkit-linear-gradient(#749d9e, #b3a68b) !important;
        background: -o-linear-gradient(#749d9e, #b3a68b) !important;
        background: -moz-linear-gradient(#749d9e, #b3a68b) !important;
        background: linear-gradient(#749d9e, #b3a68b) !important;
    }

    .jzdcalt {
        font: 18px 'Roboto';
        font-weight: 700;
        color: #f7f3eb;
        display: block;
        margin: 18px 0 0 0;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: 1px;
    }

    .jzdcal span {
        font: 11px 'Roboto';
        font-weight: 400;
        color: #f7f3eb;
        text-align: center;
        width: 42px;
        height: 42px;
        display: inline-block;
        float: left;
        overflow: hidden;
        line-height: 40px;
    }

    .jzdcal .jzdb:before {
        opacity: 0.3;
        content: 'o';
    }

    .circle {
        border: 1px solid #f7f3eb;
        box-sizing: border-box !important;
        border-radius: 200px !important;
    }

    span[data-title]:hover:after,
    div[data-title]:hover:after {
        font: 11px 'Roboto';
        font-weight: 400;
        content: attr(data-title);
        position: absolute;
        margin: 0 0 100px;
        background: #282423;
        border: 1px solid #f7f3eb;
        color: #f7f3eb;
        padding: 5px;
        z-index: 9999;
        min-width: 150px;
        max-width: 150px;
    }

    .jzdbox .day {
        cursor: pointer;
    }

    .typeOfField {
        margin-left: 20px;
    }

    .fieldColor {
        display: inline-block;
        width: 20px;
        height: 20px;
    }

</style>