<template>
  <li class="dropdown nav-item">
    <a class="nav-link nav-link-label" data-toggle="dropdown">
      <i class="ft-users"></i>
      <span
        class="badge badge-pill badge-default badge-info badge-default badge-up"
        >{{ this.count }}</span
      >
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
      <li class="scrollable-container media-list">
        <visit-item
          v-for="user in userVisited"
          :user="user"
          :key="user.key"
        ></visit-item>
      </li>
    </ul>
  </li>
</template>

<script>
import VisitItem from "./VisitItem.vue";
export default {
  components: { VisitItem },
  data() {
    return {
      count: 0,
      userVisited: [],
    };
  },
  mounted() {
    this.listen();
  },
  methods: {
    listen() {
      Echo.join("counter")
        .here((users) => {
          this.count = users.length;
          this.userVisited = users;
          // console.log("this.userVisited here", this.userVisited);
        })
        .joining((user) => {
          //  console.log("user join", user);
          this.count++;
          // this.$toast.success(user.name + " vừa đăng nhập", {
          //   hideProgressBar: false,
          // });
          this.userVisited.push({
            id: user.id,
            name: user.name,
            last_login: user.last_login,
          });
          //console.log("user join", user);
        })
        .leaving((user) => {
          this.count--;
          // this.$toast.success(user.name + " vừa thoát", {
          //   hideProgressBar: false,
          // });
          var leaveUser = user;
          this.userVisited = this.userVisited.filter(
            (user) => user.id != leaveUser.id
          );
          // console.log("this.userVisited leave", this.userVisited);
        });
    },
  },
};
</script>
