<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Reservation</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>User IDs (type the id and press the enter key)</label>
                                 <vue-tags-input
                                    v-model="tag"
                                    :tags="reservation.userIds"
                                    @tags-changed="newTags => reservation.userIds = newTags"
                                    />
                            </div>

                             <div class="form-group">
                                <label>When is the reservation?</label>
                                <input type="datetime" min="0" v-model="reservation.reservationDateTime" class="form-control" />
                            </div>

                        </form>
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
                    userIds: []
                },
                tag: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            submitReservation() {
                axios.post('/api/reservation', this.reservation)
            }
        },
    }
</script>
