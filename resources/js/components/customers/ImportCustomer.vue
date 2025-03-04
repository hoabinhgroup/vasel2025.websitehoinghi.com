<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <form
          method="POST"
          enctype="multipart/form-data"
          novalidate
          v-if="isInitial || isSaving"
        >
          <h1>Upload File Excel</h1>
          <div class="dropbox">
            <input
              type="file"
              :name="uploadFieldName"
              :disabled="isSaving"
              @change="
                filesChange($event.target.name, $event.target.files);
                fileCount = $event.target.files.length;
              "
              accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
              class="input-file"
            />
            <p v-if="isInitial">
              Kéo thả file của bạn vào đây<br />
              hoặc ấn vào để chọn file cần upload
            </p>
            <p v-if="isSaving">Excel file {{ fileCount }} đang upload...</p>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <div v-if="isSuccess">
          <h2>
            Đã upload {{ uploadedFiles.length }} file lên máy chủ thành công.
          </h2>
          <p>
            <a href="javascript:void(0)" @click="reset()">Thử lại</a>
          </p>
          <ul class="list-unstyled">
            <li v-for="item in uploadedFiles">
              <a href="">{{ item.data }}</a>
            </li>
          </ul>
        </div>
        <!--FAILED-->
        <div v-if="isFailed">
          <h2>Upload thất bại.</h2>
          <p>
            <a href="javascript:void(0)" @click="reset()">Thử lại</a>
          </p>
          <pre>{{ uploadError }}</pre>
        </div>
        <div class="form-group" id="file_upload_response"></div>
      </div>
      <p>&nbsp;</p>
    </div>
  </div>
</template>

<script>
import { upload } from "../../utilities/file-upload.service";

const STATUS_INITIAL = 0,
  STATUS_SAVING = 1,
  STATUS_SUCCESS = 2,
  STATUS_FAILED = 3;
export default {
  created() {
    console.log("created", 123);
  },
  data() {
    return {
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      uploadFieldName: "excel",
      data: null,
      excel: null,
    };
  },
  computed: {
    isInitial() {
      return this.currentStatus === STATUS_INITIAL;
    },
    isSaving() {
      return this.currentStatus === STATUS_SAVING;
    },
    isSuccess() {
      return this.currentStatus === STATUS_SUCCESS;
    },
    isFailed() {
      return this.currentStatus === STATUS_FAILED;
    },
  },
  methods: {
    reset() {
      // reset form to initial state
      this.currentStatus = STATUS_INITIAL;
      this.uploadedFiles = [];
      this.uploadError = null;
    },
    save(formData) {
      // upload data to the server
      this.currentStatus = STATUS_SAVING;

      upload(formData)
        .then((x) => {
          this.uploadedFiles = [].concat(x);
          this.currentStatus = STATUS_SUCCESS;
          console.log("this.uploadedFiles x", x);
          this.excel = x.excel;
        })
        .then((x) => {
          console.log("x success", x);       
          this.$toast.success("Import dữ liệu thành công", {
              hideProgressBar: false,
            });
           
        })
        .catch((err) => {
          console.log("err", err);
          this.uploadError = err.response;
          this.currentStatus = STATUS_FAILED;
        });

      // this.hotSettings.data = [
      //   ["ax32", "ax343", "ax", "ax", "ax3434"],
      //   ["outside", "of", "request", "redfdf", "dfdfdf"],
      // ];
    },
    filesChange(fieldName, fileList) {
      // handle file changes
      const formData = new FormData();

      if (!fileList.length) return;

      // append the files to FormData
      Array.from(Array(fileList.length).keys()).map((x) => {
        formData.append(fieldName, fileList[x], fileList[x].name);
      });

      // save it
      this.save(formData);
    },
  },

  mounted() {
    // this.data = [
    //   ["", "Ford", "Volvo", "Toyota", "Honda"],
    //   ["2016", 10, 11, 12, 13],
    //   ["2017", 20, 11, 14, 13],
    //   ["2018", 30, 15, 12, 13],
    // ];
    this.reset();
  },
};
</script>

<style scoped>
.dropbox {
  outline: 2px dashed grey; /* the dash box */
  outline-offset: -10px;
  background: lightcyan;
  color: dimgray;
  padding: 10px 10px;
  min-height: 200px; /* minimum height */
  position: relative;
  cursor: pointer;
}

.input-file {
  opacity: 0; /* invisible but it's there! */
  width: 100%;
  height: 200px;
  position: absolute;
  cursor: pointer;
}

.dropbox:hover {
  background: lightblue; /* when mouse over to the drop zone, change color */
}

.dropbox p {
  font-size: 1.2em;
  text-align: center;
  padding: 50px 0;
}
</style>
