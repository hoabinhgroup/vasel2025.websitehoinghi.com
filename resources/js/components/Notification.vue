<template>
    <li @click="markNotificationAsRead" class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" data-toggle="dropdown"><i class="ficon ft-bell"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ unreadNotifications.length }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2"></span>
                    <span class="notification-tag badge badge-default badge-danger float-right m-0">Có {{ unreadNotifications.length }} thông báo mới</span>
                  </h6>
                </li>
                <li class="scrollable-container media-list">
                	<notification-item v-for="unread in unreadNotifications" :unread="unread" :key="unread.id"></notification-item>
                  
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Xem toàn bộ</a></li>
              </ul>
            </li>
</template>

<script>
	import NotificationItem from './NotificationItem.vue';
    import { playSoundNotification } from "../utilities/sound-notification";
    import $ from "jquery";
    export default {
	    props:['unreads','userid'],
	    components: {NotificationItem},
	    data() {
		    return {
			    unreadNotifications: this.unreads
		    }
	    },
        methods: {
             markNotificationAsRead() {
                if (this.unreadNotifications.length) {               
                    axios.get('/markAsRead');
                }
            }
            
        },
        mounted() {	     
          //var myAudio = $('#audiotag')[0]; 
         //  var myAudio = document.getElementById('audiotag');      
         //   var readyState = myAudio.readyState;  
         //  console.log('readyState', readyState);
           console.log('notification mounted.');
           console.log(this.userid);
            Echo.private(`App.User.${this.userid}`)
				.notification((notification) => {
					console.log('mounted notification',notification);
                    playSoundNotification();
					let newUnreadNotifications = {data: {thread: notification.thread, user: notification.user}};
							
					appAlert.info(notification.thread.body, {container: 'body', position: "top-right", heading: notification.user.name + ' ' + notification.thread.thread_action, duration: 25000});
					
                    this.unreadNotifications.push(newUnreadNotifications);
                  //  console.log('this.unreadNotifications',this.unreadNotifications);
					});
	
        }
    }
</script>
