<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Reservation for a user</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="card">
                                    <div class="card-header">Users</div>
                                    <div class="card-body">
                                         <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                                            <table id="usersTable" class="table display table-hover text-center" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">S/N</th>
                                                        <th scope="col">User Id</th>
                                                        <th scope="col">Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(user, index) in users" v-bind:key="index">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>{{ user.id }}</td>
                                                        <td>{{ user.name }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-header">
                                        Reserve
                                    </div>
                                    <div class="card-body">
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
                                        <button type="submit" class="btn btn-success" @click="submitReservation" :disabled="disableSubmitButton">Submit Reservation</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    userIds: ''
                },
                users: []
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
                .catch(error => {

                }).finally(() => {
                    $('#usersTable').DataTable({
                        "ordering": false,
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
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
        computed: {
            disableSubmitButton() {
                return this.reservation.reservationDateTime === '' || this.reservation.userIds === '';
            }
        }
    }
</script>
