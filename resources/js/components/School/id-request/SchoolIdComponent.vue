<template>
  <div class="row match-height">
    <!-- Striped rows start -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Request ID Card</h4>
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
               <div class="card-block card-dashboard row" v-if="id_request_statistics">
                    <div class="col-md-4">
                    <h2>{{ id_request_statistics.all }}</h2>
                    <span>All ID Card Request</span>
                    </div>
                    <div class="col-md-4">
                    <h2>{{ id_request_statistics.pending }}</h2>
                    <span>Pending ID Card Request</span>
                    </div>
                    <div class="col-md-4">
                    <h2>{{ id_request_statistics.approved }}</h2>
                    <span>Approved ID Card Request </span>
                    </div>
              </div>
              <hr>
            <div class="card-block card-dashboard row">
              <form class="form" novalidate @submit.prevent="getStudents()">
                <div class="form-body">
                  <div class="form-group col-md-3">
                    <label for="issueinput1">Class</label>
                    <select
                      id="issueinput1"
                      v-model="class_id"
                      @change="changeClass($event)"
                      :class="{ 'border-danger': validationErrors.class_id }"
                      class="form-control"
                      name="class_id"
                      data-toggle="tooltip"
                      data-trigger="hover"
                      data-placement="top"
                      data-title="Class"
                      required
                    >
                      <option value="">Select Class</option>
                      <option
                        :value="clas.id"
                        v-for="(clas, index) in classes"
                        :key="index"
                      >
                        {{ clas.class_name }}
                      </option>
                    </select>
                    <span
                      v-if="validationErrors.class_id"
                      :class="['label text-danger']"
                      >{{ validationErrors.class_id[0] }}</span
                    >
                  </div>

                  <div class="form-group col-md-3">
                    <label for="issueinput2">Class Arm</label>
                    <select
                      id="issueinput2"
                      v-model="class_arm_id"
                      @change="validationErrors.class_arm_id = null"
                      :class="{
                        'border-danger': validationErrors.class_arm_id,
                      }"
                      class="form-control"
                      name="class_arm_id"
                      data-toggle="tooltip"
                      data-trigger="hover"
                      data-placement="top"
                      data-title="Class Arm"
                      required
                    >
                      <option value="">Select Class Arm</option>
                      <option
                        :value="clasarm.id"
                        v-for="(clasarm, index) in classArms"
                        :key="index"
                      >
                        {{ clasarm.class_arm }}
                      </option>
                    </select>
                    <span
                      v-if="validationErrors.class_arm_id"
                      :class="['label text-danger']"
                      >{{ validationErrors.class_arm_id[0] }}</span
                    >
                  </div>

                  <div class="form-group col-md-3">
                    <label for="issueinput3">Session</label>
                    <select
                      v-model="session"
                      @change="validationErrors.session = null"
                      class="form-control"
                      :class="{ 'border-danger': validationErrors.session }"
                      placeholder="Session"
                      data-toggle="tooltip"
                      data-trigger="hover"
                      data-placement="top"
                      data-title="Select Session"
                      required
                    >
                      <option value="">Select Session</option>
                      <option
                        v-for="year in sessions()"
                        :key="year"
                        :value="year"
                      >
                        {{ year }}/{{ year + 1 }}
                      </option>
                    </select>
                    <span
                      v-if="validationErrors.session"
                      :class="['label text-danger']"
                      >{{ validationErrors.session[0] }}</span
                    >
                  </div>

                  <div class="form-group col-md-3" v-if="is_enable">
                    <br />
                    <button type="submit" class="btn btn-success">
                      <i class="icon-ios-search-strong"></i> View Students
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div class="table-responsive">
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
                &nbsp;
                &nbsp;
                <span class="text-danger">
                    Please note! Only students with passport can an ID Card request be made for 
                </span>
              </div>
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th> <input v-if="students" type="checkbox" @change="toggleAll()"></th>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reg. Number</th>
                    <th>Passport</th>
                  </tr>
                </thead>
                <tbody v-if="students">
                  <tr v-for="(student, index) in students" :key="index">
                    <td>
                      <input v-if="student.passport != '/images/passports/no_img_da88a72526.gif' && student.passport != null && student.passport != ''"
                       type="checkbox" 
                       @change="toggleId(student.id)"
                       :id="student.id" />
                    </td>
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ student.surname }} {{ student.firstname }} {{ student.middlename }}</td>
                    <td>{{ student.regnum }}</td>
                    <td>

                      <img
                        :src="baseUrl+student.passport"
                        alt="Passport"
                        style="max-height: 100px; max-width: 100px"
                      />
                    </td>
                    
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
              <hr>
              <button
                  @click="requestID()"
                  class="btn btn-success"
                >
                  Request ID for Selected Students
                </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal v-model="showModal" title="ID Card Request Report"  @close="showModal = false">
            <div v-if="count != null">
                <h4 v-if="count > 0" class="text-success">{{count}} Students ID-Card Request Sent.</h4>
                <h4 v-if="count == 0" class="text-danget">Unable to send any ID-Card request</h4>

                <div class="row" style="padding:5px;" v-if="message.length > 0">
                  <div v-for="msg, index in message" :key="index">
                    <span class="text-danger">{{index + 1}}. {{msg}}</span>
                    <hr>
                  </div>
                </div>
            </div>
    </Modal>
    <!-- Striped rows end -->
    <FlashMessage></FlashMessage>
  </div>
