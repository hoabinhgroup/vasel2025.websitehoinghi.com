<template>
  <div>
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ address }}</h4>
        <button type="button" class="close">
          <span @click="$emit('close')" aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>
          <i class="fa fa-calendar"></i> Thời gian từ
          <strong
            >{{ start_date_text_display }} - {{ end_date_text_display }}</strong
          >
        </h5>
        <div v-if="note1">
          <h5><strong>Nội dung khách sạn chuẩn bị</strong></h5>
          <nl2br tag="p" :text="note1" />
        </div>
        <div v-if="note2">
          <h5><strong>Nội dung Hòa Bình chuẩn bị</strong></h5>
          <p>
            {{ note2 }}
          </p>
        </div>
        <div v-if="note3">
          <h5><strong>Contact của khách</strong></h5>
          <p>
            {{ note3 }}
          </p>
        </div>
        <div>
          Người thêm kế hoạch: <strong>{{ username }}</strong>
        </div>
      </div>
      <div class="modal-footer">
        <button @click="deleteSchedule" type="button" class="btn btn-default">
          <i class="fa fa-trash"></i> Xóa
        </button>
        <button
          @click="updateSchedule"
          type="button"
          class="btn btn-info flex-fill text-white"
        >
          <i class="icon-pencil"></i> Sửa
        </button>
      </div>
    </div>
    <v-dialog />
  </div>
</template>

<script>
import UpdateScheduleModal from "./UpdateSchedule.vue";
export default {
  props: [
    "id",
    "address",
    "all_day",
    "color",
    "date_start",
    "date_end",
    "time_start",
    "time_end",
    "date_start",
    "start_date_text_display",
    "end_date_text_display",
    "username",
    "note1",
    "note2",
    "note3",
    "eventCalendarApi",
  ],
  components: {
    UpdateScheduleModal,
  },
  methods: {
    updateScheduleModal(data) {
      this.$modal.show(UpdateScheduleModal, data, {
        height: "auto",
        draggable: true,
        scrollable: true,
        adaptive: true,
      });
    },
    updateSchedule() {
      this.$emit("close");
      this.updateScheduleModal([
        {
          id_update: this.id,
          address_update: this.address,
          all_day: this.all_day,
          selected_update: this.color,
          start_date: new Date(this.date_start),
          end_date: new Date(this.date_end),
          start_time: new Date(this.date_start + " " + this.time_start),
          end_time: new Date(this.date_end + " " + this.time_end),
          note1_update: this.note1,
          note2_update: this.note2,
          note3_update: this.note3,
          eventCalendarApi: this.eventCalendarApi,
        },
      ]);
    },
    deleteSchedule() {
      if (confirm("Bạn có muốn xóa?")) {
        axios({
          method: "post",
          url: "https://inventory.hoabinhtourist.com/api/event-schedule/delete",
          data: { id_schedule: this.id },
        })
          .then((response) => {
            console.log("deleteSchedule success", response.data);
            if (response.data.success) {
              this.eventCalendarApi.refetchEvents();
              this.$toast.success("Xóa thành công!", {
                hideProgressBar: false,
              });

              this.$emit("close");
              this.$modal.hide("dialog");
            }
          })
          .catch((error) => {});
      }
    },
  },
};
</script>

<style scoped></style>
