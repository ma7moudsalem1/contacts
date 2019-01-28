<template>
    <div class="container">
            <div class="card pt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
            
                                <div class="alert alert-success" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-users"></i> Contacts <span v-if="contacts.data">({{ contacts.data.length }} of {{ contacts.total }})</span>
                                            <button class="btn btn-success float-right" @click="createContactModal()"><i class="fa fa-plus"></i></button>
                                        </h4>
                                </div>
            
                            <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(contact,index) in contacts.data" v-if="contacts" :key="index">
                                    <th>{{ index+1 }}</th>
                                    <td>{{ contact.name }}</td>
                                    <td>{{ contact.phone  }}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="destroy(contact)"><i class="fa fa-trash"></i></button>
                                        <button class="btn btn-primary" @click="editContactModal(contact)"><i class="fa fa-edit"></i></button>
                                    </td>
                                  </tr>
                                  <tr v-else="contacts" class="text-center">
                                    <th colspan="4">No Contacts Yet</th>
                                  </tr>
                                  
                                </tbody>
                                <tfoot>
                                    <pagination :data="contacts" @pagination-change-page="getResults"></pagination>
                                </tfoot>
                              </table>
                        </div>
                    </div>
                    
                <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" v-if="isCreate">Add new contact</h5>
                              <h5 class="modal-title" v-else="isCreate">Update contact</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group row p-2">
                                <label for="name" class="col-2">Name</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="name" 
                                        v-model="form.name" placeholder="contact name..."
                                        :class="{'is-invalid': errors.name}"
                                        >
                                    <small class="text-danger" v-if="errors.name">
                                        {{errors.name[0]}}
                                    </small> 
                                </div>
                            </div>
                              <div class="form-group row p-2">
                                <label class="col-2">Phone</label>
                                <div class="col-10">
                                    <vue-tel-input v-model="form.phone" :class="{'is-invalid': errors.phone}" class="form-control"></vue-tel-input>
                                    <small class="text-danger text-center" v-if="errors.phone">
                                        {{errors.phone[0]}}
                                    </small>
                                </div>
                                
                            </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success" @click="store()" v-if="isCreate">Save</button>
                              <button type="button" class="btn btn-primary" @click="update()" v-else="isCreate">Update</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                contacts: {},
                isCreate: true,
                errors: {},
                editingIndex: '',
                form: {
                    name: '',
                    phone: ''
                }
            }
        },
        methods: {
            // Get Data
            getResults(page = 1) {
                axios.get('/contacts?page=' + page)
                    .then(response => {
                        this.contacts = response.data;
                    }).catch((error) =>  Swal('Failed!','Something went wrong.','warning'));
            },
            loadContacts(){
                axios.get("/contacts").then(({data}) => {(this.contacts = data)
                }).catch((error) =>  Swal('Failed!','Something went wrong.','warning'));
            },

            // Modal Functions
            createContactModal(){
                this.isCreate = true;
                this.reset();
                $("#contactModal").modal();
            },
            editContactModal(contact){
                this.isCreate = false;
                this.reset();
                this.form = contact;
                this.editingIndex = this.contacts.data.indexOf(contact);
                $("#contactModal").modal();
            },

            // Store data
            store(){
                axios.post('/contacts', this.form).then((response) => {
                    this.contacts.data.unshift(response.data);
                    $('#contactModal').modal('hide');
                   toast({
                        type: 'success',
                        title: 'Contact created successfully'
                    });
                }).catch((error) => {this.errors= error.response.data.errors});
            },

            // update data
            update(){
                axios.patch('/contacts/' + this.form._id, this.form).then((response) => {
                    this.contacts.data[this.editingIndex] = response.data;
                    $('#contactModal').modal('hide');
                    toast({
                        type: 'success',
                        title: 'Contact Updated successfully'
                    });
                }).catch((error) => {this.errors= error.response.data.errors});
            },

            destroy(contact){
                console.log(contact);
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {

                    axios.delete('/contacts/' + contact._id).then((response) => {
                        this.contacts.data.splice(this.contacts.data.indexOf(contact), 1),
                        Swal.fire(
                        'Deleted!',
                        'Your Contact has been deleted.',
                        'success'
                        )
                    })
                    .catch((error) => {Swal('Failed!','Something went wrong.','warning')});

                    
                }
                })
            },


            // Reset form
            reset(){
                this.form = {
                    name: '',
                    phone: '',
                };
                this.errors = {};
                this.toast = {};
            }

        },
        created(){
            this.loadContacts();
        }
    }
</script>
