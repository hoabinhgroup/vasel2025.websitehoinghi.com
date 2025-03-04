<template>
  <div>
    <div id="updateModal" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-road2"></i> Sửa Setup</h4>
        <button type="button" class="close" @click="$emit('close')">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form @submit.prevent="onSubmit()">
        <div class="modal-body">
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
              v-model="address"
              type="text"
              required
            />
          </div>
          <div class="col-md-12" style="margin-top: 8px">
            <input
              id="allday"
              type="checkbox"
              value="1"
              v-model="allday"
              checked
            />
            <label
              for="allday"
              class="control-label required"
              aria-required="true"
              >Diễn ra cả ngày?</label
            >
          </div>
          <div v-if="allday === false" class="col-md-12">
            <div class="row">
              <div class="form-group col-md-6">
                <label
                  for="address"
                  class="control-label required"
                  aria-required="true"
                  >Ngày bắt đầu</label
                ><br />
                <date-picker
                  v-model="startDate"
                  format="DD/MM/YYYY"
                  type="date"
                ></date-picker>
              </div>
              <div class="form-group col-md-6">
                <label
                  for="address"
                  class="control-label required"
                  aria-required="true"
                  >Thời gian bắt đầu</label
                ><br />
                <date-picker
                  v-model="startTime"
                  format="HH:mm"
                  type="time"
                  :time-picker-options="timePickerOptions"
                ></date-picker>
              </div>
            </div>
          </div>
          <div v-if="allday === false" class="col-md-12">
            <div class="row">
              <div class="form-group col-md-6">
                <label
                  for="address"
                  class="control-label required"
                  aria-required="true"
                  >Ngày kết thúc</label
                ><br />
                <date-picker
                  v-model="endDate"
                  format="DD/MM/YYYY"
                  type="date"
                ></date-picker>
              </div>
              <div class="form-group col-md-6">
                <label
                  for="address"
                  class="control-label required"
                  aria-required="true"
                  >Thời gian kết thúc</label
                ><br />
                <date-picker
                  v-model="endTime"
                  format="HH:mm"
                  type="time"
                  :time-picker-options="timePickerOptions"
                ></date-picker>
              </div>
            </div>
          </div>
          <div class="form-group col-md-12">
            <textarea
              v-model="note1"
              placeholder="Nội dung khách sạn chuẩn bị"
              class="form-control"
            ></textarea>
          </div>
          <div class="form-group col-md-12">
            <textarea
              v-model="note2"
              placeholder="Nội dung Hòa Bình chuẩn bị"
              class="form-control"
            ></textarea>
          </div>
          <div class="form-group col-md-12">
            <textarea
              v-model="note3"
              placeholder="Contact của khách"
              class="form-control"
            ></textarea>
          </div>
          <div class="color-palet col-md-12">
            <span
              v-for="(color, index) in colorTags"
              :style="{ 'background-color': color }"
              class="color-tag clickable mr15"
              v-model="selected"
              @click="selected = color"
              :class="{ active: selected == color }"
            ></span>
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
  </div>
</template>

<script>
export default {
  props: [
    "id_update",
    "address_update",
    "all_day",
    "selected_update",
    "start_date",
    "end_date",
    "start_time",
    "end_time",
    "note1_update",
    "note2_update",
    "note3_update",
    "eventCalendarApi",
  ],
  data() {
    return {
      id_schedule: "",
      address: "",
      note1: "",
      note2: "",
      note3: "",
      selected: "",
      allday: false,
      startDate: new Date(),
      endDate: new Date(),
      startTime: new Date(),
      endTime: new Date(),
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
  methods: {
    onSubmit() {
      //console.log("event", this.$parent.$parent.$parent.$parent.$parent);
      // let calendarApi = this.$parent.$refs.fullCalendar.getApi();
      // calendarApi.refetchEvents();
      //this.eventCalendarApi.refetchEvents();
      //return false;
      let formatted_date_start =
        this.startDate.getFullYear() +
        "-" +
        (this.startDate.getMonth() + 1) +
        "-" +
        this.startDate.getDate();

      //console.log("formatted_date_start", formatted_date_start);
      //return false;

      let formatted_time_start =
        this.startTime.getHours() +
        ":" +
        this.startTime.getMinutes().toString().padStart(2, "0");

      let formatted_date_end =
        this.endDate.getFullYear() +
        "-" +
        (this.endDate.getMonth() + 1) +
        "-" +
        // this.endDate.getUTCDate();
        this.endDate.getDate();

      let formatted_time_end =
        this.endTime.getHours() +
        ":" +
        this.endTime.getMinutes().toString().padStart(2, "0");

      let data = {
        id_schedule: this.id_schedule,
        color: this.selected,
        note1: this.note1,
        note2: this.note2,
        note3: this.note3,
        address: this.address,
        startDate: formatted_date_start,
        endDate: formatted_date_end,
        startTime: formatted_time_start,
        endTime: formatted_time_end,
        allday: this.allday,
      };
      // console.log("onSubmit", data);
      //return false;
      axios({
        method: "post",
        url:
          "https://inventory.hoabinhtourist.com/api/event-schedule/update-schedule-event",
        data: data,
      })
        .then((response) => {
          console.log("success", response.data);
          if (response.data.success) {
            this.eventCalendarApi.refetchEvents();
            this.$toast.success("Sửa mốc thời gian thành công!", {
              hideProgressBar: false,
            });
            this.$emit("close");
          }
        })
        .catch((error) => {
          console.log("error", error);
          //this.error = error.response.data.message;
        });
    },
  },
  mounted() {
    this.allday = this.all_day ? true : false;
    this.startDate = this.start_date;
    this.endDate = this.end_date;
    this.startTime = this.start_time;
    this.endTime = this.end_time;
    this.id_schedule = this.id_update;
    this.address = this.address_update;
    this.note1 = this.note1_update;
    this.note2 = this.note2_update;
    this.note3 = this.note3_update;
    this.selected = this.selected_update;
    this.event = this.event_update;

    //this.startDate = new Date(this.startDate);
    console.log("UpdateSchedule startTime", this.selected);
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

.color-tag.active {
  border-radius: 50%;
}
</style>
