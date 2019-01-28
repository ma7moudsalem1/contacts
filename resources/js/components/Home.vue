<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">welcome, {{ auth.name }}</div>

                    <div class="card-body">
                        Thank you for using contacts system, You have added ({{auth.count_contacts}}) till now.
                        You can add and manage your contacts from <router-link to="/home">here</router-link>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                auth: ''
            }
        },
        methods: {
            loadAuthUser(){
                axios.get("/auth").then(({data}) => {
                    (this.auth = data)
                    console.log(this.auth)
                }).catch((error) =>  Swal('Failed!','Something went wrong.','warning'));
            },
        },
        created() {
            this.loadAuthUser();
        }
    }
</script>
