<template>
    <div class="alert alert-danger mb-2" role="alert" v-if="validationErrors">

        <span v-for="(value, key, index) in validationErrors" :key="index" >
				{{ value }} <br />
		</span>
        <br />
    </div>
</template>


<script>
export default {
    name : 'ValidationError',
    props: ['errors'],
    computed: {
        validationErrors(){
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
        }
    }
}
</script>