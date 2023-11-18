<template>
    <div>
        <step-progress :steps="regSteps" :current-step="currentPage" icon-class="icon-check" active-color="orange">
        </step-progress>
    </div>
</template>

<script>
import StepProgress from 'vue-step-progress';
import 'vue-step-progress/dist/main.css';
export default {
    components: {
        'step-progress': StepProgress
    },

    props: {
        currentPage: Number
    },

    data(){
        return {
            regSteps: ['Identification', 'Characteristics', 'Enrolment', 'Staff', 'Classrooms', 'Facilities', 'Books', 'Undertaking'],
            currentStep: this.currentPage
        }
	},

}
</script>