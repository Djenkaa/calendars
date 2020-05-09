<template>

</template>

<script>
    export default {
        name: "Admin",

        data() {
            return {
                daysInWeek: ['Ne', 'Po', 'Ut', 'Sr', 'Ce', 'Pe', 'Su'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
                selectCompany: 2,
                selectYear: new Date().getFullYear(),
                selectMonth: new Date().getMonth(),
                lastMinute: 0,
                specialOffer: 0,
                freePrice:0,
                showCalendar: false,
                daysInMonth: [],
                firstDay: 0,
                calendarMonth: '',
                selectAction: '',
                actions: [
                    {
                        type: 'free',
                        background: 'rgba(71, 255, 105, 0.4)'
                    },
                    {
                        type: 'reserved',
                        background: 'rgba(255, 71, 71,0.4)'
                    },
                    {
                        type: 'special',
                        background: 'rgba(71, 227, 255, 0.4)'
                    },
                    {
                        type: 'last',
                        background: 'rgba(255, 224, 71, 0.4)'
                    },
                ]


            }
        },

        methods: {
            generateCalendar() {

                var days = 32 - (new Date(this.selectYear, this.selectMonth, 32).getDate());
                var firstDay = new Date(this.selectYear, this.selectMonth).getDay();

                this.daysInMonth = [];
                for (var i = 1; i <= days; i++) {

                    let date = {
                        field: i,
                        type: {
                            status: 'free',
                            background: 'rgba(71, 255, 105,0.4)',
                            price:this.freePrice

                        }
                    };
                    this.daysInMonth.push(date);
                }

                if (days) {
                    // this.daysInMonth = days;
                    this.calendarMonth = this.months[this.selectMonth];
                    this.showCalendar = true;
                    this.firstDay = firstDay;

                }

            },

            setPrice(action){

                var price = 0;

                switch (action.type) {

                    case 'free':
                        price = this.freePrice;
                        break;

                    case 'special':
                        price = this.specialOffer;
                        break;

                    case 'last':
                        price = this.lastMinute;
                        break;
                }
                return price;
            },

            modify(field) {

                if (!this.selectAction) {
                    console.log('moras izabrati neku akciju!');
                    return;
                }

                var search = this.actions.find(el => {
                    return el.type == this.selectAction;
                });



                var searchField = this.daysInMonth.find(el => {
                    return el.field == field;
                });


                searchField.type.status = search.type;
                searchField.type.background = search.background;
                searchField.type.price = this.setPrice(search);
            },
            save() {

                axios.post('/calendar/store', {
                    year: this.selectYear,
                    month: this.selectMonth,
                    dates: this.daysInMonth,
                    firstDay: this.firstDay,
                    companyId: this.selectCompany
                })
                    .then(data => {
                        location.reload();

                    }).catch(e => {
                    console.log(e);
                });
            }
        }
    }
</script>

<style scoped>
    @import url(https://fonts.googleapis.com/css?family=Fjalla+One:400|Roboto:400,400italic,700);

    body {
        background-color: #282423;
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
        margin-top: 100px;
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
        border: 1px solid rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    .jzdbox .day:hover {
        background: rgba(255, 255, 255, 0.6);
        color: black;
    }

</style>