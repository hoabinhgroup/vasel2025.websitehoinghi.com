<template>
  <a target="_blank">
    <div class="media">
      <div class="media-left align-self-center">
        <i class="ft-plus-square icon-bg-circle bg-cyan"></i>
      </div>
      <div class="media-body">
        <h6 class="media-heading">
          <span class="text-muted"
            ><strong>{{ user.name }}</strong> đã đăng nhập vào hệ thống
            <span style="color: #777"
              ><time-ago refresh :datetime="user.last_login"></time-ago></span
          ></span>
        </h6>
      </div>
    </div>
  </a>
</template>

<script>
import { TimeAgo } from "vue2-timeago";

export default {
  props: ["user"],
  components: {
    TimeAgo,
  },
  data() {
    return {};
  },
  methods: {},
  mounted() {
    console.log("user", this.user);
    //this.threadUrl = '/' + this.unread.data.thread.thread_url + '.html';
  },
};
</script>

<style>
.v_time_ago_a {
  color: #657786;
  cursor: pointer;
  font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
  font-size: 14px;
  text-decoration: none;
}
.v_time_ago_a:active,
.v_time_ago_a:focus,
.v_time_ago_a:hover {
  color: #1b95e0;
  text-decoration: underline;
}
.v_time_ago_span {
  letter-spacing: 0.1px;
  line-height: 20px;
  list-style-image: none;
  list-style-position: outside;
  list-style-type: none;
}
.tooltip {
  display: inline-block;
  position: relative;
}
.tooltip .tooltiptext {
  background-color: #555;
  border-radius: 6px;
  bottom: 125%;
  color: #fff;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  padding: 5px 0;
  position: absolute;
  text-align: center;
  transition: opacity 0.3s;
  transition-delay: 0.5s;
  visibility: hidden;
  width: 150px;
  z-index: 1;
}
.tooltip .tooltiptext:after {
  border: 5px solid transparent;
  border-top-color: #555;
  content: "";
  left: 50%;
  margin-left: -5px;
  position: absolute;
  top: 100%;
}
.tooltip:hover .tooltiptext {
  opacity: 1;
  visibility: visible;
}
</style>
