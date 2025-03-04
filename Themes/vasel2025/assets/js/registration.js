document.addEventListener("DOMContentLoaded", function (event) {
    //let conferenceFees = [];
    let feeCategorySelected = [];
    let IDs = [];
    let type_attachment = null;
    let totalElement = document.querySelector("#total");
    let totalAmount = document.getElementById("totalAmount");
    let feeId = document.getElementById("feeId");
    let category = "PLENARY/INVITED SPEAKERS";
    const paymentRegistration = $("#payment-registration");
    const registration_table_section = document.querySelector(
        "#registration_table_section"
    );
    const international_registration_table = document.querySelector(
        "#international_registration_table"
    );
    const local_registration_table = document.querySelector(
        "#local_registration_table"
    );
    const payment_methods = document.querySelectorAll(
        'input[name="payment_method"]'
    );
    const title = document.querySelectorAll('input[name="title"]');
    const categories = document.querySelectorAll('input[name="category"]');
    const otherTitle = document.getElementById("titleOther");
    const dietary = document.querySelectorAll('input[name="dietary"]');
    const otherDietary = document.getElementById("dietaryOther");
    const countrySelect = document.getElementById("country");
    const passport_section = document.querySelector(".passport_section");
    let conference_checklist_item = document.querySelectorAll(
        'input[name="conference_checklist_item"]'
    );
    const payment_method_section = document.querySelector(
        "#payment_method_section"
    );
    const online_payment_description = document.querySelector(
        ".online_payment_description"
    );
    const wire_transfer_description = document.querySelector(
        ".wire_transfer_description"
    );



    const galadinner = document.querySelectorAll('input[name="galadinner"]');
    registration_table_section.style.display = "none";
    payment_method_section.style.display = "none";

    let has_galadinner = "yes";
    const VND = new Intl.NumberFormat("vi-VN");

    categories.forEach(function (item) {
        item.onclick = function (e) {
            resetConferenceFee();
            resetGaladinner();
            if (e.target.checked) {
                category = e.target.value;
                countrySelect.value = "";
                countrySelect.disabled = false;
                if (e.target.value == "PLENARY/INVITED SPEAKERS") {
                    registration_table_section.style.display = "none";
                    international_registration_table.style.display = "none";
                    local_registration_table.style.display = "none";
                    payment_method_section.style.display = "none";
                } else if (e.target.value == "INTERNATIONAL REGISTRATION") {
                    registration_table_section.style.display = "block";
                    international_registration_table.style.display = "block";
                    local_registration_table.style.display = "none";
                    payment_method_section.style.display = "block";
                    conference_checklist_item =
                        international_registration_table.querySelectorAll(
                            'input[name="conference_checklist_item"]'
                        );
                } else if (e.target.value == "LOCAL REGISTRATION") {
                    registration_table_section.style.display = "block";
                    international_registration_table.style.display = "none";
                    local_registration_table.style.display = "block";
                    payment_method_section.style.display = "block";
                    countrySelect.value = "VN";
                    countrySelect.disabled = true;
                    conference_checklist_item = local_registration_table.querySelectorAll(
                        'input[name="conference_checklist_item"]'
                    );
                }
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

    galadinner.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                resetConferenceFee();
                if (e.target.value == "yes") {
                    // galadinner yes
                    has_galadinner = "yes";
                } else {
                    has_galadinner = "no";
                }

                show_fee_table();
            }
        };
    });

    function show_fee_table() {
        //console.log('show_fee_table has_galadinner', has_galadinner);
        conference_checklist_item.forEach(function (item, index) {
            console.log({ index });
            let stt = index + 1;
            if (stt <= 4) {
                // let id = item.getAttribute('id').split('_')[1]
                let id = item.getAttribute("data-id");
                let registration = window.registrations[has_galadinner][stt];

                if (category != "LOCAL REGISTRATION") {
                    item.value = registration["amount"];
                } else {
                    item.value = registration["amount_vn"];
                }

                console.log({ item });
                console.log("itregistration id:", registration["id"]);
                item.setAttribute("data-id", registration["id"]);
            }
        });
    }

    function toggleAttachByItem(currentObject) {
        let labelAttach = null;
        let renderAttach = "";

        type_attachment = currentObject.getAttribute("data-attach");

        console.log({ type_attachment });
        if (type_attachment == "apscvir_member") {
            labelAttach = "Provide proof that you are a member APSCVIR.";
        } else if (type_attachment == "young_ir") {
            labelAttach = "Provide proof that you are a Young IR trainee.";
        }
        if (labelAttach) {
            renderAttach = `
          <tr class="attach_tr">
              <td colspan="4">
                  <div class="attach_section form-group">
                  <div class="row no-gutters">
                  <label for=""><strong>${labelAttach}.</strong><sup>*</sup>:</label>
                  </div>	
                  <div class="row no-gutters">
                       <input type="file" class="form-control col-md-12" name="attachment" value="">		
                  </div>
                  </div>
              </td>
          </tr>`;
        }

        tr = currentObject.closest("tr");

        tr.insertAdjacentHTML("afterend", renderAttach);
    }

    function resetConferenceFee() {
        feeCategorySelected = [];
        IDs = [];
        totalElement.innerHTML = 0;
        totalAmount.value = 0;
        feeId.value = "";
        resetChecklistItem();
        resetAttachment();
    }

    function resetGaladinner() {
        galadinner.forEach(function (item) {
            item.checked = false;
        });
    }

    function resetAttachment() {
        attachTrElement = document.querySelector(".attach_tr");
        if (attachTrElement) {
            attachTrElement.remove();
        }
    }

    function resetChecklistItem() {
        conference_checklist_item.forEach(function (item) {
            item.checked = false;
        });
    }

    function onChangeConferenceChecklistItem() {
        conference_checklist_item.forEach(function (item) {
            item.onclick = function (e) {
                resetAttachment();
                toggleAttachByItem(e.target);
                resetChecklistItem();

                item.checked = true;

                IDs = updateIDs(e.target);

                feeCategorySelected = updateFees(e.target);

                let sum = calculateSum(feeCategorySelected);

                updateTotalAmount(sum);
                togglePaymentSection(sum);

                feeId.value = parseInt(IDs);
            };
        });
    }

    function calculateSum(items) {
        return items.reduce(
            (accumulator, currentValue) => accumulator + parseInt(currentValue),
            0
        );
    }

    function togglePaymentSection(sum) {
        if (sum == 0) {
            payment_method_section.style.display = "none";
        } else {
            payment_method_section.style.display = "block";
        }
    }

    function updateIDs(item) {
        const itemChecklistId = item.getAttribute("data-id");
        if (!IDs.includes(itemChecklistId)) {
            IDs.push(itemChecklistId);
        }
        return IDs;
    }

    function updateFees(item) {
        const itemChecklistValue = item.value;
        feeCategorySelected = [];
        feeCategorySelected.push(itemChecklistValue);
        return feeCategorySelected;
    }

    function updateTotalAmount(sum) {
        totalElement.innerHTML = unitFormat(sum);
        totalAmount.value = sum;
    }

    function unitFormat(money) {
        let sumFormat = "";
        let sum = money;
        if (category == "LOCAL REGISTRATION") {
            sumFormat = "VND";
            sum = VND.format(money);
        } else {
            sumFormat = "US$";
        }
        return sumFormat + sum;
    }

    onChangeConferenceChecklistItem();

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

    payment_methods.forEach(function (item) {
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
});
