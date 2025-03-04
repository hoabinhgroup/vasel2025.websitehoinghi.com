<template>
  <div>
    <modal id="show-modal" v-cloak>
      <template slot="title"
        ><h4 class="modal-title">{{ value.address }}</h4></template
      >

      <div slot="body">
        <div class="modal-body">
          <h5>
            <i class="fa fa-calendar"></i> Thời gian từ
            <strong
              >{{ value.start_date_text_display }} -
              {{ value.end_date_text_display }}</strong
            >
          </h5>
          <div v-if="value.note1">
            <h5><strong>Kế hoạch của đối tác</strong></h5>

            <nl2br tag="p" :text="value.note1" />
          </div>
          <div v-if="value.note2">
            <h5><strong>Kế hoạch của mình</strong></h5>
            <p>
              {{ value.note2 }}
            </p>
          </div>
          <div v-if="value.note3">
            <h5><strong>Contact của khách</strong></h5>
            <p>
              {{ value.note3 }}
            </p>
          </div>
          <div>
            Người thêm kế hoạch: <strong>{{ value.username }}</strong>
          </div>
        </div>
      </div>

      <div slot="footer">
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
    </modal>

    <UpdateScheduleModal
      :value="value"
      @input="
        (newData) => {
          value = newData;
        }
      "
    />
  </div>
</template>

<script>
import UpdateScheduleModal from "./UpdateScheduleMobile.vue";
export default {
  props: {
    value: {
      type: Object,
      required: true,
    },
  },
  watch: {
    value() {
      this.$emit("input", this.value);
    },
  },
  components: {
    UpdateScheduleModal,
  },
  mounted() {
    // this.showAddress = this.address;
    // console.log('show created address', this.showAddress);
  },

  methods: {
    updateSchedule() {
      VoerroModal.hide("show-modal");
      VoerroModal.show("update-modal");
    },
    deleteSchedule() {
      if (confirm("Bạn có muốn xóa?")) {
        //return false;
        // console.log('deleteSchedule', this.value.id);
        axios({
          method: "post",
          url: "https://inventory.hoabinhtourist.com/api/event-schedule/delete",
          data: { id_schedule: this.value.id },
        })
          .then((response) => {
            console.log("deleteSchedule success", response.data);
            if (response.data.success) {
              this.value.eventCalendarApi.refetchEvents();
              this.$toast.success("Xóa thành công!", {
                hideProgressBar: false,
              });

              VoerroModal.hide("show-modal");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
};
</script>

<style scoped></style>
