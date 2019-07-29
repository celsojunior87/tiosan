<template>
	<v-chip color="red" text-color="white" v-if="formName.errors && formName.errors.has(propName)">
		{{formName.errors.get(propName)}}
	</v-chip>
</template>

<script>
	export default {
		props:['formName','propName']
	}
</script>
