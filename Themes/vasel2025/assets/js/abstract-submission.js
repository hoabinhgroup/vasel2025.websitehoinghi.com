document.addEventListener("DOMContentLoaded", function (event) {
  const registrationForm = document.querySelector("#payment-registration");
  const registrationSubmit = document.querySelector("#registration_button");
  const payment_methods = document.querySelectorAll(
    'input[name="payment_method"]'
  );
  const title = document.querySelectorAll('input[name="title"]');
  const otherTitle = document.getElementById("titleOther");
  const dietary = document.querySelectorAll('input[name="dietary"]');
  const otherDietary = document.getElementById("dietaryOther");
  const country = document.getElementById("country");
  const attach_section = document.querySelector(".attach_section");
  const passport_section = document.querySelector(".passport_section");
  const uploadOtherAttach = document.querySelector("#uploadOtherAttach");
  const uploadSection = document.querySelector(".upload-section");
  let attachment = document.getElementById("abstract_file");
  let attach = document.getElementById("attach");
  const nextButton = document.getElementById("next-button");
  const category = document.querySelectorAll('input[name="category"]');
  const submission_for_proceedings = document.querySelector(
    "#submission_for_proceedings"
  );
  const publication = document.querySelectorAll('input[name="publication"]');
  const instruction = document.querySelector("#instruction");

  //const conference_checklist_item = document.querySelectorAll('input[name="conference_checklist_item"]');
  let conference_checklist_item = document.querySelectorAll(
    'input[name="conference_checklist_item"]'
  );
  const online_payment_description = document.querySelector(
    ".online_payment_description"
  );
  const wire_transfer_description = document.querySelector(
    ".wire_transfer_description"
  );
  const acccompanying_checklist = document.querySelector(
    ".acccompanying_checklist"
  );
  const acccompanying_person = document.querySelector("#acccompanying_person");
  const conference_checklist = document.querySelector(
    'input[name="conference_checklist_payload"]'
  );
  const totalElement = document.querySelector("#total > span.amount");
  const unitElement = document.querySelector("#total > span.unit");
  const totalData = document.getElementById("totalData");
  const vpsMemberYes = document.getElementById("isVpsMemberYes");
  const vpsMemberNo = document.getElementById("isVpsMemberNo");

  const is_vps_member_input = document.querySelectorAll(
    'input[name="is_vps_member"]'
  );

  let is_vps_member_value = is_vps_member_input.length
    ? document.querySelector('input[name="is_vps_member"]:checked').value
    : 0;
  let is_vps_member = "non-member";
  let option1 = "";
  let option2 = "";
  let option3 = "";
  let optionSection1 = document.querySelector(".option1");
  let optionSection2 = document.querySelector(".option2");
  let optionSection3 = document.querySelector(".option3");

  passport_section.style.display = "none";

  const VND = new Intl.NumberFormat("vi-VN");

  Array.from(is_vps_member_input).forEach(function (item) {
    item.onclick = function (e) {
      if (e.target.checked) {
        resetConferenceFee();
        console.log("e.target.value", e.target.value);
        if (e.target.value == 1) {
          //member
          is_vps_member = "member";
        } else {
          is_vps_member = "non-member";
        }

        sumConferenceFee();
      }
    };
  });

  if (country) {
    country.onchange = function (e) {
      console.log("country.change", e.target.value);
      if (e.target.value == "VN") {
        passport_section.style.display = "none";
      } else {
        passport_section.style.display = "block";
      }
    };
  }

  if (uploadOtherAttach) {
    uploadOtherAttach.onclick = function () {
      uploadSection.innerHTML = `
			<div class="row no-gutters">
			<div class="col-md-12">
				<label for="">Please upload student ID Card. <sup>*</sup>:</label>
			</div>
			</div>	
			<div class="row no-gutters">
				<div class="col-md-12">
					<input type="file" class="form-control col-md-4" id="attachment" name="attachment" value="">		
				</div>

			</div>
			<p>&nbsp;</p>
		`;
    };
  }

  function resetConferenceFee() {
    totalElement.innerHTML = 0;
    unitElement.innerHTML = "";
    totalData.value = "";
    optionSection1.innerHTML = "";
    optionSection2.innerHTML = "";
    optionSection3.innerHTML = "";
  }

  function sumConferenceFee() {
    renderConferenceFeeOption();

    onChangeConferenceChecklistItem();
  }

  function onChangeConferenceChecklistItem() {
    console.log(23232);
    let conference_checklist_item = document.querySelectorAll(
      'input[name="conference_checklist_item"]'
    );
    conference_checklist_item.forEach(function (item) {
      item.onclick = function (e) {
        if (e.target.checked) {
          let itemChecklistValue = e.target.value;
          let itemChecklistId = e.target.getAttribute("data-id");

          console.log("itemChecklistId", itemChecklistId);
          if (itemChecklistId == 1) {
            //student
            attach_section.style.display = "block";
          } else {
            attach_section.style.display = "none";
          }
          is_vps_member_value = document.querySelector(
            'input[name="is_vps_member"]:checked'
          ).value;
          //console.log('is_vps_member_value', is_vps_member_value);

          if (is_vps_member_value == 0 || itemChecklistId == 2) {
            unit = "USD";
          } else {
            unit = "VNĐ";
          }

          let itemCheckedValue = {
            amount: itemChecklistValue,
            id: itemChecklistId,
            unit: unit,
          };
          totalElement.innerHTML = VND.format(itemChecklistValue);
          unitElement.innerHTML = unit;

          totalData.value = JSON.stringify(itemCheckedValue);

          //console.log('conference_checklist_item value', itemCheckedValue)
        }
      };
    });
  }

  if (attachment) {
    attachment.addEventListener("change", function () {
      console.log("attachment", attachment);
      var fileName = this.value.split("\\").pop(); // Lấy tên tệp từ đường dẫn đầy đủ
      document.getElementById("customFileLabel").innerText = fileName; // Hiển thị tên tệp đã chọn
    });
  }

  if (attach) {
    attach.addEventListener("change", function () {
      console.log("attach", attach);
      var fileName = this.value.split("\\").pop(); // Lấy tên tệp từ đường dẫn đầy đủ
      document.getElementById("customFileLabel").innerText = fileName; // Hiển thị tên tệp đã chọn
    });
  }

  onChangeConferenceChecklistItem();

  function renderConferenceFeeOptionHTML(param) {
    optionHtml = `<input 
			type="radio" 
			name="conference_checklist_item" 
			value="${param.amount}" 
			data-id="${param.id}">`;

    return optionHtml;
  }

  title.forEach(function (item) {
    item.onclick = function (e) {
      if (e.target.checked) {
        if (e.target.value == 5 || e.target.value == "other") {
          otherTitle.disabled = false;
        } else {
          otherTitle.disabled = true;
        }
        console.log("e.target.value", e.target.value);
      }
    };
  });

  dietary.forEach(function (item) {
    item.onclick = function (e) {
      if (e.target.checked) {
        if (e.target.value == "other") {
          otherDietary.disabled = false;
        } else {
          otherDietary.disabled = true;
        }
      }
    };
  });

  Array.from(payment_methods).forEach(function (item) {
    item.onclick = function (e) {
      if (e.target.checked) {
        console.log("payment_methods", e.target.value);
        if (e.target.value == "bank-transfer") {
          wire_transfer_description.style.display = "block";
          online_payment_description.style.display = "none";
        } else {
          wire_transfer_description.style.display = "none";
          online_payment_description.style.display = "block";
        }
      }
    };
  });

  if (category) {
    category.forEach(function (item) {
      item.onclick = function (e) {
        if (e.target.checked) {
          console.log("e.target.value", e.target.value);

          // if (e.target.value === "1") {
          //   passport_section.style.display = "block";
          // } else {
          //   passport_section.style.display = "none";
          // }
        }
      };
    });
  }

  if (publication) {
    publication.forEach(function (item) {
      item.onclick = function (e) {
        console.log("e.target.value", e.target.value);
        if (e.target.value == 1) {
          submission_for_proceedings.style.display = "block";
          instruction.innerHTML = "";
        } else {
          submission_for_proceedings.style.display = "none";
          instruction.innerHTML =
            "Full papers submitted for consideration in Advances in Natural Sciences: Nanoscience and Nanotechnology must be done through the journal's online submission system. Reviewing and revisions will be handled through the online system. Editorial standards are the same as those used for regular articles submitted to Advances in Natural Sciences: Nanoscience and Nanotechnology. The paper therefore can be accepted and published after the conference event.";
        }
      };
    });
  }
});
