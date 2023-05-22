<template>
    <div :class="`text-${field.textAlign}`">
        <Dropdown>
            <DropdownTrigger class="text-gray-500 inline-flex items-center cursor-pointer" :showArrow="false">
                <span class="link-default font-bold">{{ field.previewLabel || __('View') }}</span>
            </DropdownTrigger>

            <template #menu>
                <DropdownMenu width="auto">
                    <div class="p-4 preview-wrapper overflow-auto">
                        <component
                            :is="componentName"
                            :field="field"
                            :resource="resource"
                            :resource-name="resourceName"
                            :via-resource="viaResource"
                            :via-resource-id="viaResourceId"
                        />
                    </div>
                </DropdownMenu>
            </template>
        </Dropdown>
    </div>
</template>
<style>
    .preview-wrapper .whitespace-nowrap {
        white-space: normal;
    }
    .overflow-auto {
        overflow: auto;
    }
</style>
<script>
    export default {
        props: ['resourceName', 'field', 'viaResource', 'viaResourceId', 'resource'],
        computed: {
            componentName() {
                return this.field.prefixComponent
                    ? 'index-' + this.field.originalComponent
                    : this.field.originalComponent;
            }
        }
    };
</script>
