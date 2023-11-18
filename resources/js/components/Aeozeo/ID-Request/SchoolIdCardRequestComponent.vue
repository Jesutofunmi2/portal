<template>
  <div class="row match-height">
    <!-- Striped rows start -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">ID Card Request</h4>
            <a class="heading-elements-toggle"
              ><i class="icon-ellipsis font-medium-3"></i
            ></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li>
                  <a data-action="collapse"><i class="icon-minus4"></i></a>
                </li>
                <li>
                  <a data-action="reload"><i class="icon-reload"></i></a>
                </li>
                <li>
                  <a data-action="expand"><i class="icon-expand2"></i></a>
                </li>
                <li>
                  <a data-action="close"><i class="icon-cross2"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body collapse in">
               <div class="card-block card-dashboard row">
                    <div class="col-md-2" v-if="id_request_statistics">
                      <h2>{{ id_request_statistics.all }}</h2>
                      <span>All ID Card Request</span>
                    </div>
                    <div class="col-md-2" v-if="id_request_statistics">
                      <h2>{{ id_request_statistics.pending }}</h2>
                      <span>Pending ID Card Request</span>
                    </div>
                    <div class="col-md-2" v-if="id_request_statistics">
                      <h2>{{ id_request_statistics.approved }}</h2>
                      <span>Approved ID Card Request </span>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-9">
                          <select v-model="s_session" class="form-control border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                            <option :value="null" >Select Session</option>
                            <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                          </select>
                        </div>
                        <p></p>
                         <div class="col-md-3">
                              <button @click="getData()" class="btn btn-success">Fetch</button>
                          </div>
                        </div>
                      </div>
                </div>
              <hr>
           
            <div class="table-responsive">
                <div id="tabs" class="container" v-if="print_data == null">
                
                  <div class="stabs">
                      <a @click="change_tab(1)" v-bind:class="[ activetab === 1 ? 'active' : '' ]">View Pending ID Card</a>
                      <a @click="change_tab(2)" v-bind:class="[ activetab === 2 ? 'active' : '' ]">View Approved ID Card</a>
                      <a @click="change_tab(3)" v-bind:class="[ activetab === 3 ? 'active' : '' ]">View Downloaded ID Card</a>
                  </div>

                  <div class="scontent">
                      <div v-if="activetab === 1" class="stabcontent">
                          <div v-if="pagination">
                            
                            <button
                              @click="getStudents(meta.current_page - 1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page + 1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                            
                          </div>
                          <table class="table table-striped mb-0">
                            <thead>
                              <tr>
                                <th>
                                  <label class="toggle-control">
                                    <input @click="toggleAll()" type="checkbox" :checked ="check_all">
                                    <span class="control"></span>
                                  </label>
                                </th>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Reg. Number</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody v-if="students && activetab == 1">
                              <tr v-for="(student, index) in students" :key="index">
                                <td>
                                  <label class="toggle-control">
                                
                                    <input @click="toggleId(student.id)"  type="checkbox" :id="student.id">
                                    <span class="control"></span>
                                  </label>
                                </td>
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ student.surname }} {{ student.firstname }} {{ student.middlename }}</td>
                                <td>{{ student.regnum }}</td>
                                <td>Pending</td>
                              </tr>
                            </tbody>
                          </table>
                          <div v-if="pagination">
                            <button
                              @click="getStudents(meta.current_page-1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page+1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                          </div>
                          <div style="float:right">
                            <button @click="approve()" class="btn btn-success" > <span class="icon-check"></span> Approved Selected ID Card Request</button>
                          </div>
                          <p></p>
                      </div>
                      <div v-if="activetab === 2" class="stabcontent">
                          <div v-if="pagination">
                            
                            <button
                              @click="getStudents(meta.current_page - 1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page + 1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                            
                          </div>
                          <table class="table table-striped mb-0">
                            <thead>
                              <tr>
                                <th>
                                  <label class="toggle-control">
                                    <input @click="toggleAll()" type="checkbox" :checked ="check_all">
                                    <span class="control"></span>
                                  </label>
                                </th>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Reg. Number</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody v-if="students && activetab == 2">
                              <tr v-for="(student, index) in students" :key="index">
                                <td>
                                  <label class="toggle-control">
                                
                                    <input @click="toggleId(student.id)"  type="checkbox" :id="student.id">
                                    <span class="control"></span>
                                  </label>
                                </td>
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ student.surname }} {{ student.firstname }} {{ student.middlename }}</td>
                                <td>{{ student.regnum }}</td>
                                <td>Approved</td>
                              </tr>
                            </tbody>
                          </table>
                          <div v-if="pagination">
                            <button
                              @click="getStudents(meta.current_page-1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page+1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                          </div>
                          <div style="float:right">
                            <button @click="printIdCard()" class="btn btn-success" > <span class="icon-print"></span> Download/Print Selected ID Card Request</button>
                            <button @click="unApprove()" class="btn btn-danger" > <span class="icon-trash"></span> Unapprove Selected ID Card Request</button>
                          </div>
                          <p></p>
                      </div>
                      <div v-if="activetab === 3" class="stabcontent">
                          <div v-if="pagination">
                            
                            <button
                              @click="getStudents(meta.current_page - 1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page + 1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                            
                          </div>
                          <table class="table table-striped mb-0">
                            <thead>
                              <tr>
                                <th>
                                  <label class="toggle-control">
                                    <input @click="toggleAll()" type="checkbox" :checked ="check_all">
                                    <span class="control"></span>
                                  </label>
                                </th>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Reg. Number</th>
                                <th>Class</th>
                                <th>Arm</th>
                                <th>Session</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody v-if="students && activetab == 3">
                              <tr v-for="(student, index) in students" :key="index">
                                <td>
                                  <label class="toggle-control">
                                
                                    <input @click="toggleId(student.id)"  type="checkbox" :id="student.id">
                                    <span class="control"></span>
                                  </label>
                                </td>
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ student.fullname }}</td>
                                <td>{{ student.regnum }}</td>
                                <td>{{ student.class }}</td>
                                <td>{{ student.class_arm }}</td>
                                <td>{{ student.session }}</td>
                                <td> <span class="text-success">Downloaded</span> </td>
                              </tr>
                            </tbody>
                          </table>
                          <div v-if="pagination">
                            <button
                              @click="getStudents(meta.current_page-1)"
                              :class="pagination.prev ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              &lt;&lt; Prev
                            </button>
                            {{ meta.current_page }} of {{ meta.last_page }}
                            <button
                              @click="getStudents(meta.current_page+1)"
                              :class="pagination.next ? '' : 'disabled'"
                              class="btn btn-success"
                            >
                              Next &gt;&gt;
                            </button>
                          </div>
                          <div style="float:right">
                            <button @click="printIdCard()" class="btn btn-success" > <span class="icon-print"></span> Download/Print Selected ID Card Request</button>
                          </div>
                          <p></p>
                      </div>
                  </div>
                
                </div>

              <div class="card-block card-dashboard row" v-if="print_data != null && print_data.students.length > 0">
                          <div v-for="student in print_data.students" :key="student.regnum" class="student_idcard" :data-regnum="student.regnum" :data-id="student.id">
                              
                              <div v-if="student.is_downloaded" class="printnone status downloaded">Downloaded</div>
                             
                              <div class="id__card senior">
                                  <div style="">
                                    <div class="cover_one"></div>
                                    <div class="cover_two"></div>
                                    <div class="main">
                                      <div class="header">
                                        <div class="ods_logo">
                                          <img :src="'/portal'+print_data.site_logo_url">
                                        </div>
                                        <div class="title">
                                          <h1>{{ print_data.state_name }} State Ministry of Education <br> Science and Technology</h1>
                                        </div>
                                        <div class="school_logo">
                                          <img :src="baseUrl + print_data.school_data.logo">
                                        </div>
                                      </div>
                                      <div class="header_bottom"></div>
                                      <div class="contents">
                                      <div class="user_photo">
                                        <img :src="baseUrl + student.passport">
                                      </div>
                                        <div class="user_details">
                                          <div class="form_input">
                                            <div class="title">
                                              FULLNAME
                                            </div>
                                            <div class="line">{{ student.fullname }}</div>
                                          </div>
                                          <br>
                                          <div class="form_input">
                                            <div class="title">
                                             {{ print_data.state_name }} STATE STUDENT IDENTIFICATION NUMBER (0SSIN)
                                            </div>
                                            <div class="line">{{ student.regnum }}</div>
                                          </div>
                                          <br>
                                          <div class="form_row">
                                            <div class="form_input">
                                              <div class="title">
                                                CLASS:
                                              </div>
                                              <div class="line">
                                                 {{ student.level }}
                                              </div>
                                            </div>
                                            <div class="form_input" style="margin-left:3em;">
                                              <div class="title">
                                                GENDER:
                                              </div>
                                              <div class="line">{{ student.gender }}</div>
                                            </div>
                                          </div>
                                          <br><br>
                                          <div class="form_input row">
                                            <div class="title">
                                              P/G MOBILE:
                                            </div>
                                            <div class="line">{{ student.parent_phone }}</div>
                                            <div class="title">
                                              EXP:
                                            </div>
                                            <div class="line">{{ student.expire }}</div>
                                          </div>
                                          
                                        </div>
                                    </div>
                                    <div class="sfooter">
                                        <div>{{ print_data.school_data.name }}</div>
                                    </div>
                                    </div>
                                  </div>
                              </div>
                      </div>
                      <div class="preview__holder"></div>
                      <button @click="print()" id="print_btn" class="btn btn-success "> <span class="icon-download"></span> Download ID Card</button>
                      <button @click="goBack()" class="btn btn-danger"> &lt;&lt; Back</button>
              </div>
                            
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Striped rows end -->
    <FlashMessage></FlashMessage>
  </div>
