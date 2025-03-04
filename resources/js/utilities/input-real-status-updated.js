const BASE_URL = "http://inventory.hoabinhtourist.com/api/";

function updatedInputRealStatus(formData) {
  const url = `${BASE_URL}inventory/input-real-status-updated`;
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

export { updatedInputRealStatus };
