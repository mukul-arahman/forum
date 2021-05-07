<template>
    <button type="submit" :class="classes" @click="toggle">
        <i class="fa fa-heart" aria-hidden="true"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ];
            },

            endpoints() {
                return '/replies/'+ this.reply.id +'/favorites';
            }
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoints);

                this.active = true;
                this.count++;
            },

            destroy() {
                axios.delete(this.endpoints);

                this.active = false;
                this.count--;
            }
        }
    }
</script>