</template>

<script>

import $ from 'jquery';

export default {
  data() {
    return {
      school_id: this.$route.params.schoolID,
      students: null,
      pagination: null,
      meta: "",
      id_request_statistics : null,
      activetab: 1,
      check_all : false,
      ids: [],
      url : null,
      print_data : null,
      output : null,
      s_session: null,
      baseUrl:  '/public',
    };
  },

  mounted() {
    
  },

  methods: {
    change_tab(id = 1) {
      this.students = null,
      this.pagination = null,
      this.meta = "",
      this.check_all = false,
      this.ids = [];
      this.activetab = id;

      if (id == 1) {
        this.url = '/api/ministry/school-id-card-request/pending/';
        this.getStudents();
      }
      
      if (id == 2) {
         this.url = '/api/ministry/school-id-card-request/approved/';
         this.getStudents();
      }

      if (id == 3) {
         this.url = '/api/ministry/school-id-card-request/downloaded/';
         this.getStudents();
      }
    },

    getStudents(page = 1) {
      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }

      if(this.url == null) this.url = '/api/ministry/school-id-card-request/pending/';
      if (this.meta && (page > this.meta.last_page || page == 0)) return;

      this.$loading(true);
      axios.get(this.url+this.school_id + "?page=" + page + "&session=" + this.s_session)
        .then((res) => {
            this.students = res.data.data;
            if (this.activetab == 3) this.students = res.data.students;
            this.pagination = res.data.links,
            this.meta = res.data.meta,
            this.$loading(false);
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status === 403) {
            this.$alert(
              "Sorry, you do not have the permission to perfrom this action",
              "No Permission",
              "error"
            );
          }

        });
    },

    getData() {
      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }
      this.$loading(true);
      axios
        .get('/api/ministry/school-id-card-request/statistics/'+this.school_id+"?session=" + this.s_session)
        .then((res) => {
          this.id_request_statistics = res.data.data;
          this.getStudents()
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
          }
          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }
        });

    },

    toggleId(id) {
        let index = null;
        this.ids.forEach(element => {
            if (element == id) {
                index = this.ids.indexOf(element);
                this.ids.splice(index, 1);
            } 
        });
        if (index == null) this.ids.push(id);
    },

    toggleAll() {
        this.ids = [];
        if (this.check_all == false) {

            this.students.forEach(student => {
                this.ids.push(student.id);
                document.getElementById(student.id).checked = true;
            });
            
            this.check_all = true;
        } 
        else {
            this.uncheckAll();
        }
    },

    uncheckAll() {
      if(this.students != null && this.students.length > 0) {
            this.students.forEach(student => {
                    document.getElementById(student.id).checked = false;
            });
      }
            this.check_all = false;
    },

    approve() {
      if(this.ids.length == 0) {
        alert('Please select at least one student');
        return;
      }

      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }

      this.$loading(true);
      axios.post('/api/ministry/school-id-card-request/operation/approve', {ids : this.ids, session : this.s_session})
        .then((res) => {
            this.$alert(
              res.data.data.total+" Total Request | "+res.data.data.successful+" Successful | "+res.data.data.failed+" Failed",
              "Request Approved",
              "success"
            );
            this.uncheckAll();
            this.ids = [];
            this.getData();
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status == 422){
            this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

          if (error.response.status === 403) {
            this.$alert(
              "Sorry, you do not have the permission to perfrom this action",
              "No Permission",
              "error"
            );
          }

        });
    },

      unApprove() {
      if(this.ids.length == 0) {
        alert('Please select at least one student');
        return;
      }

      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }

      this.$loading(true);
      axios.post('/api/ministry/school-id-card-request/operation/unapprove', {ids : this.ids, session : this.s_session})
        .then((res) => {
            this.$alert(
              res.data.data.total+"Total Request | "+res.data.data.successful+" Successful | "+res.data.data.failed+" Failed",
              "Request Unapproved",
              "success"
            );
            this.uncheckAll();
            this.ids = [];
            this.getData();
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status == 422){
            this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

          if (error.response.status === 403) {
            this.$alert(
              "Sorry, you do not have the permission to perfrom this action",
              "No Permission",
              "error"
            );
          }

        });
    },

    printIdCard() {
      if(this.ids.length == 0) {
        alert('Please select at least one student');
        return;
      }

      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }

      this.$loading(true);
      axios.post('/api/ministry/school-id-card-request/operation/download', {
              ids : this.ids,
              school_id: this.school_id,
              session : this.s_session
              })
        .then((res) => {
            this.$loading(false);
            this.print_data = res.data.data;
            //this.getData();
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status == 422){
            this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

          if (error.response.status === 403) {
            this.$alert(
              "Sorry, you do not have the permission to perfrom this action",
              "No Permission",
              "error"
            );
          }

        });
    },

    async print() {

      if(this.s_session == null) {
        this.$alert(
              "Please select a session",
              "No Session",
              "error"
            );
        return;
      }
      // add option type to get the image version
      // if not provided the promise will return 
      // the canvas.
      let btn = document.getElementById('print_btn');
      btn.innerHTML = "Processing...";

      const options = {
        type: 'dataURL'
      }

      axios.post('/api/ministry/school-id-card-request/operation/downloaded', {ids : this.ids, session : this.s_session})
        .then((res) => {

        })
        .catch((error) => {
           btn.innerHTML = "Download ID Card";
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "aeo_zeo-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status == 422){
            this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
            return;
					}

          if (error.response.status === 403) {
            this.$alert(
              "Sorry, you do not have the permission to perfrom this action",
              "No Permission",
              "error"
            );
            return;
          }

        });

      let idCard = $(".student_idcard");
      let printnone = $(".printnone");

      for (let i = 0; i < printnone.length; i++) {
          let element = printnone.get(i);
          element.setAttribute('class', 'hidden');
      }

      btn.innerHTML = "Downloading...";

      for  (let i = 0; i < idCard.length; i++) {
        let el = idCard.get(i);
        let name = el.getAttribute('data-regnum');
        this.output = await this.$html2canvas(el, options);
        let link = document.createElement("a");
        link.download = name +'.png';
        link.href = this.output;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
       btn.innerHTML = "Download ID Card";
       
      this.print_data.students.forEach(student => {
                student.is_downloaded = true;
        });
        for (let i = 0; i < printnone.length; i++) {
          let element = printnone.get(i);
          element.setAttribute('class', 'printnone status downloaded');
      }
    },

    session() {
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
		},

    goBack() {
      this.print_data = null;
      this.ids = [];
      this.getData();
    }
  },
};
</script>
<style lang="scss" scoped>
$toggle-background-color-on: dodger#45b6fe;
$toggle-background-color-off: darkgray;
$toggle-control-color: white;
$toggle-width: 50px;
$toggle-height: 25px;
$toggle-gutter: 5px;
$toggle-radius: 50%;
$toggle-control-speed: .15s;
$toggle-control-ease: ease-in;

