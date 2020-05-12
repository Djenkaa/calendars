<template>

</template>

<script>

    export default {

        data() {
            return {
                daysInWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                firms: JSON.parse(this.companies),
                cal: '',
                dates: '',
                user: {
                    userDates: [],
                    fullName: '',
                    phone: '',
                    email: '',
                    price: 0,
                    period: ''
                },
                reservationError:''
            }
        },

        props: ['companies'],

        methods: {

            // reservation
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

            // available fields
            availableFields(field) {

                var count = field;

                for (var i = 0; i < this.dates.length; i++) {

                    if (this.dates[i].type.status == 'free' || this.dates[i].type.status == 'last' ||
                        this.dates[i].type.status == 'special') {

                        this.dates[i].type.status = 'notAllowed';
                        this.dates[i].type.background = '#FF8A75';
                    }
                }

                var possibleField = this.dates.find(el => {
                    return el.field == count + 1;
                });

                if (!possibleField || possibleField.type.status == 'reserved') {
                    return;
                }

                possibleField.type.status = 'free';
                possibleField.type.background = 'rgba(255,255,255, 0.3)';
            },

            // reserve
            reserve(field, calendarId) {

                var searchDate = this.dates.find(el => {
                    return el.field == field
                });

                if (searchDate.type.status == 'reserved' || searchDate.type.status == 'notAllowed'
                    || searchDate.type.status == 'unavailable') {
                    return;
                }

                this.availableFields(field);

                searchDate.type.status = 'reserved';
                searchDate.type.background = 'rgba(255,255,255, 0.3)';

                this.user.userDates.push(field);

                axios.post('/calendar/price', {
                    dates: this.user.userDates,
                    calendarId

                })
                    .then(data => {

                        this.user.price = data.data.price.toFixed(2);
                        this.user.period = data.data.period;
                    })
                    .catch(e => {

                    });
            },


            // send reservation
            sendReservation(calendarId) {

                axios.post('/calendar/reserve', {
                    calendarId,
                    dates: this.user.userDates,
                    fullName: this.user.fullName,
                    email: this.user.email,
                    phone: this.user.phone,
                    price: this.user.price

                })
                    .then(data => {

                        if(data.data == 'success'){
                            location.reload();
                        }

                    }).catch(e => {
                        this.reservationError = e.response.data.message;
                        setTimeout(()=>{
                            this.reservationError = '';
                        }, 4000);
                });
            },

            // field background
            paintField(index, fields) {

                var field = fields.find(el => {
                    return el.field == index;
                });

                var lastField = fields.find(el => {
                    return el.field == index - 1;
                });

                if (lastField) {
                    return 'linear-gradient(to right bottom, ' + lastField.type.background + ' 50%, ' + field.type.background + ' 50%)';
                }
                return field.type.background;
            },

            reset(id) {
                this.reservation(id);
                this.user.userDates = [];
            }


        },

        mounted() {

        }

    }
</script>


<style scoped>


</style>