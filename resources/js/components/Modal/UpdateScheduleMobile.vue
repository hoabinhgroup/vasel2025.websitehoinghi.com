<template>
  <div>
    <modal id="update-modal" v-cloak>
      <template slot="title">Chỉnh sửa kế hoạch</template>
  
      <div slot="body">
         <form @submit.prevent="onSubmit()">
           <div class="modal-body">
            <div class="row"> 
           <div class="col-md-12">
             <label
             for="address"
             class="control-label required"
             aria-required="true"
             >Địa điểm Setup / Hạng muc</label
             >
             <input
             class="form-control"
             placeholder="Địa điểm Setup / Hạng mục"
             v-model="value.address"
             type="text"
             required
             />
           </div>
           <div class="col-md-12" style="margin-top: 8px">
             <input
             id="allday"
             type="checkbox"
             value="1"
             v-model="value.all_day"
             checked
             />
             <label
             for="allday"
             class="control-label required"
             aria-required="true"
             >Diễn ra cả ngày?</label
             >
           </div>
            </div>
           <div v-if="!value.all_day" class="col-md-12">
             <div class="row">
             <div class="form-group col-xs-12">
               <label
               for="address"
               class="control-label required"
               aria-required="true"
               >Ngày bắt đầu</label
               ><br />
              
               <date-picker
               v-model="value.date_start"
               format="DD/MM/YYYY"
               type="date"
               ></date-picker>
             </div>
             <div class="form-group col-xs-12">
              
               <label
               for="address"
               class="control-label required"
               aria-required="true"
               >Thời gian bắt đầu</label
               ><br />
              
               <date-picker
               v-model="value.time_start"
               format="HH:mm"
               type="time"
               :time-picker-options="timePickerOptions"
               ></date-picker>
             </div>
             </div>
           </div>
           <div v-if="!value.all_day" class="col-md-12">
             <div class="row">
             <div class="form-group col-xs-12">
              
               <label
               for="address"
               class="control-label required"
               aria-required="true"
               >Ngày kết thúc</label
               ><br />
               <date-picker
               v-model="value.date_end"
               format="DD/MM/YYYY"
               type="date"
               ></date-picker>
             </div>
             <div class="form-group col-xs-12">
              
               <label
               for="address"
               class="control-label required"
               aria-required="true"
               >Thời gian kết thúc</label
               ><br />
            
               <date-picker
               v-model="value.time_end"
               format="HH:mm"
               type="time"
               :time-picker-options="timePickerOptions"
               ></date-picker>
             </div>
             </div>
           </div>
           <div class="row">
           <div class="form-group col-md-12">
             <textarea
             v-model="value.note1"
             placeholder="Kế hoạch bên đối tác"
             class="form-control"
             ></textarea>
           </div>
           <div class="form-group col-md-12">
             <textarea
             v-model="value.note2"
             placeholder="Kế hoạch bên mình"
             class="form-control"
             ></textarea>
           </div>
           <div class="form-group col-md-12">
             <textarea
             v-model="value.note3"
             placeholder="Contact của khách"
             class="form-control"
             ></textarea>
           </div>
           <div class="color-palet col-md-12">
             <span
             v-for="(color, index) in colorTags"
             :style="{ 'background-color': color }"
             class="color-tag clickable mr15"
             v-model="value.color"
             @click="value.color = color"
             :class="{ active: value.color == color }"
             ></span>
           </div>
           </div>
           </div>
           <div class="modal-footer">
           <button
             type="submit"
             class="btn btn-info flex-fill text-white"
             value="save"
           >
             <i class="icon-check"></i> Sửa
           </button>
           </div>
         </form>
      </div>
  
      <div slot="footer">
          
      </div>
  </modal>
  </div>
</template>

<script>
import moment from 'moment'

Vue.filter('formatDate', function(value) {
if (value) {
  return new Date(String(value));
}
});

export default {
  props: {
    value:{
      type: Object,
      required: true
    }
  },
  watch: {
    value(){
    console.log('watch update', this.value);
    this.$emit('input', this.value);
    this.value.time_start = new Date(this.value.date_start + "T" + this.value.time_start);
    this.value.time_end = new Date(this.value.date_end + "T" + this.value.time_end);
    this.value.date_start = new Date(this.value.date_start);
    this.value.date_end = new Date(this.value.date_end);

   }
},

  data() {
    return {
      id_schedule: "",
      //allday: false,
      colorTags: [
        "#83c340",
        "#29c2c2",
        "#2d9cdb",
        "#aab7b7",
        "#f1c40f",
        "#e18a00",
        "#e74c3c",
        "#d43480",
        "#ad159e",
        "#34495e",
        "#dbadff",
      ],
      timePickerOptions: {
        start: "00:00",
        step: "00:30",
        end: "23:30",
      },
    };
  },
  computed:{
      
  },
  methods: {
    onSubmit() {
     // console.log('onsubmit this.date_start', this.value.date_start);
     // return false;
      let formatted_date_start =
        this.value.date_start.getFullYear() +
        "-" +
        (this.value.date_start.getMonth() + 1) +
        "-" +
        this.value.date_start.getDate();

      let formatted_time_start =
        this.value.time_start.getHours() +
        ":" +
        this.value.time_start.getMinutes().toString().padStart(2, "0");

      let formatted_date_end =
        this.value.date_end.getFullYear() +
        "-" +
        (this.value.date_end.getMonth() + 1) +
        "-" +
        // this.date_end.getUTCDate();
        this.value.date_end.getDate();

      let formatted_time_end =
        this.value.time_end.getHours() +
        ":" +
        this.value.time_end.getMinutes().toString().padStart(2, "0");

      let data = {
        id_schedule: this.value.id,
        color: this.value.color,
        note1: this.value.note1,
        note2: this.value.note2,
        note3: this.value.note3,
        address: this.value.address,
        startDate: formatted_date_start,
        endDate: formatted_date_end,
        startTime: formatted_time_start,
        endTime: formatted_time_end,
        allday: this.value.all_day,
      };
       console.log("onSubmit", data);
     // return false;
      axios({
        method: "post",
        url:
          "https://inventory.hoabinhtourist.com/api/event-schedule/update-schedule-event",
        data: data,
      })
        .then((response) => {
          console.log("success", response.data);
          if (response.data.success) {
            this.value.eventCalendarApi.refetchEvents();
            this.$toast.success("Sửa mốc thời gian thành công!", {
              hideProgressBar: false,
            });
            VoerroModal.hide('update-modal');
          }
        })
        .catch((error) => {
          console.log("error", error);
          //this.error = error.response.data.message;
        });
    },
  },
};
</script>

<style scoped>
.color-tag.clickable:hover {
  -moz-transform: scale(1.5);
  -webkit-transform: scale(1.5);
  transform: scale(1.5);
}

.color-tag {
  display: inline-block;
  width: 15px;
  height: 15px;
  margin: 2px 10px 0 0;
  transition: all 300ms ease;
  -moz-transition: all 0.1s;
  -webkit-transition: all 0.1s;
  transition: all 0.1s;
}
.clickable {
  cursor: pointer;
}
.mr15 {
  margin-right: 15px !important;
}

form .form-group{
width: 100%;
}

.mx-datepicker{
width: 100%;
}

.color-tag.active {
  border-radius: 50%;
}
</style>
