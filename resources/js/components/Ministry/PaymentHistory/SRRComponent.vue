<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Schools Remittance Report </h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block card-dashboard row">
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="lga_id" type="text" required @change="getSchools()" class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value="null">Select L.G.A</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-4">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="school_id" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value="null">Select school</option>
                                    <option  v-for="school in schools" :key="school.id" :value="school.id"> {{ school.name }}</option>
                                </select>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-3">
                        <fieldset class="row py-2">
                            <select v-model="s_session" class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                <option :value="null" >All Session</option>
                                <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                            </select>
                        </fieldset>
                   </div>
                   <div class="col-md-2">
                       <p></p>
                       <p></p>
                        <button @click="getReports()" class="btn btn-success btn-lg">Fetch Report</button>
                   </div>
                </div>
                <div id="printable" class="table-responsive " style="max-height:500px; overflow:scroll; size: landscape;">
                    <table width="100%" class="table table-striped mb-0 " style="border: 1px solid #333;" v-if="report">
                        <tr>
                            <td style="border: 1px solid #333;" colspan="2">{{ report.name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">JSS1</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.jss1_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.jss1_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">JSS2</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.jss2_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.jss2_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="2">JSS3</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.jss3_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.jss3_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">SS1</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.sss1_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.sss1_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">SS2</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.sss2_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.sss2_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">SS3</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;">
                                STUDENT STATISTICS: {{ report.sss3_sts }}
                            </td>
                            <td style="border: 1px solid #333;">
                                MONEY PAID: {{ report.sss3_mp }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;" colspan="2">
                                TOTAL NUMER OF STUDENT: {{ report.tnos }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;" colspan="2">
                                TOTAL AMOUNT PAID: {{ report.tap }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #333;" colspan="2">
                                TOTAL OUT STANDING PAYMENT: {{ report.tosp }}
                            </td>
                        </tr>
                    </table>
                </div>
                <button v-if="report" class="btn btn-primary" @click="printPageArea()">Print</button>
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

		data(){
			return {
				report : null,
                lgas : [],
                lga_id : null,
                s_session : null,
                schools : null,
                school_id : null,
                can_print : false
			}
		},
        mounted() {
			this.getState();
        },

		methods : {
			getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state;
					this.lgas = res.data.data;
                    this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getSchools(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/payment-history/report/srr?page='+page;
                
                if(this.lga_id != null) {
                    url += '&lga_id='+this.lga_id;
                }

                if(this.s_session != null) {
                    url += '&session='+this.s_session;
                }

                if(url == null) return ;

				this.$loading(true);
                this.schools = [];
				axios.get(url)
				.then((res) => {
                    this.schools = res.data.data,
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                        name: "ministry-login",
                        params: { return_url: return_url },
                        });
                    }

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getReports() {
                if(this.s_session == null || this.s_session == '') {
                    alert('Please select a session');
                    return;
                }

                if(this.school_id == null || this.school_id == '') {
                    alert('Please select a school');
                    return;
                }

                let url = '/api/ministry/payment-history/report/school/srr?school_id='+this.school_id+'&session='+this.s_session;
                
                this.$loading(true);

                axios.get(url).then((res) => {
                    this.report = res.data.data;
                    this.$loading(false);
                    this.flashMessage.success({
                        title: 'Successful',
                        message: 'Report generated successfully',
                        time: 5000,
                        flashMessageStyle: {
                            backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                        }
                    });
                })
                .catch((error) => {
                    if (!error.response) {
                        this.$alert("You do not have internet access","Network Error","error");
                        return ;
                    }

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                        name: "ministry-login",
                        params: { return_url: return_url },
                        });
                    }

                    if(error.response.status === 403){
                        this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                    }
                });
            },

            printPageArea(){
                let printContent = document.getElementById('printable');
                let WinPrint = window.open('', '', 'width=2480px, height=3000px');
                WinPrint.document.write(printContent.outerHTML);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            },

            session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},
		}
    }
</script>
<style scoped>
    tr, td {
        border: 1px solid #555;
    }
</style>
