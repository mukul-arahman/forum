<template>
    <div class="dropdown" v-if="notifications.length">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div v-for="notification in notifications" :key="notification.id">
                <a :href="notification.data.link"
                    class="dropdown-item"
                    v-text="notification.data.message"
                    @click="markAsRead(notification)">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return { notifications: false }
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }
</script>
