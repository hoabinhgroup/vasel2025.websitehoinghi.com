<template>
  <a target="_blank" :href="threadUrl">
    <div v-if="unread.data.user.name" class="media">
      <avatar
        :username="unread.data.user.name"
        class="mr-1"
        :size="50"
      ></avatar>
      <!-- <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div> -->
      <div class="media-body">
        <h6 class="media-heading d-inline">
          <span class="text-muted"
            ><strong>{{ unread.data.user.name }}</strong>
            {{ unread.data.thread.thread_action }}</span
          >
          {{ unread.data.thread.thread_name }}
        </h6>
        <small>
          vào
          <time-ago
            :datetime="unread.data.thread.created_at.replace(' ', 'T')"
            locale="vi"
            :refresh="60"
          ></time-ago>
        </small>
        <p class="notification-text font-small-3 text-muted">
          <small>{{ unread.data.thread.body }} </small>
        </p>
      </div>
    </div>
  </a>
</template>

<script>
import Avatar from "vue-avatar";
import { TimeAgo } from "vue2-timeago";

export default {
  components: {
    Avatar,
    TimeAgo,
  },
  props: ["unread"],
  data() {
    return {
      threadUrl: "",
    };
  },
  methods: {},
  mounted() {
    this.threadUrl = this.unread.data.thread.thread_url;
  },
};
</script>