// These are our computed letiables
// change at your own risk.
$toggle-radius: $toggle-height / 2;
$toggle-control-size: $toggle-height - ($toggle-gutter * 2);

.toggle-control {
  display: block;
  position: relative;
  padding-left: $toggle-width;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  user-select: none;

  input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  input:checked ~ .control {
    background-color: $toggle-background-color-on;
    
    &:after {
      left: $toggle-width - $toggle-control-size - $toggle-gutter;
    }
  }

  .control {
    position: absolute;
    top: 0;
    left: 0;
    height: $toggle-height;
    width: $toggle-width;
    border-radius: $toggle-radius;
    background-color: $toggle-background-color-off;
    transition: background-color $toggle-control-speed $toggle-control-ease;

    &:after {
      content: "";
      position: absolute;
      left: $toggle-gutter;
      top: $toggle-gutter;
      width: $toggle-control-size;
      height: $toggle-control-size;
      border-radius: $toggle-radius;
      background: $toggle-control-color;
      transition: left $toggle-control-speed $toggle-control-ease;
    }
  }
}
.scontainer {  
    max-width: 620px; 
    min-width: 420px;
    margin: 40px auto;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    color: #888;
}

/* Style the tabs */
.stabs {
    overflow: hidden;
    margin-left: 20px;
    margin-bottom: -2px; /* hide bottom border */
}

