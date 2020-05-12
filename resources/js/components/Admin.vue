<template>

</template>

<script>
    export default {
        name: "Admin",

        data() {
            return {
                daysInWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                selectCompany: 2,
                selectYear: new Date().getFullYear(),
                selectMonth: new Date().getMonth(),
                lastMinute: 0,
                specialOffer: 0,
                freePrice: 0,
                showCalendar: false,
                daysInMonth: [],
                firstDay: 0,
                calendarMonth: '',
                selectAction: '',
                error: '',
                createError: '',
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
                    {
                        type: 'unavailable',
                        background: 'rgba(255, 136, 0, 0.4)'
                    },
                ]
            }
        },

        methods: {
            generateCalendar() {

                if (this.freePrice < 1 || !this.freePrice) {
                    this.createError='You have to fill free field';
                    return;
                }

                var days = 32 - (new Date(this.selectYear, this.selectMonth, 32).getDate());
                var firstDay = new Date(this.selectYear, this.selectMonth).getDay();

                this.daysInMonth = [];
                for (var i = 1; i <= days; i++) {

                    let date = {
                        field: i,
                        type: {
                            status: 'free',
                            background: 'rgba(71, 255, 105,0.4)',
                            price: this.freePrice

                        }
                    };
                    this.daysInMonth.push(date);
                }
                if (days) {
                    this.calendarMonth = this.months[this.selectMonth];
                    this.showCalendar = true;
                    this.firstDay = firstDay;
                }
            },

            setPrice(action) {

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
                    this.error='You have to select some date type';
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
                    companyId: this.selectCompany,
                    free: this.freePrice,
                    lastMinute: this.lastMinute,
                    special: this.specialOffer
                })
                    .then(data => {

                        if (data.data == 'success') {
                            location.reload();
                        } else if (data.data.error) {
                            this.error=data.data.error;
                        }

                    }).catch(e => {

                    this.createError = e.response.data.message;
                    setTimeout(() => {
                        this.createError = '';
                    }, 4000);
                });
            }
        }
    }
</script>

<style scoped>

</style>