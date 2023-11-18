<template>
  <div class="row match-height">
    <!-- Striped rows start -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Approved Request ID Card</h4>
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
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reg. Number</th>
                    <th>Passport</th>
                    <th>Status</th>
                    <th>Request On</th>
                    <th>Approved On</th>
                  </tr>
                </thead>
                <tbody v-if="students">
                  <tr v-for="(student, index) in students" :key="index">
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
                    <td>
                      <span style="background-color:#0f0; color:#fff; padding:5px; border-radius:2px;"><strong>Approved</strong> </span>
                    </td>
                    <td>{{ student.created_at }}</td>
                    <td>{{ student.updated_at }}</td>
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
export default {
  data() {
    return {
      students: null,
      pagination: null,
      meta: "",
      id_request_statistics : null,
      s_session: null,
      baseUrl:  '/public',
    };
  },

  mounted() {

  },

  methods: {
    getStudents(page = 1) {
      if (this.meta && (page > this.meta.last_page || page == 0)) return;

      this.$loading(true);
      axios.get("/api/school/school-id-request/approved?session=" + this.s_session)
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
        .get("/api/school/school-id-request/view/page?session=" + this.s_session)
        .then((res) => {
          this.id_request_statistics = res.data.id_request_statistics,
          this.getStudents();
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

    session() {
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},

  },
};
</script>
