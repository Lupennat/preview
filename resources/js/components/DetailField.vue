<template>
    <component
        :key="index"
        :index="index"
        :is="componentName"
        :resource-name="resourceName"
        :resource-id="resourceId"
        :resource="resource"
        :field="field"
        @actionExecuted="$emit('actionExecuted')"
    />
</template>

<script>
    export default {
        props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
        computed: {
            componentName() {
                return this.field.prefixComponent
                    ? 'detail-' + this.field.originalComponent
                    : this.field.originalComponent;
            }
        }
    };
</script>
