const BASE_URL = "http://inventory.hoabinhtourist.com/api/";

function importExcelToDatabase(formData) {
  const url = `${BASE_URL}inventory/import-excel-to-database`;
  // console.log("formData", formData);
  // return false;
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

export { importExcelToDatabase };