</template>

<script>
export default {
  data() {
    return {
      session: null,
      class_id: null,
      class_arm_id: null,
      classes: null,
      classArms: "",
      students: null,
      pagination: null,
      meta: "",
      validationErrors: [],
      is_enable : false,
      id_request_statistics : null,
      ids: [],
      checked_all : false,
      message :  [],
      count : null,
      showModal : false,
      baseUrl:  '/public',
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    getStudents(page = 1) {
      if (!this.classes) {
        this.flashMessage.error({
          title: "Incomplete Data Supplied",
          message: "Please select a Class, a Class Arm, a Session, and a Term",
          time: 15000,
        });
        return;
      }

      if (this.meta && (page > this.meta.last_page || page == 0)) return;

      const params = new URLSearchParams();
      if (this.class_id) params.append("class", this.class_id);
      if (this.class_arm_id) params.append("arm", this.class_arm_id);
      if (this.session) params.append("session", this.session);
      params.append("page", page);

      this.$loading(true);
      axios.get("/api/school/school-id-request/view/student", { params: params })
        .then((res) => {
            this.students = res.data.data,
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
              name: "school-login",
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

          if (error.response.status == 422){
            this.validationErrors = error.response.data.errors;
            this.flashMessage.error({title: 'Validation Error', 
                                    message: 'Their is Error with the Data you supplied',
                                    time: 15000, });
            }
        });
    },

    getData() {
      this.$loading(true);
      axios
        .get("/api/school/school-id-request/view/page")
        .then((res) => {
          this.classes = res.data.data,
          this.id_request_statistics = res.data.id_request_statistics,
          this.is_enable = true;
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
            this.$router.go(-1);
            return;
          }
          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "school-login",
              params: { return_url: return_url },
            });
          }

          if (error.response.status === 400) {
                this.$alert(
                "Sorry, Please upload school logo to access this feature",
                "No School Logo",
                "error"
                );
            }
        });

    },

    changeClass(event) {
      this.validationErrors.class_id = null;
      let classID = event.target.value;
      this.getClassArms(classID);
    },

    getClassArms(classID) {
      this.$loading(true);
      axios
        .get(`/api/school/classarm/view/${classID}`)
        .then((res) => {
          this.classArms = res.data.data;
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
            this.$router.go(-1);
            return;
          }
          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "school-login",
              params: { return_url: return_url },
            });
          }
        });
    },

    sessions() {
      const d = new Date();
      const n = d.getFullYear();
      const year = [];
      for (let index = 2010; index <= n; index++) {
        year.push(index);
      }
      return year;
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
        if (this.checked_all == false) {

            this.students.forEach(student => {
                if (student.passport != '/images/passports/no_img_da88a72526.gif' && student.passport != null && student.passport != '') {
                    this.ids.push(student.id);
                    document.getElementById(student.id).checked = true;
                }
            });
            
            this.checked_all = true;
        } 
        else {

            this.students.forEach(student => {
                if (student.passport != '/images/passports/no_img_da88a72526.gif' && student.passport != null && student.passport != '') {
                    document.getElementById(student.id).checked = false;
                }
            });
            
            this.checked_all = false;
        }
    },

    requestID() {
        if(! this.ids.length) return;
        this.$loading(true);

        axios.post("/api/school/school-id-request/create", {ids : this.ids, session : this.session})
        .then((res) => {
          this.$loading(false);
          this.message = res.data.message;
          this.count = res.data.count;
          this.showModal = true;
        })
        .catch((error) => {
          this.$loading(false);
          if (!error.response) {
            this.$alert(
              "You do not have internet access",
              "Network Error",
              "error"
            );
            this.$router.go(-1);
            return;
          }

          if (error.response.status === 401) {
            let return_url = window.location.pathname;
            this.$router.push({
              name: "school-login",
              params: { return_url: return_url },
            });
          }
        });

    }

  },
};
</script>
