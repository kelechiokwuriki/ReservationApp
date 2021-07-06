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
                        <button type="submit" class="btn btn-success" @click="createSettings" v-if="settingsExisted">Create Settings</button>
                        <button type="submit" class="btn btn-success" @click="saveSettings" v-else>Save Changes</button>

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
                reservationTimeZone: '',
                id: null
            },
            settingsExisted: false
        }
    },
    methods: {
        saveSettings() {
            axios.put(`/api/reservationSettings/${this.reservationSettings.id}`, this.reservationSettings).then(response => {
                this.$toast.open(`Settings updated successfully`);
                console.log(response.data);
            })
        },
        createSettings() {
             axios.post(`/api/reservationSettings`, this.reservationSettings).then(response => {
                this.$toast.open(`Settings created successfully`);
                console.log(response.data);
            })
        },
        fetchPreviousReservationSettings() {
            axios.get('/api/reservationSettings').then(response => {
                this.reservationSettings.lengthOfReservation = response.data.lengthOfReservation;
                this.reservationSettings.numberOfReservations = response.data.numberOfReservations;
                this.reservationSettings.reservationType = response.data.reservationType;
                this.reservationSettings.reservationTimeZone = response.data.reservationTimeZone;
                this.reservationSettings.id = response.data.id;
            })
        }
    },
    created() {
        this.fetchPreviousReservationSettings();
    },

}
</script>
