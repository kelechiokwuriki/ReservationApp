<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Settings</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Number of reservations allowed</label>
                                <input type="number" min="0" v-model="reservationSettings.numberOfReservations" class="form-control" />
                            </div>

                             <div class="form-group">
                                <label>Length of reservation allowed</label>
                                <v-select :options="reservationLengths" v-model="reservationSettings.lengthOfReservation"></v-select>
                            </div>

                             <div class="form-group">
                                <label>Type of reservation allowed</label>
                                <v-select :options="reservationTypes" v-model="reservationSettings.reservationType"></v-select>
                            </div>

                             <div class="form-group">
                                <label>TimeZone of reservation allowed</label>
                                <input type="text" v-model="reservationSettings.reservationTimeZone" class="form-control" />
                            </div>
                        </form>
                        <button type="submit" class="btn btn-primary" @click="submitSettings">Submit</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<<script>
export default {
    data() {
        return {
            reservationLengths: ['day', 'week', 'month'],
            reservationTypes: ['individual', 'group'],
            reservationSettings: {
                lengthOfReservation: '',
                numberOfReservations: 0,
                reservationType: '',
                reservationTimeZone: ''
            }
        }
    },
    methods: {
        submitSettings() {}
    },

}
</script>