.stabs ul {
    list-style-type: none;
    margin-left: 20px;
}

.stabs a{
    float: left;
    cursor: pointer;
    padding: 12px 24px;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    border-right: none;
    background-color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
}
.stabs a:last-child { 
    border-right: 1px solid #ccc;
}

/* Change background color of tabs on hover */
.stabs a:hover {
    background-color: #aaa;
    color: #fff;
}

/* Styling for active tab */
.stabs a.active {
    background-color: #fff;
    color: #484848;
    border-bottom: 2px solid #fff;
    cursor: default;
}

/* Style the tab content */
.stabcontent {
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 10px;
  box-shadow: 3px 3px 6px #e1e1e1
}

    .id__card.senior{
        pointer-events: none;
		position: absolute;
	    top: 0%;
	    left: 0%;
	    right: 0%;
	    overflow: hidden;
	    bottom: 0%;
	    width: 100%;
	    height: 100%;
	    border-radius: 4px;
	    border: 5px solid #dc4901;
	    padding: 0px !important;
	}
	.id__card.senior .cover_one{
		position: absolute;
	    top: 0px;
	    left: 0px;
	    bottom: 0px;
	    right: 0px;
	    background: linear-gradient(45deg, #fff, #ffffff14);
	    z-index: 2px !important;
	    background-size: 55% 34% !important;
	    background-position: 122% 80% !important;
	    background-color: #fff !important;
	    background-repeat: no-repeat !important;
	    transform: rotate(-10deg);
	}
	.id__card.senior .cover_two{
		position: absolute;
        bottom: -170px;
        left: -170px;
        height: 250px;
        width: 250px;
        background: #9e9e9e14;
        border-radius: 50%;
		z-index: 2px !important;
	}
	.id__card .main{
		position: absolute;
		top: 0px;
		left: 0px;
		right: 0px;
		bottom: 0px;
		z-index: 2px !important;
		/*padding: 0px 50px;*/
	}
	.id__card .header{
		display: flex;
		justify-content: center;
		align-content: center;
		background: #dc4901;
		padding: 10px 10px;
		margin-bottom: 4px;
	}
	.id__card .header_bottom{
		background: #dc4901;
		padding: 3px;
	}
	.id__card .header .ods_logo{
		padding: 10px 15px;
	    background: #fff;
	    border-radius: 5px;
	}
	.id__card .header .ods_logo img{
		width: 140px;
		height: 100px;
	}
	.id__card .header .school_logo{
		padding: 10px 15px;
	    background: #fff;
	    border-radius: 5px;
	}
	.id__card .header .school_logo img{
		width: 130px !important;
		height: 100px !important;
	}
	.id__card .header .title{
		padding: 0px 10px 0px 10px;
		text-align: center;
	}
	.id__card .header .title h1{
		font-size: 35px;
		color: #f7f7f7;
		text-transform: uppercase;
		word-break: keep-all;
		margin-bottom: 0px;
	}
	.id__card .header .title p{
		font-size: 15px;
		color: #f7f7f7;
		text-transform: uppercase;
		word-break: keep-all;
	}

	/*content*/
	.id__card .contents{
		padding: 15px 50px;
		display: flex;
		justify-content: center;
	}
	.id__card .contents .user_details{
		flex: 3;
		padding-left: 10px;
	}
	.id__card .contents .user_details .form_input.row{
		display: flex;
		justify-content: flex-start;
	}
	.id__card .contents .user_details .form_input .title{
		font-size: 20px !important;
        color: #000;
        align-self: flex-end;
        padding-right: 10px;
        flex: none;
        font-weight: 700 !important;
        text-transform: uppercase !important;
    }
	.id__card .contents .user_details .form_input .line{
	    font-size: 21px !important;
        text-transform: capitalize !important;
        width: 100%;
        color: #000;
        /* border-bottom: 1px solid #333; */
        padding: 5px 19px 0px 0px;
        font-weight: 900 !important;
	}
	.id__card .contents .user_photo{
		flex: 1;
		padding-right: 10px;
		align-self: center;
	}
	.id__card .contents .user_photo img{
		width: 200px;
		height: 180px;
		border-radius: 8px;
	    border: 6px solid #dc4901;
	    background-color: #fffa;
	}
	.id__card .sfooter{
	    margin-top: 15px;
		padding: 10px 0px;
		border-top: 5px solid #dc4901;
		border-bottom: 5px solid #dc4901;
	}
	.id__card .sfooter div{
	    width: 100%;
	    text-align: center;
		text-transform: capitalize;
		font-size: 25px;
		padding: 10px;
		color: #f7f7f7;
		background: #dc4901;
	}
    .student_idcard{
        position: relative !important;
	    margin: 15px 0px !important;
	    width: 950px;
	    height: 565px;
    }
    .student_idcard .status.downloaded{
        background: #21ba45;
        color: #fff;
        z-index: 1233345679 !important;
        position: absolute;
        top: 0px;
        left: 0px;
        padding: 10px 20px;
    }
    .student_idcard .status.not_downloaded{
        background: red;
    }

  .form_row{
		display: inline-flex;
		justify-content: space-between;
	}
	.form_row .form_input{
		flex: 1;
	}
  .preview__holder{
        height: 10px;
        visibility: hidden;
        overflow: hidden;
  }
</style>


