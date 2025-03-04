document.addEventListener("DOMContentLoaded", function (event) {
    const training = document.querySelectorAll('input[name="training"]');

    const session = document.querySelectorAll('input[name="session"]');
    const sessionOther = document.getElementById("sessionOther");
    const title = document.querySelectorAll('input[name="title"]');
    const course = document.querySelectorAll('input[name="course"]');
    const otherCourse = document.getElementById("other_course");
    const otherTitle = document.getElementById("titleOther");

    const payment_methods = document.querySelectorAll(
        'input[name="payment_method"]'
    );
    const cash_payment_description = document.querySelector(
        ".cash_payment_description"
    );
    const wire_transfer_description = document.querySelector(
        ".wire_transfer_description"
    );

    flatpickr(".datepicker", {
        dateFormat: "d/m/Y",
        // các tùy chọn khác
    });
    if (cash_payment_description) { cash_payment_description.style.display = "none"; }

    if (wire_transfer_description) { wire_transfer_description.style.display = "none"; }


    const report_file_summary_input = document.getElementById('report_file_summary_input');
    const report_file_summary_name = document.getElementById('report_file_summary_name');

    const report_file_full_input = document.getElementById('report_file_full_input');
    const report_file_full_name = document.getElementById('report_file_full_name');

    const shortCV_input = document.getElementById('shortCV_input');
    const shortCV_name = document.getElementById('shortCV_name');

    const passport_input = document.getElementById('passport_input');
    const passport_name = document.getElementById('passport_name');

    const UNC_input = document.getElementById('UNC_input');
    const UNC_name = document.getElementById('UNC_name');

    // Khi người dùng chọn file, ta sẽ cập nhật tên file hiển thị
    if (report_file_summary_input) {
        report_file_summary_input.addEventListener('change', function () {
            console.log('report_file_summary_input', report_file_summary_input.files);

            if (report_file_summary_input.files && report_file_summary_input.files.length > 0) {
                report_file_summary_name.textContent = report_file_summary_input.files[0].name;
            } else {
                report_file_summary_name.textContent = 'FILE BÁO CÁO TÓM TẮT';
            }
        });
    }

    if (report_file_full_input) {
        report_file_full_input.addEventListener('change', function () {
            console.log('report_file_full_input', report_file_full_input.files);

            if (report_file_full_input.files && report_file_full_input.files.length > 0) {
                report_file_full_name.textContent = report_file_full_input.files[0].name;
            } else {
                report_file_full_name.textContent = 'FILE BÁO CÁO TOÀN VĂN';
            }
        });
    }

    if (UNC_input) {
        UNC_input.addEventListener('change', function () {
            console.log('UNC_input', UNC_input.files);
            if (UNC_input.files && UNC_input.files.length > 0) {
                UNC_name.textContent = UNC_input.files[0].name;
            } else {
                UNC_name.textContent = 'ĐÍNH KÈM SAO KÊ/ UNC NẾU ĐÃ CHUYỂN KHOẢN';
            }
        });
    }

    if (shortCV_input) {
        shortCV_input.addEventListener('change', function () {
            console.log('shortCV_input', shortCV_input.files);
            if (shortCV_input.files && shortCV_input.files.length > 0) {
                shortCV_name.textContent = shortCV_input.files[0].name;
            } else {
                shortCV_name.textContent = 'SHORT CV';
            }
        });
    }

    if (passport_input) {
        passport_input.addEventListener('change', function () {
            console.log('passport_input', passport_input.files);
            if (passport_input.files && passport_input.files.length > 0) {
                passport_name.textContent = passport_input.files[0].name;
            } else {
                passport_name.textContent = 'PASSPORT';
            }
        });
    }

    title.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                if (e.target.value == "other") {
                    otherTitle.disabled = false;
                } else {
                    otherTitle.disabled = true;
                }
                console.log("e.target.value", e.target.value);
            }
        };
    });

    session.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                console.log("e.target.value", e.target.value);

                if (e.target.value === "other_session") {
                    sessionOther.disabled = false;
                } else {
                    sessionOther.disabled = true;
                }
            }
        };
    })

    course.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                console.log("e.target.value", e.target.value);
                if (e.target.value === "other_course") {
                    otherCourse.disabled = false;
                } else {
                    otherCourse.disabled = true;
                }
            }
        }
    });

    training.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                if (e.target.value == "yes") {
                    document.querySelector('.has_training').style.display = 'block';
                } else {
                    document.querySelector('.has_training').style.display = 'none';
                }
            }
        }
    });

    payment_methods.forEach(function (item) {
        item.onclick = function (e) {
            if (e.target.checked) {
                //  console.log("payment_methods", e.target.className);
                if (e.target.value == "bank-transfer") {
                    wire_transfer_description.style.display = "block";
                    cash_payment_description.style.display = "none";
                    if (e.target.className == "unc_statement") {
                        document.querySelector("#unc_section").style.display = "block";
                    }
                } else {
                    wire_transfer_description.style.display = "none";
                    cash_payment_description.style.display = "block";
                    document.querySelector("#unc_section").style.display = "none";
                }
            }
        };
    });
});

function uploadOtherCV() {
    document.querySelector("#uploadCV").style.display = "flex";
}

function uploadOtherPassport() {
    document.querySelector("#uploadPassport").style.display = "flex";
}
