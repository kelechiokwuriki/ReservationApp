<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Reservation</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">


                            </div>

                            <div class="col-sm-4">
                                   <form>
                            <div class="form-group">
                                <label>User IDs (type the id separated by a comma)</label>
                                 <input type="text" class="form-control" v-model.trim="reservation.userIds" />
                                 <small class="text-danger" v-show="reservation.userIds !== null">User IDs must exist in the database</small>
                            </div>

                             <div class="form-group">
                                <label>When is the reservation?</label>
                                <input type="datetime-local" v-model="reservation.reservationDateTime" class="form-control" />
                            </div>

                        </form>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-success" @click="submitReservation">Submit Reservation</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                reservation: {
                    reservationDateTime: '',
                    userIds: null
                },
                tag: '',
            }
        },
        mounted() {
            this.getUsers();
        },
        methods: {
            getUsers() {
                axios.get('/api/user').then(response => {
                    this.users = response.data;
                })
            },
            submitReservation() {
                let userIds = this.reservation.userIds.replace(/ /g,'').split(','); //remove whitespace and convert to array

                let data = {
                    userIds,
                    reservation_datetime: [this.reservation.reservationDateTime]
                }

                axios.post('/api/reservation', data).then(response => {
                    console.log(response.data);
                })
            }
        },
    }
</script>
