const BASE_URL = "https://hoabinhclub.com/api/";

function upload(formData) {
  const url = `${BASE_URL}membership/import-excel-to-database`;
  // console.log("formData", formData);
  // return;
  return axios({
    method: "post",
    url: url,
    data: formData,
  })
    .then((response) => response.data)
    .catch((error) => {
      console.log("error", error);
    });
}

export { upload };
